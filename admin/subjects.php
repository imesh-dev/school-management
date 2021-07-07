<?php 

require_once "includes/header.php"; 

function add_subject() {
	global $conn;
	if(isset($_POST['subject_submit'])) {
		$subject = clean_data($_POST['subject']);
		if(!empty($subject)) {
			$query = "INSERT INTO subjects (subject) VALUES ('$subject')";
			$result = mysqli_query($conn, $query);
			if($result) {
				echo "<script>window.location.href='subjects.php'</script>";
			} else {
				die(mysqli_error($conn));
			}
		}
	}
}

function update_subject($id) {
	global $conn;
	if(isset($_POST['subject_update_submit'])) {
		$subject = clean_data($_POST['subject']);
		if(!empty($subject)) {
			$query = "UPDATE subjects SET subject='$subject' WHERE id=$id";
			$result = mysqli_query($conn, $query);
			if($result) {
				echo "<script>window.location.href='subjects.php'</script>";
			} else {
				die(mysqli_error($conn));
			}
		}
	}
}

function delete_subject() {
	global $conn;
	if(isset($_GET['delete_subject'])) {
		$id = $_GET['delete_subject'];

		$sub_query = "DELETE FROM class_teacher WHERE class_name_id=$id";
		$delete_sub = mysqli_query($conn, $sub_query);
		
		$query = "DELETE FROM subjects WHERE id=$id";
		$result = mysqli_query($conn, $query);
		if($result) {
			echo "<script>window.location.href='subjects.php'</script>";
		}

	}
}

delete_subject();

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
            <h1>Subjects</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Subjects</li>
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
					if(isset($_GET['edit_subject'])) {
						update_subject($_GET['edit_subject']);
						$subject = $_GET['edit_subject'];
						$query2 = "SELECT * FROM subjects WHERE id=$subject";
						$result2 = mysqli_query($conn, $query2);
						$row2 = mysqli_fetch_assoc($result2);
					?>
					<div class="row align-items-end">
					<div class="col-6 offset-1">
					<form action="" method="post">
						<div class="form-group">
							<label for="">Update Subject</label>
							<input type="text" name="subject" class="form-control" value="<?php echo $row2['subject']; ?>">
						</div>
						</div>
						<div class="col-3">
						<div class="form-group">
							<input type="submit" name="subject_update_submit" value="Update Subject" class="btn btn-warning">
						</div>
					</form>
				</div>
				</div>
				<?php } else { ?>
				<div class="row  align-items-end">
				<div class="col-6 offset-1">
					<?php add_subject(); ?>
					<form action="" method="post">
						<div class="form-group">
							<label for="">Add Subject</label>
							<input type="text" name="subject" class="form-control">
						</div>
				</div>
				<div class="col-3">
						<div class="form-group">
							<input type="submit" name="subject_submit" value="Add Subject" class="btn btn-info">
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
					<th>Subject</th>
					<th>Edit</th>
					<th>Delete<span class='text-danger shwo-text'>(Edit instead of Deleting)</span></th>
                  </tr>
                  </thead>
                  <tbody>				
					<?php
						$query = "SELECT * FROM subjects ORDER BY subject ASC";
						$result = mysqli_query($conn, $query);
						if(!$result) {
							die(mysqli_error($conn));
						}
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>".$row['id']."</td>";
							echo "<td>".$row['subject']."</td>";
							echo "<td><a href='subjects.php?edit_subject=".$row['id']."' class='btn btn-warning'>Edit</a></td>";
							echo "<td><a href='subjects.php?delete_subject=".$row['id']."' class='btn btn-danger delete-hidden'>Delete</a></td>";
							echo "</tr>";
						}
					?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
					<th>Subject</th>
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
