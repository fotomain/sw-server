<?php

//header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
//header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
//header('Content-Type: application/json');
//$method = $_SERVER['REQUEST_METHOD'];
//if ($method == "OPTIONS") {
//    header('Access-Control-Allow-Origin: *');
//    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
//    header("HTTP/1.1 200 OK");
//    die();
//}

require_once __DIR__ . '/vendor/autoload.php';

use App\DB;
use App\Types;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

try {

    $servername = "srv1503.hstgr.io";
    $username = "u235058084_sw_user";
    $password = "sw_Password1";
    $database = "u235058084_sw_database";

    $config=[
        'host'      =>'srv1503.hstgr.io',
        'username'  =>'u235058084_sw_user',
        'password'  =>'sw_Password1',
        'database'  =>'u235058084_sw_database'
    ];

DB::init($config);

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
$query = $input['query'];


$variables = isset($input['variables']) ? $input['variables'] : null;
//$variables = isset($input['variables']) ? json_decode($input['variables'], true) : null;

//    echo json_encode($variables);

$schema = new Schema([
    'query'=>Types::query(),
    'mutation'=>Types::mutation()
]);

//echo json_encode($schema);

$result = GraphQL::executeQuery($schema,$query,null,null,$variables);

} catch (\Exception $e) {
    $result = [
        'error' => [
            'message' => $e->getMessage()
        ]
    ];
}

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($result);
