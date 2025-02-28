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

        if($debug) {
            echo "\n ======= params1";
            echo json_encode($params);
            echo "\n ======= params2";
        }

        $this->categorySuffix = ' WHERE 1=1 ';
        if(is_object($params)){
            if(property_exists($params,'categoryId')){
            $this->categorySuffix = $this->categorySuffix
                ." AND category = '{$params->categoryId}' ";
        }}

        if($debug) {
            echo "\n ======= params3";
        }


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
                            $sql = "SELECT DISTINCT 
                                    aa.attribute_id as id , 
                                    hh.attribute_name as name, 
                                    aa.entity_id as productId
                                FROM catalog_product_entity_text AS aa
                                LEFT JOIN attribute_entity hh ON aa.attribute_id=hh.attribute_id
                                WHERE aa.entity_id = '{$root->id}'
                             ";

                            if($this->debug) {
//                                echo "/n === sql attributes1";
//                                echo $sql;
                            }

                            return DB::select("
                                $sql                                                              
                            ");

                        }
                    ]
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

        $debug=false;
        if($debug) {
            echo "\n === getSqlTextSELECT1  ";
            echo json_encode($params);
        }

        $ret = "SELECT product_id AS id, name AS name, 111.11 as price FROM product_entity "
            .$this->categorySuffix;

        return $ret;

    }

    public static function getArgsFilters(){
        $filters = new InputObjectType([
            'name' => 'StoryFiltersInput',
            'fields' => [
                'product_id' => [
                    'type' => Type::id(),
                    'description' => 'product id filter'
                ],
                'inStock' => [
                    'type' => Type::boolean(),
                    'description' => 'inStock filter'
                ],
                'product_name' => [
                    'type' => Type::string(),
                    'description' => 'product name filter'
                ],
                'price_from' => [
                    'type' => Type::float(),
                    'description' => 'price from filter'
                ],
                'price_to' => [
                    'type' => Type::float(),
                    'description' => 'price to filter'
                ],
                'option_id_set' => [
                    'type' => Type::listOf(Type::int()),
                    'description' => 'option id filter'
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

