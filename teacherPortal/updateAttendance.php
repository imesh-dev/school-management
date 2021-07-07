<?php 

require_once "includes/header.php"; 
$session_user = $_SESSION['username'];

function get_subject_name_by_id($id) {
	global $conn;
	$query = "SELECT subject FROM subjects WHERE id=$id";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	return $row['subject'];
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
            <h1>Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Update</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
	  <?php if(!isset($_GET['global_name_id'])) { ?>
		<?php if(isset($_GET['message']) && $_GET['message'] == "updated") { ?>
		<div class='alert alert-success alert-dismissible'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					  <h5><i class='icon fas fa-check'></i> Alert!</h5>
					  Attendance Updated.
					</div>
		<?php } ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update class Attendance</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Class</th>
					<th>Subject</th>
					<th>Class Time</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
					  <?php
						$query = "SELECT sections.global_name, class_teacher.is_class_teacher, class_teacher.class_time, class_teacher.subject_name_id, class_teacher.global_name_id FROM sections INNER JOIN class_teacher ON class_teacher.global_name_id=sections.id WHERE class_teacher.teacher_email='$session_user'";
						$result = mysqli_query($conn, $query);
						if(!$result){
							die(mysqli_error($conn));
						}
						while ($row = mysqli_fetch_assoc($result)) {
							$global_name = $row['global_name'];
							$global_name_id = $row['global_name_id'];
							$class_time = $row['class_time'];
							$subject_name_id = $row['subject_name_id'];
							$is_class_teacher = $row['is_class_teacher'];

							if($is_class_teacher == 'Y') {
								echo "<tr>";
								echo "<td>$global_name</td>";
								echo "<td>". get_subject_name_by_id($subject_name_id) ."</td>";
								echo "<td>$class_time</td>";
								echo "<td><a class='btn btn-info' href='updateAttendance.php?global_name_id=$global_name_id'>See/Update attendance</a></td>";
								echo "</tr>";
							}
						}
					?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Class</th>
					<th>Subject</th>
					<th>Class Time</th>
					<th>Action</th>
                  </tr>
                  </tfoot>
                </table>
				
              </div>
			<!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
			  <?php } else { ?>
			  <?php 
				if(isset($_GET['global_name_id'])) {
					$global_name_id = $_GET['global_name_id'];
					echo "<input id='thisclass' type='hidden' value='$global_name_id' >";
				}
				?>
		  <div class="row">
          <div class="col-12">
		  <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update class Attendance</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="col-md-6 col-md-offset-3">
				<div class="form-group">
			  <label>Date:</label>
                    <input type="date" name="select_date" class="custom-date select_date form-control" placeholder="YYYY/MM/DD" value="" autocomplete="off">
					</div>
					</div>
			  </div>
			  </div>
			  <div class="card">
				<div class="card-body" id="students-info">
				<div id="error-msg"></div>
				</div>
			  </div>
		  </div>
		  </div>
		  <?php } ?>
		</form>
        </div>
        <!-- /.row -->
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- ./wrapper -->

<?php require_once "includes/footer.php"; ?>
<script>
  $(function () {
	  
	  $('#reservationdate').datetimepicker({
        format: 'YYYY/MM/DD'
    });
	
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

<script>
	$(document).ready(function() {

		$('.select_date').on('change', function() {
			$("#error-msg").empty();
			$('#students-info').hide();
			$('.hide-please').hide();
			var attendance_date = $(this).val();
			var attendance_class = $('#thisclass').val();
			$.ajax({
				url: 'updateAttendanceFN.php',
				type: 'POST',
				data: {attendance_date: attendance_date, attendance_class: attendance_class},
				success: function(data) {
					if(data) {
						$('#students-info').show();
						$('#students-info').html(data);
					}
				}		
			});
			
		});

		$(document).on('click', '.student_id', function(){
			var checked = $(this).attr('std_id');

			if($(this).prop('checked') == true) {
				$(this).attr('value', checked);
			} else {
				$(this).attr('value', '');
			}
		});
	});
</script>
</body>
</html>
