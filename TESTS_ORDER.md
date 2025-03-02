
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



