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
                    ]
//                    ', attributeOptions'=>[
//                        'type'=>Types::listOf(Types::attribute()),
//                        'description'=>'attributes of 1 product',
//                        'resolve'=>function ($root){
//
//                            $result = DB::selectAttribures();
//
//                            return $result;
//
//
//                        }
//                    ]

                ];
            },
        ];

        parent::__construct($config);
    }
}

