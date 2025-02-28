<?php

namespace App\Type;

use App\DB;
use App\Product\ProductClothesType;
use App\Product\ProductTechType;
use App\Product\ProductType;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

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
                    'allProducts'=> [
                        'type'=>Types::listOf(Types::product()),
                        'description'=> 'return List of Products',
                        'args'=>[
                                'filters' => [
                                    'type' => ProductType::getArgsFilters(),
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
                    'techProducts'=> [
                        'type'=>Types::listOf(Types::productTech()),
                        'description'=> 'return List of Tech Products',
                        'args'=> ProductTechType::getArgs(),
                        'resolve'=> function ($root, $args) {
                            echo "\n === args";
                            echo json_encode($args);

                            $handler = new ProductTechType();
                            return DB::select($handler->getSqlTextSELECT($args));
                        }
                    ],
                    'clothesProducts'=> [
                        'type'=>Types::listOf(Types::productClothes()),
                        'description'=> 'return List of Clothes Products',
                        'resolve'=> function ($root, $args) {
                            $handler = new ProductClothesType();
                            return DB::select($handler->getSqlTextSELECT());
                        }
                    ],
                ]; //return fields
            }
        ];

        parent::__construct($config);
    }
}