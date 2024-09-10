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
    $password = $conn->real_escape_string($_POST["password"]);

    $result = $conn->query("SELECT * FROM users WHERE username = '$username' LIMIT 1");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+30 days'));

            setcookie("login", $row["cookie"], time() + (30 * 24 * 60 * 60), "/", "", false, true);

            $conn->query(
                "UPDATE users SET expiration_date = '$expiration_date' WHERE username = '$username'"
            );

            header("Location: account.php");
        } else {
            require "html/wrong.html";
        }
    } else {
        require "html/error.html";
    }

    $conn->close();
} else {
    require "html/error.html";
}
?>