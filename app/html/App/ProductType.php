<?php

namespace App;

use GraphQL\Type\Definition\ObjectType;

class ProductType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Product object',
            'fields'=>function (){
                return[
                  'id'=>[
                      'type'=> Types::int(),
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
                        'type'=>Types::listOf(Types::product()),
                        'description'=>'attributes of 1 product',
                        'resolve'=>function ($root){
                            return DB::select("
                                
                                SELECT p.* FROM products_attributes_table AS c
                                    LEFT JOIN attributes_values_table AS p
                                        ON c.attributeId = p.attributeId
                                        WHERE c.productId={$root->id}
                                
                            ");



                        }
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

