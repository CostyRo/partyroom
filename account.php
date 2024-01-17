<?php
session_start();
$user = $_SESSION['auth_user'];

$conn = new mysqli("localhost", "root", "", "daw-app");
if ($conn->connect_error) {
    die("Eroare: " . $conn->connect_error);
}
$result = $conn->query(
    "SELECT * FROM profiles WHERE username = '$user'"
);
$_SESSION['user_profiles'] = array_column($result->fetch_all(MYSQLI_ASSOC),"profilename");

require "html/account.html"
?>