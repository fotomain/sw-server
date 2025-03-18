
CREATE TABLE order_header LIKE cart_header;
CREATE TABLE order_lines LIKE cart_lines;
CREATE TABLE order_line_options LIKE cart_line_options;


delete from order_header where 1;
delete from order_lines where 1;
delete from order_line_options where 1;

SET @CART_GUID = 'cc6bb519-f811-11ef-a13a-55e370885b2f' ;

INSERT INTO order_header
SELECT *
FROM cart_header
WHERE cart_guid = @CART_GUID ;

INSERT INTO order_lines (cart_id,cart_line_id,product_id,qty,comment, price, total_sum_line)
SELECT cart_id,cart_line_id,product_id,qty,comment, pl.price as price, CAST(qty * pl.price AS DECIMAL(6,2)) as total_sum_line
FROM cart_lines
LEFT JOIN price_list AS pl ON product_id=pl.entity_id
WHERE
pl.currency_id='USD'
AND
cart_id = (SELECT cart_id FROM cart_header
WHERE cart_guid = @CART_GUID LIMIT 1
);

INSERT INTO order_line_options
SELECT *
FROM cart_line_options
WHERE cart_line_id IN (SELECT cart_line_id FROM cart_lines WHERE cart_id = (SELECT cart_id FROM cart_header
WHERE cart_guid = @CART_GUID LIMIT 1
));


UPDATE order_header SET total_sum = (
SELECT SUM(  total_sum_line )
FROM order_lines
WHERE cart_line_id IN (SELECT cart_line_id FROM cart_lines WHERE cart_id = (SELECT cart_id FROM cart_header
WHERE cart_guid = @CART_GUID LIMIT 1
)))
WHERE cart_guid = @CART_GUID ;

{
    "newOrder": {
        "order_total":555,
        "comment":"cccc"
    }
}


mutation ($newOrder:InputOrder) {
        createOrder(order:$newOrder){
            order_id
            order_total 
            order_lines {
                order_line_id
            }
        }
    }



