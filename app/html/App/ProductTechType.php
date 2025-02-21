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
        $aa->categoryId = 'tech';
        $this->parameters = $aa;
        parent::__construct($aa);
    }

    public function parameters(): stdClass {
        return $this->parameters;
    }
}

