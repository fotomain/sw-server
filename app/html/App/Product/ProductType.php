<?php

namespace App\Product;

use stdClass;

class ProductType extends ProductAbstructType
{
    public function __construct()
    {
        $aa = new stdClass();
        $aa->filters = '';
        parent::__construct($aa);
    }
}
