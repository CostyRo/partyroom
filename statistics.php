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

if (isset($_GET["room"]) && isset($_GET["profile"])) {
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        die("Eroare: " . $conn->connect_error);
    }

    $room = validateInput($conn,$_GET['room']);
    $profile = validateInput($conn,$_GET['profile']);

    $counts  = $conn->query(
        "SELECT type, COUNT(*) AS count FROM songs WHERE roomname = '$room' GROUP BY type"
    )->fetch_all(MYSQLI_ASSOC);
    $labels = array_column($counts, 'type');
    $data = array_column($counts, 'count');

    $conn->close();

    include "html/statistics.html";
} else {
    require "html/error.html";
}
?>