<?php
$services_query = mysqli_query($conn, "SELECT * FROM service WHERE status = 'active' ORDER BY id");
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item <?php echo $sidebar?>">
      <a class="nav-link" href="index.php">
        <i class="typcn typcn-device-desktop menu-icon"></i>
        <span class="menu-title">Dashboard</span>
        <div class="badge badge-danger">new</div>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#attd-menu" aria-expanded="false" aria-controls="attd-menu">
        <i class="typcn typcn-th-list-outline menu-icon"></i>
        <span class="menu-title">Attendance</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="attd-menu">
        <ul class="nav flex-column sub-menu">
          <?php
          while ($services = mysqli_fetch_array($services_query)) {
            if ($services['id'] == 1) {
              $link = 'sun_sch_attd.php';
            }else {
              $link = "service_attd.php?type=".$services['id'];
            }
          ?>
          <li class="nav-item"> <a class="nav-link" href="<?php echo $link ?>"><?php echo $services['name'] ?></a></li>
          <?php }?>
          <li class="nav-item"> <a class="nav-link text-secondary" href="absentees.php">Absentees</a></li>
        </ul>
      </div>
    </li>
    </li>
    <li class="nav-item">  
      <a class="nav-link" href="record_blessing.php">
        <i class="typcn typcn-edit menu-icon"></i>
        <span class="menu-title">Record Of Blessing</span>
    </a>
    <li class="nav-item <?php echo $sidebar?>">
      <a class="nav-link" data-toggle="collapse" href="#report-menu" aria-expanded="false" aria-controls="attd-menu">
        <i class="typcn typcn-chart-pie-outline menu-icon"></i>
        <span class="menu-title">Reports</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="report-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="attd_report.php">Attendance</a></li>
          <li class="nav-item"> <a class="nav-link" href="blessing_report.php">Blessings</a></li>
          <li class="nav-item"> <a class="nav-link text-secondary" href="abs_report.php">Absentees</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item <?php echo $sidebar?>">    
      <a class="nav-link" href="brethren.php">
        <i class="typcn typcn-group-outline menu-icon"></i>
        <span class="menu-title">Members</span>
      </a>
    </li>
    <li class="nav-item">  
      <a class="nav-link" href="new_member.php">
        <i class="typcn typcn-user-add-outline menu-icon"></i>
        <span class="menu-title">New Member</span>
    </a>
    </li>
    <li class="nav-item">    
      <a class="nav-link text-danger" href="login.php?logout">
        <i class="typcn typcn-eject menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
  </ul>
</nav>