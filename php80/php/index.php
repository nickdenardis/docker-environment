<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

phpinfo();

$to      = 'nobody@example.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if (mail($to, $subject, $message, $headers)){
    echo 'Success!';
} else {
    print_r(error_get_last());
}
die();



$servername = "db_server";
$username = "test_user";
$password = "test_pass";
$db = "laravelproject";

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
