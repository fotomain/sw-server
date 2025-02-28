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

# GLOBAL PHP
push git main
rebuild Docker global on render.com
TEST Docker global PHP SERVER
    https://sw-server-przw.onrender.com/graphql.php

RUN App
    http://localhost:8088/index.php
    http://localhost:8088/graphql.php
    https://php-quickstart-docker.onrender.com/graphql.php

git init
git remote add origin https://github.com/fotomain/php-quickstart-docker.git
git add .
git commit -m "first commit"
git branch -M main
git push -u origin main

