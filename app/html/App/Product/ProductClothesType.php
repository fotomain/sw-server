<?php

namespace App\Product;

use stdClass;

class ProductClothesType extends ProductAbstructType
{
    private $parameters;

    public function __construct($params=array())
    {
        $init = new stdClass();
        $init->categoryId = 'clothes';
        parent::__construct($init);
    }

}

