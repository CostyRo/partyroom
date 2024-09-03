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

    $profile = validateInput($conn,$_POST["profileName"]);
    $type = $conn->real_escape_string($_POST["profileType"]);
    $user = $conn->real_escape_string(getUser($conn));

    if ($conn->query(
        "SELECT * FROM profiles WHERE profilename = '$profile'"
        )->num_rows > 0) {
        $taken = "Profilul " . $profile;
        require "html/taken.html";
    } else {
        $sql = "INSERT INTO profiles (profilename, username, type) VALUES ('$profile', '$user', '$type')";
        if ($conn->query($sql)) {
            header("Location: profile.php?profile=" . noAND($_POST["profileName"]));
        }
    }
    $conn->close();
}
?>