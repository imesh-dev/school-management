<?php 

require_once "includes/header.php"; 

	$username = $_SESSION['username'];

	$id = $_SESSION['id'];
	$select_student = "SELECT user.id,students.id as sid,user.username from user left join students on user.username=students.student_email WHERE user.id='$id'";
	$student_result = mysqli_query($conn, $select_student);
	$student = mysqli_fetch_assoc($student_result);
	$sid = $student['sid'];


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
            <h1>Library Books</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Library Books</li>
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
                <h3 class="card-title">Library Books To Return</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Book Name</th>
					<th>Author</th>
					<th>ISBN</th>
					<th>Return Date</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
					$query = "SELECT book_lend.borrower_name, book_lend.in_date,book_lend.book_name,books.author,books.isbn from book_lend left join books on book_lend.book_name=books.book_name where book_lend.book_name=books.book_name && book_lend.borrower_id='$sid'";

					$result = mysqli_query($conn, $query);
					if(!$result) {
						die(mysqli_error($conn));
					}
					while ($row = mysqli_fetch_assoc($result)) {

						$name = $row['book_name'];
						$author = $row['author'];
						$isbn = $row['isbn'];
						$auth = $row['in_date'];
						
						echo "<tr>";
						echo "<td>".$name."</td>";
						echo "<td>".$author."</td>";
						echo "<td>".$isbn."</td>";
						echo "<td>".$auth." </td>";
						echo "</tr>";
					} 
				?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Book Name</th>
					<th>Author</th>
					<th>ISBN</th>
					<th>Return Date</th>
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
