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
            <h1>All Teachers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">All Teachers</li>
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
                <h3 class="card-title">View All Teachers</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Designation</th>
					<th>Edit</th>
					<th>Delete</th>
                  </thead>
                  <tbody>
					<?php 
						$query = "SELECT * FROM teachers";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$teacher_email 			= $row['teacher_email'];
							$teacher_designation 	= $row['teacher_designation'];

							$query_2 = "SELECT * FROM user WHERE username='$teacher_email' LIMIT 1";
							$result_2 = mysqli_query($conn, $query_2);
							$row_2 = mysqli_fetch_assoc($result_2);

							$teacher_first_name = $row_2['user_firstname'];
							$teacher_last_name = $row_2['user_lastname'];

							echo "<tr>";
								echo "<td>$teacher_first_name</td>";
								echo "<td>$teacher_last_name</td>";
								echo "<td>$teacher_email</td>";
								echo "<td>$teacher_designation</td>";
								echo "<td><a class='btn btn-info' href='editTeacher.php?action=edit_teacher&t_id=$id'>Edit</a></td>";
								echo "<td><a class='btn btn-danger' href='deleteTeacher.php?action=delete_teacher&t_id=$id'>Delete</a></td>";
							echo "</tr>";
						}

					?>
				</tbody>
                  </tbody>
                  <tfoot>
                    <th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Designation</th>
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
