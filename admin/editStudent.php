<?php 

require_once "includes/header.php"; 

function student_email_by_id($id) {
	global $conn;
	$query = "SELECT student_email FROM students WHERE id=$id LIMIT 1";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	return $row['student_email'];
}

function showStudentsData() {
	global $conn;
	$data = [];
	if(isset($_GET['action']) && $_GET['action']=='edit_student') {
		$s_id = $_GET['s_id'];
		$query = "SELECT * FROM students INNER JOIN user ON user.username=students.student_email AND students.id=$s_id";
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);
		$data['username'] = $row['username'];
		$data['user_role'] = $row['user_role'];
		$data['user_firstname'] = $row['user_firstname'];
		$data['user_lastname'] = $row['user_lastname'];
		$data['student_class'] = $row['student_class'];
		$data['student_section'] = $row['student_section'];
		$data['student_roll'] = $row['student_roll'];
		$data['student_father_name'] = $row['student_father_name'];
		$data['student_mother_name'] = $row['student_mother_name'];
		$data['student_address'] = $row['student_address'];
		$data['student_contact'] = $row['student_contact'];
		$data['student_dob']		 	= $row['student_dob'];
		$data['student_blood_group']	= $row['student_blood_group'];
		$data['student_gender']			= $row['student_gender'];
		$data['student_status']			= $row['student_status'];

	}
	
	return $data;
}	

function updateStudentById() {
	global $conn;
	$s_id = $_GET['s_id'];
	if(isset($_POST['update_student_btn'])) {
		$username 				= clean_data($_POST['username']);
		$user_role 				= clean_data($_POST['user_role']);
		$user_password 			= clean_data($_POST['user_password']);
		$user_firstname 		= clean_data($_POST['user_firstname']);
		$user_lastname 			= clean_data($_POST['user_lastname']);
		$student_class 			= clean_data($_POST['student_class']);
		$student_section 		= clean_data($_POST['student_section']);
		$student_group 			= clean_data($_POST['student_group']);
		$student_roll 			= clean_data($_POST['student_roll']);
		$student_father_name 	= clean_data($_POST['student_father_name']);
		$student_mother_name 	= clean_data($_POST['student_mother_name']);
		$student_address 		= clean_data($_POST['student_address']);
		$student_contact 		= clean_data($_POST['student_contact']);
		$student_dob		 	= clean_data($_POST['student_dob']);
		$student_blood_group	= clean_data($_POST['student_blood_group']);
		$student_gender			= clean_data($_POST['student_gender']);
		$student_status			= clean_data($_POST['student_status']);
		$student_name 			= $user_firstname. " ". $user_lastname;

		$student_email = student_email_by_id($s_id);

		if(!empty($user_firstname) && !empty($user_lastname) && !empty($username)) {
			$query = "UPDATE user SET user_firstname='$user_firstname', user_lastname='$user_lastname', username='$username' WHERE username='$student_email'";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die(mysqli_error($conn));
			}
		}
		if(!empty($user_password)) {
			$query_2 = "UPDATE user SET user_password='$user_password' WHERE username='$student_email'";
			$result_2 = mysqli_query($conn, $query_2);
		}
		if(!empty($student_section) && !empty($student_roll) && !empty($student_address) && !empty($student_contact) && !empty($student_class)) {
			$query_3 = "UPDATE students SET student_email='$username', student_name='$student_name', student_class='$student_class', student_section='$student_section', student_group='$student_group', student_roll='$student_roll', student_father_name='$student_father_name', student_mother_name='$student_mother_name', student_address='$student_address', student_contact='$student_contact', student_dob='$student_dob', student_blood_group='$student_blood_group', student_gender='$student_gender', student_status='$student_status' WHERE id=$s_id";
			$result_3 = mysqli_query($conn, $query_3);
		}
		header("Location: editStudent.php?action=edit_student&s_id=$s_id&message=success");
	}
}

$students_data = showStudentsData();
	updateStudentById();

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
					  Student data updated successfully.
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
                <form action="" method="post">
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">First Name</label>
							<input type="text" name="user_firstname" class="form-control" value="<?php echo $students_data['user_firstname']; ?>" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Last Name</label>
							<input type="text" name="user_lastname" class="form-control" value="<?php echo $students_data['user_lastname']; ?>">
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Username</label>
							<input type="email" name="username" class="form-control" value="<?php echo $students_data['username']; ?>" readonly>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Password</label>
							<input type="text" name="user_password" class="form-control">
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Class</label>
							<?php
								$s_id = $_GET['s_id'];
								$query = "SELECT student_class FROM students WHERE id=$s_id";
								$result = mysqli_query($conn, $query);
								$row = mysqli_fetch_assoc($result);

								$studentClass = $row['student_class'];
							?>
							<select name="student_class" class="form-control" id="">
								<option value="">Select Class</option>
								<option value="6" <?php echo $studentClass == "6"? "selected" : ""; ?>>6</option>
								<option value="7" <?php echo $studentClass == "7"? "selected" : ""; ?>>7</option>
								<option value="8" <?php echo $studentClass == "8"? "selected" : ""; ?>>8</option>
								<option value="9" <?php echo $studentClass == "9"? "selected" : ""; ?>>9</option>
								<option value="10" <?php echo $studentClass == "10"? "selected" : ""; ?>>10</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Section</label>
							<?php
								$s_id = $_GET['s_id'];
								$query_2 = "SELECT student_section FROM students WHERE id=$s_id";
								$result_2 = mysqli_query($conn, $query_2);
								$row = mysqli_fetch_assoc($result_2);

								$studentSec = $row['student_section'];
							?>
							<select name="student_section" class="form-control" id="student-section">
								<option value="">Select Section</option>
								<option value="A" <?php echo $studentSec == "A"? "selected" : ""; ?>>A</option>
								<option value="B" <?php echo $studentSec == "B"? "selected" : ""; ?>>B</option>
								<option value="C" <?php echo $studentSec == "C"? "selected" : ""; ?>>C</option>
								<option value="D" <?php echo $studentSec == "D"? "selected" : ""; ?>>D</option>
								<option value="E" <?php echo $studentSec == "E"? "selected" : ""; ?>>E</option>
								<option value="F" <?php echo $studentSec == "F"? "selected" : ""; ?>>F</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Groups</label>
							<?php
								$s_id = $_GET['s_id'];
								$query_3 = "SELECT student_group FROM students WHERE id=$s_id";
								$result_3 = mysqli_query($conn, $query_3);
								$row = mysqli_fetch_assoc($result_3);

								$studentGrp = $row['student_group'];
							?>
							<select name="student_group" class="form-control" id="student-group">
								<option value="">Select Group</option>
								<option value="Science" <?php echo $studentGrp == "Science"? "selected" : ""; ?>>Science</option>
								<option value="Humanities" <?php echo $studentGrp == "Humanities"? "selected" : ""; ?>>Humanities</option>
								<option value="Commerce" <?php echo $studentGrp == "Commerce"? "selected" : ""; ?>>Commerce</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Roll</label>
							<input type="text" name="student_roll" class="form-control" value="<?php echo $students_data['student_roll']; ?>">
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Date of Birth</label>
							<input type="text" name="student_dob" class="form-control custom-date" value="<?php echo $students_data['student_dob']; ?>">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Blood Group</label>
							<?php
								$s_id = $_GET['s_id'];
								$query_4 = "SELECT student_blood_group FROM students WHERE id=$s_id";
								$result_4 = mysqli_query($conn, $query_4);
								$row = mysqli_fetch_assoc($result_4);

								$studentBloodGrp = $row['student_blood_group'];
							?>
							<select name="student_blood_group" class="form-control" id="blood-group">
								<option value="">Select One</option>
								<option value="AB+" <?php echo $studentBloodGrp == "AB+"? "selected" : ""; ?>>AB+</option>
								<option value="A+" <?php echo $studentBloodGrp == "A+"? "selected" : ""; ?>>A+</option>
								<option value="B+" <?php echo $studentBloodGrp == "B+"? "selected" : ""; ?>>B+</option>
								<option value="O+" <?php echo $studentBloodGrp == "O+"? "selected" : ""; ?>>O+</option>
								<option value="AB-" <?php echo $studentBloodGrp == "AB-"? "selected" : ""; ?>>AB-</option>
								<option value="A-" <?php echo $studentBloodGrp == "A-"? "selected" : ""; ?>>A-</option>
								<option value="B-" <?php echo $studentBloodGrp == "B-"? "selected" : ""; ?>>B-</option>
								<option value="O-" <?php echo $studentBloodGrp == "O-"? "selected" : ""; ?>>O-</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Gender</label>
							<?php
								$s_id = $_GET['s_id'];
								$query_5 = "SELECT student_gender FROM students WHERE id=$s_id";
								$result_5 = mysqli_query($conn, $query_5);
								$row = mysqli_fetch_assoc($result_5);

								$studentGender = $row['student_gender'];
							?>
							<select name="student_gender" class="form-control" id="student-gender">
								<option value="">Select One</option>
								<option value="Male" <?php echo $studentGender == "Male"? "selected" : ""; ?>>Male</option>
								<option value="Female" <?php echo $studentGender == "Female"? "selected" : ""; ?>>Female</option>
								<option value="Other" <?php echo $studentGender == "Other"? "selected" : ""; ?>>Other</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Student Status</label>
							<?php
								$s_id = $_GET['s_id'];
								$query_5 = "SELECT student_status FROM students WHERE id=$s_id";
								$result_5 = mysqli_query($conn, $query_5);
								$row = mysqli_fetch_assoc($result_5);

								$studentSts = $row['student_status'];
							?>
							<select name="student_status" class="form-control" id="">
								<option value="">Select One</option>
								<option value="active" <?php echo $studentSts == "active"? "selected" : ""; ?>>Active</option>
								<option value="inactive" <?php echo $studentSts == "inactive"? "selected" : ""; ?>>Inactive</option>
								<option value="completed" <?php echo $studentSts == "completed"? "selected" : ""; ?>>Completed</option>
								<option value="failed" <?php echo $studentSts == "failed"? "selected" : ""; ?>>Failed</option>
							</select>
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Father's Name</label>
							<input type="text" name="student_father_name" class="form-control" value="<?php echo $students_data['student_father_name']; ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Mother's Name</label>
							<input type="text" name="student_mother_name" class="form-control" value="<?php echo $students_data['student_mother_name']; ?>">
						</div>
					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Address</label>
							<textarea id="summernote" name="student_address" class="form-control"><?php echo $students_data['student_address']; ?></textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Parents Contact</label>
							<input type="text" name="student_contact" class="form-control" value="<?php echo $students_data['student_contact']; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input type="submit" Value="Update Student" class="btn btn-info" name="update_student_btn">
						</div>
					</div>
				</form>
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
  })
</script>
</body>
</html>
