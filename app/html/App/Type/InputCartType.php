<?php

namespace App\Type;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

class InputCartType extends InputObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'create new Product',
            'fields' => function(){
                return[
                    'cart_total'=>[
                        'type'=>Types::nonNull(Types::float()),
                        'description'=>'Cart total',
                    ],
                    'comment'=>[
                        'type'=>Types::nonNull(Types::string()),
                        'description'=>'Cart comment',
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}