<?php

namespace App\Type;

use App\DB;
use App\Cart\CartType;
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
//                cc6bb519-f811-11ef-a13a-55e370885b2f
                return [
                    'createCart'=> [
                        'type'=>Types::cart(),
                        'description'=>"create 1 cart",
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {

                            $lastIndex = DB::create("INSERT INTO cart_header (cart_guid, total_sum) VALUES( UUID(), 'new Cart'); ");

                            $sqlRet="SELECT * FROM cart_header WHERE cart_id = ".$lastIndex."; ";

                            return DB::selectOne($sqlRet);

                        }
                    ],

                    'addToCart'=> [
                        'type'=>Types::cart(),
                        'description'=>"create or update 1 cart line",
                        'args' => [
                            'addToCartData'=>Types::inputAddToCart()
                        ],
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {
                              echo "\n === addToCart ";
                              echo "\n === args ";
                              echo json_encode($args);
                              echo "\n =========== ";

                            $sqlHeader="SELECT cart_id FROM cart_header WHERE cart_guid = '".$args['addToCartData']['cart_guid']."' ; ";
                            $retHeader = DB::selectOne($sqlHeader);
                            echo "\n =========== cart_id ".$retHeader->cart_id;
                              
                            $lastIndex = DB::create("INSERT INTO cart_lines (
                                    cart_id, 
                                    product_id, 
                                    qty
                                ) 
                                VALUES( 
                                     '{$retHeader->cart_id}',
                                     '{$args['addToCartData']['product_id']}',
                                     '{$args['addToCartData']['qty']}'
                                       ); ");
                                echo "\n =========== lastIndex";
                                echo $lastIndex;
                                echo "\n =========== ";

                                $sqlRet="SELECT * FROM cart_header WHERE cart_id = ".$lastIndex."; ";
                                echo "\n =========== sqlRet".$sqlRet;

                              $ret = DB::selectOne($sqlRet);
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
