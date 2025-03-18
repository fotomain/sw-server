<?php

namespace App\Type;

use App\Cart\CartController;
use App\DB;
use App\Cart\CartType;
use App\Types;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use PDO;
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
                    'deleteCartLine'=> [
                        'type'=>Types::cart(),
                        'description'=>"delete 1 line from the cart",
                        'args' => [
                            'cartParams'=>Types::inputCartParams()
                        ],
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {

                            $a = [...$args['cartParams']];
//                            echo json_encode($a);
                            $cartHeader=CartController::readCartHeader($a['cart_guid']);
                            if(null==$cartHeader){
                                $errorText="ERROR 5128: Cart not found! Cart id: ".$a['cart_guid'];
                                echo new Error($errorText);
                            }

                            $cartLine=CartController::readCartLine($a['cart_guid'], $a['cart_line_id']);

                            if(null==$cartLine){
                                $errorText="ERROR 5130: cart line not found! Cart id: ".$a['cart_guid']." line id ".$a['cart_line_id'];
                                echo new Error($errorText);
                            }

                            CartController::deleteCartLine($a['cart_guid'], $cartLine->cart_line_id);

                            return $cartHeader;

                        }
                    ],

                    'createOrder'=> [
                        'type'=>Types::string(),
                        'description'=>"create or update 1 cart line",
                        'args' => [
                            'cartParams'=>Types::inputCartParams()
                        ],
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {

                            $a = [...$args['cartParams']];

                            $sql="                            
                                SET @CART_GUID = '".$a['cart_guid']."' ;
                                
                                INSERT INTO order_header
                                SELECT *
                                FROM cart_header
                                WHERE cart_guid = @CART_GUID ;
                                
                                INSERT INTO order_lines (cart_id,cart_line_id,product_id,qty,comment, price, total_sum_line)
                                SELECT cart_id,cart_line_id,product_id,qty,comment, pl.price as price, CAST(qty * pl.price AS DECIMAL(6,2)) as total_sum_line
                                FROM cart_lines
                                LEFT JOIN price_list AS pl ON product_id=pl.entity_id
                                WHERE
                                pl.currency_id='USD'
                                AND
                                cart_id = (SELECT cart_id FROM cart_header
                                WHERE cart_guid = @CART_GUID LIMIT 1
                                );
                                
                                INSERT INTO order_line_options
                                SELECT *
                                FROM cart_line_options
                                WHERE cart_line_id IN (SELECT cart_line_id FROM cart_lines WHERE cart_id = (SELECT cart_id FROM cart_header
                                WHERE cart_guid = @CART_GUID LIMIT 1
                                ));
                                
                                
                                UPDATE order_header SET total_sum = (
                                SELECT SUM(  total_sum_line )
                                FROM order_lines
                                WHERE cart_line_id IN (SELECT cart_line_id FROM cart_lines WHERE cart_id = (SELECT cart_id FROM cart_header
                                WHERE cart_guid = @CART_GUID LIMIT 1
                                )))
                                WHERE cart_guid = @CART_GUID ;
                                                                                                                           
                            ";

                            DB::create($sql);

                            $sql="                                
                                SELECT * FROM order_header WHERE cart_guid = '".$a['cart_guid']."' ; 
                            ";

                            $res = DB::select($sql);

                            return 'createOrder-json-'.json_encode($res);


                        }

                    ],


                    'addToCart'=> [
                        'type'=>Types::cart(),
                        'description'=>"create or update 1 cart line",
                        'args' => [
                            'cartParams'=>Types::inputCartParams()
                        ],
                        'resolve'=>function ($root, $args, $context, ResolveInfo $info) {

                            $a = [...$args['cartParams']];

                            $cartHeader=CartController::readCartHeader($a['cart_guid']);
                            if(null==$cartHeader){
                                $errorText="ERROR 5126: Cart not found! Cart id: ".$a['cart_guid'];
                                echo new Error($errorText);
                            }

                            $productHasOptions=false;
                            if(array_key_exists("product_has_options",$a)) {
                                $productHasOptions = $a['product_has_options'];
                            }

                            $optionsArrayPassed = false;
                            $optionsArray=[];
                            $optionsArrayIsFull=false;
                            if(array_key_exists("product_options",$a)) {
                                $optionsArrayPassed = true;
                                $optionsArray = $a['product_options'];
                                $optionsArrayIsFull = (0<sizeof($optionsArray));
                            }

                            if($productHasOptions && $optionsArrayPassed && (!$optionsArrayIsFull)) {
                                $errorText="ERROR 303: options passed but array is empty! ";
                                echo new Error($errorText);
                            }

                            $resLine = CartController::read_cart_line_of_product_with_options(
                                $a['cart_guid'],
                                $a['product_id'],
                                $optionsArray
                            );

                            switch ($resLine->result) {
                                case "found_1_line": {
                                    //=== case qty +1
//                                    echo $resLine->cart_line_id;
                                    $ret = CartController::updateQtyPlus( $resLine->cart_line_id, $a['qty']);
                                    $ret = CartController::readCartHeader($cartHeader->cart_guid);
                                    return $ret;
                                }
                                case "found_more_1_line": {
                                    //=== case ERROR
                                    $errorText="ERROR 5125: found more 1 line but 1 line needed ";
                                    echo Error($errorText);
                                }
                            }

                            //=== case ADD NEW LINE
//                            echo "\n ========= resLine  ";
//                            echo json_encode($resLine);
//
//                            echo "\n ========= optionsArrayIsFull  ";
//                            echo json_encode($optionsArrayIsFull);
//                            echo "\n ================== ";

                            $cartLine = DB::create("INSERT INTO cart_lines (
                                    cart_id, 
                                    product_id,
                                    product_has_options,
                                    qty
                                ) 
                                VALUES( 
                                     '{$cartHeader->cart_id}',
                                     '{$a['product_id']}',
                                     '{$a['product_has_options']}',
                                     '{$a['qty']}'
                                       ); ");

                                if($optionsArrayPassed && $optionsArrayIsFull) {

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

                                $ret = CartController::readCartHeader($cartHeader->cart_guid);

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
