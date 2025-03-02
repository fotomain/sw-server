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

                            $sql = "SELECT *
                                        FROM cart_lines
                             ;";

//                            echo  "999";

                            return DB::select("
                                $sql
                            ");

//                            return null; //["id"=>"fff","name"=>"fff"];
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

