<?php

namespace App\Type;

use App\DB;
use App\ProductTechType;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config=[
            'fields'=>function() {
                return [
                    'product'=> [
                        'type'=>Types::product(),
                        'description'=> 'return Product by id',
                        'args'=> [
                            'id'=>Types::string()
                        ],
                        'resolve'=> function ($root, $args) {

                    //                            echo $args['id'];
//                            return DB::selectOne("SELECT * FROM products_table WHERE id = 2 ");
//                            echo "SELECT * FROM products_table WHERE id = '{$args['id']}'";

                            return DB::selectOne("SELECT * FROM products_table WHERE id = '{$args['id']}'");
                        }
                    ],
                    'allProducts'=> [
                        'type'=>Types::listOf(Types::product()),
                        'description'=> 'return List of Products',
                        'resolve'=> function ($root, $args) {
                            return DB::select("SELECT * FROM products_table");
                        }
                    ],
                    'techProducts'=> [
                        'type'=>Types::listOf(Types::productTech()),
                        'description'=> 'return List of Tech Products',
                        'resolve'=> function ($root, $args) {
                            $handler = new ProductTechType();
                            $parameters = $handler->parameters();
                            return DB::select("SELECT * FROM products_table ".$parameters->textSqlSelectSuffix);
                        }
                    ],
                ]; //return fields
            }
        ];

        parent::__construct($config);
    }
}