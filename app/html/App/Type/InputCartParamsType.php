<?php

namespace App\Type;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

class InputCartParamsType extends InputObjectType
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
                    'product_has_options'=>[
                        'type'=>Types::int(),
                        'description'=>'product has options',
                    ],
                    'product_options'=>[
                        'type'=>Types::listOf(Types::addToCartLineProductOption()),
                        'description'=>'product options',
                    ],
                    'qty'=>[
                        'type'=>Types::int(),
                        'description'=>'quantity',
                    ],
                    'cart_line_id'=>[
                        'type'=>Types::int(),
                        'description'=>'cart line id for delete',
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}