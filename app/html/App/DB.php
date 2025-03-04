<?php

namespace App;

use PDO;
use PDOException;
use stdClass;

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

    public static function selectAttribures($query)
    {

        $handler = self::$pdo->query("
                SELECT attributeSetId, attributeOptionId 
                FROM products_attributes_table 
                ORDER BY attributeSetId, attributeOptionId
        ");

        $data = $handler->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);

        $result = [];
        foreach ($data as $attributeSetId => $row)
        {
            //echo $attributeSetId."<br/>\n";
            $items=[];
            foreach ($row as $attributeOptionId)
            {
                //echo $attributeOptionId."<br/>\n";
                $items.push($attributeOptionId);
            }

            $resObject = new stdClass();
            $resObject->id=$attributeSetId;
            $resObject->items=$items;

            $result.push($resObject);
        }
        return $result;
    }
    public static function select($query)
    {
        try {
            $handler = self::$pdo->query($query);
            $result = $handler->fetchAll();
            return $result;
        }catch(PDOException $e) {
            echo "\n ====== ERROR 209 ====== \n";
            echo $e->getMessage();
            return null;
        }
        //echo json_encode($handler->fetchAll());
    }

    public static function selectOne($query)
    {
        $handler = self::$pdo->query($query);
        $result = $handler->fetchAll();
        return array_shift($result);
    }

    public static function exec($query){
        return self::$pdo->exec($query);
    }
    public static function execute($query){
        $handler = self::$pdo->prepare($query);
        $handler->execute();
//        echo "\n ====== execute";
//        echo $handler->errorInfo()[2];
//        echo "\n ====== execute";
//        echo json_encode($handler);
        return $handler;
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
            return self::$pdo->lastInsertId();
        }
        catch (\Exception $e){
            $result1 = [
                'error' => [
                    'message' => $e->getMessage()
                ]
            ];
            echo "ERROR 112 ".json_encode($result1);
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