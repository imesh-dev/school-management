<?php 

require_once "includes/header.php"; 
	function remove_lend() {
	global $conn;
	if(isset($_GET['delete_lend'])) {
		$id = $_GET['delete_lend'];
		$query = "DELETE FROM book_lend WHERE id=$id";
		$result = mysqli_query($conn, $query);
		if($result) {
			header("Location: lendBookList.php");
		}

	}
}
remove_lend();
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
            <h1>Lend Book List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Lend Book List</li>
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
                <h3 class="card-title">Lend Book List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Borrower ID</th>
					<th>Borrower Name</th>
					<th>Book Name</th>
					<th>Lend Date</th>
					<th>Return Date</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
						$query = "SELECT * from book_lend ORDER BY out_date ASC";
						$result = mysqli_query($conn, $query);
						if(!$result) {
							die(mysqli_error($conn));
						}
						while ($row = mysqli_fetch_assoc($result)) {

							$lid = $row['id'];
							$bid = $row['borrower_id'];
							$bname = $row['borrower_name'];
							$odate = $row['out_date'];
							$idate = $row['in_date'];
							$boname = $row['book_name'];

							echo "<tr>";
							echo "<td>".$bid."</td>";
							echo "<td>".$bname."</td>";
							echo "<td>".$boname."</td>";
							echo "<td>".$odate." </td>";
							echo "<td>".$idate."</td>";
							echo "<td><a href='lendBookList.php?delete_lend=".$lid."' class='btn btn-danger'>Recieved</a></td>";
							echo "</tr>";
						}
					?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Borrower ID</th>
					<th>Borrower Name</th>
					<th>Book Name</th>
					<th>Lend Date</th>
					<th>Return Date</th>
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
