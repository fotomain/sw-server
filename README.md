# sw-server

composer update

# LOCAL
RUN Docker local
    from PHPStorm
        right Click on ocker-compose.yml
            menu -> run

run chrome NO CORS
CHECK Docker local
    http://localhost:8088/index.php

# GLOBAL DOCKER
    https://sw-server-przw.onrender.com/graphql.php
# GLOBAL PHP
    https://midnightblue-newt-595842.hostingersite.com/app1/html/index.php
    https://midnightblue-newt-595842.hostingersite.com/app1/html/graphql.php

# GLOBAL PHP
push git main
rebuild Docker global on render.com
TEST Docker global PHP SERVER
    https://sw-server-przw.onrender.com/graphql.php

RUN App
    http://localhost:8088/index.php
    http://localhost:8088/graphql.php
    https://php-quickstart-docker.onrender.com/graphql.php


# CORS PHP FOR graphql.php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header("HTTP/1.1 200 OK");
die();
}


git init
git remote add origin https://github.com/fotomain/php-quickstart-docker.git
git add .
git commit -m "first commit"
git branch -M main
git push -u origin main

