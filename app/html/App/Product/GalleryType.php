<?php

namespace App\Product;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

class GalleryType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Attribute object',
            'fields'=>function (){
                return[
                    'entity_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Owner identifier',
                    ],
                    'url_order'=>[
                      'type'=> Types::int(),
                      'description'=> 'order in gallary',
                    ],
                    'url_path'=>[
                      'type'=> Types::string(),
                      'description'=> 'gallary url',
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

