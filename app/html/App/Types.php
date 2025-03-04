<?php

namespace App;

use App\Cart\CartLineOptionsType;
use App\Cart\CartLineType;
use App\Cart\CartType;

use App\Cart\AddToCartLineProductOptionType;
use App\Product\KeyValueType;
use App\Product\ProductClothesType;
use App\Product\ProductTechType;
use App\Product\ProductType;

use App\Type\InputCartParamsType;
use App\Type\InputCartType;
use App\Type\InputProductType;
use App\Type\MutationType;
use App\Type\QueryType;
use GraphQL\Type\Definition\Type;

class Types
{

    private static $query;
    private static $mutation;
    private static $product;
    private static $cart;
    private static $cartLine;

    private static $keyvalue;
    private static $attribute;
    private static $attributeOption;
    private static $inputProduct;
    private static $inputCart;
    private static $inputCartParams;
    private static $addToCartLineProductOption;
    private static $cartLineOption;

    public static function keyvalue()
    {
        return self::$keyvalue?:(self::$keyvalue=new KeyValueType());
    }
    public static function product()
    {
        return self::$product?:(self::$product=new ProductType());
    }
    public static function cart()
    {
        return self::$cart?:(self::$cart=new CartType());
    }
    public static function cartLine()
    {
        return self::$cartLine?:(self::$cartLine=new CartLineType());
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

    public static function inputCart()
    {
        return self::$inputCart ?: (self::$inputCart = new InputCartType());
    }
    public static function inputCartParams()
    {
        return self::$inputCartParams ?: (self::$inputCartParams = new InputCartParamsType());
    }
    public static function addToCartLineProductOption()
    {
        return self::$addToCartLineProductOption ?: (self::$addToCartLineProductOption = new AddToCartLineProductOptionType());
    }
    public static function cartLineOption()
    {
        return self::$cartLineOption ?: (self::$cartLineOption = new CartLineOptionsType());
    }
}

