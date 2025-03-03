<?php

namespace App\Cart;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;

class AddToCartLineProductOptionType extends InputObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Add Line Option Type',
            'fields'=>function (){
                return[
                    'attribute_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Cart Line attribute id',
                    ],
                    'option_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Cart Line option id',
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

