
mutation {
        createCart {            
            cart_guid
        }
    }


## ============== readCart
    {
        query: readCart(cartParams:{
            cart_guid:"cc6bb519-f811-11ef-a13a-55e370885b2f"
    }){
        cart_guid
            cart_total 
            cart_lines {
                cart_line_id
                product_id
                qty
                product_has_options
                product_options {
                    attribute_id
                    option_id
                }
            }
    }
## ============== addToCart

{
    "newCartLine": {
        "cart_guid":"cc6bb519-f811-11ef-a13a-55e370885b2f",
        "qty":1,
        "product_id":103,
        "product_has_options":1,
        "product_options":[
            {"attribute_id":801,"option_id":80001},
            {"attribute_id":802,"option_id":80002},
            {"attribute_id":803,"option_id":80005}
        ]        
                       
    }
}

mutation ($newCartLine:InputAddToCart) {
        addToCart(cartParams:$newCartLine){
            cart_guid
            cart_total 
            cart_lines {
                cart_line_id
                product_id
                qty
                product_has_options
                product_options {
                    attribute_id
                    option_id
                }
            }
        }
    }


## ============== READ CART


DROP TEMPORARY TABLE IF EXISTS temp_lines;
CREATE TEMPORARY TABLE temp_lines
SELECT * FROM cart_line_options WHERE cart_line_id IN
(SELECT cart_line_id FROM cart_lines WHERE cart_id =
(SELECT cart_id FROM cart_header
WHERE cart_guid='cc6bb519-f811-11ef-a13a-55e370885b2f'))
;

# SELECT * FROM temp_lines;

SELECT t1.cart_line_id FROM temp_lines AS t1
INNER JOIN temp_lines AS t2 ON t1.cart_line_id =t2.cart_line_id
INNER JOIN temp_lines AS t3 ON t2.cart_line_id =t3.cart_line_id
WHERE t1.attribute_id=801 AND t1.option_id=80001
AND  t2.attribute_id=802 AND t2.option_id=80002
AND  t3.attribute_id=803 AND t3.option_id=80003


## ============== deleteCartLine

{
    "cartLine": {
        "cart_guid":"cc6bb519-f811-11ef-a13a-55e370885b2f",
        "cart_line_id":144
   }
}

mutation ($cartLine:InputCartParams) {
        deleteCartLine(cartParams:$cartLine){
            cart_guid
            cart_total 
            cart_lines {
                cart_line_id
                product_id
                qty
                product_has_options
                product_options {
                    attribute_id
                    option_id
                }
            }
        }
    }

