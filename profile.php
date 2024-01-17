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
        $sql = $conn->query(
            "SELECT *
            FROM rooms
            JOIN roomconector ON rooms.roomname = roomconector.roomname
            WHERE roomconector.profilename = '$profile'"
        );
        $_SESSION['profile_rooms'] = array_column($sql->fetch_all(MYSQLI_ASSOC),"roomname");
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