<?php 

require_once "includes/header.php"; 
$username = clean_data($_SESSION['username']);

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
	
	
	$id = $_SESSION['id'];
	$select_student = "SELECT user.id,students.id as sid,user.username from user left join students on user.username=students.student_email WHERE user.id='$id'";
	$student_result = mysqli_query($conn, $select_student);
	$student = mysqli_fetch_assoc($student_result);
	$sid = $student['sid'];

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

				$query = "SELECT class_teacher.teacher_email, class_teacher.class_days, class_teacher.class_time, subjects.subject FROM class_teacher INNER JOIN subjects ON class_teacher.subject_name_id=subjects.id WHERE class_teacher.global_name_id=$global_name_id";
				$sub_res = mysqli_query($conn, $query);
				$num_sub = mysqli_num_rows($sub_res);
				?>
							<h3><?php echo $num_sub ; ?></h3>
							<p>Number Of classes</p>
							  </div>
							  <div class="icon">
								<i class="ion ion-bag"></i>
							  </div>
							  <a href="classtimetable.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						  </div>
						  <!-- ./col -->
						  <div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-success">
							  <div class="inner">
							  <?php 
						$query = "SELECT book_lend.borrower_name, book_lend.in_date,book_lend.book_name,books.author,books.isbn from book_lend left join books on book_lend.book_name=books.book_name where book_lend.book_name=books.book_name && book_lend.borrower_id='$sid'";
						$result_books = mysqli_query($conn, $query);
						$num_books = mysqli_num_rows($result_books);
						?>
								<h3><?php echo $num_books ; ?></h3>

								<p>Books from Library</p>
							  </div>
							  <div class="icon">
								<i class="ion ion-stats-bars"></i>
							  </div>
							  <a href="libraryBooks.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						  </div>
						  <!-- ./col -->
						  <div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-warning">
							  <div class="inner">
							  <?php 
						$query = "SELECT * FROM results where student_id='$username' and exam_type='mid'";
						$result_mid = mysqli_query($conn, $query);
						$num_mid = mysqli_num_rows($result_mid);
						?>
								<h3><?php echo $num_mid ; ?></h3>

								<p>Mid Term results are released</p>
							  </div>
							  <div class="icon">
								<i class="ion ion-person-add"></i>
							  </div>
							  <a href="results.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						  </div>
						  <!-- ./col -->
						  <div class="col-lg-3 col-6">
							<!-- small box -->
							<div class="small-box bg-danger">
							  <div class="inner">
							  <?php 
						$query = "SELECT * FROM results where student_id='$username' and exam_type='final'";
						$result_end = mysqli_query($conn, $query);
						$num_end = mysqli_num_rows($result_end);
						?>
								<h3><?php echo $num_end ; ?></h3>

								<p>Final Term results are released</p>
							  </div>
							  <div class="icon">
								<i class="ion ion-pie-graph"></i>
							  </div>
							  <a href="results.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
