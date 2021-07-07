<?php 

require_once "includes/header.php"; 


function add_new_notice_lib() {
	global $conn;
	if(isset($_POST['add_notice_btn'])) {
		$notice_title = clean_data($_POST['notice_title']);
		$notice_desc = clean_data($_POST['notice_desc']);
		$notice_image 		= $_FILES['notice_image']['name'];
		$notice_image_temp 	= $_FILES['notice_image']['tmp_name'];
		
		$path = "../assets/images/notice-images/{$notice_image}";
		
		move_uploaded_file($notice_image_temp, $path); 

		if(!empty($notice_title) && !empty($notice_desc)) {
			$query = "INSERT INTO notice (notice_title, notice_desc, notice_date,department,image) VALUES ('$notice_title', '$notice_desc', now(),'','$notice_image')";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: addNewNotice.php?action=add_new&message=success");
			}

		}
	}
}
add_new_notice_lib();
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
            <h1>New Notice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">New Notice</li>
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
					  Notice was added successfully.
					</div>";
		}
		?>
      <div class="row">
        <div class="col-md-12">
		<form action="" method="post" enctype="multipart/form-data" >
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Add New Notice
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
				<div class="row">
				<div class = "col-10">
					<div class="form-group">
					  <label for="exampleInputBorder">Notiece Title</label>
					  <input type="text" name="notice_title" class="form-control form-control-border" required>
					</div>
				</div>
				<div class="col-10 mb-4">
					<label for="exampleInputBorder">Notice Image</label>
					<div class="form-group custom-file">
						  <input type="file" name="notice_image" class="form-control custom-file-input" id="customFile">
						  <label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>
				<div class = "col-11">				
				<div class="form-group">
				<label for="exampleInputBorder">Notice Description</label>
					<textarea id="summernote" name="notice_desc" class="form-control" required>
						Notice description.
					</textarea>
				</div>
				</div>
            </div>
            <div class="card-footer">
				<div class="form-group">
				  <button type="submit" name="add_notice_btn" class="btn btn-primary">Add Notice</button>
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
    // Summernote
    $('#summernote').summernote();
	
		bsCustomFileInput.init();
  })
</script>
</body>
</html>
