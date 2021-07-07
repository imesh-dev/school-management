<?php 

require_once "includes/header.php"; 

	$username = $_SESSION['username'];


	$id = 0;
	if($_GET['action'] && $_GET['action'] == "reply_message"){
		$id = clean_data($_GET['id']);
		if(!empty($notice_title) && !empty($notice_desc)) {
			$query = "SELECT * from parent_message WHERE id=$id";
			$result = mysqli_query($conn, $query);
				while($row = mysqli_fetch_assoc($result)) {
					$id = $row['id'];
				}
		}
	}
			
	global $conn;
	if(isset($_POST['submit_reply_message'])) {
		$reply = clean_data($_POST['reply']);
		$id = clean_data($_POST['id']);
		if(!empty($reply) && !empty($id)) {
			$query = "UPDATE parent_message SET reply='$reply' WHERE id=$id";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: allMessages.php?message=success");
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
            <h1>Messages</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Messages</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
		<form action="" method="post">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Reply Message
              </h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
				 <input type="hidden" name="id"  value="<?php echo $id; ?>">
				<div class="form-group">
					<textarea id="summernote" name="reply" class="form-control">
						Message content
					</textarea>
				</div>
            </div>
            <div class="card-footer">
				<div class="form-group">
				  <button type="submit" name="submit_reply_message" class="btn btn-primary">Submit</button>
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
