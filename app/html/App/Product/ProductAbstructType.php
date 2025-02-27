<?php

namespace App\Product;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


abstract class ProductAbstructType extends ObjectType
{
    private $categorySuffix;
    private $debug;

    public function __construct($params=array())
    {
        $debug=false;

        echo "\n ======= params1";
        echo json_encode($params);
        echo "\n ======= params2";

        $this->categorySuffix = ' WHERE 1=1 ';
        if(is_object($params)){
            if(property_exists($params,'categoryId')){
            $this->categorySuffix = $this->categorySuffix
                ." AND category = '{$params->categoryId}' ";
        }}
        echo "\n ======= params3";

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
                            $sql = "SELECT DISTINCT aa.attribute_id as id , hh.attribute_name as name, aa.entity_id as productId
                                FROM catalog_product_entity_text AS aa
                                LEFT JOIN attribute_entity hh ON aa.attribute_id=hh.attribute_id
                                WHERE aa.entity_id = '{$root->id}'
                             ";

                            if($this->debug) echo $sql;

                            return DB::select("
                                $sql                                                              
                            ");

                        }
                    ]
                ];
            },
        ];

        echo "\n ======= params4";
        parent::__construct($config);
    }

    public function getSqlTextSELECT($params){
    // how to pass params
        // js->JSON.stringify() => (where:"{\"name\":\"iMac 2021\"}
        //      "\"name\":[\"iMac 2021\",\"iMac 2022\"]"
        //      "{\"name\":{ \"eq\": \"iMac 2021\" }, \"Color\":{ \"eq\": \"black\" }}"
        // prepare tests json online https://jsonformatter.org/json-stringify-online

        echo "\n === 111111  ";
        echo json_encode($params);
//        $where0 = $params['where'];
//        echo "\n === where0  ".$where0;
//        echo "\n === where0 gettype ".gettype($where0);
//        $where=json_decode($where0);
//        echo "\n === type of where ".gettype($where);
//
//            $array = get_object_vars($where);
//            $whereNames  = array_keys($array);
//            $whereValues = array_values($array);
//            for ( $i = 0; $i <sizeof($whereNames) ; $i++) {
//                echo "\n === whereNames ".json_encode($whereNames[$i]);
//                echo "\n === whereValuew ".json_encode($whereValues[$i]->eq);
//            }
//
//        $filters = json_encode($where,true);
//        echo "\n === obj1 ".$filters;
//        echo "\n === obj2 ".gettype($filters);
//

        echo "\n === ";

//        $ret = "SELECT * FROM products_table ".$this->categorySuffix;

        $ret = "SELECT product_id AS id, name AS name, 111.11 as price FROM product_entity "
            .$this->categorySuffix;

        return $ret;

    }

    public static function getArgs2(){
        $filters = new InputObjectType([
            'name' => 'StoryFiltersInput',
            'fields' => [
                'author' => [
                    'type' => Type::id(),
                    'description' => 'Only show stories with this author id'
                ],
                'popular' => [
                    'type' => Type::boolean(),
                    'description' => 'Only show popular stories (liked by several people)'
                ],
                'tags' => [
                    'type' => Type::listOf(Type::string()),
                    'description' => 'Only show stories which contain all of those tags'
                ]
            ]
        ]);
        return $filters;
    }

        public static function getArgs(){

//            where: "8888"

//        $args = new stdClass();
//        $args->name=Types::string();
        $args = array();
//        $args = [...$args,'where'=>Types::string()] ;
        $args = [...$args,'where'=>Types::string()] ;
        return $args;
    }


}

