
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

