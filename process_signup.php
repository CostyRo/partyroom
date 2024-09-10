<?php
require_once "utils.php";

session_start();
$config = include('config.php');
if($config['debug']){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $username = validateInput($conn,$_POST["username"]);
    $password = password_hash(validateInput($conn,$_POST["password"]),PASSWORD_DEFAULT);    

    if ($conn->query(
        "SELECT * FROM users WHERE username = '$username'"
        )->num_rows > 0) {
        $taken = "Utilizatorul " . $username;
        require "html/taken.html";
    } else {
        $cookie = $conn->real_escape_string(generateRandomString(100));
        $expiration_date = $conn->real_escape_string(date('Y-m-d H:i:s', strtotime('+30 days')));

        setcookie("login", $cookie, time() + (30 * 24 * 60 * 60), "/", "", false, true);

        $sql = 
            "INSERT INTO users (username, password, cookie, expiration_date)
            VALUES ('$username', '$password', '$cookie', '$expiration_date')";
        $conn->query($sql);
    
        header("Location: account.php");
    }

    $conn->close();
} else {
    require "html/error.html";
}
?>