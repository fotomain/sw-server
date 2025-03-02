<?php

namespace App\Type;

use App\DB;
use App\Order\OrderType;
use App\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class MutationType extends ObjectType
{
    public function __construct()
    {
        //echo " __construct1";
        $config=[
            'fields'=>function () {
                return [
                    'createOrder'=> [
                        'type'=>Types::order(),
                        'description'=>"create 1 order",
                        'args' => [
                            'order'=>Types::inputOrder()
                        ],
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {

                              echo "\n === createOrder1 ";
                              $ret = DB::selectOne("SELECT * FROM order_header WHERE order_id = 1; ");
//                              echo json_encode($ret);

                            return $ret;

                        }
                    ],
                    'createProduct'=> [
                        'type'=>Types::product(),
                        'description'=>"create 1 product",
                        'args' => [
                            'product'=>Types::inputProduct()
                        ],
                        'resolve' => function($root,$args){
//                            echo  "resolve createProduct".json_encode($args);
                            echo  "\n resolve createProduct ".$args['product']['id'];
                            echo  "\n resolve createProduct ".$args['product']['name'];
                            echo  "\n resolve createProduct ".$args['product']['price'];
                            $productId = DB::create("
                                INSERT INTO products_table
                                    (id, name, price)
                                VALUES (
                                    '{$args['product']['id']}', '{$args['product']['name']}', '{$args['product']['price']}'                                      
                                );  
                            ");

                            return DB::selectOne("SELECT * FROM products_table WHERE id = {$productId}");

                        }
                    ],

                    'deleteProduct'=> [
                        'type'=>Types::product(),
                        'description'=>"delete 1 product",
                        'args' => [
                            'id'=>Types::nonNull(Types::string())
                         ],
                        'resolve' => function($root, $args) {
                            $productReturn=DB::selectOne("SELECT * FROM products_table WHERE id = {$args['id']}");
                            DB::delete("DELETE FROM products_table WHERE id = '{$args['id']}' ");
                            return $productReturn;
                        }
                    ],

                    'updateProductPrice'=> [
                            'type'=>Types::product(),
                            'description'=>"update 1 product price",
                            'args' => [
                                'id'=>Types::nonNull(Types::string()),
                                'newPrice'=>Types::int(),
                            ], //args
                            'resolve' => function($root, $args) {
                                $resUpdate = DB::update("UPDATE products_table SET price = '{$args['newPrice']}' WHERE id = '{$args['id']}' ");
//                                    if(1!==$resUpdate){
//                                        $errorText = 'error 1010 - update not successful! product id = '.$args['id'];
//                                        throw new \Exception($errorText);
//                                    }

                                    $retProcuct = DB::selectOne("SELECT * FROM products_table WHERE id = '{$args['id']}' ");
//                                    if(is_null($retProcuct)){
//                                        $errorText = 'error product not found! id = '.$args['id'];
//                                        throw new \Exception($errorText);
//                                    }
                                return $retProcuct;
                            }
                        ], // updateProductPrice
                ];//return
            }
        ];
        parent::__construct($config);
    }
}
