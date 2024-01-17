<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["roomName"];
    $code = $_POST["roomCode"];

    $conn = new mysqli("localhost", "root", "", "daw-app");

    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    if ($conn->query(
        "SELECT * FROM rooms WHERE roomname = '$name'"
        )->num_rows > 0) {
        require "html/error.html";
    } else {
        $code = generateRandomString();
        $sql = 
            "INSERT INTO roomconector (profilename, roomname) 
            VALUES ('$name', '$code')";

        if ($conn->query($sql)) {
            $_SESSION['auth_room'] = $name;
            $_SESSION['auth_room_code'] = $code;
            header("Location: html/room.html");
            exit();
        }
    }

    $conn->close();
}
?>