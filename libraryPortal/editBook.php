<?php 

require_once "includes/header.php"; 

function showBookData() {
	global $conn;
	$data = [];
	if(isset($_GET['action']) && $_GET['action'] == "edit_book") {
		$id = $_GET['t_id'];
		$query = "SELECT * FROM books WHERE id=$id LIMIT 1";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);

		$data['name'] 	= $row['book_name'];
		$data['author'] 		= $row['author'];
		$data['year'] 			= $row['year'];
		$data['description'] 	= $row['description'];
		$data['image'] 			= $row['image'];
		$data['category'] 		= $row['category'];
		$data['isbn'] 		= $row['isbn'];
		$data['Publisher'] 		= $row['Publisher'];
		$data['Edition'] 		= $row['Edition'];
		$data['page'] 		= $row['page'];
		$data['Language'] 		= $row['Language'];

	}
	return $data;
}

$teacher_data = showBookData();

function teacher_email_by_id($id) {
	global $conn;
	$query = "SELECT teacher_email FROM teachers WHERE id=$id LIMIT 1";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	return $row['teacher_email'];
}

function updateBookById() {
	global $conn;
	if(isset($_GET['t_id'])) {

		$t_id = $_GET['t_id'];

		if(isset($_POST['update_book_btn'])) {
			$Book_name 			= clean_data($_POST['teacher_first_name']);
			$author				= clean_data($_POST['teacher_last_name']);
			$category 	= clean_data($_POST['teacher_designation']);
			$year 	= clean_data($_POST['teacher_email']);
			$page 	= clean_data($_POST['pages']);
			$description 	= clean_data($_POST['teacher_qualification']);
			$isbn 		= clean_data($_POST['teacher_contact']);
			$book_img_name 		= $_FILES['teacher_image']['name'];
			$book_img_tmp_name 	= $_FILES['teacher_image']['tmp_name'];

			$teacher_email = teacher_email_by_id($t_id);

			if(!empty($book_img_name)) {
				$path = "../assets/images/book-images/{$book_img_name}";
				move_uploaded_file($book_img_tmp_name, $path);

				$query_img = "UPDATE books SET image='$book_img_name' WHERE id='$t_id'";
				$result_img = mysqli_query($conn, $query_img);
				if(!$result_img) {
					die(mysqli_error($conn));
				}

			}
			
			$query = "UPDATE Books SET book_name='$Book_name', author='$author', category = '$category', year = '$year', description = '$description',isbn='$isbn',page='$page' WHERE id=$t_id";
			
			if(mysqli_query($conn, $query)){
				header("Location: editBook.php?action=edit_book&t_id=$t_id&message=success");
			}
			
		}
	}
}
updateBookById();

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
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
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
					  Book Details were updated successfully.
					</div>";
		}
		?>
      <div class="row">
        <div class="col-md-12">
		<form action="" method="post" enctype="multipart/form-data">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Summernote
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
				<div class="row">
				<div class = "col-6">
					<div class="form-group">
					  <label for="exampleInputBorder">Book Name</label>
					  <input type="text" name="teacher_first_name" class="form-control form-control-border" value="<?php echo $teacher_data['name']; ?>">
					</div>
				</div>
				<div class = "col-6">
					<div class="form-group">
					  <label for="exampleInputBorder">Author</label>
					  <input type="text" name="teacher_last_name" class="form-control form-control-border" value="<?php echo $teacher_data['author']; ?>">
					</div>
				</div>
				</div>
				
				<div class="row">
				<div class = "col-4">
				  <div class="form-group">
					  <label for="exampleSelectBorder">Category</label>
					  <select name="teacher_designation"  class="custom-select form-control-border" id="exampleSelectBorder">
					  <option value="<?php echo $teacher_data['category']; ?>"><?php echo $teacher_data['category']; ?></option>
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
					  <input type="text" name="teacher_email" class="form-control form-control-border" value="<?php echo $teacher_data['year']; ?>">
					</div>
				</div>
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">Publisher</label>
					  <input type="text" name="publisher" class="form-control form-control-border" value="<?php echo $teacher_data['Publisher']; ?>" required>
					</div>
				</div>
				</div>
				
				
				<div class="row">
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">pages</label>
					  <input type="text" name="pages" class="form-control form-control-border" value="<?php echo $teacher_data['page']; ?>">
					</div>
				</div>
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">Edition</label>
					  <input type="text" name="edition" class="form-control form-control-border" value="<?php echo $teacher_data['Edition']; ?>" required>
					</div>
				</div>
				<div class = "col-4">
					<div class="form-group">
					  <label for="exampleInputBorder">Language</label>
					  <input type="text" name="language" class="form-control form-control-border" value="<?php echo $teacher_data['Language']; ?>" required>
					</div>
				</div>
				</div>
				<div class="col-md-12">
					<img src="../assets/images/book-images/<?php echo $teacher_data['image']; ?>" width="230" height="300" alt="">
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
					  <input type="text" name="teacher_contact" class="form-control form-control-border" value="<?php echo $teacher_data['isbn']; ?>">
					</div>
				</div>				
				<div class="form-group">
				<label for="exampleInputBorder">Description</label>
					<textarea id="summernote" name="teacher_qualification" class="form-control">
						<?php echo $teacher_data['description']; ?>
					</textarea>
				</div>
            </div>
            <div class="card-footer">
				<div class="form-group">
				  <button type="submit" name="update_book_btn" class="btn btn-primary">Update Book</button>
				</div>
			</div>
          </div>
        </div>
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
  })
</script>
</body>
</html>
