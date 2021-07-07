<?php 

require_once "includes/header.php"; 

	$username = $_SESSION['username'];
	global $conn;
	$get_the_id = '';
	if(isset($_GET['action']) && $_GET['action'] == "message") {
		$get_the_id = $_GET['id'];
	}
	
	if(isset($_POST['message_submit'])) {
		$notice_title = clean_data($_POST['subject']);
		$notice_desc = clean_data($_POST['message']);

		if(!empty($notice_title) && !empty($notice_desc)) {
			$query = "INSERT INTO parent_message (notice_title, reply, notice_date,stid,tid) VALUES ('$notice_title', '$notice_desc', now(),'$get_the_id','$username')";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: contactParent.php?action=add_new&message=success");
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
            <h1>Contact Parent</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Contact Parent</li>
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
                Send message to a Parent
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
