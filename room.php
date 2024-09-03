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

    $room = validateInput($conn,$_GET['room']);
    $profile = validateInput($conn,$_GET['profile']);

    $result = $conn->query(
        "SELECT *
        FROM rooms
        JOIN roomconector ON rooms.roomname = roomconector.roomname
        JOIN profiles ON profiles.profilename = roomconector.profilename
        WHERE rooms.roomname = '$room' AND profiles.profilename = '$profile'
        LIMIT 1"
    );

    if ($result->num_rows == 0) {
        require "html/error.html";
    } else {
        $row = $result->fetch_assoc();
        $code = $row['code'];
        $status = $row["status"];
        if($row['type'] == "DJ"){
            require "html/room_dj.html";
        }else{
            if($status == "Closed"){
                require "html/closed.html";
            }else{
                require "html/room_listener.html";
            }
        }
    }
    $conn->close();
} else {
    require "html/error.html";
}
?>