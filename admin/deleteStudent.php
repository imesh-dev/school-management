<?php

require_once "includes/header.php"; 

if(isset($_GET['action']) && $_GET['action'] == "delete_student") {

	$student_id = $_GET['s_id'];

	$find_query = "SELECT * FROM students WHERE id=$student_id";
	$find_result = mysqli_query($conn, $find_query);
	$row = mysqli_fetch_assoc($find_result);
	$email = $row['student_email'];

	$query_2 = "DELETE FROM user WHERE username='$email'";
	$result_2 = mysqli_query($conn,  $query_2);

	$query = "DELETE FROM students WHERE id=$student_id";
	$result = mysqli_query($conn,  $query);

	if($result) {
		header("Location: viewAllStudents.php");
	}
}