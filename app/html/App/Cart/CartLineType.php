<?php

namespace App\Cart;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;

class CartLineType extends ObjectType
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
                    'cart_id'=>[
                      'type'=> Types::string(),
                      'description'=> 'Cart identifier',
                    ],
                    'comment'=>[
                      'type'=> Types::string(),
                      'description'=> 'CartLine name',
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

