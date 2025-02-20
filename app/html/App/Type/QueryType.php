<?php

namespace App\Type;

use App\DB;
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
                            'id'=>Types::int()
                        ],
                        'resolve'=> function ($root, $args) {
//                            echo $args['id'];
//                            return DB::selectOne("SELECT * FROM products_table WHERE id = 2 ");
                            return DB::selectOne("SELECT * FROM products_table WHERE id = {$args['id']}");
                        }
                    ],
                    'allProducts'=> [
                        'type'=>Types::listOf(Types::product()),
                        'description'=> 'return List of Products',
                        'resolve'=> function ($root, $args) {
                            $ret = DB::select("SELECT * FROM products_table");
                            return $ret;
                        }
                    ],
                ]; //return fields
            }
        ];

        parent::__construct($config);
    }
}