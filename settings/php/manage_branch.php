<?php
include('../../php/config.php');
session_start();
$id = $_SESSION['id'];

if (isset($_GET['branch'])) {
  $status = $_GET['action'];
  $id_ = $_GET['branch'];

  mysqli_query($conn, "UPDATE branch SET status = '$status' WHERE id = $id_");
}

if (isset($_POST['save'])) {
  $id_ = $_POST['branch_id'];
  $name = $_POST['name'];

  if ($id_ == 0) {
    mysqli_query($conn, "INSERT INTO branch (name) VALUES ('$name')");
  } else {
    mysqli_query($conn, "UPDATE branch SET name = '$name' WHERE id = $id_");
  }
}

$branch_query = mysqli_query($conn, "SELECT * FROM branch ORDER BY status, id");

?>
<div class="card-header">
  <h5 class="text-titlecase"> branchs </h5>
</div>
<div class="table-responsive pt-1">
  <table class="table table-striped project-orders-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (mysqli_num_rows($branch_query) > 0) {
        while ($branch = mysqli_fetch_array($branch_query)) {
          $status = $branch['status'];
          $status_c = 'success';
          $btn_c = 'danger';
          $btn_text = 'Close';
          $action = 'inactive';
          if ($status != 'active') {
            $status_c = 'danger';
            $btn_c = 'success';
            $btn_text = 'Open';
            $action = 'active';
          }
          ?>
          <tr>
            <td class="text-secondary font-weight-bold"><?php echo $branch['name'] ?></td>
            <td>
              <div class="text-<?php echo $status_c ?> font-weight-bold">
                <?php echo $status ?>
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <button id="new_branch.php?branch=<?php echo $branch['id'] ?>" type="button" class="btn btn-sm btn-primary btn-icon-text mr-2" onclick="editPage(this.id)">                    
                  <i class="typcn typcn-edit text-light btn-icon-prepend"></i> Edit
                </button>
                <button id="manage_branch.php?branch=<?php echo $branch['id'].'&action='.$action ?>" type="button" class="btn btn-sm btn-inverse-<?php echo $btn_c ?> btn-icon-text" onclick="editPage(this.id)">                    
                  <i class="typcn typcn-times text-light btn-icon-prepend"></i> <?php echo $btn_text ?>
                </button>
              </td>
            </tr>
        <?php }
      } else { ?>
            <tr>
              <td colspan="6" class="text-center py-2">No branch is created yet!</td>
            </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

