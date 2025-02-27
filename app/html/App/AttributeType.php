<?php

namespace App;
use GraphQL\Type\Definition\ObjectType;

class AttributeType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'Attribute object',
            'fields'=>function (){
                return[
                    'id'=>[
                      'type'=> Types::string(),
                      'description'=> 'Attribute identifier',
                    ],
                    'name'=>[
                      'type'=> Types::string(),
                      'description'=> 'Attribute name',
                    ],
                    'attributeOptions'=>[
                        'type'=>Types::listOf(Types::attributeOption()),
                        'description'=>'attributes of 1 product',
                        'resolve'=>function ($root,$args){

//                            echo "\n === attributeOptions root->id ";
//                            echo "\n ===  ".$root->id;
//                            echo "\n === root ";
//                            echo "\n ===  ".json_encode($root);

                            //cool1: use productId from previous level of analytics
                            $sql = "
                                SELECT 
                                    ao.option_id as id ,                                      
                                    ao.displayValue as displayValue,
                                    ao.value as name                                    
                                FROM attribute_options AS ao
                                WHERE ao.attribute_id = {$root->id}                                       
                            ";
//                            echo $sql;
                            return DB::select($sql);

                        }
                    ]

                ];
            },
        ];

        parent::__construct($config);
    }
}

