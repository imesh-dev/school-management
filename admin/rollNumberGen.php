<?php
require_once "../includes/database.php";
session_start();

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != "administrator") {
		header("Location: ../../login.php");
}

if(isset($_POST['std_class']) && isset($_POST['std_section'])) {
	$student_class = $_POST['std_class'];
	$student_section = $_POST['std_section'];

	$query = "SELECT MAX(student_roll) AS last_roll FROM students WHERE student_class=$student_class AND student_section='$student_section' LIMIT 1";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$last_roll = $row['last_roll'];
	$new_roll = $last_roll + 1;

	echo str_pad($new_roll, 2, '0', STR_PAD_LEFT);
}