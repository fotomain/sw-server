<?php

namespace App;

use GraphQL\Type\Definition\ObjectType;

class AttributeType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Attribute object',
            'fields'=>function (){
                return[
                    'id'=>[
                      'type'=> Types::string(),
                      'description'=> 'Attribute identifier',
                    ],
                    'name'=>[
                      'type'=> Types::string(),
                      'description'=> 'Attribute name',
                    ],
                    'attributeOptions'=>[
                        'type'=>Types::listOf(Types::attributeOption()),
                        'description'=>'attributes of 1 product',
                        'resolve'=>function ($root,$args){

//                            echo "\n === attributeOptions root->id ";
//                            echo "\n ===  ".$root->id;
//                            echo "\n === root ";
//                            echo "\n ===  ".json_encode($root);

                            //cool1: use productId from previous level of analytics
                            return DB::select("
                                SELECT DISTINCT aa.attributeOptionId as id , aa.attributeOptionId as name
                                FROM products_attributes_register AS aa
                                WHERE aa.attributeSetId = '{$root->id}'
                                      AND aa.productId = '{$root->productId}' 
                            ");

                        }
                    ]

                ];
            },
        ];

        parent::__construct($config);
    }
}

