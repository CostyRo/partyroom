<?php
setcookie("login", '', time() - 3600, "/", "", false, true);
header("Location: login.php");
?>