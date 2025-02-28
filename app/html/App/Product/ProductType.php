<?php

namespace App\Product;

use App\Types;
use stdClass;

class ProductType extends ProductAbstructType
{

        public function __construct($params=array())
    {

        $init = new stdClass();
        parent::__construct($init);

    }


}
