<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $conn = new mysqli("localhost", "root", "", "daw-app");

    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    if ($conn->query(
        "SELECT * FROM users WHERE username = '$username'"
        )->num_rows > 0) {
        echo "$username exista deja în baza de date!";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql)) {
            $_SESSION['auth_user'] = $username;
            header("Location: account.php");
            exit();
        }
    }

    $conn->close();
}
?>