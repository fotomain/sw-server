<?php

namespace App\Product;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

abstract class ProductAbstructType extends ObjectType
{
    private $categorySuffix;

    public function __construct($params=array())
    {
        echo "\n ======= params";
        echo json_encode($params);

        $this->categorySuffix = ' WHERE 1=1 ';
        if(is_object($params)){
            if(property_exists($params,'categoryId')){
            $this->categorySuffix = $this->categorySuffix
                ." AND category = '{$params->categoryId}' ";
        }}

//        echo "\n categorySuffix1 ";
//        echo $this->categorySuffix;

        $config=[
            'description'=>'Product object',
            'fields'=>function () {
                return[
                  'id'=>[
                      'type'=> Types::string(),
                      'description'=> 'Product identifier',
                  ],
                  'name'=>[
                      'type'=> Types::string(),
                      'description'=> 'Product name',
                  ],
                  'price'=>[
                      'type'=> Types::int(),
                      'description'=> 'Product price',
                  ],
                    'attributes'=>[
                        'type'=>Types::listOf(Types::attribute()),
                        'description'=>'attributes of 1 product',
                        'resolve'=>function ($root, $args){

//                            echo "\n === args ";
//                            echo json_encode($args);
//                            echo "\n === root->id ";
//                            echo json_encode($root->id);

                            //cool1: select productId for next level of analytics
                            return DB::select("
                                SELECT DISTINCT aa.attributeSetId as id , productId as productId 
                                FROM products_attributes_register AS aa
                                WHERE aa.productId = '{$root->id} '
                            ");


                        }
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }

    public function getSqlTextSELECT($params){
    // how to pass params
        // js->JSON.stringify() => (where:"{\"name\":\"iMac 2021\"}
        //      "\"name\":[\"iMac 2021\",\"iMac 2022\"]"
        //      "{\"name\":{ \"eq\": \"iMac 2021\" }, \"color\":{ \"eq\": \"black\" }}"
        // prepare tests json online https://jsonformatter.org/json-stringify-online

        $where0 = $params['where'];
        echo "\n === where0  ".$where0;
        echo "\n === where0 gettype ".gettype($where0);
        $where=json_decode($where0);
        echo "\n === type of where ".gettype($where);

            $array = get_object_vars($where);
            $whereNames  = array_keys($array);
            $whereValues = array_values($array);
            for ( $i = 0; $i <sizeof($whereNames) ; $i++) {
                echo "\n === whereNames ".json_encode($whereNames[$i]);
                echo "\n === whereValuew ".json_encode($whereValues[$i]->eq);
            }

        $filters = json_encode($where,true);
        echo "\n === obj1 ".$filters;
        echo "\n === obj2 ".gettype($filters);


        echo "\n === ";

//        $ret = "SELECT * FROM products_table ".$this->categorySuffix;

        $ret = "SELECT * FROM products_table "
            .$this->categorySuffix;
//            ." A//ND name = '{$params['where']->name}' ";

//        echo "\n === getSqlTextSELECT";
//        echo $ret;
        return $ret;

    }
}

