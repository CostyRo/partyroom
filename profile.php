<?php
session_start();
$profile = $_SESSION['auth_profile'];
require "html/profile.html"
?>