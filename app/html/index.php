<?php

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

echo "Hi 555";

//if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//    header('Access-Control-Allow-Origin: *');
//    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
//    header('Access-Control-Allow-Headers: token, Content-Type');
//    header('Access-Control-Max-Age: 1728000');
//    header('Content-Length: 0');
//    header('Content-Type: text/plain');
//    die();
//}
//
//header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');


$servername = "srv1503.hstgr.io";
$username = "u235058084_sw_user";
$password = "sw_Password1";

echo '<br>';
try {
    $pdo = new PDO("mysql:host=$servername;dbname=u235058084_sw_database", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";

        $query = 'SELECT *
                    FROM categories
                    ORDER BY Name';

    $stmt = $pdo->prepare($query);

//    $stmt = $pdo->prepare("SELECT * FROM product WHERE productTypeId=:productTypeId AND brand=:brand");
//    $stmt->bindValue(":productTypeId", 6);
//    $stmt->bindValue(":brand", "Slurm");

    $products = array();
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $products[] = $row;
        echo '<h2>'.$row['Name'].'</h2>';
        echo '<br>';
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

echo '<br>';





phpinfo();

error_log("###############################################");
error_log("Hello error log from PHP ".phpversion().".");
error_log("###############################################");