<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $conn = new mysqli("localhost", "root", "", "daw-app");

    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $result = $conn->query(
        "SELECT * FROM users WHERE username = '$username' LIMIT 1"
    );

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION['auth_user'] = $username;
            header("Location: account.php");
            exit();
        } else {
            echo "Parola gresita!";
        }

    } else {
        require "html/error.html";
    }
    
    $conn->close();
}
?>