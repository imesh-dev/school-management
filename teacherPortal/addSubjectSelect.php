<?php
require_once "includes/header.php"; 

function get_subject_name_by_id($id) {
	global $conn;
	$query = "SELECT subject FROM subjects WHERE id=$id";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	return $row['subject'];
}

if(isset($_POST['global_name_id']) && isset($_POST['teacher_email'])) {
	$global_name_id = $_POST['global_name_id'];
	$teacher_email = $_POST['teacher_email'];

	$query = "SELECT DISTINCT subject_name_id FROM class_teacher WHERE teacher_email='$teacher_email' AND global_name_id='$global_name_id'";
	$results = mysqli_query($conn, $query);
	if(mysqli_num_rows($results) > 0) {
		echo '<label for="">Select Subject</label>
				<select name="select_subject" class="form-control" id="">';
		echo "<option value=''>Select Subject</option>";

		while ($row = mysqli_fetch_assoc($results)) {
			$subject_id = $row['subject_name_id'];
			$subject_name = get_subject_name_by_id($subject_id);
			echo "<option value='{$subject_id}'>{$subject_name}</option>";
		}
		echo '</select>';
	}
}