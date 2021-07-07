<?php 

require_once "includes/header.php"; 

	$username = $_SESSION['username'];

	$id = $_SESSION['id'];
	$select_student = "SELECT user.id,students.id as sid,user.username from user left join students on user.username=students.student_email WHERE user.id='$id'";
	$student_result = mysqli_query($conn, $select_student);
	$student = mysqli_fetch_assoc($student_result);
	$sid = $student['sid'];

function get_subject_name_by_id($id) {
	global $conn;
	$query = "SELECT subject FROM subjects WHERE id=$id";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	return $row['subject'];
}

	global $conn;
	if(isset($_GET['delete_class_teacher'])) {
		$id = $_GET['delete_class_teacher'];
		$query = "DELETE FROM class_teacher WHERE id=$id";
		$result = mysqli_query($conn, $query);
		if($result) {
			echo "<script>window.location.href='classTeachers.php'</script>";
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
            <h1>Class Teachers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">class Teachers</li>
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
					  Teacher assigned successfully.
					</div>";
		}
		?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All the Class Teachers</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <th>Info</th>
					<th>Subject</th>
					<th>Teacher</th>
					<th>Time</th>
					<th>Delete</th>
                  </thead>
                  <tbody>
					<?php
						$query = "SELECT *, class_teacher.id as class_id FROM class_teacher INNER JOIN user ON class_teacher.teacher_email=user.username ORDER BY class_teacher.id ASC";
						$result = mysqli_query($conn, $query);
						if(!$result) {
							die(mysqli_error($conn));
						}
						while ($row = mysqli_fetch_assoc($result)) {

							$global_name_id = $row['global_name_id'];
							$subject_id = $row['subject_name_id'];
							$query_global_name = "SELECT global_name FROM sections WHERE id=$global_name_id";
							$result_global_name = mysqli_query($conn, $query_global_name);
							$row_global_name = mysqli_fetch_assoc($result_global_name);
							$global_name = $row_global_name['global_name'];

							echo "<tr>";
							echo "<td>$global_name</td>";
							echo "<td>".get_subject_name_by_id($subject_id)."</td>";
							echo "<td>".$row['user_firstname'] ." ". $row['user_lastname']."</td>";
							echo "<td>".$row['class_time']."</td>";
							echo "<td><a href='classTeachers.php?delete_class_teacher=".$row['class_id']."' class='btn btn-danger'>Delete</a></td>";
							echo "</tr>";
						}
					?>
				</tbody>
                  </tbody>
                  <tfoot>
                    <th>Info</th>
					<th>Subject</th>
					<th>Teacher</th>
					<th>Time</th>
					<th>Delete</th>
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
