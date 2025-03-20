<?php

namespace App\Cart;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class CartLineType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Cart Line Type',
            'fields' => function () {
                return [
                    'cart_line_id' => [
                        'type' => Types::int(),
                        'description' => 'Cart Line identifier',
                    ],
                    'cart_id' => [
                        'type' => Types::int(),
                        'description' => 'Cart identifier',
                    ],
                    'product_id' => [
                        'type' => Types::int(),
                        'description' => 'Cart identifier',
                    ],
                    'qty' => [
                        'type' => Types::float(),
                        'description' => 'Cart identifier',
                    ],
                    'price' => [
                        'type' => Types::float(),
                        'description' => 'Cart line price',
                    ],
                    'total_line' => [
                        'type' => Types::float(),
                        'description' => 'Cart line total',
                    ],
                    'comment' => [
                        'type' => Types::string(),
                        'description' => 'CartLine name',
                    ],
                    'product_object' => [
                        'type' => Types::product(),
                        'resolve' => function ($root, $args, $context, ResolveInfo $info) {
                            $sql = "  
                                    SELECT price.price as price, p.* FROM product_entity p
                                    LEFT JOIN price_list AS price ON p.product_id=price.entity_id
                                         WHERE product_id=" . $root->product_id . "
                                         AND price.currency_id='USD'
                                                                
                            ";


                            $result = DB::selectOne($sql);

                            return $result;
                        }
                    ],
                    'product_options' => [
                        'type' => Types::listOf(Types::cartLineOption()),
                        'resolve' => function ($root, $args, $context, ResolveInfo $info) {
                            $sql = "  SELECT * FROM cart_line_options
                                    WHERE cart_line_id=" . $root->cart_line_id;
                            "
                            ";
                            $result = DB::select($sql);
                            return $result;
                        }
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}

