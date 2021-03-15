<?php

class Database{

    private static $dbHost = "localhost";
    private static $dbName = "formation";
    private static $dbUser = "root";
    private static $dbPwd = "";

    private static $connection = null;


    public static function connect(){
        try
        {
            self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName, self::$dbUser, self::$dbPwd);
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}

?>