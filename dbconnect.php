<?php

$server = "localhost";
$port = 3306;
$user = "root";
$password = "";
$dbname = "test";


    $conn = new PDO("mysql:host=$server;port=3306;dbname=$dbname", $user, $password);
    echo "Connection got";

//$conn = new PDO(dsn: "mysql:host=$server;port=3306;dbname=$dbname", $user, $password);
//echo "Connection got";

    