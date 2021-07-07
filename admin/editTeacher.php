<?php 

require_once "includes/header.php"; 

function teacher_email_by_id($id) {
	global $conn;
	$query = "SELECT teacher_email FROM teachers WHERE id=$id LIMIT 1";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	return $row['teacher_email'];
}


function showTeachersData() {
	global $conn;
	$data = [];
	if(isset($_GET['action']) && $_GET['action'] == "edit_teacher") {
		$id = $_GET['t_id'];
		$query = "SELECT * FROM teachers WHERE id=$id LIMIT 1";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);

		$data['teacher_designation'] 	= $row['teacher_designation'];
		$data['teacher_gender'] 		= $row['teacher_gender'];
		$data['teacher_image'] 			= $row['teacher_image'];
		$data['teacher_qualification'] 	= $row['teacher_qualification'];
		$data['teacher_email'] 			= $row['teacher_email'];
		$data['teacher_address'] 		= $row['teacher_address'];
		$data['teacher_contact'] 		= $row['teacher_contact'];
		$teacher_email 					= $data['teacher_email'];

		$query_2 = "SELECT * FROM user WHERE username='$teacher_email' LIMIT 1";
		$result_2 = mysqli_query($conn, $query_2);
		$row_2 = mysqli_fetch_assoc($result_2);

		$data['teacher_first_name'] = $row_2['user_firstname'];
		$data['teacher_last_name'] = $row_2['user_lastname'];

	}
	return $data;
}

function updateTeacherById() {
	global $conn;
	if(isset($_GET['t_id'])) {

		$t_id = $_GET['t_id'];

		if(isset($_POST['update_teacher_btn'])) {
			$first_name 			= clean_data($_POST['teacher_first_name']);
			$last_name 				= clean_data($_POST['teacher_last_name']);
			$teacher_designation 	= clean_data($_POST['teacher_designation']);
			$teacher_gender 		= clean_data($_POST['teacher_gender']);
			$teacher_qualification 	= clean_data($_POST['teacher_qualification']);
			$teacher_address 		= clean_data($_POST['teacher_address']);
			$teacher_contact 		= clean_data($_POST['teacher_contact']);
			$password 				= clean_data($_POST['password']);
			$teacher_img_name 		= $_FILES['teacher_image']['name'];
			$teacher_img_tmp_name 	= $_FILES['teacher_image']['tmp_name'];

			$teacher_email = teacher_email_by_id($t_id);

			if(!empty($teacher_img_name)) {
				$path = "../assets/images/teacher-images/{$teacher_img_name}";
				move_uploaded_file($teacher_img_tmp_name, $path);

				$query_img = "UPDATE teachers SET teacher_image='$teacher_img_name' WHERE id='$t_id'";
				$result_img = mysqli_query($conn, $query_img);
				if(!$result_img) {
					die(mysqli_error($conn));
				}

			}

			if(!empty($first_name) && !empty($last_name)) {
				$query = "UPDATE user SET user_firstname='$first_name', user_lastname='$last_name' WHERE username='$teacher_email'";
				$result = mysqli_query($conn, $query);
				if(!$result) {
					die(mysqli_error($conn));
				}
			}
			if(!empty($password)) {
				$query_2 = "UPDATE user SET user_password='$password' WHERE username='$teacher_email'";
				$result_2 = mysqli_query($conn, $query_2);
			}
			if(!empty($teacher_designation) && !empty($teacher_qualification) && !empty($teacher_address) && !empty($teacher_contact)) {
				$query_3 = "UPDATE teachers SET teacher_designation='$teacher_designation', teacher_gender='$teacher_gender', teacher_qualification='$teacher_qualification', teacher_address='$teacher_address', teacher_contact='$teacher_contact' WHERE id=$t_id";
				$result_3 = mysqli_query($conn, $query_3);
			}
			header("Location: viewAllTeachers.php?action=edit_teacher&t_id=$t_id&message=success");
		}
	}
}

$teacher_data = showTeachersData();
	updateTeacherById();

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
					  Teacher assigned successfully.
					</div>";
		}
		?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">First Name</label>
							<input type="text" name="teacher_first_name" class="form-control" value="<?php echo $teacher_data['teacher_first_name']; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Last Name</label>
							<input type="text" name="teacher_last_name" class="form-control" value="<?php echo $teacher_data['teacher_last_name']; ?>">
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Designation</label>
							<?php
								$t_id = $_GET['t_id'];
								$query = "SELECT teacher_designation FROM teachers WHERE id=$t_id";
								$result = mysqli_query($conn, $query);
								$row = mysqli_fetch_assoc($result);

								$teacherDesignation = $row['teacher_designation'];
							?>
							<select name="teacher_designation" class="form-control" id="">
								<option value="">Select One</option>
								<option value="Assistant Teacher" <?php echo $teacherDesignation == "Assistant Teacher"? "selected" : ""; ?>>Assistant Teacher</option>
								<option value="Senior Teacher" <?php echo $teacherDesignation == "Senior Teacher"? "selected" : ""; ?>>Senior Teacher</option>
								<option value="Junior Teacher" <?php echo $teacherDesignation == "Junior Teacher"? "selected" : ""; ?>>Junior Teacher</option>
								<option value="Headmaster" <?php echo $teacherDesignation == "Headmaster"? "selected" : ""; ?>>Headmaster</option>
								<option value="Assistant Headmaster" <?php echo $teacherDesignation == "Assistant Headmaster"? "selected" : ""; ?>>Assistant Headmaster</option>
								<option value="Sports Teacher" <?php echo $teacherDesignation == "Sports Teacher"? "selected" : ""; ?>>Sports Teacher</option>
								<option value="Proxy Teacher" <?php echo $teacherDesignation == "Proxy Teacher"? "selected" : ""; ?>>Proxy Teacher</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Gender</label>
							<?php
								$t_id = $_GET['t_id'];
								$query = "SELECT teacher_gender FROM teachers WHERE id=$t_id";
								$result = mysqli_query($conn, $query);
								$row = mysqli_fetch_assoc($result);

								$teacherGender = $row['teacher_gender'];
							?>
							<select name="teacher_gender" class="form-control" id="">
								<option value="">Select One</option>
								<option value="Male" <?php echo $teacherGender == "Male"? "selected" : ""; ?>>Male</option>
								<option value="Female" <?php echo $teacherGender == "Female"? "selected" : ""; ?>>Female</option>
								<option value="Other" <?php echo $teacherGender == "Other"? "selected" : ""; ?>>Other</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Email</label>
							<input type="email" name="teacher_email" class="form-control" value="<?php echo $teacher_data['teacher_email']; ?>" disabled="disabled">
						</div>
					</div>
					</div>
					<div class="row align-items-center justify-content-center">
					<div class="col-3 mb-2">
						<img src="../assets/images/teacher-images/<?php echo $teacher_data['teacher_image']; ?>" width="200" height="140" alt="">
					</div>
					<div class="col-6">
						<div class="form-group custom-file">
						  <input type="file" name="teacher_image" class="form-control custom-file-input" id="customFile">
						  <label class="custom-file-label" for="customFile">Teacher photo</label>
						</div>
					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="exampleInputBorder">Qualification</label>
							<textarea id="summernote" name="teacher_qualification" class="form-control">
								<?php echo $teacher_data['teacher_qualification']; ?>
							</textarea>
						</div>
						<div class="form-group">
							<label for="">Address</label>
							<textarea id="summernote2" name="teacher_address" class="form-control"><?php echo $teacher_data['teacher_address']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="">Contact</label>
							<input type="text" name="teacher_contact" class="form-control" value="<?php echo $teacher_data['teacher_contact']; ?>">
						</div>
						<div class="form-group">
							<label for="">Password</label>
							<input type="password" name="password" class="form-control">
						</div>
					</div>
					<div class="card-footer">
						<div class="form-group">
							<button type="submit" name="update_teacher_btn" class="btn btn-primary">Update Teacher</button>
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
