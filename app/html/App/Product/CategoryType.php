<?php

namespace App\Product;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;


class CategoryType extends ObjectType
{
    private $debug;

    public function __construct($params = array())
    {
        $debug = false;

        if ($debug) {
            echo "\n ======= params1";
            echo json_encode($params);
            echo "\n ======= params2";
        }


        $config = [
            'description' => 'Category object',
            'fields' => function () {
                return [
                    'category_id' => [
                        'type' => Types::string(),
                        'description' => 'Category identifier',
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Category name',
                    ],
                    'display_name' => [
                        'type' => Types::string(),
                        'description' => 'Category name',
                    ],
                    'order_in_interface' => [
                        'type' => Types::string(),
                        'description' => 'Category order_in_interface',
                    ],
                    'products' => [
                        'type' => Types::listOf(Types::product()),
                        'description' => 'Category products',
                        'resolve' => function ($root, $args) {
                            $sql = "

                                SELECT * FROM product_entity WHERE category='{$root->name}'

                             ";

                            return DB::select(
                                "
                                $sql
                            "
                            );
                        }
                    ],
                    'categories' => [
                        'type' => Types::listOf(Types::category()),
                        'description' => 'Categories list',
                        'resolve' => function ($root, $args) {
                            $sql = "

                                SELECT * FROM categories ORDER BY order_in_interface ASC;

                             ";

                            return DB::select(
                                "
                                $sql
                            "
                            );
                        }
                    ]
                ];
            },
        ];

        if ($debug) {
            echo "\n ======= params4";
        }

        parent::__construct($config);
    }


}

