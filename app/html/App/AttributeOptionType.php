<?php

namespace App;

use GraphQL\Type\Definition\ObjectType;

class AttributeOptionType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Attribute Option',
            'fields'=>function (){
                return[
                    'id'=>[
                      'type'=> Types::string(),
                      'description'=> 'Attribute Option identifier',
                    ],
                    'name'=>[
                      'type'=> Types::string(),
                      'description'=> 'Attribute Option name',
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

