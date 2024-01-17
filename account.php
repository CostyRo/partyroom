<?php
session_start();
$user = $_SESSION['auth_user'];
require "html/account.html"
?>