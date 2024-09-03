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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $room = validateInput($conn,$_POST["roomName"]);
    $profile = validateInput($conn,$_GET['profile']);

    if ($conn->query(
        "SELECT * FROM rooms WHERE roomname = '$room'"
        )->num_rows > 0) {
        $taken = "Roomul " . $room;
        require "html/taken.html";
    } else {
        $code = generateUniqueCode($conn);

        $conn->query("INSERT INTO roomconector (profilename, roomname) VALUES ('$profile', '$room')");
        $conn->query("INSERT INTO rooms (roomname, code) VALUES ('$room', '$code')");

        header("Location: room.php?room=" . $room . "&profile=" . $profile);
    }
    $conn->close();
}
?>