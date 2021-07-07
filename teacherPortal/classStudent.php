<?php 

require_once "includes/header.php"; 

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
            <h1>Class Students</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Students</li>
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
                <h3 class="card-title">All the Students of the class</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Student ID</th>
					<th>Name</th>
					<th>Farther's Name</th>
					<th>Address</th>
					<th>Contact No</th>
					<th>Blood Group</th>
					<th>Contact Parent</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
					if(isset($_GET['global_name_id'])) {

						$session_user = clean_data($_SESSION['username']);
						$global_name_id = $_GET['global_name_id'];

						$query = "SELECT * FROM sections WHERE id=$global_name_id";
						$result = mysqli_query($conn, $query);

						if(!$result) {
							die(mysqli_error($conn));
						}

						while($row = mysqli_fetch_assoc($result)) {

							$class_id = $row['class_id'];
							$section = $row['section'];
							$group = $row['group_name'];

							$select_students = "SELECT * FROM students WHERE student_class=$class_id AND student_section='$section' AND student_group='$group' AND student_status='active'";

							$student_result = mysqli_query($conn, $select_students);
							if(!$student_result) {
								die(mysqli_error($conn));
							}
							while($students = mysqli_fetch_assoc($student_result)) {
								$std_id = $students['student_email'];
								$std_name = $students['student_name'];
								$student_father_name = $students['student_father_name'];
								$student_address = $students['student_address'];
								$student_contact = $students['student_contact'];
								$student_blood_group = $students['student_blood_group'];

								echo "<tr>";
								echo "<td>$std_id</td>";
								echo "<td>$std_name</td>";
								echo "<td>$student_father_name</td>";
								echo "<td>$student_address</td>";
								echo "<td>$student_contact</td>";
								echo "<td>$student_blood_group</td>";
								echo "<td><a class='btn btn-info' href='contactParent.php?action=message&id=$std_id'>send Message</a></td>";
								echo "</tr>";
							}
						}
					} else {
						header("Location: classes.php");
					}
					?>	
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Student ID</th>
					<th>Name</th>
					<th>Farther's Name</th>
					<th>Address</th>
					<th>Contact No</th>
					<th>Blood Group</th>
					<th>Contact Parent</th>
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
