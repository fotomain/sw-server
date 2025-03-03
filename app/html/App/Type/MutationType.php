<?php

namespace App\Type;

use App\DB;
use App\Cart\CartType;
use App\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use stdClass;

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

//                    TODO qty:+1 to cart
                    'addToCart'=> [
                        'type'=>Types::cart(),
                        'description'=>"create or update 1 cart line",
                        'args' => [
                            'addToCartData'=>Types::inputAddToCart()
                        ],
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {

                            $a = [...$args['addToCartData']];

                            $sqlHeader="SELECT cart_id FROM cart_header WHERE cart_guid = '".$a['cart_guid']."' ; ";
                            $cartHeader = DB::selectOne($sqlHeader);

                            $cartLine = DB::create("INSERT INTO cart_lines (
                                    cart_id, 
                                    product_id, 
                                    qty
                                ) 
                                VALUES( 
                                     '{$cartHeader->cart_id}',
                                     '{$a['product_id']}',
                                     '{$a['qty']}'
                                       ); ");

                                $hasOptions = array_key_exists("product_options",$a);

                                if($hasOptions){
                                    $optionsArray = $a['product_options'];

                                    $sql = "";
                                    for ($i = 0; $i < sizeof($optionsArray) ; $i++) {
                                        $o = $optionsArray[$i];
                                        $sql .= "
                                        INSERT INTO cart_line_options (cart_line_id, attribute_id, option_id)
                                        VALUES (
                                            '{$cartLine}',
                                            '{$o['attribute_id']}',
                                            '{$o['option_id']}'
                                        );
                                    ";
                                    }
                                    DB::create($sql);
                                }

                              $sqlRet="SELECT * FROM cart_header WHERE cart_id = ".$cartHeader->cart_id."; ";

                              $ret = DB::selectOne($sqlRet);

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
