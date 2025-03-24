<?php

namespace App\Type;

use App\Cart\CartController;
use App\DB;
use App\Product\ProductClothesType;
use App\Product\ProductTechType;
use App\Product\ProductType;
use App\Types;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class QueryType extends ObjectType
{

    public function __construct()
    {
        $config = [
            'fields' => function () {
                return [
                    'readProduct' => [
                        'type' => Types::product(),
                        'description' => 'return Product by id',
                        'args' => [
                            'product_id' => Types::int()
                        ],
                        'resolve' => function ($root, $args) {
                            $sql = "SELECT * FROM product_entity WHERE product_id = {$args['product_id']}";
                            return DB::selectOne($sql);
                        }
                    ],

                    'readCart' => [
                        'type' => Types::cart(),
                        'description' => "read Cart",
                        'args' => [
                            'cartParams' => Types::inputCartParams()
                        ],
                        'resolve' => function ($root, $args, $context, ResolveInfo $info) {
                            $a = [...$args['cartParams']];

                            $cartHeader = CartController::readCartHeader($a['cart_guid']);

                            if (null == $cartHeader) {
                                $errorText = "ERROR 5125: Cart not found! Cart id: " . $a['cart_guid'];
                                return new Error($errorText);
//                                throw new Error($errorText);
                            }

                            return $cartHeader;
                        }
                    ],

                    'allCarts' => [
                        'type' => Types::cart(),
                        'resolve' => function ($root, $args) {
                            $ret = DB::select("SELECT * FROM cart_header;");

                            return $ret;
                        }
                    ],

                    'readCategories' => [
                        'type' => Types::listOf(Types::category()),
                        'description' => 'return Categories of Products',
                        'args' => [
                            'filters' => [
                                'type' => ProductType::getArgsFilters("readCategoryFilters"),
                                'defaultValue' => [
                                    'popular' => true
                                ]
                            ],
                            'orderBy' => [
                                'type' => Types::string(),
                            ]

                        ],
                        'resolve' => function ($root, $args) {
                            $sql = "SELECT * FROM categories
                                    ORDER BY order_in_interface ASC
                            ";

                            $ret = DB::select($sql);

                            return $ret;
                        }
                    ],

                    'readProducts' => [
                        'type' => Types::listOf(Types::product()),
                        'description' => 'return List of Products',
                        'args' => [
                            'filters' => [
                                'type' => ProductType::getArgsFilters("readProductsFilters"),
                                'defaultValue' => [
                                    'popular' => true
                                ]
                            ],
                            'orderBy' => [
                                'type' => Types::string(),
                            ]
                        ],
                        'resolve' => function ($root, $args) {
                            $handler = new ProductType();
                            $sql = $handler->getSqlTextSELECT($args);

                            return DB::select($sql);
                        }
                    ],

                    'readProductsTech' => [
                        'type' => Types::listOf(Types::productTech()),
                        'description' => 'return List of Tech Products',
                        'args' => [
                            'filters' => [
                                'type' => ProductType::getArgsFilters("readProductsFiltersTech"),
                                'defaultValue' => [
                                    'popular' => true
                                ]
                            ],
                            'orderBy' => [
                                'type' => Types::string(),
                            ]

                        ],
                        'resolve' => function ($root, $args) {
                            $handler = new ProductTechType();
                            $sql = $handler->getSqlTextSELECT($args);
                            return DB::select($sql);
                        }
                    ],

                    'readProductsClothes' => [
                        'type' => Types::listOf(Types::productClothes()),
                        'description' => 'return List of Clothes Products',
                        'args' => [
                            'filters' => [
                                'type' => ProductType::getArgsFilters("readProductsFiltersClothes"),
                                'defaultValue' => [
                                    'popular' => true
                                ]
                            ],
                            'orderBy' => [
                                'type' => Types::string(),
                            ]

                        ],
                        'resolve' => function ($root, $args) {
                            $handler = new ProductClothesType();
                            $sql = $handler->getSqlTextSELECT($args);
                            return DB::select($sql);
                        }
                    ],
                ]; //return fields
            }
        ];

        parent::__construct($config);
    }
}