<?php

// class Database
// {

//     $dbHost = "localhost";
//     $dbName = "Pizza_Code";
//     $dbUser = "root";
//     $dbUserPassword = "";

//     $connection = null;


//     function connect()
//     {
//         try
//         {
//             $connection = new PDO("mysql:host=$dbHost; dbName=$dbName", $dbUser, $dbUserPassword);
//         }
//         catch(PDOExeption $e)
//         {
//             die($e->getMessage());
//         }
//         return $connection
//     }
    
//     function disconnect()
//     {
//         $connection = null;
//     }
// }


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Pizza_Code";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

