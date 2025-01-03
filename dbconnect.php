<?php

$server = "localhost";
$port = 4306;
$user = "root";
$password = "";
$dbname = "test";


    $conn = new PDO("mysql:host=$server;port=4306;dbname=$dbname", $user, $password);
    echo "";

//$conn = new PDO(dsn: "mysql:host=$server;port=3306;dbname=$dbname", $user, $password);
//echo "Connection got";

    