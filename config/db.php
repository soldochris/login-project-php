<?php
    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $dbname = 'login-project';

    //set DSN - Database Sourse Name
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

    try{
        //createa PDO instance
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);//used for object orentation mode
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //print message if it's ok
        //echo "Connected successfully";
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>