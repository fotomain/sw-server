<?php

namespace App\Type;

use App\Cart\CartController;
use App\DB;
use App\Product\ProductClothesType;
use App\Product\ProductTechType;
use App\Product\ProductType;
use App\Types;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{

    public function __construct()
    {

        $config=[
            'fields'=>function() {
                return [
                    'product'=> [
                        'type'=>Types::product(),
                        'description'=> 'return Product by id',
                        'args'=> [
                            'id'=>Types::string()
                        ],
                        'resolve'=> function ($root, $args) {

                    //                            echo $args['id'];
//                            return DB::selectOne("SELECT * FROM products_table WHERE id = 2 ");
//                            echo "SELECT * FROM products_table WHERE id = '{$args['id']}'";

                            return DB::selectOne("SELECT * FROM products_table WHERE id = '{$args['id']}'");
                        }
                    ],

                    'readCart'=> [
                        'type'=>Types::cart(),
                        'description'=>"read Cart",
                        'args' => [
                            'cartParams'=>Types::inputCartParams()
                        ],
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {
                            $a = [...$args['cartParams']];

                            $cartHeader=CartController::readCartHeader($a['cart_guid']);
                            if(null==$cartHeader){
                                $errorText="ERROR 5125: Cart not found! Cart id: ".$a['cart_guid'];
                                throw new Error($errorText);
                            }

                            return $cartHeader;

                        }
                    ],

                    'allCarts'=> [
                        'type'=>Types::cart(),
                        'resolve'=> function ($root, $args) {

                            $ret = DB::select("SELECT * FROM cart_header;");

//                            echo "=== allCarts";
//                            echo json_encode($ret);

                            return $ret;

                        }
                    ],
                    'readCategories'=> [
                        'type'=>Types::listOf(Types::category()),
                        'description'=> 'return Categories of Products',
                        'args'=>[
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
                        'resolve'=> function ($root, $args) {
                            $sql = "SELECT * FROM categories
                                    ORDER BY order_in_interface ASC
                            ";

                            $ret = DB::select($sql);

                            return $ret;
                        }
                    ],
                    'readFirstCategory'=> [
                        'type'=>Types::listOf(Types::category()),
                        'description'=> 'return 1st Category of Products',
                        'args'=>[
                            'filters' => [
                                'type' => ProductType::getArgsFilters("readFirstCategoryFilters"),
                                'defaultValue' => [
                                    'popular' => true
                                ]
                            ],
                            'orderBy' => [
                                'type' => Types::string(),
                            ]

                        ],
                        'resolve'=> function ($root, $args) {
                            $sql = "SELECT name FROM categories
                                    WHERE category_id > 0
                                    ORDER BY order_in_interface ASC
                                    LIMIT 1
                            ";

                            $ret = DB::select($sql);

                            return $ret;

                        }
                    ],
                    'readProducts'=> [
                        'type'=>Types::listOf(Types::product()),
                        'description'=> 'return List of Products',
                        'args'=>[
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
                        'resolve'=> function ($root, $args) {
                            $handler = new ProductType();
                            $sql = $handler->getSqlTextSELECT($args);
                            $debug=false;
                            if($debug) {
                                echo "\n === sql getSqlTextSELECT";
                                echo "\n";
                                echo $sql;
                            }
                            return DB::select($sql);
                        }
                    ],
                    'readProductsTech'=> [
                        'type'=>Types::listOf(Types::productTech()),
                        'description'=> 'return List of Tech Products',
                        'args'=>[
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
                        'resolve'=> function ($root, $args) {

                            $handler = new ProductTechType();
                            $sql = $handler->getSqlTextSELECT($args);
                            return DB::select($sql);
                        }
                    ],
                    'readProductsClothes'=> [
                        'type'=>Types::listOf(Types::productClothes()),
                        'description'=> 'return List of Clothes Products',
                        'args'=>[
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
                        'resolve'=> function ($root, $args) {

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