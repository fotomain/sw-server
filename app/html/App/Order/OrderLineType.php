<?php

namespace App\Order;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;

class OrderLineType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Order Line Type',
            'fields'=>function (){
                return[
                    'order_line_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Order Line identifier',
                    ],
                    'order_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Order identifier',
                    ],
                    'comment'=>[
                      'type'=> Types::string(),
                      'description'=> 'OrderLine name',
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

