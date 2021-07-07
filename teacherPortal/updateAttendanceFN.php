<?php

require_once "includes/header.php"; 

function get_name_by_email($email) {
	global $conn;
	$query = "SELECT user_firstname, user_lastname FROM user WHERE username='$email'";
	$result = mysqli_query($conn, $query);

	$row = mysqli_fetch_assoc($result);

	return $row['user_firstname']. " " .$row['user_lastname'];
}

if(isset($_POST['attendance_date']) && isset($_POST['attendance_class'])) {

	$global_name_id = $_POST['attendance_class'];
	$attendance_date = $_POST['attendance_date'];
	$total_students = [];

	$select_students = "SELECT attendance.*, students.student_roll  FROM attendance INNER JOIN students ON attendance.student_id=students.student_email WHERE attendance.global_name_id=$global_name_id AND attendance.dates='$attendance_date' AND students.student_status='active' ORDER BY students.student_roll";
	$students_result = mysqli_query($conn, $select_students);
	if(!$students_result) {
		die(mysqli_error($conn));
	} else {
		if(mysqli_num_rows($students_result) > 0) {
			echo '<table class="table table-striped">
					<thead>
						<tr>
							<th>Student ID</th>
							<th>Name</th>
							<th>Roll</th>
							<th>Attendence</th>
						</tr>
					</thead>
					<tbody>';
			while ($students = mysqli_fetch_assoc($students_result)) {
				$stdnt_id = $students['student_id'];
				$total_students[] = $stdnt_id;
				$stdnt_roll = $students['student_roll'];
				$stdnt_name = get_name_by_email($stdnt_id);
				$stdnt_attendance = $students['attendance'];
				$std_checked_val = $stdnt_attendance == 'Y' ? 'value='.$stdnt_id : '';
				$std_checked = $stdnt_attendance == 'Y' ? 'checked' : '';
				echo "<tr>";
				echo "<td>$stdnt_id</td>";
				echo "<td>$stdnt_name</td>";
				echo "<td>$stdnt_roll</td>";
				echo "<td>
					<input type='checkbox' class='form-control student_id' name='attendance[]' std_id='{$stdnt_id}' std-roll='{$stdnt_roll}' $std_checked_val $std_checked>
					</td>";
				echo "</tr>";
			}
			$output = '<tr>
					<td colspan="4" class="text-center">
						<input type="submit" name="attendance_update_submit" class="btn btn-info" value="Update">
					</td>
				</tr></tbody>
				</table>';
				echo $output;
		} else {
			echo "<div class='alert alert-danger alert-dismissible'>
						  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						  <h5><i class='icon fas fa-check'></i> Alert!</h5>
						  No records found on $attendance_date. Please take attendance first.
						</div>";
		}
	}
}