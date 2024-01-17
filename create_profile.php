<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["profileName"];
    $type = $_POST["profileType"];
    $user = $_SESSION['auth_user'];

    $conn = new mysqli("localhost", "root", "", "daw-app");

    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    if ($conn->query(
        "SELECT * FROM profiles WHERE profilename = '$name'"
        )->num_rows > 0) {
        echo "$name exista deja în baza de date!";
    } else {
        $sql = 
            "INSERT INTO profiles (profilename, username, type) 
            VALUES ('$name', '$user', '$type')";

        if ($conn->query($sql)) {
            $_SESSION['auth_profile'] = $name;
            header("Location: profile.php?profile=" . $name);
            exit();
        }
    }

    $conn->close();
}
?>