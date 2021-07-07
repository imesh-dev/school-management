<?php

require_once "includes/header.php"; 
$session_user = clean_data($_SESSION['username']);
?>
<!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
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
          <a href="index.php" class="d-block"><?php echo $user_firstname.' '.$user_lastname; ?></a>
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
            <a href="classtimetable.php" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Class time table
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="subjects.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Subjects
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Class Teachers 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
			<ul class="nav nav-treeview">
				<li class='nav-item'>
                <a href='classTeachers.php' class='nav-link'>
                  <i class='far fa-circle nav-icon'></i>
                  <p>Class teachers</p>
                </a>
              </li>
			  <li class='nav-item'>
                <a href='assignTeacher.php' class='nav-link'>
                  <i class='far fa-circle nav-icon'></i>
                  <p>Assign a teacher</p>
                </a>
              </li>
            </ul>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                All Teachers 
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
			<ul class="nav nav-treeview">
				<li class='nav-item'>
                <a href='viewAllTeachers.php' class='nav-link'>
                  <i class='far fa-circle nav-icon'></i>
                  <p>All teachers</p>
                </a>
              </li>
			  <li class='nav-item'>
                <a href='addNewTeacher.php' class='nav-link'>
                  <i class='far fa-circle nav-icon'></i>
                  <p>Add new teacher</p>
                </a>
              </li>
            </ul>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Students
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
			<ul class="nav nav-treeview">
				<li class='nav-item'>
                <a href='viewAllStudents.php' class='nav-link'>
                  <i class='far fa-circle nav-icon'></i>
                  <p>All Students</p>
                </a>
              </li>
			  <li class='nav-item'>
                <a href='addNewStudent.php' class='nav-link'>
                  <i class='far fa-circle nav-icon'></i>
                  <p>Add new Student</p>
                </a>
              </li>
            </ul>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Notice Board
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
			<ul class="nav nav-treeview">
				<li class='nav-item'>
                <a href='allNotices.php' class='nav-link'>
                  <i class='far fa-circle nav-icon'></i>
                  <p>View All notices</p>
                </a>
              </li>
			  <li class='nav-item'>
                <a href='addNewNotice.php' class='nav-link'>
                  <i class='far fa-circle nav-icon'></i>
                  <p>Add new Notice</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->