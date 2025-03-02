

mutation ($newCart:InputCart) {
        updateCart(updateCartData:$newCart){
            cart_id
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

