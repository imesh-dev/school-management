<?php 

require_once "includes/header.php"; 

function get_class_by_global_name_id($id) {
	global $conn;
	$query = "SELECT class_id FROM sections WHERE id=$id";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	return $row['class_id'];
}
function get_student_roll_by_id($student_id) {
	global $conn;
	$query = "SELECT student_roll FROM students WHERE student_email='$student_id' LIMIT 1";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	return intval($row['student_roll']);
}
function get_grade_by_marks($marks){
	$grade = 0;
	if($marks == 0) {
		$grade = 0;
	} else {
		switch ($marks) {
			case ($marks >= 75 && $marks <= 100):
				$grade = 'A';
				break;

			case ($marks >= 65 && $marks <75):
				$grade = 'B';
				break;

			case ($marks >= 50 && $marks <65):
				$grade = 'C';
				break;

			case ($marks >= 35 && $marks <50):
				$grade = 'D';
				break;

			case ($marks >= 0 && $marks <35):
				$grade = 'E';
				break;
			
			default:
				$grade = 0;
				break;
		}
	}
	return $grade;
}

	$session_user = $_SESSION['username'];
	$query = "SELECT *, class_teacher.subject_name_id as subject_id FROM sections INNER JOIN class_teacher ON sections.id=class_teacher.global_name_id AND class_teacher.teacher_email='$session_user'";

	if(isset($_POST['select_class_submit'])) {
		$global_name_id = $_POST['select_class'];
		$exam_type = $_POST['exam_type'];
		$subject_id = $_POST['select_subject'];

		$thisdate = date("Y");

		$checkquery = "SELECT * FROM results WHERE global_name_id=$global_name_id AND exam_type='$exam_type' AND subject_id=$subject_id AND teacher_email='$session_user'";
		$check_res = mysqli_query($conn, $checkquery);
		if(mysqli_num_rows($check_res) > 0) {
			echo "<script>window.location.href='addResults.php?message=exists'</script>";
		} else {
			echo "<script>window.location.href='addResults.php?global_name_id=$global_name_id&exam_type=$exam_type&subject=$subject_id'</script>";
		}
	}
?>
<input type="hidden" class="teacher_email" value="<?php echo $session_user; ?>">
<body class="hold-transition sidebar-mini">
<div class="wrapper">
 <?php require_once "includes/navbar.php"; ?>
  <?php require_once "includes/sidebar.php"; ?>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Results</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Results</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
	  <?php
		  if(isset($_GET['message']) && $_GET['message'] == "success") {
			echo "<div class='alert alert-success alert-dismissible'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					  <h5><i class='icon fas fa-check'></i> Alert!</h5>
					  Results were added successfully.
					</div>";
		} else if(isset($_GET['message']) && $_GET['message'] == "exists") {
			echo "<div class='alert alert-info alert-dismissible'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					  <h5><i class='icon fas fa-check'></i> Alert!</h5>
					  Results are existing.
					</div>";
		}
		?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add Student Results</h3>
              </div>
              <!-- /.card-header -->
                <?php if(!isset($_GET['global_name_id'])) { ?>              
				<div class="card-body">
					<div class="col-md-6 col-md-offset-3">
						<form action="" method="post">
							<div class="form-group">
								<label for="">Select Class</label>
								<select name="select_class" class="form-control" id="class_selector">
									<option value="">Select Class</option>
									<?php
										$query = "SELECT DISTINCT sections.*, class_teacher.global_name_id FROM class_teacher INNER JOIN sections ON class_teacher.global_name_id=sections.id WHERE class_teacher.teacher_email='$session_user'";
										$result = mysqli_query($conn, $query);
										while($row = mysqli_fetch_assoc($result)) {

											$my_class = $row['global_name'];
											$global_name_id = $row['global_name_id'];

											echo "<option value='{$global_name_id}'>{$my_class}</option>";
										}
									?>
								</select>
							</div>
							<div class="form-group" id="subject_selector">
								
							</div>
							<div class="form-group">
								<label for="">Select Exam Type</label>
								<select name="exam_type" class="form-control" id="">
									<option value="">Select Exam Type</option>
									<option value="mid">Mid Term Exam</option>
									<option value="final">Final Exam</option>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="select_class_submit" value="Submit" class="btn btn-info">
							</div>
						</form>
					</div>
					<div class="clearfix"></div>

					<?php } else { ?>
								<div class="col-md-12">
								<form action="" method="post">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Student ID</th>
											<th>Student Roll</th>
											<th>Marks</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(empty($_GET['global_name_id']) || empty($_GET['exam_type']) || empty($_GET['subject'])) {
											header("Location: add_result.php");
										}
										if(isset($_GET['global_name_id'])) {

											$session_user = clean_data($_SESSION['username']);
											$global_name_id = $_GET['global_name_id'];

											$total_students = [];

											$query = "SELECT * FROM sections WHERE id=$global_name_id";
											$result = mysqli_query($conn, $query);

											if(!$result) {
												die(mysqli_error($conn));
											}

											while($row = mysqli_fetch_assoc($result)) {

												$class_id = $row['class_id'];
												$section = $row['section'];
												$group = $row['group_name'];

												$select_students = "SELECT * FROM students WHERE student_class=$class_id AND student_section='$section' AND student_group='$group' AND student_status='active' ORDER BY student_roll ASC";

												$student_result = mysqli_query($conn, $select_students);
												if(!$student_result) {
													die(mysqli_error($conn));
												}
												while($students = mysqli_fetch_assoc($student_result)) {
													$std_id = $students['student_email'];
													$total_students[] = $std_id;
													$std_name = $students['student_name'];
													$std_roll = $students['student_roll'];

													echo "<tr>";
													echo "<td>$std_id</td>";
													echo "<td>$std_roll</td>";
													echo "<td>
														<input type='text' class='form-control student_mark' name='marks[]' std_id='{$std_id}' std-roll='{$std_roll}'>
													</td>";
													echo "</tr>";
												}
											}
										} else {
											header("Location: add_result.php");
										}
										?>
										<tr>
											<td colspan="4" class="text-center">
												<input type="submit" name="result_submit" class="btn btn-info result_submit" value="Submit">
											</td>
										</tr>
									</tbody>
								</table>
								</form>
							</div>

					<?php } ?>
              </div>
			  <div class="card-body">
					<div class="row">
					<div class="col-md-12">
						<?php
							if(isset($_POST['result_submit'])) {
								$exam_type = $_GET['exam_type'];
								$global_name_id = $_GET['global_name_id'];
								$exam_year = date("Y");

								// $sub_q = "SELECT subject_name_id FROM class_teacher WHERE global_name_id=$global_name_id AND teacher_email='$session_user'";
								// $sub_res = mysqli_query($conn, $sub_q);

								// $subject = mysqli_fetch_assoc($sub_res);
								// $subject_id = $subject['subject_name_id'];
								$subject_id = $_GET['subject'];

								$student_class = get_class_by_global_name_id($global_name_id);

								$results = $_POST['marks'];

								// [id1, id2, id3]
								// [40, 50, 20]

								// [id1=>40, id2=>50, id3=>20]

								$combine_results = array_combine($total_students, $results);

								foreach ($combine_results as $key => $marks) {
									if(empty($marks)) {
										$marks = 0;
									}
									$grade = get_grade_by_marks($marks);
									$student_roll = get_student_roll_by_id($key);

									$mark_query = "INSERT INTO results (student_id, student_roll, exam_year, exam_type, global_name_id, subject_id, marks, grade, student_class, teacher_email) VALUES('$key', $student_roll, '$exam_year', '$exam_type', '$global_name_id', '$subject_id', '$marks', '$grade', '$student_class', '$session_user')";
									$mark_res = mysqli_query($conn, $mark_query);
									if($mark_res) {
										echo "<script>window.location.href='addResults.php?message=success'</script>";
									} else {
										die(mysqli_error($conn));
									}
								}
							}
						?>
					</div>
				</div>
			  </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- ./wrapper -->

  <!-- Main Footer -->
<?php require_once "includes/footer.php"; ?>

<script>
	$(document).ready(function() {
		var global_name_id = $('input.global_name_id').val();
		var exam_type = $('input.exam_type').val();
		var teacher_email = $('input.teacher_email').val();
		var subject_id = $('input.subject_id').val();

		if(global_name_id != '' && exam_type != '') {
			$.ajax({
				url: 'updateResults.php',
				type: 'POST',
				data: {global_name_id: global_name_id, exam_type: exam_type, teacher_email: teacher_email, subject_id: subject_id},
				success: function(data) {
					$("#result_info").html(data);
				}
			});
			
		}
		$(document).on('change', '#class_selector', function() {
			var global_name_id = $(this).val();
			var teacher_email = $('input.teacher_email').val();
			if(global_name_id != '') {
				$.ajax({
					url: 'addSubjectSelect.php',
					type: 'POST',
					data: {teacher_email: teacher_email, global_name_id: global_name_id},
					success: function(data) {
						$("#subject_selector").html(data);
					}
				});
			}
		});
	});
</script>
</body>
</html>
