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

    $profile = validateInput($conn,$_GET["profile"]);
    $user = $conn->real_escape_string(getUser($conn));

    $result = $conn->query("SELECT * FROM profiles WHERE profilename = '$profile' and username = '$user'");

    if ($result->num_rows == 0) {
        $missing = "Profilul " . $profile;
        require "html/missing.html";
    } else {
        $row = $result->fetch_assoc();

        if($row['type'] == "DJ"){
            $rows = $conn->query(
                "SELECT rooms.roomname FROM rooms
                JOIN roomconector ON rooms.roomname = roomconector.roomname
                JOIN profiles ON profiles.profilename = roomconector.profilename
                WHERE profiles.profilename = '$profile'"
            );
            while ($row = $rows->fetch_assoc()) {
                $room = $row['roomname'];
                $conn->query("DELETE FROM roomconector WHERE roomname = '$room'");
                $conn->query("DELETE FROM rooms WHERE roomname = '$room'");
            }
        }
        $conn->query("DELETE FROM roomconector WHERE profilename = '$profile'");
        $conn->query("DELETE FROM profiles WHERE profilename = '$profile'");

        header("Location: account.php");
    }

    $conn->close();
} else {
    require "html/error.html";
}
?>