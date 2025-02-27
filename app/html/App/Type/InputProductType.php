<?php

namespace App\Type;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

class InputProductType extends InputObjectType
{
    public function __construct()
    {
        $config=[
            'description'=>'create new Product',
            'fields' => function(){
                return[
                    'id'=>[
                        'type'=>Types::nonNull(Types::string()),
                        'description'=>'Product id',
                    ],
                    'name'=>[
                        'type'=>Types::nonNull(Types::string()),
                        'description'=>'Product name',
                    ],
                    'price'=>[
                        'type'=>Types::nonNull(Types::int()),
                        'description'=>'Product price',
                    ],                ];
            }
        ];
        parent::__construct($config);
    }
}