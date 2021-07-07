<?php 

require_once "includes/header.php"; 

	$username = $_SESSION['username'];

	$select_student = "SELECT * FROM students WHERE student_email='$username' AND student_status='active'";
	$student_result = mysqli_query($conn, $select_student);

	if(mysqli_num_rows($student_result) <= 0) {
		header("Location: index.php");
	}

	$select_student = "SELECT * FROM students WHERE student_email='$username' AND student_status='active'";
	$student_result = mysqli_query($conn, $select_student);

	if(mysqli_num_rows($student_result) <= 0) {
		header("Location: index.php");
	}

	$student = mysqli_fetch_assoc($student_result);

	$student_email = $student['student_email'];
	$student_name = $student['student_name'];
	$student_class = $student['student_class'];
	$student_section = $student['student_section'];
	$student_group = $student['student_group'];
	$student_roll = $student['student_roll'];

	$select_global_name_id = "SELECT * FROM sections WHERE class_id=$student_class AND section='$student_section' AND group_name='$student_group'";

	$global_name_id_res = mysqli_query($conn, $select_global_name_id);

	if(!$global_name_id_res)die(mysqli_error($conn));

	$row = mysqli_fetch_assoc($global_name_id_res);

	$global_name_id = $row['id'];
	$teacher='';
	$query_t = "SELECT * from class_teacher where global_name_id=$global_name_id";
					$result_t = mysqli_query($conn, $query_t);
					if(!$result_t) {
						die(mysqli_error($conn));
					}
					while ($data_t = mysqli_fetch_assoc($result_t)) {
						$teacher = $data_t['teacher_email'];
						
					}
	global $conn;
	if(isset($_POST['message_submit'])) {
		$notice_title = clean_data($_POST['subject']);
		$notice_desc = clean_data($_POST['message']);

		if(!empty($notice_title) && !empty($notice_desc)) {
			$query = "INSERT INTO parent_message (notice_title, notice_desc, notice_date,stid,tid) VALUES ('$notice_title', '$notice_desc', now(),'$username','$teacher')";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: submitIssue.php?action=add_new&message=success");
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
            <h1>Message</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Message</li>
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
					  Message was sent successfully.
					</div>";
		}
		?>
      <div class="row">
        <div class="col-md-12">
		<form action="" method="post">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Contact Teacher
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
				<div class="form-group">
                  <label for="exampleInputBorder">Message Title</label>
                  <input type="text" name="subject" class="form-control form-control-border" id="exampleInputBorder" placeholder="Title">
                </div>
				
				<div class="form-group">
					<textarea id="summernote" name="message" class="form-control">
						Message content
					</textarea>
				</div>
            </div>
            <div class="card-footer">
				<div class="form-group">
				  <button type="submit" name="message_submit" class="btn btn-primary">Submit</button>
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
    $('#summernote').summernote()

  })
</script>
</body>
</html>
