<?php 

require_once "includes/header.php"; 

function add_books(){
		global $conn;
		$error = "";
	if(isset($_POST['add_book_btn'])) {

		$book_name 			= clean_data($_POST['teacher_first_name']);
		$author				= clean_data($_POST['teacher_last_name']);
		$category 	= clean_data($_POST['teacher_designation']);
		$year 		= clean_data($_POST['teacher_email']);
		$desc 			= clean_data($_POST['teacher_qualification']);
		$ISBN	= clean_data($_POST['teacher_contact']);
		$publisher	= clean_data($_POST['publisher']);
		$lan	= clean_data($_POST['language']);
		$edi	= clean_data($_POST['edition']);
		$pgs	= clean_data($_POST['pages']);
		$book_img_name 		= $_FILES['teacher_image']['name'];
		$book_img_tmp_name 	= $_FILES['teacher_image']['tmp_name'];

			$path = "../assets/images/book-images/{$book_img_name}";

			move_uploaded_file($book_img_tmp_name, $path);

				$query_2 = "INSERT INTO books(`id`, `book_name`, `author`, `category`, `year`, `description`, `isbn`, `image`,`Publisher`,`Language`,`Edition`,`page`) VALUES('', '$book_name', '$author', '$category', '$year', '$desc','$ISBN' ,'$book_img_name','$publisher','$lan','$edi','$pgs')";
				 if(mysqli_query($conn, $query_2)){
				header("Location: addBook.php?message=success");
			} else {
				$error = "Please Check the details again";
			}

	}
	return $error;
}
$error = add_books();
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
            <h1>Add Book</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Add Book</li>
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
					  Book Details were added successfully.
					</div>";
		}
		
		if(!empty($error)) {
			echo "<div class='alert alert-danger alert-dismissible'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					  <h5><i class='icon fas fa-ban'></i> Alert!</h5>
					  $error
					</div>";
		}
		?>
      <div class="row">
        <div class="col-md-12">
		<form action="" method="post" enctype="multipart/form-data">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Add New Book
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
				<div class="row">
				<div class = "col-6">
					<div class="form-group">
					  <label for="exampleInputBorder">Book Name</label>
					  <input type="text" name="teacher_first_name" class="form-control form-control-border" required>
					</div>
				</div>
				<div class = "col-6">
					<div class="form-group">
					  <label for="exampleInputBorder">Author</label>
					  <input type="text" name="teacher_last_name" class="form-control form-control-border" required>
					</div>
				</div>
				</div>
				
				<div class="row">
				<div class = "col-4">
				  <div class="form-group">
					  <label for="exampleSelectBorder">Category</label>
					  <select name="teacher_designation"  class="custom-select form-control-border" id="exampleSelectBorder">
						<?php 
						$query11 = "SELECT * FROM book_categories";
						$result11 = mysqli_query($conn, $query11);

						if(!$result11) {
							die(mysqli_error($conn));
						}
						while($row11 = mysqli_fetch_assoc($result11)) {
							
							echo "<option value=".$row11['category'].">".$row11['category']."</option>";
						}
						?>
					  </select>
					</div>
				</div>
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">Year</label>
					  <input type="text" name="teacher_email" class="form-control form-control-border" required>
					</div>
				</div>
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">Publisher</label>
					  <input type="text" name="publisher" class="form-control form-control-border" required>
					</div>
				</div>
				</div>
				
				
				<div class="row">
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">pages</label>
					  <input type="text" name="pages" class="form-control form-control-border" >
					</div>
				</div>
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">Edition</label>
					  <input type="text" name="edition" class="form-control form-control-border" required>
					</div>
				</div>
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">Language</label>
					  <input type="text" name="language" class="form-control form-control-border"  required>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-6">
					<label for="exampleInputBorder">Book Cover</label>
					<div class="form-group custom-file">
						  <input type="file" name="teacher_image" class="form-control custom-file-input" id="customFile">
						  <label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>
				<div class="form-group">
					  <label for="exampleInputBorder">ISBN</label>
					  <input type="text" name="teacher_contact" class="form-control form-control-border" required>
					</div>
				</div>				
				<div class="form-group">
				<label for="exampleInputBorder">Description</label>
					<textarea id="summernote" name="teacher_qualification" class="form-control" required>
					</textarea>
				</div>
            </div>
            <div class="card-footer">
				<div class="form-group">
				  <button type="submit" name="add_book_btn" class="btn btn-primary">Add Book</button>
				</div>
			</div>
          </div>
        </div>
		</form>
        <!-- /.col-->
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
	  bsCustomFileInput.init();
    // Summernote
    $('#summernote').summernote();

  });
</script>
</body>
</html>
