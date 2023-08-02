<?php
include('../../php/config.php');
session_start();
$id = $_SESSION['id'];

if (isset($_GET['user'])) {
  $status = $_GET['action'];
  $id_ = $_GET['user'];

  mysqli_query($conn, "UPDATE user SET status = '$status' WHERE id = $id_");
}

if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  $password = $_POST['password'];

  mysqli_query($conn, "INSERT INTO user (name, phone, email, role, password, created_by) VALUES ('$name', '$phone', '$email', '$role', '$password', $id)");
}

$user_query = mysqli_query($conn, "SELECT * FROM user WHERE id != '$id' ORDER BY id");
?>
<div class="card-header">
  <h5 class="text-titlecase"> Users </h5>
</div>
<div class="table-responsive pt-1">
  <table class="table table-striped project-orders-table">
    <thead>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (mysqli_num_rows($user_query) > 0) {
        while ($user = mysqli_fetch_array($user_query)) {
          $status = $user['status'];
          $status_c = 'success';
          $btn_c = 'danger';
          $btn_text = 'Deactivate';
          $action = 'inactive';
          if ($status != 'active') {
            $status_c = 'danger';
            $btn_c = 'success';
            $btn_text = 'Activate';
            $action = 'active';
          }
          ?>
            <tr>
              <td>
                <img src="../assets/images/admins/<?php echo $user['picture'] ?>" alt="image" />
              </td>
              <td><?php echo $user['name'] ?></td>
              <td><?php echo $user['email'] ?></td>
              <td><?php echo $user['role'] ?></td>
              <td>
                <div class="text-<?php echo $status_c ?> font-weight-bold">
                  <?php echo $status ?>
                </div>
              </td>
              <td>
                <?php if ($user['role'] != 'admin'): ?>
                    <button id="manage_user.php?user=<?php echo $user['id'] . '&action=' . $action ?>" type="button" class="btn btn-sm btn-inverse-<?php echo $btn_c ?> btn-icon-text" onclick="editPage(this.id)">                    
                      <i class="typcn typcn-times text-light btn-icon-prepend"></i> <?php echo $btn_text ?>
                    </button>
                <?php endif; ?>
              </td>
            </tr>
            <?php }
        } else { ?>
              <tr>
                <td colspan="6" class="text-center py-2">No other User is registered yet!</td>
              </tr>
        <?php } ?>
    </tbody>
  </table>
</div>