<?php 

require_once "includes/header.php"; 
function add_category() {
	global $conn;
	if(isset($_POST['category_submit'])) {
		$subject = clean_data($_POST['subject']);
		if(!empty($subject)) {
			$query = "INSERT INTO book_categories (category) VALUES ('$subject')";
			$result = mysqli_query($conn, $query);
			if($result) {
				echo "<script>window.location.href='categoryList.php'</script>";
			} else {
				die(mysqli_error($conn));
			}
		}
	}
}

function update_category($id) {
	global $conn;
	if(isset($_POST['category_update_submit'])) {
		$subject = clean_data($_POST['subject']);
		if(!empty($subject)) {
			$query = "UPDATE book_categories SET category='$subject' WHERE id=$id";
			$result = mysqli_query($conn, $query);
			if($result) {
				echo "<script>window.location.href='categoryList.php'</script>";
			} else {
				die(mysqli_error($conn));
			}
		}
	}
}

function delete_category() {
	global $conn;
	if(isset($_GET['delete_category'])) {
		$id = $_GET['delete_category'];
		
		$query = "DELETE FROM book_categories WHERE id=$id";
		$result = mysqli_query($conn, $query);
		if($result) {
			header("Location: categoryList.php");
		}

	}
}
delete_category();
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
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
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

		  	  <?php if(isset($_GET['edit_category'])) { ?>
			  	<div class="row ml-3">
				<div class="col-6">
					<?php update_category($_GET['edit_category']); ?>
					<?php
						$subject = $_GET['edit_category'];
						$query2 = "SELECT * FROM book_categories WHERE id=$subject";
						$result2 = mysqli_query($conn, $query2);
						$row2 = mysqli_fetch_assoc($result2);
					?>
					<form action="" method="post">
						<div class="form-group">
							<label for="">Update Categories</label>
							<input type="text" name="subject" class="form-control" value="<?php echo $row2['category']; ?>">
						</div>
						</div>
						<div class="col-3">
						<div class="form-group mt-4">
							<input type="submit" name="category_update_submit" value="Update category" class="btn btn-warning">
						</div>
					</form>
				</div>
				</div>
				<?php } else { ?>
				<div class="row ml-3">
				<div class="col-6">
					<?php add_category(); ?>
					<form action="" method="post">
						<div class="form-group">
							<label for="">Add new Category</label>
							<input type="text" name="subject" class="form-control">
						</div>
				</div>
				<div class="col-3">
						<div class="form-group mt-4">
							<input type="submit" name="category_submit" value="Add category" class="btn btn-info">
						</div>
					</form>
				</div>
				<?php } ?>
				</div>
			</div>
			<div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Category</th>
					<th>Edit</th>
					<th>Delete<span class='text-danger shwo-text'>   (Edit instead of Deleting)</span></th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
						$query = "SELECT * FROM book_categories ORDER BY id ASC";
						$result = mysqli_query($conn, $query);
						if(!$result) {
							die(mysqli_error($conn));
						}
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>".$row['category']."</td>";
							echo "<td><a href='categoryList.php?edit_category=".$row['id']."' class='btn btn-warning'>Edit</a></td>";
							echo "<td><a href='categoryList.php?delete_category=".$row['id']."' class='btn btn-danger delete-hidden'>Delete</a></td>";
							echo "</tr>";
						}
					?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Category</th>
					<th>Edit</th>
					<th>Delete</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
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
