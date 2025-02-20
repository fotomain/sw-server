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

                            echo "\n === attributeOptions root->id ";
                            echo "\n ===  ".$root->id;

                            return DB::select("
                                SELECT DISTINCT aa.attributeOptionId as id , aa.attributeOptionId as name
                                FROM products_attributes_register AS aa
                                WHERE aa.attributeSetId = '{$root->id}'
                            ");


//                            return ['id'=>'111'];



                        }
                    ]

                ];
            },
        ];

        parent::__construct($config);
    }
}

