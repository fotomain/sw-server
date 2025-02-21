<?php

namespace App;

use GraphQL\Type\Definition\ObjectType;
use stdClass;

class ProductClothesType extends ProductType
{
    private $parameters;

    public function __construct()
    {
        $aa = new stdClass();
        $aa->categoryId = 'clothes';
        parent::__construct($aa);
    }

}

