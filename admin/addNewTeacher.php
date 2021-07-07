<?php 

require_once "includes/header.php"; 

function is_user_unique( $username ) {
	global $conn;
	$query = "SELECT * FROM user WHERE username='$username'";
	$result = mysqli_query($conn, $query);
	$have_result = mysqli_num_rows($result);
	if($have_result <= 0) {
		return true;
	} else {
		return false;
	}
}

function register_teacher() {
	global $conn;
	$error = "";
	if(isset($_POST['add_teacher_btn'])) {
		$first_name 			= clean_data($_POST['teacher_first_name']);
		$last_name 				= clean_data($_POST['teacher_last_name']);
		$teacher_designation 	= clean_data($_POST['teacher_designation']);
		$teacher_gender 		= clean_data($_POST['teacher_gender']);
		$teacher_email 			= clean_data($_POST['teacher_email']);
		$teacher_qualification 	= clean_data($_POST['teacher_qualification']);
		$teacher_address 		= clean_data($_POST['teacher_address']);
		$teacher_contact 		= clean_data($_POST['teacher_contact']);
		$password 				= clean_data($_POST['password']);
		$teacher_img_name 		= $_FILES['teacher_image']['name'];
		$teacher_img_tmp_name 	= $_FILES['teacher_image']['tmp_name'];

		if(!empty($first_name) && !empty($last_name) && !empty($teacher_designation) && !empty($teacher_email) && !empty($teacher_qualification) && !empty($teacher_address) && !empty($teacher_contact) && !empty($password) && !empty($teacher_img_name)) {

			$path = "../assets/images/teacher-images/{$teacher_img_name}";

			move_uploaded_file($teacher_img_tmp_name, $path);

			if(is_user_unique($teacher_email)) {
				$query = "INSERT INTO user(username, user_password, user_role, user_firstname, user_lastname) VALUES('$teacher_email', '$password', 'teacher', '$first_name', '$last_name')";
				$result = mysqli_query($conn, $query);

				$query_2 = "INSERT INTO teachers(teacher_designation, teacher_gender, teacher_qualification, teacher_email, teacher_address, teacher_contact, teacher_image) VALUES('$teacher_designation', '$teacher_gender', '$teacher_qualification', '$teacher_email', '$teacher_address', '$teacher_contact', '$teacher_img_name')";
				$result_2 = mysqli_query($conn, $query_2);

				header("Location: addnewTeacher.php?action=add_new&message=success");
			} else {
				$error = "This email already exists. Email must be unique.";
			}
		} else {
			$error = "Fields can't be empty.";
		}
	}
	return $error;
}

$error = register_teacher();

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
            <h1>New Teacher</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">New Teacher</li>
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
					  Teacher added successfully.
					</div>";
		}
		if(!empty($error)) {
			echo "<div class='alert alert-danger alert-dismissible'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					  <h5><i class='icon fas fa-check'></i> Alert!</h5>
					  $error
					</div>";
		}
		?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add new Teacher</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">First Name</label>
							<input type="text" name="teacher_first_name" class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Last Name</label>
							<input type="text" name="teacher_last_name" class="form-control">
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Designation</label>
							<select name="teacher_designation" class="form-control" id="">
								<option value="">Select One</option>
								<option value="Assistant Teacher">Assistant Teacher</option>
								<option value="Senior Teacher">Senior Teacher</option>
								<option value="Junior Teacher">Junior Teacher</option>
								<option value="Headmaster">Headmaster</option>
								<option value="Assistant Headmaster">Assistant Headmaster</option>
								<option value="Sports Teacher">Sports Teacher</option>
								<option value="Proxy Teacher">Proxy Teacher</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label for="">Gender</label>
							<select name="teacher_gender" class="form-control" id="">
								<option value="">Select One</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Email</label>
							<input type="email" name="teacher_email" class="form-control" >
						</div>
					</div>
					</div>
					<div class="row mt-2 mb-3">
					<div class="col-6">
						<div class="form-group custom-file">
						  <input type="file" name="teacher_image" class="form-control custom-file-input" id="customFile">
						  <label class="custom-file-label" for="customFile">Teacher photo</label>
						</div>
					</div>
					</div>
					<div class="form-group">
						<label for="">Qualification</label>
						<textarea id="summernote" name="teacher_qualification" class="form-control">
						</textarea>
					</div>
					<div class="form-group">
						<label for="">Address</label>
						<textarea id="summernote2" name="teacher_address" class="form-control">
						</textarea>
					</div>
					<div class="form-group">
						<label for="">Contact</label>
						<input type="text" name="teacher_contact" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Password</label>
						<input type="password" name="password" class="form-control">
					</div>
					<div class="card-footer">
						<div class="form-group">
							<button type="submit" name="add_teacher_btn" class="btn btn-primary">Add Teacher</button>
						</div>
							</form>
					</div>
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
    // Summernote
    $('#summernote').summernote();
	$('#summernote2').summernote();
	bsCustomFileInput.init();
  })
</script>
</body>
</html>
