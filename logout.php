<?php
// https://novaldis.c120.me/tp6-prakdesweb/login.php
session_start();

// delete session
$_SESSION = [];
session_destroy();
session_unset();

// delete cookie
setcookie("username", "", time() - 3600);
setcookie("password", "", time() - 3600);

// back to login page
header("Location: login.php");
exit;
