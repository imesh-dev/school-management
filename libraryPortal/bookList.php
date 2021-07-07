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
            <h1>Book List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Book List</li>
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
                <h3 class="card-title">View/Edit All Book List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Book Name</th>
					<th>Author</th>
					<th>Description</th>
					<th>Year</th>
					<th>ISBN</th>
					<th>Category</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php 
						$query = "SELECT * FROM books";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$teacher_email 			= $row['book_name'];
							$teacher_designation 	= $row['author'];
							$description 	= $row['description'];
							$year 	= $row['year'];
							$isbn 	= $row['isbn'];
							$category 	= $row['category'];
							
							if(strlen($description)>100) $description = substr($description,0,100)."...";
							echo "<tr>";
								echo "<td>$teacher_email</td>";
								echo "<td>$teacher_designation</td>";
								echo "<td>$description</td>";
								echo "<td>$year</td>";
								echo "<td>$isbn</td>";
								echo "<td>$category</td>";
								echo "<td><a class='btn btn-info' href='editBook.php?action=edit_book&t_id=$id'>Edit</a><a class='btn btn-danger' href='deleteBook.php?action=delete_book&t_id=$id'>Delete</a></td>";
							echo "</tr>";
						}

					?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Book Name</th>
					<th>Author</th>
					<th>Description</th>
					<th>Year</th>
					<th>ISBN</th>
					<th>Category</th>
					<th>Action</th>
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
