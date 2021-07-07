<?php
require_once "includes/header.php"; 

if(isset($_POST['global_name_id'])) {

	$all_class_time = [];

	$query = "SELECT * FROM classtime ORDER BY class_time ASC";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die(mysqli_error($conn));
	}
	while ($row = mysqli_fetch_assoc($result)) {
		$time_id = $row['id'];
		$all_class_time[] = $row['class_time'];
		//echo "<option value='{$class_time}'>{$class_time}</option>";
	}

	$global_name_id = $_POST['global_name_id'];
	$assigned_class_time = [];

	$assigned_class_time_query = "SELECT class_time FROM class_teacher WHERE global_name_id=$global_name_id";
	$assigned_class_time_result = mysqli_query($conn, $assigned_class_time_query);
	while ($row_2 = mysqli_fetch_assoc($assigned_class_time_result)) {
		$assigned_class_time[] = $row_2['class_time'];
	}

	$available_class_time = array_diff($all_class_time, $assigned_class_time);
	foreach ($available_class_time as $key => $class_time) {
		echo "<option value='{$class_time}'>{$class_time}</option>";
	}
}