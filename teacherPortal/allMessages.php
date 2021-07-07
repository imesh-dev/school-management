<?php 

require_once "includes/header.php"; 
$username = $_SESSION['username'];

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
	  	  <?php
		  if(isset($_GET['message']) && $_GET['message'] == "success") {
			echo "<div class='alert alert-success alert-dismissible'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					  <h5><i class='icon fas fa-check'></i> Alert!</h5>
					  Message was sent successfully.
					</div>";
		}
		?>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All messages and replys</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Message Title</th>
					<th>Parent Message</th>
					<th>Student Name</th>
					<th>Class</th>
					<th>Farther's Name</th>
					<th>Message Date</th>
					<th>My message</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php 
						$query = "SELECT parent_message.*,students.* FROM parent_message join students on parent_message.stid=students.student_email where tid='$username'";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$notice_title = $row['notice_title'];
							$notice_desc = $row['notice_desc'];
							$notice_date = $row['notice_date'];
							$student_name = $row['student_name'];
							$student_class = $row['student_class'];
							$student_section = $row['student_section'];
							$student_group = $row['student_group'];
							$student_father_name = $row['student_father_name'];
							$reply = $row['reply'];
							$styles = empty($notice_desc) ? "background-color: yellow;" : (empty($reply) ? "background-color: blue;" : "");
							echo "<tr style='$styles'>";
								echo "<td>$notice_title</td>";
								echo "<td>$notice_desc</td>";
								echo "<td>$student_name</td>";
								echo "<td>$student_class $student_section $student_group</td>";
								echo "<td>$student_father_name</td>";
								echo "<td>$notice_date</td>";
								echo "<td>$reply</td>";
								echo "<td><a class='btn btn-info' href='replyMessage.php?action=reply_message&id=$id'>Reply</a></td>";
							echo "</tr>";
						}

					?>
				</tbody>
                  </tbody>
                  <tfoot>
                  <tr>
					<th>Message Title</th>
					<th>Parent Message</th>
					<th>Student Name</th>
					<th>Class</th>
					<th>Farther's Name</th>
					<th>Message Date</th>
					<th>My Message</th>
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
