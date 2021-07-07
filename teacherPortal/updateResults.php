<?php
require_once "includes/header.php"; 

if(isset($_POST['global_name_id']) && isset($_POST['exam_type']) && isset($_POST['teacher_email'])) {
	$global_name_id = $_POST['global_name_id'];
	$exam_type = $_POST['exam_type'];
	$teacher_email = $_POST['teacher_email'];
	$total_students = [];

	$query = "SELECT * FROM results WHERE teacher_email='$teacher_email' AND global_name_id='$global_name_id' AND exam_type='$exam_type' ORDER BY student_roll ASC";

	$results = mysqli_query($conn, $query);

	if(mysqli_num_rows($results) > 0) {

	echo '<form action="" method="post"><table class="table table-striped">
			<thead>
				<tr>
					<th>Student ID</th>
					<th>Student Roll</th>
					<th>Marks</th>
					<th>Grade</th>
				</tr>
			</thead>
			<tbody>';

	while ($row = mysqli_fetch_assoc($results)) {
		$marks 				= $row['marks'];
		$student_id 		= $row['student_id'];
		$students_roll 		= $row['student_roll'];
		$grade 				= $row['grade'];

		$exam_type 			= $row['exam_type'];
		$global_name_id 	= $row['global_name_id'];
		$subject_id 		= $row['subject_id'];
		$student_class 		= $row['student_class'];
		$exam_year 		= $row['exam_year'];

		echo "<tr>";
		echo "<td>$student_id</td>";
		echo "<td>$students_roll</td>";
		echo "<td>
				<input type='text' class='form-control student_mark' name='marks[]' std_id='{$student_id}' std-roll='{$students_roll}' value='{$marks}' autocomplete='off'>
				<input type='hidden' name='exam_year' value='$exam_year'>
			</td>";
		echo "<td><span class='label label-info' style='font-size: 20px'>$grade</td></span>";
		echo "</tr>";
	}
	echo '<tr>
			<td colspan="4" class="text-center">
				<input type="submit" name="result_update_submit" class="btn btn-info result_update_submit" value="Update Result">
			</td>
		</tr>';

	echo '</tbody></table></form>';
	} else {
		echo "No result found for this class! Please add result first.";
	}
}