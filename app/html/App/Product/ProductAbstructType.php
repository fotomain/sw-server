<?php

namespace App\Product;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


abstract class ProductAbstructType extends ObjectType
{
    private $categorySuffix;
    private $debug;

    public function __construct($params = array())
    {
        $debug = false;

        if ($debug) {
            echo "\n ======= params1";
            echo json_encode($params);
            echo "\n ======= params2";
        }

        $this->categorySuffix = ' WHERE 1=1 ';
        if (is_object($params)) {
            if (property_exists($params, 'categoryId')) {
                $this->categorySuffix = $this->categorySuffix
                    . " AND category = '{$params->categoryId}' ";
            }
        }

        if ($debug) {
            echo "\n ======= params3";
        }


        $config = [
            'description' => 'Product object',
            'fields' => function () {
                return [
                    'product_id' => [
                        'type' => Types::string(),
                        'description' => 'Product identifier',
                    ],
                    'sku' => [
                        'type' => Types::string(),
                        'description' => 'Product sku identifier',
                    ],
                    'inStock' => [
                        'type' => Types::int(),
                        'description' => 'Product in Stock',
                    ],
                    'has_options' => [
                        'type' => Types::int(),
                        'description' => 'Product has options',
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Product name',
                    ],
                    'category' => [
                        'type' => Types::string(),
                        'description' => 'Product description',
                    ],
                    'brand' => [
                        'type' => Types::string(),
                        'description' => 'Product description',
                    ],
                    'description' => [
                        'type' => Types::string(),
                        'description' => 'Product description',
                    ],
                    'price' => [
                        'type' => Types::float(),
                        'description' => 'Product price',
                        'resolve' => function ($root, $args) {
                            $sql = "  
                                SELECT price.price FROM price_list as price
                                     WHERE price.entity_id=" . $root->product_id . "
                                     AND price.currency_id='USD'
                                                                
                            ";

                            $result = DB::selectOne($sql);

                            return $result->price;
                        }
                    ],
                    'gallery' => [
                        'type' => Types::listOf(Types::gallery()),
                        'description' => 'gallery url',
                        'resolve' => function ($root, $args) {
                            $sql = "SELECT * 
                                    FROM product_gallery AS g
                                    WHERE g.entity_id = '{$root->product_id}'
                                    ORDER BY g.url_order ASC
                             ";


                            return DB::select(
                                "
                                $sql                                                              
                            "
                            );
                        }
                    ],
                    'attributes' => [
                        'type' => Types::listOf(Types::attribute()),
                        'description' => 'attributes of 1 product',
                        'resolve' => function ($root, $args) {
//                            echo "\n === args ";
//                            echo json_encode($args);
//                            echo "\n === root->id ";
//                            echo json_encode($root->id);

                            //cool1: select productId for next level of analytics
                            $sql = "SELECT DISTINCT 
                                    aa.attribute_id as id , 
                                    hh.attribute_name as name, 
                                    aa.entity_id as productId
                                FROM product_option_value AS aa
                                LEFT JOIN attribute_entity hh ON aa.attribute_id=hh.attribute_id
                                WHERE aa.entity_id = '{$root->product_id}'
                                ORDER BY hh.display_order ASC

                             ";

                            if ($this->debug) {
//                                echo "/n === sql attributes1";
//                                echo $sql;
                            }

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

    public static function getArgsFilters($name)
    {
        $filters = new InputObjectType([
            'name' => $name,
            'fields' => [
                'filterProductName' => [
                    'type' => Type::string(),
                    'description' => 'product id filter'
                ],
                'product_id' => [
                    'type' => Type::id(),
                    'description' => 'product id filter'
                ],
                'inStock' => [
                    'type' => Type::boolean(),
                    'description' => 'inStock filter'
                ],
                'product_name' => [
                    'type' => Type::string(),
                    'description' => 'product name filter'
                ],
                'price_from' => [
                    'type' => Type::float(),
                    'description' => 'price from filter'
                ],
                'price_to' => [
                    'type' => Type::float(),
                    'description' => 'price to filter'
                ],
                'option_id_set' => [
                    'type' => Type::listOf(Type::int()),
                    'description' => 'option id filter'
                ]
            ]
        ]);
        return $filters;
    }

    public static function getArgs()
    {
//            where: "8888"

//        $args = new stdClass();
//        $args->name=Types::string();
        $args = array();
//        $args = [...$args,'where'=>Types::string()] ;
        $args = [...$args, 'where' => Types::string()];
        return $args;
    }

    public function getSqlTextSELECT($params)
    {
        $a = $params['filters'];
        $filterProductName="";

        if(!empty($a['filterProductName'])){
            $filterProductName = " AND name LIKE '%".$a['filterProductName']."%'";
        }

        $ret = "SELECT * FROM product_entity ".$this->categorySuffix.$filterProductName;

        return $ret;
    }


}

