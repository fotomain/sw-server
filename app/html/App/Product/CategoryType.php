<?php

namespace App\Product;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


class CategoryType extends ObjectType
{
    private $debug;

    public function __construct($params=array())
    {
        $debug=false;

        if($debug) {
            echo "\n ======= params1";
            echo json_encode($params);
            echo "\n ======= params2";
        }


        $config=[
            'description'=>'Category object',
            'fields'=>function () {
                return[
                  'category_id'=>[
                      'type'=> Types::string(),
                      'description'=> 'Category identifier',
                  ],
                  'name'=>[
                      'type'=> Types::string(),
                      'description'=> 'Category name',
                  ],
                  'order_in_interface'=>[
                      'type'=> Types::string(),
                      'description'=> 'Category order_in_interface',
                  ],
//                    'attributes'=>[
//                        'type'=>Types::listOf(Types::attribute()),
//                        'description'=>'attributes of 1 product',
//                        'resolve'=>function ($root, $args){
//
//                            //cool1: select productId for next level of analytics
//                            $sql = "SELECT DISTINCT
//                                    aa.attribute_id as id ,
//                                    hh.attribute_name as name,
//                                    aa.entity_id as productId
//                                FROM catalog_product_entity_text AS aa
//                                LEFT JOIN attribute_entity hh ON aa.attribute_id=hh.attribute_id
//                                WHERE aa.entity_id = '{$root->product_id}'
//                                ORDER BY hh.display_order ASC
//
//
//
//                             ";
//
//                            if($this->debug) {
////                                echo "/n === sql attributes1";
////                                echo $sql;
//                            }
//
//                            return DB::select("
//                                $sql
//                            ");
//
//                        }
//                    ]
                ];
            },
        ];

        if($debug) {
            echo "\n ======= params4";
        }

        parent::__construct($config);
    }


}

