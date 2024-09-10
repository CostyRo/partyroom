<?php
require_once "utils.php";

session_start();
$config = include('config.php');
if($config['debug']){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if(!isset($_COOKIE['login'])){
    header("Location: /");
    exit();
}

if (isset($_GET['profile'])) {
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $profile = validateInput($conn,$_GET['profile']);
    $user = $conn->real_escape_string(getUser($conn));

    $result = $conn->query(
        "SELECT * FROM profiles WHERE profilename = '$profile' AND username = '$user' LIMIT 1"
    );

    if ($result->num_rows == 0) {
        require "html/error.html";
    } else {
        $rooms = $conn->query(
            "SELECT DISTINCT rooms.roomname
            FROM rooms
            JOIN roomconector ON rooms.roomname = roomconector.roomname
            WHERE roomconector.profilename = '$profile'"
        );

        $rooms = array_column($rooms->fetch_all(MYSQLI_ASSOC),"roomname");
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