<?php
session_start();
if (isset($_GET['profile'])) {
    $profile = $_GET['profile'];
    $conn = new mysqli("localhost", "root", "", "daw-app");

    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    if ($conn->query(
        "SELECT * FROM profiles WHERE profilename = '$profile'"
        )->num_rows == 0) {
        require "html/error.html";
    } else {
        require "html/profile.html";
    }

    $conn->close();
} else {
    require "html/error.html";
}

?>