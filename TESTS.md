# TESTS

http://localhost:8088/graphql.php

https://php-quickstart-docker.onrender.com/graphql.php

{
    query: techProducts (name:"iMac 2021") { 
        id name
        attributes {
            id 
            name
                attributeOptions { 
                    id
                    name
                } 
        }
    }
}

 {
    query: product (id:"apple-iphone-12-pro") { 
        id name
        attributes {
            id 
            name
                attributeOptions { 
                    id
                    name
                } 
        }
    }
}


{
    query: allProducts (
        orderBy:"price ASC, name DESC",
        filters: { product_id: "1", inStock: false , option_id_set:[111,222,333]}
        )
     { 
        id name
        attributes {
            id 
            name
                attributeOptions { 
                    id
                    name
                    displayValue
                } 
        }
    }
}

mutation ($newOrder:InputOrder) {
        createOrder(order:$newOrder){
            product_id
            product_total 
        }
    }
