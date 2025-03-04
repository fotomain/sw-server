<?php

namespace App\Cart;

use App\DB;
use PDO;
use stdClass;

class CartController {

public function __construct()
{
}

public static function read_cart_line_of_product_with_options(
    $cart_id,$product_id,$optionsArray
){

//                                echo "\n ========= read_cart  ";
//                                echo json_encode($optionsArray);
//                                echo "\n =========   ";
    $count=sizeof($optionsArray);
//                                echo $count;
//                                echo "\n =========   ";

    $sql_prepare="
                                    DROP TEMPORARY TABLE IF EXISTS temp_lines;
                                    CREATE TEMPORARY TABLE temp_lines
                                    SELECT * FROM cart_line_options WHERE cart_line_id IN
                                    (SELECT cart_line_id FROM cart_lines WHERE cart_id =
                                    (SELECT cart_id FROM cart_header
                                    WHERE cart_guid='".$cart_id."'))
                                    ; 
                                ";
    echo "\n ========= 111  ";
    DB::exec($sql_prepare);

    echo "\n ========= 222  ";

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
    echo "\n ========= sql  ";
    $sql = $sql_select.$sql_join.$sql_where." ;";
    echo $sql;
    echo "\n ========= 333  ";
    $result=DB::execute($sql);
    echo "\n ========= 444  ";
    try {
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
    }catch (e){
        echo "\n ========= ERROR 5001  ";
    }

//                                echo "\n ========= data  ";
//                                echo json_encode($data);
    echo "\n ========= 555  ";
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
