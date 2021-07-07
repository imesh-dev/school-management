<?php 

require_once "includes/header.php"; 

	if(isset($_GET['global_name_id'])) {
		$global_name_id = $_GET['global_name_id'];
	}

?>
<input id='thisclass' type='hidden' value='<?php echo $global_name_id; ?>' >

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
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<form action="" method="post">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  <div class="col-4 form-group">
                  <label>Date:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="select_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
		  
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped ">
                  <thead>
                  <tr>
                    <th>Student ID</th>
					<th>Name</th>
					<th>Roll</th>
					<th>Attendence</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
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

								$select_students = "SELECT * FROM students WHERE student_class=$class_id AND student_section='$section' AND student_group='$group' AND student_status='active' ORDER BY id ASC";

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
									echo "<td>$std_name</td>";
									echo "<td>$std_roll</td>";
									echo "<td>
										<input type='checkbox' class='form-control student_id' name='attendance[]' std_id='{$std_id}' std-roll='{$std_roll}'>
										<input type='hidden' class='student-{$std_roll}' name='myid[]' value=''>

									</td>";
									echo "</tr>";
								}
							}
						} else {
							header("Location: my_classes.php");
						}
						?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Student ID</th>
					<th>Name</th>
					<th>Roll</th>
					<th>Attendence</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
			  
			  <div class="card-footer">
                  <button type="submit" name="attendance_submit" class="btn btn-primary">Submit Attendance</button>
                </div>
				</form>
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
  $(function () {

	$('#reservationdate').datetimepicker({
        format: 'YYYY/MM/DD'
    });
	
	$('.select_date').on('change', function() {
			$("#error-msg").empty();

			var datess = $(this).val();
			var classs = $('#thisclass').val();
			$.ajax({
				url: 'attendance_checker.php',
				type: 'POST',
				data: {classs: classs, datess: datess},
				success: function(data) {
					if(data) {
						$('.make-hidden').hide();
						$('.success-msg').hide();
						$("#error-msg").html("<div class='col-md-12 text-center'><h3>Attendance taken on this day.</h3></div>");
					} else {
						$('.make-hidden').show();
					}
				}		
			});
			
		});
  });
</script>
</body>
</html

<?php
	if(isset($_POST['attendance_submit']) && isset($_POST['attendance'])) {

		$students_attendance = $_POST['attendance'];
		$class_date = $_POST['select_date'];

		var_dump($students_attendance);
		var_dump($class_date);

		foreach ($total_students as $key => $student) {
			if(in_array($student, $students_attendance)) {
				$attendance_val = "Y";
			} else {
				$attendance_val = "N";
			}
			$query = "INSERT INTO attendance (dates, student_id, attendance, global_name_id, teacher_email) VALUES ('$class_date', '$student', '$attendance_val', '$global_name_id', '$session_user')";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die(mysqli_error($conn));
			}
		}
		echo "<div class='col-md-12 text-center success-msg'><h3>Done!</h3></div>";
	}


?>
