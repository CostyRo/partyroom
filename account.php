<?php
session_start();
$config = include('config.php');
if($config['debug']){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

if ($conn->connect_error) {
    die("Eroare: " . $conn->connect_error);
}

if (isset($_COOKIE['login'])) {
    $cookie = $conn->real_escape_string($_COOKIE['login']);
    $result = $conn->query(
        "SELECT username,expiration_date FROM users WHERE cookie = '$cookie' LIMIT 1"
    );
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if (strtotime($row['expiration_date']) > time()) {
            $user = $conn->real_escape_string($row['username']);

            $result = $conn->query("SELECT * FROM profiles WHERE username = '$user'");
            $profiles = array_column($result->fetch_all(MYSQLI_ASSOC),"profilename");

            require "html/account.html";
            exit();
        }
    }
}

$conn->close();
header("Location: /");
?>