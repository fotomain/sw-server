<?php

namespace App;

use GraphQL\Type\Definition\ObjectType;
use stdClass;

class ProductTechType extends ProductType
{
    public function __construct()
    {
        $aa = new stdClass();
        $aa->categoryId = 'tech';
        parent::__construct($aa);
    }
}

