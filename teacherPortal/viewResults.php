<?php 

require_once "includes/header.php"; 
	$session_user = $_SESSION['username'];

	//function to process the class and id
	if(isset($_POST['update_get_class_submit'])) {
		echo $global_name_id = $_POST['select_class'];
		echo $exam_type = $_POST['exam_type'];
		echo $select_subject = $_POST['select_subject'];

		if(!empty($global_name_id) && !empty($exam_type) && !empty($select_subject)) {
			header("Location: viewResults.php?global_name_id=$global_name_id&exam_type=$exam_type&subject=$select_subject");
		} else {
			header("Location: viewResults.php");
		}
	}
	function get_attendance_total_students($teacher_email, $global_name_id, $exam_type){
	global $conn;
	$total_students = [];
	$query = "SELECT * FROM results WHERE teacher_email='$teacher_email' AND global_name_id='$global_name_id' AND exam_type='$exam_type' ORDER BY student_roll ASC";

	$results = mysqli_query($conn, $query);
	while($row = mysqli_fetch_assoc($results)) {
		$total_students[] = $row['student_id'];
	}
	return $total_students;
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
	if(isset($_POST['result_update_submit'])) {
		$exam_type = $_GET['exam_type'];
		$subject_id = $_GET['subject'];
		$global_name_id = $_GET['global_name_id'];
		$results = $_POST['marks'];
		$exam_year = $_POST['exam_year'];
		$total_students = get_attendance_total_students($session_user, $global_name_id, $exam_type);
		$combine_results = array_combine($total_students, $results);

		foreach ($combine_results as $key => $marks) {
			if(empty($marks)) {
				$marks = 0;
			}
			$grade = get_grade_by_marks($marks);

			$update_query = "UPDATE results SET marks='$marks', grade='$grade' WHERE student_id='$key' AND exam_year='$exam_year'";
						echo $update_query;
			$update_result = mysqli_query($conn, $update_query);
			if($update_result) {
				header("Location: viewResults.php?message=success");
			}
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
					  Results were updated successfully.
					</div>";
		}
		?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View Student Results</h3>
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
								<input type="submit" name="update_get_class_submit" value="Submit" class="btn btn-info">
							</div>
						</form>
					</div>
					<div class="clearfix"></div>

					<?php } else { ?>
						<?php
							$global_name_id = $_GET['global_name_id'];
							$exam_type = $_GET['exam_type'];
							$subject_id = $_GET['subject'];
						?>
						<input type="hidden" class="global_name_id" value="<?php echo $global_name_id; ?>">
						<input type="hidden" class="exam_type" value="<?php echo $exam_type; ?>">
						<input type="hidden" class="subject_id" value="<?php echo $subject_id; ?>">

						 <div class="card-body" id="result_info">

					<?php } ?>
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
					url: 'subjectSelector.php',
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
