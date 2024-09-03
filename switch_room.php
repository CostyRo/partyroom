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

if (isset($_GET['room']) && isset($_GET['profile'])) {
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $room = validateInput($conn,$_GET["room"]);
    $profile = validateInput($conn,$_GET["profile"]);

    if ($conn->query(
        "SELECT * FROM rooms
        JOIN roomconector ON rooms.roomname = roomconector.roomname
        JOIN profiles ON profiles.profilename = roomconector.profilename
        WHERE rooms.roomname = '$room' AND profiles.profilename = '$profile'"
        )->num_rows == 0) {
        $missing = "Roomul " . $room;
        require "html/missing.html";
    } else {
        $result = $conn->query("SELECT status FROM rooms WHERE rooms.roomname = '$room'");
        $status = $result->fetch_assoc()["status"] == "Open" ? "Closed" : "Open";
        $conn->query("UPDATE rooms SET rooms.status = '$status' WHERE rooms.roomname = '$room'");
        header("Location: room.php?room=" . $_GET['roomCode'] . "&profile=" . $_GET["profile"]);
    }
    $conn->close();
}
?>