<?php

$sName = "localhost";
$name = "root";
$pass = "root";
$db_name = "online_bookstore_db";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $name, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}