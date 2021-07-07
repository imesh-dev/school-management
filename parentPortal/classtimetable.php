<?php 

require_once "includes/header.php"; 

	$username = $_SESSION['username'];

	$select_student = "SELECT * FROM students WHERE student_email='$username' AND student_status='active'";
	$student_result = mysqli_query($conn, $select_student);

	if(mysqli_num_rows($student_result) <= 0) {
		header("Location: index.php");
	}

	$student = mysqli_fetch_assoc($student_result);

	$student_email = $student['student_email'];
	$student_name = $student['student_name'];
	$student_class = $student['student_class'];
	$student_section = $student['student_section'];
	$student_group = $student['student_group'];
	$student_roll = $student['student_roll'];

	$select_global_name_id = "SELECT * FROM sections WHERE class_id=$student_class AND section='$student_section' AND group_name='$student_group'";

	$global_name_id_res = mysqli_query($conn, $select_global_name_id);

	if(!$global_name_id_res)die(mysqli_error($conn));

	$row = mysqli_fetch_assoc($global_name_id_res);

	$global_name_id = $row['id'];


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
            <h1>Time Table</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Time Table</li>
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
                <h3 class="card-title">Class Time Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Subject</th>
					<th>Teacher</th>
					<th>Days</th>
					<th>Time</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
					$query = "SELECT class_teacher.teacher_email, class_teacher.class_days, class_teacher.class_time, subjects.subject FROM class_teacher INNER JOIN subjects ON class_teacher.subject_name_id=subjects.id WHERE class_teacher.global_name_id=$global_name_id";

					$result = mysqli_query($conn, $query);
					if(!$result) {
						die(mysqli_error($conn));
					}

					while ($data = mysqli_fetch_assoc($result)) {
						$subject = $data['subject'];
						$teacher = teacher_name_by_email($data['teacher_email']);
						$time = $data['class_time'];

						$booked_days_encoded = $data['class_days'];
						$class_days_decoded = json_decode($booked_days_encoded, true);
						$class_days_string = implode(", ", $class_days_decoded);

						echo "<tr>";
						echo "<td>$subject</td>";
						echo "<td>$teacher</td>";
						echo "<td>$class_days_string</td>";
						echo "<td>$time</td>";
						echo "</tr>";
					}
				?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Subject</th>
					<th>Teacher</th>
					<th>Days</th>
					<th>Time</th>
                  </tr>
                  </tfoot>
                </table>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
