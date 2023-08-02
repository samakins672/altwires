<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a id="profile" class="nav-link" href="../">
        <i class="typcn typcn-device-desktop menu-icon"></i>
        <span class="menu-title">Back to Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a id="profile" class="nav-link" href="javascript:;" onclick="newPage(this.id)">
        <i class="typcn typcn-user menu-icon"></i>
        <span class="menu-title">My Profile</span>
      </a>
    </li>
    <li class="nav-item <?php echo $sidebar?>">
      <a class="nav-link" data-toggle="collapse" href="#services-menu" aria-expanded="false" aria-controls="attd-menu">
        <i class="typcn typcn-th-list-outline menu-icon"></i>
        <span class="menu-title">Services</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="services-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a id="manage_service" class="nav-link" href="javascript:;" onclick="newPage(this.id)">Manage Services</a></li>
          <li class="nav-item"> <a id="new_service" class="nav-link" href="javascript:;" onclick="newPage(this.id)">New services</a></li>
        </ul>
      </div>
    </li>
    </li>
    <li class="nav-item <?php echo $sidebar?>">
      <a class="nav-link" data-toggle="collapse" href="#users-menu" aria-expanded="false" aria-controls="attd-menu">
        <i class="typcn typcn-chart-pie-outline menu-icon"></i>
        <span class="menu-title">Users</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="users-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a id="manage_user" class="nav-link" href="javascript:;" onclick="newPage(this.id)">Manage Users</a></li>
          <li class="nav-item"> <a id="new_user" class="nav-link" href="javascript:;" onclick="newPage(this.id)">New User</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item <?php echo $sidebar ?>">    
      <a id="roles" class="nav-link" href="javascript:;" onclick="newPage(this.id)">
        <i class="typcn typcn-group-outline menu-icon"></i>
        <span class="menu-title">Roles</span>
      </a>
    </li>
    <li class="nav-item">    
      <a class="nav-link text-danger" href="../login.php?logout">
        <i class="typcn typcn-eject menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
  </ul>
</nav>