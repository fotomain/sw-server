<?php

namespace App;

use GraphQL\Type\Definition\ObjectType;
use stdClass;

class ProductTechType extends ProductType
{
    private $parameters;

    //    = {
//            'category'=>'tech',
//            'textSqlSelectSuffix'=>"WHERE category='tech' ",
//        };
    public function __construct()
    {
        $aa = new stdClass();
        $aa->category = 'tech';
        $aa->textSqlSelectSuffix = "WHERE category='tech' ";
        $this->parameters = $aa;
        parent::__construct();
    }

    public function parameters(): stdClass {
        return $this->parameters;
    }
}

