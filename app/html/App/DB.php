<?php

namespace App;

use PDO;

class DB
{
    private static $pdo;

    public static function init($config)
    {
//        echo 'init1';
        self::$pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['database']};",
            $config['username'],
            $config['password']
        );

        self::$pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_OBJ
        );

    }

    public static function select($query)
    {
        $handler = self::$pdo->query($query);
        return $handler->fetchAll();
    }

    public static function selectOne($query)
    {
        $result = self::select($query);
        return array_shift($result);
    }

    public static function update($query){
        $handler = self::$pdo->query($query);
        $handler->execute();
        return $handler->rowCount();
    }

    public static function create($query){
//        echo "\n create start ".$query;
        try {
            $handler = self::$pdo->prepare($query);
            $handler->execute();
//            echo "\n handler ".json_encode($handler);
//            echo "\n result OK".self::$pdo->lastInsertId();
            return self::$pdo->lastInsertId();
        }
        catch (\Exception $e){
            $result1 = [
                'error' => [
                    'message' => $e->getMessage()
                ]
            ];
            echo json_encode($result1);
        }
    }

    public static function delete($query){
        $handler = self::$pdo->prepare($query);
        $handler->execute();
        $idn=0;
        $handler->bindValue(":idn",$idn,PDO::PARAM_INT);
        return $idn;
    }

}