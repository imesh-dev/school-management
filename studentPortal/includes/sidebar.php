<?php

require_once "includes/header.php"; 
$session_user = clean_data($_SESSION['username']);
?>
<!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Student Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        </div>
        <div class="info">
		<?php 
						$query = "SELECT * from students where student_email='$session_user'";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)) {
							$user_firstname = $row['student_name'];
						}
							?>
          <a href="#" class="d-block"><?php echo $user_firstname; ?></a>
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
            <a href="results.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                View Results
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="libraryBooks.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Library Books
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="allNotices.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                View Notices
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->