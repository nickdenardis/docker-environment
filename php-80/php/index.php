<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "db_tester_2021-db";
$username = "test_user";
$password = "test_pass";
$db = "db_tester_2021";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully";
    
    $stm = $conn->query("SELECT VERSION()");
    $version = $stm->fetch();
    echo $version[0] . PHP_EOL;

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
