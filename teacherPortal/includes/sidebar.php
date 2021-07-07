<?php

require_once "includes/header.php"; 
$session_user = clean_data($_SESSION['username']);
?>
<!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Teacher Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
		<?php 
						$query = "SELECT * from teachers where teacher_email='$session_user'";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)) {
							$teacher_image = $row['teacher_image'];
						}
							?>
          <img src="../assets/images/teacher-images/<?php echo $teacher_image; ?>" class=" elevation-2" alt="User Image">
        </div>
        <div class="info">
		<?php 
						$query = "SELECT * from user where username='$session_user'";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)) {
							$user_firstname = $row['user_firstname'];
							$user_lastname = $row['user_lastname'];
						}
							?>
          <a href="#" class="d-block"><?php echo $user_firstname.' '.$user_lastname; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="classes.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Classes
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="updateAttendance.php" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                view/Update Attendence
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Student Results
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="addResults.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Results</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="viewResults.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>view/Update Results</p>
                </a>
              </li>
            </ul>
          </li>
		  		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Parent Messages
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="allMessages.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
				  <?php 
				  $username = $_SESSION['username'];
						$query = "SELECT * FROM parent_message where tid='$username' and reply =''";
						$result = mysqli_query($conn, $query);
						$num1 = mysqli_num_rows($result);

					?>
                  <p>View All Messages</p><span class="right badge badge-danger"><?php echo $num1; ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="classes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Send message to Parent</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->