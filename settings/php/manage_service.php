<?php
include('../../php/config.php');
session_start();
$id = $_SESSION['id'];

if (isset($_GET['service'])) {
  $status = $_GET['action'];
  $id_ = $_GET['service'];

  mysqli_query($conn, "UPDATE service SET status = '$status' WHERE id = $id_");
}

if (isset($_POST['save'])) {
  $id_ = $_POST['service_id'];
  $name = $_POST['name'];
  $repeat = $_POST['repeat'];
  $event_date = $_POST['event_date'];
  $repeat_day = $_POST['repeat_day'];

  if ($id_ == 0) {
    mysqli_query($conn, "INSERT INTO service (name, repetition, start_date, repeat_day) VALUES ('$name', '$repeat', '$event_date', '$repeat_day')");
  } else {
    mysqli_query($conn, "UPDATE service SET name = '$name', repetition = '$repeat', start_date = '$event_date', repeat_day = '$repeat_day' WHERE id = $id_");
  }
}

$service_query = mysqli_query($conn, "SELECT * FROM service ORDER BY status, id");

?>
<div class="card-header">
  <h5 class="text-titlecase"> Services </h5>
</div>
<div class="table-responsive pt-1">
  <table class="table table-striped project-orders-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Event date</th>
        <th>Repeat</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (mysqli_num_rows($service_query) > 0) {
        while ($service = mysqli_fetch_array($service_query)) {
          $status = $service['status'];
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
          if ($service['repetition'] == 'daily') {
            $s_date = date('Y-m-d');
            $check_date = mysqli_query($conn, "SELECT * FROM service");
          } elseif ($service['repetition'] == 'weekly') {
            $s_date = $service['repeat_day'].'s';
          } elseif ($service['repetition'] == 'no-repeat') {
            $s_date = $service['start_date'];
            // $status_c = 'success';
            // $status = "done";
          } else {
            $s_date = $service['repetition'];
          }
          ?>
          <tr>
            <td class="text-secondary font-weight-bold"><?php echo $service['name'] ?></td>
            <td><?php echo $s_date ?></td>
            <td><?php echo $service['repetition'] ?></td>
            <td>
              <div class="text-<?php echo $status_c ?> font-weight-bold">
                <?php echo $status ?>
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                <button id="new_service.php?service=<?php echo $service['id'] ?>" type="button" class="btn btn-sm btn-primary btn-icon-text mr-2" onclick="editPage(this.id)">                    
                  <i class="typcn typcn-edit text-light btn-icon-prepend"></i> Edit
                </button>
                <button id="manage_service.php?service=<?php echo $service['id'].'&action='.$action ?>" type="button" class="btn btn-sm btn-inverse-<?php echo $btn_c ?> btn-icon-text" onclick="editPage(this.id)">                    
                  <i class="typcn typcn-times text-light btn-icon-prepend"></i> <?php echo $btn_text ?>
                </button>
              </td>
            </tr>
        <?php }
      } else { ?>
            <tr>
              <td colspan="6" class="text-center py-2">No Service is created yet!</td>
            </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

