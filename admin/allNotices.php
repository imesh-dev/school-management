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
            <h1>All Notices</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">All Notices</li>
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
                <h3 class="card-title">View All Notices</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Notice ID</th>
					<th>Notice Title</th>
					<th>Notice Description</th>
					<th>Notice Date</th>
					<th>Edit</th>
					<th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php 
						$query = "SELECT * FROM notice";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$notice_title = $row['notice_title'];
							$notice_desc = $row['notice_desc'];
							$notice_date = $row['notice_date'];

							echo "<tr>";
								echo "<td>$id</td>";
								echo "<td>$notice_title</td>";
								echo "<td>$notice_desc</td>";
								echo "<td>$notice_date</td>";
								echo "<td><a class='btn btn-info' href='editNotice.php?action=edit_notice&n_id=$id'>Edit</a></td>";
								echo "<td><a class='btn btn-danger' href='deleteNotice.php?action=delete_notice&n_id=$id'>Delete</a></td>";
							echo "</tr>";
						}

					?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Notice ID</th>
					<th>Notice Title</th>
					<th>Notice Description</th>
					<th>Notice Date</th>
					<th>Edit</th>
					<th>Delete</th>
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
