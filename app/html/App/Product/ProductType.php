<?php

namespace App\Product;

use stdClass;

class ProductType extends ProductAbstructType
{
    public function __construct($params = array())
    {
        $init = new stdClass();
        parent::__construct($init);
    }

}
