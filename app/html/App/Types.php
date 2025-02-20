<?php

namespace App;

use App\Type\InputProductType;
use App\Type\MutationType;
use App\Type\QueryType;
use GraphQL\Type\Definition\Type;

class Types
{

    private static $query;
    private static $mutation;
    private static $product;
    private static $inputProduct;

    public static function product()
    {
        return self::$product?:(self::$product=new ProductType());
    }
    public static function attribute()
    {
        return self::$product?:(self::$product=new AttributeType());
    }

    public static function int()
    {
        return Type::int();
    }

    public static function string()
    {
        return Type::string();
    }

    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function listOf($type)
    {
        return Type::listOf($type);
    }

    public static function nonNull($type)
    {
        return Type::nonNull($type);
    }

    public static function mutation()
    {
//        echo  "mutation1";
        return self::$mutation ?: (self::$mutation = new MutationType());
    }

    public static function inputProduct()
    {
        return self::$inputProduct ?: (self::$inputProduct = new InputProductType());
    }
}

