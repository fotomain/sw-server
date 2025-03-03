<?php

namespace App\Cart;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;

class CartLineOptionsType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Cart Line Type',
            'fields'=>function (){
                return[
                    'cart_line_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Cart Line identifier',
                    ],
                    'attribute_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Cart identifier',
                    ],
                    'option_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Cart identifier',
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

