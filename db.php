<?php
$server = "104.247.163.244";
$username = 'halilroot';
$password = 'halilroot123456';
$dbname = 'admin_halil_test';
$port = '3306';

try {
    $dsn = "mysql:host=$server;dbname=$dbname;port=$port;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $conn = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage() . " Code: " . $e->getCode());
}
?>