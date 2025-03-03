<?php

namespace App\Cart;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

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
                      'type'=> Types::int(),
                      'description'=> 'Cart identifier',
                    ],
                    'product_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'Cart identifier',
                    ],
                    'product_has_options'=>[
                      'type'=> Types::int(),
                      'description'=> 'product has options',
                    ],
                    'qty'=>[
                      'type'=> Types::float(),
                      'description'=> 'Cart identifier',
                    ],
                    'comment'=>[
                      'type'=> Types::string(),
                      'description'=> 'CartLine name',
                    ],
                    'product_options'=>[
                        'type'=> Types::listOf(Types::cartLineOption()),
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {

                            $sql="  SELECT * FROM cart_line_options
                                    WHERE cart_line_id=".$root->cart_line_id;"
                            ";
                            $result=DB::select($sql);
                            return $result;
                        }
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

