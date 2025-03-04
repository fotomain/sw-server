<?php

namespace App\Cart;

use App\DB;
use PDO;
use stdClass;

class CartController {

public function __construct()
{
}

public static function updateQtyPlus($cart_line_id, $qty){

    $sql="UPDATE cart_lines SET qty=qty+".$qty." WHERE cart_line_id=".$cart_line_id." ; ";
    DB::execute($sql);

}
public static function readCartHeader($cart_guid)
{
    $sqlRet="SELECT * FROM cart_header WHERE cart_guid = '".$cart_guid."' ; ";
//    echo $sqlRet;
    $ret = DB::selectOne($sqlRet);
    return $ret;
}

//TODO $product_id
public static function read_cart_line_of_product_with_options(
    $cart_id,$product_id,$optionsArray
){

    $count=sizeof($optionsArray);

    $sql_prepare="
                                    DROP TEMPORARY TABLE IF EXISTS temp_lines;
                                    CREATE TEMPORARY TABLE temp_lines
                                    SELECT * FROM cart_line_options WHERE cart_line_id IN
                                    (SELECT cart_line_id FROM cart_lines WHERE product_id=".$product_id." AND cart_id =
                                    (SELECT cart_id FROM cart_header
                                    WHERE cart_guid='".$cart_id."'))
                                    ; 
                                ";

    DB::exec($sql_prepare);

    $sql_select="SELECT t1.cart_line_id FROM temp_lines AS t1 ";
    $o=$optionsArray[0];
    $sql_where ="WHERE t1.attribute_id=".$o['attribute_id']." AND t1.option_id=".$o['option_id']." ";
    $sql_join="";
    if($count>1) {
        for ($i = 1; $i < $count; $i++) {
            $o=$optionsArray[$i];
            $sql_join.=" INNER JOIN temp_lines AS t".($i+1)." ON t".($i).".cart_line_id =t".($i+1).".cart_line_id ";
            $sql_where.=" AND t".($i+1).".attribute_id=".$o['attribute_id']." AND t".($i+1).".option_id=".$o['option_id']." ";
        }
    }

//                                echo "\n ========= sql_join  ";
//                                echo $sql_join;
//                                echo "\n ========= sql_where  ";
//                                echo $sql_where;
//    echo "\n ========= sql  ";
    $sql = $sql_select.$sql_join.$sql_where." ;";
//    echo $sql;
    $result=DB::execute($sql);
    try {
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
    }catch (e){
        echo "\n ========= ERROR 5001  ";
    }

//    echo json_encode($data);

    $ret=new stdClass();

    switch (sizeof($data)) {
        case 0:
        {
            $ret->status = 200;
            $ret->result="not_found";
            return $ret;
            break;
        }
        case 1:
        {
            $ret->status = 200;
            $ret->result="found_1_line";
            $ret->cart_line_id = $data[0]["cart_line_id"];
            return $ret;
            break;
        }
        default:{
            $ret->status = 500;
            $ret->result="found_more_1_line";
            return $ret;
        }
    }


}

}
