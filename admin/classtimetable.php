<?php 

require_once "includes/header.php"; 

function add_class_time() {
	global $conn;
	if(isset($_POST['class_time_submit'])) {
		$class_time = clean_data($_POST['class_time']);
		if(!empty($class_time)) {
			$query = "INSERT INTO classtime (class_time) VALUES ('$class_time')";
			$result = mysqli_query($conn, $query);
			if($result) {
				header("Location: classtimetable.php");
			} else {
				die(mysqli_error($conn));
			}
		}
	}
}

function get_class_time_by_id($id) {
	global $conn;
	$query = "SELECT class_time FROM classtime WHERE id=$id";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	return $row['class_time'];
}

function update_class_time($id) {
	global $conn;
	if(isset($_POST['update_class_time_submit'])) {
		$class_time = clean_data($_POST['class_time']);
		if(!empty($class_time)) {
			$query = "UPDATE classtime SET class_time='$class_time' WHERE id=$id";
			$result = mysqli_query($conn, $query);
			if($result) {
				echo "<script>window.location.href='classtimetable.php'</script>";
			} else {
				die(mysqli_error($conn));
			}
		}
	}
}

if(isset($_GET['delete_time'])) {
	$id = $_GET['delete_time'];

	$select_class_time = "SELECT class_time FROM classtime WHERE id=$id";
	$class_time_res = mysqli_query($conn, $select_class_time);
	$class_time_row = mysqli_fetch_assoc($class_time_res);
	$class_time = $class_time_row['class_time'];

	$delete_assigned_sec_query = "DELETE FROM class_teacher WHERE class_time='$class_time'";
	$delete_assigned_sec_result = mysqli_query($conn, $delete_assigned_sec_query);

	$query = "DELETE FROM classtime WHERE id=$id";
	$result = mysqli_query($conn, $query);

	if($result) {
		header("Location: classtimetable.php");
	} else {
		die(mysqli_error($conn));
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
            <h1>Class Times</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Class Times</li>
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
					<?php
					if(isset($_GET['edit_class_time'])) {
						$class_time_id = $_GET['edit_class_time'];
						update_class_time($class_time_id);
					?>
					<div class="row align-items-end">
					<div class="col-6 offset-1">
					<form action="" method="post">
						<div class="form-group">
							<label for="">Update Class Time</label>
							<input type="text" name="class_time" class="form-control" value="<?php echo get_class_time_by_id($class_time_id); ?>">
						</div>
						</div>
						<div class="col-3">
						<div class="form-group">
							<input type="submit" name="update_class_time_submit" value="Update Class Time" class="btn btn-warning">
						</div>
					</form>
				</div>
				</div>
				<?php } else { ?>
				<div class="row  align-items-end">
				<div class="col-6 offset-1">
					<?php add_class_time(); ?>
					<form action="" method="post">
						<div class="form-group">
							<label for="">Add Class Time</label>
							<input type="text" name="class_time" class="form-control">
						</div>
				</div>
				<div class="col-3">
						<div class="form-group">
							<input type="submit" name="class_time_submit" value="Add Class Time" class="btn btn-info">
						</div>
					</form>
				</div>
				</div>
				<?php } ?>
				
			</div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
					<th>Class Time</th>
					<th>Edit</th>
					<th>Delete<span class='text-danger shwo-text'>(Edit instead of Deleting)</span></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
					$query = "SELECT * FROM classtime ORDER BY class_time ASC";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						die(mysqli_error($conn));
					}
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>".$row['id']."</td>";
						echo "<td>".$row['class_time']."</td>";
						echo "<td><a href='classtimetable.php?edit_class_time=".$row['id']."' class='btn btn-warning'>Edit</a></td>";
						echo "<td><a href='classtimetable.php?delete_time=".$row['id']."' class='btn btn-danger delete-hidden'>Delete</a></td>";
						echo "</tr>";
					}
				?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
					<th>Class Time</th>
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
