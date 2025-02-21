<?php

namespace App\Product;

use stdClass;

class ProductClothesType extends ProductAbstructType
{
    private $parameters;

    public function __construct()
    {
        $aa = new stdClass();
        $aa->categoryId = 'clothes';
        parent::__construct($aa);
    }

}

