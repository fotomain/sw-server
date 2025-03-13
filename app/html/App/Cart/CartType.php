<?php

namespace App\Cart;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


class CartType extends ObjectType
{

    private $debug;

    public function __construct($params=array())
    {
        $debug=false;

        if($debug) {
            echo "\n ======= params1";
            echo json_encode($params);
            echo "\n ======= params2";
        }


        $config=[
            'description'=>'Product object',
            'fields'=>function () {
                return[
                  'cart_id'=>[
                      'type'=> Types::int(),
                      'description'=> 'cart identifier',
                  ],
                  'cart_guid'=>[
                      'type'=> Types::string(),
                      'description'=> 'cart identifier',
                  ],
                  'cart_total'=>[
                      'type'=> Types::float(),
                      'description'=> 'cart total',
                      'resolve'=>function ($root, $args) {
                          $sql = "
                             SELECT SUM( CAST(li.qty * pl.price AS DECIMAL(6,2))  ) AS total_cart
                             FROM cart_lines AS li
                                LEFT JOIN price_list as pl ON li.product_id=pl.entity_id
                                WHERE   pl.currency_id='USD'
                                AND     li.cart_id=" . $root->cart_id .
                              "
                             ;";

                          $res = DB::selectOne("
                                $sql
                            ");

                          return $res->total_cart;

                        }
                       ],
                  'email'=>[
                      'type'=> Types::string(),
                      'description'=> 'email identifier',
                  ],
                  'comment'=>[
                      'type'=> Types::string(),
                      'description'=> 'comment ',
                  ],
                    'cart_lines' => [
                        'type' => Types::listOf(Types::cartLine()),
                        'resolve'=>function ($root, $args){
                            $sql = "
                             SELECT pl.price AS price,  ROUND(pl.price*li.qty,2) AS total_line, li.* FROM cart_lines AS li
                                LEFT JOIN price_list as pl ON li.product_id=pl.entity_id
                                WHERE   pl.currency_id='USD'
                                AND     cart_id=".$root->cart_id.
                                "
                             ;";

                            return DB::select("
                                $sql
                            ");

                        }
                    ],

                ];
            },
        ];

        if($debug) {
            echo "\n ======= params4";
        }

        parent::__construct($config);
    }

    public function getSqlTextSELECT($params){
    // how to pass params

    }

    public static function getLineType(){
        $lineType = new InputObjectType([
            'name' => 'CartLineType',
            'fields' => [
                'cart_line_id' => [
                    'type' => Type::int(),
                    'description' => 'product id filter'
                ],
                'product_id' => [
                    'type' => Type::int(),
                    'description' => 'product id filter'
                ],
                'quantity' => [
                    'type' => Type::int(),
                    'description' => 'price from filter'
                ],
            ]
        ]);
        return $lineType;
    }


}


//                            echo "\n === root1";
//                            echo json_encode($root);
