<?php 

require_once "includes/header.php"; 
function lend_book() {
	global $conn;
	if(isset($_POST['lend_class_btn'])) {
		
		$book_name = clean_data($_POST['borrower_id']);
		$borrower = clean_data($_POST['borrower_name']);
		$fromd = clean_data($_POST['from']);
		$tod = clean_data($_POST['to']);
	
	$query1= "Select id from students where student_name='".$borrower."'  LIMIT 1";
	$result1 = mysqli_query($conn, $query1);
		$row1 = mysqli_fetch_assoc($result1);

		$sid 	= $row1['id'];
	$query = "INSERT INTO book_lend (id, borrower_id, borrower_name, out_date, in_date, book_name) VALUES ('', '$sid', '$borrower', '$tod', '$fromd', '$book_name')";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die(mysqli_error($conn));
			} else {
				echo "<script>window.location.href='lendBook.php'</script>";
			}
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
            <h1>Book lend</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Book lend</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
			
			<div class="col-md-8 col-md-offset-1">
	<?php lend_book(); ?>
	<form action="" method="post">
		<div class="form-group">
			<label for="">Book Name</label>
			<input type="text" name="borrower_id" id="borrower_id" class="form-control">
		</div>
		<table class="table table-striped bg-light text-center" id="booktable">
	<thead>
		<tr>
			<th>Book Name</th>
			<th>ISBN</th>
			<th>Category</th>
			<th>Author</th>
			
		</tr>
	</thead></table>
		<div class="form-group">
			<label for="">Borrower Name</label>
			<input type="text" name="borrower_name" id="borrower_name" class="form-control">
		</div>
		<table class="table table-striped bg-light text-center" id="nametable">
	<thead>
		<tr>
			<th>Student ID</th>
			<th>Name</th>
			<th>Class</th>
			<th>Section</th>
			
		</tr>
	</thead></table>

		<div class="form-group">
			<label for="">From</label>
			<input type="date" name="from" id="from" class="form-control">
		</div>
		<div class="form-group">
			<label for="">To</label>
			<input type="date" name="to" id="to" class="form-control">
		</div>
		<div class="form-group">
			<input type="submit" id="lend_class_btn" name="lend_class_btn" value="Lend book" class="btn btn-info">
		</div>
	</form>
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
	$(document).ready(function() {		
		$('#borrower_id').keyup(function(){
				var bid = document.getElementById('borrower_id').value;
					$.ajax({
				url: 'searchlend.php',
				type: 'POST',
				data: {bid: bid},
				success: function(data) {
					//console.log(data);
					$("#booktable").find("tr:gt(0)").remove();
					$("#booktable").append(data);
				}
			});
			});

	$(document).on('click','#booktable td',function(){
		document.getElementById('borrower_id').value=($(this).text());
		$("#booktable").find("tr:gt(0)").remove();
	});
	
		$('#borrower_name').keyup(function(){
				var borrower_name = document.getElementById('borrower_name').value;
					$.ajax({
				url: 'searchlend.php',
				type: 'POST',
				data: {bname: borrower_name},
				success: function(data) {
					//console.log(data);
					$("#nametable").find("tr:gt(0)").remove();
					$("#nametable").append(data);
				}
			});
			});

	$(document).on('click','#nametable td',function(){
		document.getElementById('borrower_name').value=($(this).text());
		$("#nametable").find("tr:gt(0)").remove();
	});
});


</script>
</body>
</html>
