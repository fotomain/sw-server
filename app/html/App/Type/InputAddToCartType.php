<?php

namespace App\Type;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

class InputAddToCartType extends InputObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'create new Product',
            'fields' => function(){
                return[
                    'cart_guid'=>[
                        'type'=>Types::string(),
                        'description'=>'Cart id',
                    ],
                    'product_id'=>[
                        'type'=>Types::int(),
                        'description'=>'product id',
                    ],
                    'product_options'=>[
                        'type'=>Types::listOf(Types::productOptionAddCart()),
                        'description'=>'product options',
                    ],
                    'qty'=>[
                        'type'=>Types::int(),
                        'description'=>'quantity',
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}