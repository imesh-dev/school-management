<?php 

require_once "includes/header.php"; 

	$username = $_SESSION['username'];

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
            <h1>Results</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Results</li>
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
                <h3 class="card-title">View Student Results</h3>
              </div>
              <!-- /.card-header -->
			  <div class="row">
				  <div class="col-4 ml-5">
				  <form action="" method="post">
					   <div class="form-group">
						  <label for="exampleSelectBorder">Select Class</label>
						  <select class="custom-select form-control-border" name='class' id="exampleSelectBorder">
							<option value='6'>Class 6</option>
							<option value='7'>Class 7</option>
							<option value='8'>Class 8</option>
							<option value='9'>Class 9</option>
							<option value='10'>Class 10</option>
							<option value='11'>Class 11</option>
						  </select>
						</div>
					</div>
					<div class="col-4">
						 <div class="form-group">
						  <label for="exampleSelectBorder">Select Term</label>
						  <select class="custom-select form-control-border" name='term' id="exampleSelectBorder">
							<option value='mid'>Mid Term</option>
							<option value='final'>Final Term</option>
						  </select>
						</div>
					</div>
					<div class="col-2">
					<div class="form-group mt-4">
						<button type="submit" name="results_submit" class="btn btn-primary">View</button>
						</div>
					</div>
					</form>
				</div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Subject</th>
					<th>Marks</th>
					<th>Grade</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
				  		if(isset($_POST['results_submit'])) {
		$term = clean_data($_POST['term']);
		$class = clean_data($_POST['class']);

		if(!empty($term) && !empty($class)) {
			$query = "SELECT results.marks,results.grade,subjects.subject from results join subjects on results.subject_id = subjects.id where results.student_id='$username' and results.student_class=$class and results.exam_type='$term'  ";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						die(mysqli_error($conn));
					}

					while ($data = mysqli_fetch_assoc($result)) {
						$marks = $data['marks'];
						$grade = $data['grade'];
						$subject = $data['subject'];

						echo "<tr>";
						echo "<td>$subject</td>";
						echo "<td>$marks</td>";
						echo "<td>$grade</td>";
						echo "</tr>";
					}
	}
						}
					
				?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Subject</th>
					<th>Marks</th>
					<th>Grade</th>
                  </tr>
                  </tfoot>
                </table>
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
