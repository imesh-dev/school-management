<?php 

require_once "includes/header.php"; 

function assign_teacher() {
	global $conn;
	if(isset($_POST['assign_class_btn'])) {

		if(!isset($_POST['week_days'])) {
			header("Location: assign_teacher.php?action=add-new");
		}
		$global_name_id = $_POST['global_name_id'];
		$subject_name_id = $_POST['subject_name_id'];
		$teacher_email 	= $_POST['teacher_email'];
		$class_time 	= clean_data($_POST['class_time']);
		$week_days_array = $_POST['week_days'];
		$week_days = json_encode($week_days_array);
		$is_class_teacher = "N";

		if(isset($_POST['is_class_teacher'])) {
			$is_class_teacher = "Y";
		}

		if(!empty($class_time)) {
			$query = "INSERT INTO class_teacher (global_name_id, subject_name_id, teacher_email, class_time, class_days, is_class_teacher) VALUES ('$global_name_id', '$subject_name_id', '$teacher_email', '$class_time', '$week_days', '$is_class_teacher')";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die(mysqli_error($conn));
			} else {
				echo "<script>window.location.href='classTeachers.php?message=success'</script>";
			}
		}
	}
}
?>

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
            <h1>Assign Teacher</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Assign Teacher</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Assign Teachers</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="col-6 offset-3">
					<?php assign_teacher(); ?>
					<form action="" method="post">
						<div class="form-group">
							<label for="">Class</label>
							<select name="global_name_id" id="global_name_id" class="custom-select form-control-border form-control">
								<option value="">Select One</option>
								<?php
									$query = "SELECT * FROM sections ORDER BY global_name ASC";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_assoc($result)) {
										$section_id = $row['id'];
										$global_name = $row['global_name'];
										echo "<option value='{$section_id}'>{$global_name}</option>";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="">Subject</label>
							<select name="subject_name_id" id="" class="custom-select form-control-border form-control">
								<?php
									$query = "SELECT * FROM subjects ORDER BY subject ASC";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_assoc($result)) {
										$subject_id = $row['id'];
										$subject = $row['subject'];
										echo "<option value='{$subject_id}'>{$subject}</option>";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="">Teacher</label>
							<select name="teacher_email" id="teacher_email" class="custom-select form-control-border form-control">
								<?php
									$query = "SELECT * FROM user WHERE user_role='teacher'";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_assoc($result)) {
										$teacher_fname = $row['user_firstname'];
										$teacher_lname = $row['user_lastname'];
										$teacher_email = $row['username'];
										echo "<option value='$teacher_email'>$teacher_fname $teacher_lname</option>";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="is_class_teacher">Is class teacher?</label>
							<input type="checkbox" id="is_class_teacher" name="is_class_teacher[]" value="Y" class="">
						</div>
						<div class="form-group">
							<label for="">Class Time</label>
							<select name="class_time" id="class_time" class="custom-select form-control-border form-control">
								<option value="">Select Time</option>

							</select>
						</div>
						<div class="form-group">
						<div id="weekDays">
							<h4>Select days</h4>

							<input type="checkbox" id="sat" name="week_days[]" value="Saturday">
							<label for="sat" class="switch">Saturday</label>
							<br>

							<input type="checkbox" id="sun" name="week_days[]" value="Sunday">
							<label for="sun" class="switch">Sunday</label>
							<br>

							<input type="checkbox" id="mon" name="week_days[]" value="Monday">
							<label for="mon" class="switch">Monday</label>
							<br>

							<input type="checkbox" id="tues" name="week_days[]" value="Tuesday">
							<label for="tues" class="switch">Tuesday</label>
							<br>

							<input type="checkbox" id="wed" name="week_days[]" value="Wednesday">
							<label for="wed" class="switch">Wednesday</label>
							<br>

							<input type="checkbox" id="thurs" name="week_days[]" value="Thursday">
							<label for="thurs" class="switch">Thursday</label>
							<br>

							<!-- <input type="checkbox" id="fri" name="week_days[]" value="Friday">
							<label for="fri" class="switch">Friday</label> -->
							<br>
						</div>
						</div>
						<div class="form-group">
							<input type="submit" id="assign_class_btn" name="assign_class_btn" value="Assign Teacher" class="btn btn-info">
						</div>
					</form>
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

<?php require_once "includes/footer.php"; ?>
<script>
	$(document).ready(function() {	
		$("#assign_class_btn").attr('disabled', 'disabled');
		$(document).on('change', '#class_time, #teacher_email', function() {
			var class_time = $("#class_time").val();
			var teacher_email = $("#teacher_email").val();

			if(class_time != '' && teacher_email != '') {
				$.ajax({
					url: 'weekDaysCheck.php',
					type: 'POST',
					data: {class_time: class_time, teacher_email: teacher_email},
					success: function(data) {
						if(data == false) {
							$("#assign_class_btn").attr('disabled', 'disabled');
							$("#weekDays").html("<p class='bg-danger'>This teacher is not available at this time. Please select a different time.</p>");
						} else {
							$("#weekDays").html(data);
							$("#assign_class_btn").attr('disabled', false);
						}
					} 
				});
				
			}
		});
		$(document).on('change', '#global_name_id', function() {
			var global_name_id = $(this).val();
			$.ajax({
				url: 'getClassTime.php',
				type: 'POST',
				data: {global_name_id: global_name_id},
				success: function(data) {
					$("#class_time").html(data);
				}
			});
			
		});
	});
</script>
</body>
</html>
