<?php

namespace App\Product;

use stdClass;

class ProductType extends ProductAbstructType
{

        public function __construct($params=array())
    {

        echo json_encode($params);
        $init = new stdClass();
        parent::__construct($init);

    }
}
