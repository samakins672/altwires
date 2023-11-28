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
      <a class="nav-link" href="settings">
        <i class="typcn typcn-cog-outline menu-icon"></i>
        <span class="menu-title">Settings</span>
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