<?php

namespace App\Product;

use App\Types;
use stdClass;

class ProductTechType extends ProductAbstructType
{
    public function __construct($params=array())
    {

        $init = new stdClass();
        $init->categoryId = 'tech';
        parent::__construct($init);

    }
    public static function getArgs(){
//        $args = new stdClass();
//        $args->name=Types::string();
        $args = array();
        $args = [...$args,'name'=>Types::string()] ;
        return $args;
    }
}

