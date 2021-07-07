<?php 

require_once "includes/header.php"; 
$session_user = clean_data($_SESSION['username']);
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
            <h1>Dash Board</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Dash Board</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Summary</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
					<div class="row">
					  <div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-info">
						  <div class="inner">
						  <?php

				$query = "SELECT *, class_teacher.is_class_teacher, class_teacher.subject_name_id as subject_id FROM sections INNER JOIN class_teacher ON sections.id=class_teacher.global_name_id AND class_teacher.teacher_email='$session_user'";
				$result_class = mysqli_query($conn, $query);
				$num_class = mysqli_num_rows($result_class);
				?>
							<h3><?php echo $num_class ; ?></h3>
							<p>Number Of classes</p>
							  </div>
							  <div class="icon">
								<i class="ion ion-bag"></i>
							  </div>
							  <a href="classes.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						  </div>
						  <!-- ./col -->
						  <div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-success">
							  <div class="inner">
							  <?php 
						$query = "SELECT parent_message.* FROM parent_message where tid='$session_user' and reply=''";
						$result_message = mysqli_query($conn, $query);
						$num_message = mysqli_num_rows($result_message);
						?>
								<h3><?php echo $num_message ; ?></h3>

								<p>Messages from parents</p>
							  </div>
							  <div class="icon">
								<i class="ion ion-stats-bars"></i>
							  </div>
							  <a href="allMessages.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						  </div>
						  <!-- ./col -->
						  <div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-warning">
							  <div class="inner">
							  <?php 
						$query = "SELECT * FROM results where teacher_email='$session_user' and exam_type='mid'";
						$result_mid = mysqli_query($conn, $query);
						$num_mid = mysqli_num_rows($result_mid);
						?>
								<h3><?php echo $num_mid ; ?></h3>

								<p>Mid Term results are added</p>
							  </div>
							  <div class="icon">
								<i class="ion ion-person-add"></i>
							  </div>
							  <a href="viewResults.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						  </div>
						  <!-- ./col -->
						  <div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-danger">
							  <div class="inner">
							  <?php 
						$query = "SELECT * FROM results where teacher_email='$session_user' and exam_type='final'";
						$result_end = mysqli_query($conn, $query);
						$num_end = mysqli_num_rows($result_end);
						?>
								<h3><?php echo $num_end ; ?></h3>

								<p>Final Term results are added</p>
							  </div>
							  <div class="icon">
								<i class="ion ion-pie-graph"></i>
							  </div>
							  <a href="viewResults.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						  </div>
						  <!-- ./col -->
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
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
