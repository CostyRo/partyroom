<?php
session_start();
if (isset($_GET['profile'])) {
    $profile = $_GET['profile'];
    $conn = new mysqli("localhost", "root", "", "daw-app");

    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $result = $conn->query(
        "SELECT * FROM profiles WHERE profilename = '$profile'"
    );

    if ($result->num_rows == 0) {
        require "html/error.html";
    } else {
        $row = $result->fetch_assoc();
        if ($row["type"] == "DJ") {
        require "html/profile_dj.html";
        } else if ($row["type"] == "Listener") {
            require "html/profile_listener.html";
        } else {

        }
    }

    $conn->close();
} else {
    require "html/error.html";
}

?>