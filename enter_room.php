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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['profile'])) {
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $code = validateInput($conn,$_POST['roomCode'],8);
    $profile = validateInput($conn,$_GET['profile']);

    $result = $conn->query(
        "SELECT * FROM rooms
        JOIN roomconector ON rooms.roomname = roomconector.roomname
        JOIN profiles ON profiles.profilename = roomconector.profilename
        WHERE rooms.code = '$code'"
    );

    if ($result->num_rows == 0) {
        $missing = "Codul " . $code;
        require "html/missing.html";
    } else if($result->num_rows > 1){
        $taken = "Accesul ";
        require "html/taken.html";
    }else {
        $row = $result->fetch_assoc();
        $room = $conn->real_escape_string($row['roomname']);
        if($row['status'] == "Closed"){
            require "html/closed.html";
            exit();
        }

        $conn->query("INSERT INTO roomconector (profilename, roomname) VALUES ('$profile', '$room')");

        header("Location: room.php?room=" . $room . "&profile=" . $profile);
    }
    $conn->close();
} else {
    require "html/error.html";
}
?>