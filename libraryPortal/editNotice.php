<?php 

require_once "includes/header.php"; 

function showNoticeData() {
	$notice = [];
	global $conn;
	if(isset($_GET['action']) && $_GET['action'] == "edit_notice") {
		$get_the_id = $_GET['n_id'];
		$query = "SELECT * FROM notice WHERE id=$get_the_id";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$notice['notice_title'] = $row['notice_title'];
			$notice['notice_desc'] = $row['notice_desc'];
		}
	}
	return $notice;
}

function update_notice() {
	global $conn;
	$get_the_id = $_GET['n_id'];
	if(isset($_POST['update_notice_btn'])) {
		$notice_title = clean_data($_POST['notice_title']);
		$notice_desc = clean_data($_POST['notice_desc']);

		if(!empty($notice_title) && !empty($notice_desc)) {
			$query = "UPDATE notice SET notice_title='$notice_title', notice_desc='$notice_desc', notice_date=now() WHERE id=$get_the_id";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: editNotice.php?action=edit_notice&n_id=$get_the_id&message=success");
			}

		}
	}
}


$notice_data = showNoticeData();
	update_notice();
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
					  Notice was updated successfully.
					</div>";
		}
		?>
      <div class="row">
        <div class="col-md-12">
		<form action="" method="post" >
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Summernote
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
				<div class="row">
				<div class = "col-10">
					<div class="form-group">
					  <label for="exampleInputBorder">Notiece Title</label>
					  <input type="text" name="notice_title" class="form-control form-control-border" value="<?php echo $notice_data['notice_title']; ?>">
					</div>
				</div>
				<div class = "col-11">				
				<div class="form-group">
				<label for="exampleInputBorder">Notice Description</label>
					<textarea id="summernote" name="notice_desc" class="form-control">
						<?php echo $notice_data['notice_desc']; ?>
					</textarea>
				</div>
				</div>
            </div>
            <div class="card-footer">
				<div class="form-group">
				  <button type="submit" name="update_notice_btn" class="btn btn-primary">Update Notice</button>
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
