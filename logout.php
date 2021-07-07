<?php
ob_start();
session_start();

$_SESSION['username'] = null;
$_SESSION['user_role'] = null;
$_SESSION['id'] = null;

header("Location: ../login.php");