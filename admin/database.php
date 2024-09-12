<?php

class Database
{

    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "Pizza_Code";    

    private static $connection = null;


    public static function connect()
    {
        try
        {
            self::$connection = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$dbname, self::$username, self::$password);
            // echo "Connected successfully";
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


// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "Pizza_Code";


// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully";
//     }
// catch(PDOException $e)
//     {
//     echo "Connection failed: " . $e->getMessage();
//     }