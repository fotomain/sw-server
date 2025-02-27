<?php

namespace App\Product;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;


class KeyValueType extends ObjectType
{
    private $categorySuffix;
    private $debug;

    public function __construct($params=array())
    {
        $config=[
            'description'=>'Product object',
            'fields'=>function () {
                return[
                  'key'=>[
                      'type'=> Types::string(),
                      'description'=> 'key data',
                  ],
                  'value'=>[
                      'type'=> Types::string(),
                      'description'=> 'value data',
                  ]
                ];
            },
        ];

        parent::__construct($config);
    }

}

