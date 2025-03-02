<?php

namespace App;

use App\Order\OrderLineType;
use App\Order\OrderType;

use App\Product\KeyValueType;
use App\Product\ProductClothesType;
use App\Product\ProductTechType;
use App\Product\ProductType;
use App\Type\InputProductType;
use App\Type\MutationType;
use App\Type\QueryType;
use GraphQL\Type\Definition\Type;

class Types
{

    private static $query;
    private static $mutation;
    private static $product;
    private static $order;
    private static $orderLine;

    private static $keyvalue;
    private static $attribute;
    private static $attributeOption;
    private static $inputProduct;

    public static function keyvalue()
    {
        return self::$keyvalue?:(self::$keyvalue=new KeyValueType());
    }
    public static function product()
    {
        return self::$product?:(self::$product=new ProductType());
    }
    public static function order()
    {
        return self::$order?:(self::$order=new OrderType());
    }
    public static function orderLine()
    {
        return self::$orderLine?:(self::$orderLine=new OrderLineType());
    }
    public static function productTech()
    {
        return self::$product?:(self::$product=new ProductTechType());
    }
    public static function productClothes()
    {
        return self::$product?:(self::$product=new ProductClothesType());
    }
    public static function attribute()
    {
        return self::$attribute?:(self::$attribute=new AttributeType());
    }
    public static function attributeOption()
    {
        return self::$attributeOption?:(self::$attributeOption=new AttributeOptionType());
    }

    public static function int()
    {
        return Type::int();
    }
    public static function float()
    {
        return Type::float();
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

