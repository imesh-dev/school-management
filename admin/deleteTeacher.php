<?php

require_once "includes/header.php"; 

if(isset($_GET['action']) && $_GET['action'] == "delete_teacher") {

	$teacher_id = $_GET['t_id'];

	$find_query = "SELECT * FROM teachers WHERE id=$teacher_id";
	$find_result = mysqli_query($conn, $find_query);
	$row = mysqli_fetch_assoc($find_result);
	$email = $row['teacher_email'];

	//delete user info
	$query_2 = "DELETE FROM user WHERE username='$email'";
	$result_2 = mysqli_query($conn,  $query_2);

	//delete assigend teacher
	$query_3 = "DELETE FROM class_teacher WHERE username='$email'";
	$result_3 = mysqli_query($conn,  $query_3);

	//delete teacher info
	$query = "DELETE FROM teachers WHERE id=$teacher_id";
	$result = mysqli_query($conn,  $query);

	if($result) {
		header("Location: viewAllTeachers.php");
	}
}