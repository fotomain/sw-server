<?php

namespace App\Type;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

class InputOrderType extends InputObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'create new Product',
            'fields' => function(){
                return[
                    'order_total'=>[
                        'type'=>Types::nonNull(Types::float()),
                        'description'=>'Order total',
                    ],
                    'comment'=>[
                        'type'=>Types::nonNull(Types::string()),
                        'description'=>'Order comment',
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}