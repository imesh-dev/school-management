<?php 

require_once "includes/header.php"; 
function get_subject_name_by_id($id) {
	global $conn;
	$query = "SELECT subject FROM subjects WHERE id=$id";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	return $row['subject'];
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
            <h1>All Classes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Classes</li>
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
                <h3 class="card-title">All classes Assigned to me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Class</th>
					<th>Subject</th>
					<th>Time</th>
					<th>Days</th>
					<th>My Students</th>
					<th>Take Attendance</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
					<?php
						$session_user = clean_data($_SESSION['username']);
						$query = "SELECT *, class_teacher.is_class_teacher, class_teacher.subject_name_id as subject_id FROM sections INNER JOIN class_teacher ON sections.id=class_teacher.global_name_id AND class_teacher.teacher_email='$session_user'";
						$result = mysqli_query($conn, $query);
						if(!$result) {
							die(mysqli_error($conn));
						}
						while($row = mysqli_fetch_assoc($result)) {

							$my_class = $row['global_name'];
							$is_class_teacher = $row['is_class_teacher'];
							$class_time = $row['class_time'];
							$global_name_id = $row['global_name_id'];
							$subject_id = $row['subject_id'];
							$class_days_encoded = $row['class_days'];
							$class_days_decoded = json_decode($class_days_encoded, true);
							$class_days = implode(", ", $class_days_decoded);


							echo "<tr>";
							echo "<td>$my_class</td>";
							echo "<td>".get_subject_name_by_id($subject_id)."</td>";
							echo "<td>$class_time</td>";
							echo "<td>$class_days</td>";
							echo "<td><a href='classStudent.php?global_name_id=$global_name_id' class='btn btn-info'>View Student</a></td>";
							if($is_class_teacher == 'Y') {
								echo "<td><a href='markAttendence.php?global_name_id=$global_name_id' class='btn btn-info'>Take Attendance</a></td>";
							} else {
								echo "<td>No access</td>";
							}
							echo "</tr>";
						}
				?>
                  </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Class</th>
					<th>Subject</th>
					<th>Time</th>
					<th>Days</th>
					<th>My Students</th>
					<th>Take Attendance</th>
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
