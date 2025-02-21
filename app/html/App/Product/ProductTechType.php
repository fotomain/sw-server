<?php

namespace App\Product;

use stdClass;

class ProductTechType extends ProductAbstructType
{
    public function __construct()
    {
        $aa = new stdClass();
        $aa->categoryId = 'tech';
        parent::__construct($aa);
    }
}

