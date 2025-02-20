<?php

namespace App;

use GraphQL\Type\Definition\ObjectType;

class ProductType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Product object',
            'fields'=>function () {
                return[
                  'id'=>[
                      'type'=> Types::string(),
                      'description'=> 'Product identifier',
                  ],
                  'name'=>[
                      'type'=> Types::string(),
                      'description'=> 'Product name',
                  ],
                  'price'=>[
                      'type'=> Types::int(),
                      'description'=> 'Product price',
                  ],
                    'attributes'=>[
                        'type'=>Types::listOf(Types::attribute()),
                        'description'=>'attributes of 1 product',
                        'resolve'=>function ($root, $args){

//                            echo "\n === args ";
//                            echo json_encode($args);
//                            echo "\n === root->id ";
//                            echo json_encode($root->id);

                            //cool1: select productId for next level of analytics
                            return DB::select("
                                SELECT DISTINCT aa.attributeSetId as id , productId as productId 
                                FROM products_attributes_register AS aa
                                WHERE aa.productId = '{$root->id}'
                            ");

//                            SELECT aa.attributeSetId as id, aa.attributeOptionId as name
//                                FROM products_attributes_register AS aa
//                                WHERE aa.productId = '{$root->id}'

                        }
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

