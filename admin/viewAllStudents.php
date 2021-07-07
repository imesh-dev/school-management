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
            <h1>All Students</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">All Students</li>
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
					  Teacher details were updated successfully.
					</div>";
		}
		?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View All Students</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <th>Name</th>
					<th>Email</th>
					<th>Class</th>
					<th>Section</th>
					<th>Group</th>
					<th>Roll</th>
					<th>Status</th>
					<th>Edit</th>
					<th>Delete</th>
                  </thead>
                  <tbody>
					<?php 
						$sql = "SELECT * FROM students";
						$res_data = mysqli_query($conn,$sql);

						while($row = mysqli_fetch_assoc($res_data)) {
							$id 					= $row['id'];
							$student_email 			= $row['student_email'];
							$student_class 			= $row['student_class'];
							$student_section 		= $row['student_section'];
							$student_group 			= $row['student_group'];
							$student_roll 			= $row['student_roll'];
							$student_status 		= $row['student_status'];
							$student_name = $row['student_name'];

							echo "<tr>";
								echo "<td>$student_name</td>";
								echo "<td>$student_email</td>";
								echo "<td>$student_class</td>";
								echo "<td>$student_section</td>";
								echo "<td>$student_group</td>";
								echo "<td>$student_roll</td>";
								echo "<td>$student_status</td>";
								echo "<td><a class='btn btn-info' href='editStudent.php?action=edit_student&s_id=$id'>Edit</a></td>";
								echo "<td><a class='btn btn-danger' href='deleteStudent.php?action=delete_student&s_id=$id'>Delete</a></td>";
							echo "</tr>";
						}

					?>
                  </tbody>
                  <tfoot>
                    <th>Name</th>
					<th>Email</th>
					<th>Class</th>
					<th>Section</th>
					<th>Group</th>
					<th>Roll</th>
					<th>Status</th>
					<th>Edit</th>
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
