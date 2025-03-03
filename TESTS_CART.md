
mutation {
        createCart {            
            cart_guid
        }
    }

## ==============
{
    "newCartLine": {
        "cart_guid":"cc6bb519-f811-11ef-a13a-55e370885b2f",
        "product_id":103,
        "qty":1,
        "product_options":[
            {"attribute_id":801,"option_id":80001},
            {"attribute_id":802,"option_id":80002},
            {"attribute_id":803,"option_id":80003}
        ]        
    }
}

mutation ($newCartLine:InputAddToCart) {
        addToCart(addToCartData:$newCartLine){
            cart_guid
            cart_total 
            cart_lines {
                cart_line_id
            }
        }
    }

## ==============

mutation ($newCart:InputCart) {
        updateCart(updateCartData:$newCart){
            cart_guid
            cart_total 
            cart_lines {
                cart_line_id
            }
        }
    }

{
    "newCart": {
        "cart_total":555,
        "comment":"new222"
    }
}

SELECT t1.cart_line_id, t2.cart_line_id FROM cart_line_options AS t1
INNER JOIN cart_line_options AS t2 ON t1.cart_line_id =t2.cart_line_id
WHERE t1.attribute_id=801 AND t1.option_id=80001
AND  t2.attribute_id=802 AND t2.option_id=80002

