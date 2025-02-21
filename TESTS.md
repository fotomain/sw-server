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
