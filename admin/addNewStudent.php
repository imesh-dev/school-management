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

function register_student() {
	global $conn;
	$error = "";
	if(isset($_POST['add_student_btn'])) {
		$first_name 			= clean_data($_POST['user_firstname']);
		$last_name 				= clean_data($_POST['user_lastname']);
		$student_email 			= clean_data($_POST['username']);
		$password 				= clean_data($_POST['user_password']);
		$student_class		 	= clean_data($_POST['student_class']);
		$student_section	 	= clean_data($_POST['student_section']);
		$student_group		 	= clean_data($_POST['student_group']);
		$student_roll	 		= clean_data($_POST['student_roll']);
		$student_father_name 	= clean_data($_POST['student_father_name']);
		$student_mother_name 	= clean_data($_POST['student_mother_name']);
		$student_address	 	= clean_data($_POST['student_address']);
		$student_contact	 	= clean_data($_POST['student_contact']);
		$student_dob		 	= clean_data($_POST['student_dob']);
		$student_blood_group	= clean_data($_POST['student_blood_group']);
		$student_gender			= clean_data($_POST['student_gender']);
		$student_status			= clean_data($_POST['student_status']);
		$student_name 			= $first_name. " ". $last_name;

		if(!empty($first_name) && !empty($last_name) && !empty($student_email) && !empty($password) && !empty($student_class) && !empty($student_roll) && !empty($student_address) && !empty($student_contact)) {
			if(is_user_unique($student_email)) {
				$query = "INSERT INTO user(username, user_password, user_role, user_firstname, user_lastname) VALUES('$student_email', '$password', 'student', '$first_name', '$last_name')";
				$result = mysqli_query($conn, $query);

				$query_2 = "INSERT INTO students(student_email, student_name, student_class, student_section, student_group, student_roll, student_father_name, student_mother_name, student_address, student_contact, student_dob, student_blood_group, student_gender, student_status) VALUES('$student_email', '$student_name', '$student_class', '$student_section', '$student_group', '$student_roll', '$student_father_name', '$student_mother_name', '$student_address', '$student_contact', '$student_dob', '$student_blood_group', '$student_gender', '$student_status')";
				$result_2 = mysqli_query($conn, $query_2);
				if(!$result_2) {
					die(mysqli_error($conn));
				}

				header("Location: addNewStudent.php?action=add_new&message=success");
			} else {
				$error = "This email already exists. Email must be unique.";
			}
		} else {
			$error = "Fields can't be empty.";
		}
	}
	return $error;
}

$error = register_student();
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
					  Student data added successfully.
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
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="" method="post">
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">First Name</label>
							<input type="text" name="user_firstname" class="form-control" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Last Name</label>
							<input type="text" name="user_lastname" class="form-control">
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Class</label>
							<select name="student_class" class="form-control" id="student-class">
								<option value="">Select Class</option>
								<?php
									$query = "SELECT * FROM class";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_assoc($result)) {
										$class_id = $row['id'];
										$class = $row['class'];
										echo "<option value='{$class}'>{$class}</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Section</label>
							<select name="student_section" class="form-control" id="student-section">
								<option value="">Select Section</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Groups</label>
							<select name="student_group" class="form-control" id="student-group" readonly>
								<option value="">Select Group</option>
								<option value="Science">Science</option>
								<option value="Humanities">Humanities</option>
								<option value="Commerce">Commerce</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Admission Year</label>
							<select name="admission_year" id="admission_year" class="form-control">
								<option value="">Select One</option>
							<?php
								$year = date("Y");
								$count = $year + 7;
								for($i=$year; $i<$count; $i++) {
									echo "<option value='$i'>$i</option>";
								}
							?>
							</select>
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Username</label>
							<input type="email" name="username" class="form-control" id="student-username"  readonly>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Password</label>
							<input type="text" name="user_password" class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Roll</label>
							<input type="text" name="student_roll" class="form-control" id="student-roll" readonly>
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Date of Birth</label>
							<input type="text" name="student_dob" class="form-control custom-date" >
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Blood Group</label>
							<select name="student_blood_group" class="form-control" id="blood-group">
								<option value="">Select One</option>
								<option value="AB+">AB+</option>
								<option value="A+">A+</option>
								<option value="B+">B+</option>
								<option value="O+">O+</option>
								<option value="AB-">AB-</option>
								<option value="A-">A-</option>
								<option value="B-">B-</option>
								<option value="O-">O-</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Gender</label>
							<select name="student_gender" class="form-control" id="student-gender">
								<option value="">Select One</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Student Status</label>
							<select name="student_status" class="form-control" id="">
								<option value="active">Active</option>
								<option value="inactive">Inactive</option>
								<option value="completed">Completed</option>
								<option value="failed">Failed</option>
							</select>
						</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Father's Name</label>
							<input type="text" name="student_father_name" class="form-control" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Mother's Name</label>
							<input type="text" name="student_mother_name" class="form-control" >
						</div>
					</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Address</label>
							<textarea id="summernote" name="student_address" class="form-control"></textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Parents Contact</label>
							<input type="text" name="student_contact" class="form-control">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<input type="submit" Value="Add Student" class="btn btn-info" name="add_student_btn">
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
	//select student group
	$(document).on('change', '#student-class', function() {
		$('#student-group').attr('readonly', 'readonly');
		var student_class = $(this).val();
		if(student_class >= 12) {
			$('#student-group').attr('readonly', false);
		} else {
			$('#student-group').val('');
		}
	});

	//auto student id generator
	$(document).on('change', '#student-class, #student-section, #student-group, #admission_year', function() {
		var std_class_name = $("#student-class").val();
		var std_section = $("#student-section").val();
		var std_group_name = $("#student-group").val();
		var admission_year = $("#admission_year").val();
		console.log("wdwd");
		if(!std_group_name) {
			std_group_name = '';
		}

		switch(std_group_name) {
			case 'Science':
				std_group = '1';
				break;
			case 'Humanities':
				std_group = '2';
				break;
			case 'Commerce':
				std_group = '3';
				break;
			default:
				std_group = '0';
				break;
		}

		switch(std_class_name) {
			case '6':
				std_class = '06';
				break;
			case '7':
				std_class = '07';
				break;
			case '8':
				std_class = '08';
				break;
			case '9':
				std_class = '09';
				break;
			case '10':
				std_class = '10';
				break;
			default:
				std_class = '06';
				break;
		}
		if(std_class && std_section && admission_year) {
			$.ajax({
				url: 'rollNumberGen.php',
				type: 'POST',
				data: {std_class: std_class, std_section: std_section},
				success: function(data) {
					var full_id = admission_year + std_group + std_section + std_class + data + "@school.com";
					console.log(data);
					$("#student-username").attr('value', full_id);
					$("#student-roll").attr('value', parseInt(data));
				}
			});
		}
	});

</script>
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote();
  })
</script>
</body>
</html>
