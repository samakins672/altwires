<?php
session_start();
include('php/config.php');
include('php/page-config.php');

$last_combine_id = array();
$get_total_combine = 0;
$skip = 0;
$class_query = mysqli_query($conn, "SELECT * FROM class WHERE status = 'active'");

$h_alert = "d-none";
if (isset($_GET['success'])) {
  $alert = "Attendance Has Been Submitted Successfully!";
  $h_alert = 'text-success';
}

if (isset($_GET['combined'])) {
  $alert = "Classes combined Successfully!";
  $h_alert = 'text-success';
}

if (isset($_GET['err'])) {
  $alert = "Attendance submission Unsuccessful, Please try again!";
  $h_alert = 'text-danger';
}

if (isset($_GET['err1'])) {
  $alert = "A class has been combined please choose new classes!";
  $h_alert = 'text-danger';
}

if (isset($_GET['err2'])) {
  $alert = "Please choose 2 or more classes to combine!";
  $h_alert = 'text-danger';
}

if (isset($_GET['date'])) {
  $date = strtotime($_GET['date']);
  $date = date('Y-m-d', $date);
} else {
  if ($short_day !== 'Sun') {
    $date = date('Y-m-d', strtotime("last Sunday"));
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- partial:partials/_head.php -->
<?php include('partials/_head.php') ?>
<!-- partial -->

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.php -->
    <?php include('partials/_navbar.php') ?>
    <!-- partial --><br><br><br>
    <nav class="bg-gradient-primary col-xl-12 col-12 d-flex flex-row p-3 text-light">
        <div class="col-sm-8 d-flex align-items-center align-items-baseline my-auto">
          <h6 class="mb-0">Youth Db</h6>
          <i class="typcn typcn-chevron-right"></i>
          <p class="mb-0">Sunday School</p>
          <i class="typcn typcn-chevron-right"></i>
          <p class="mb-0"><?php echo $date ?></p>
        </div>
        <div class="input-group col-sm-4">
          <input type="text" class="form-control form-control-sm" placeholder="Search..." aria-label="search"
            aria-describedby="search">
        </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.php -->
      <?php include('partials/_settings-panel.php') ?>
      <!-- partial -->
      <!-- partial:partials/_sidebar.php -->
      <?php include('partials/_sidebar.php') ?>
      <!-- partial -->
      <div class="main-panel">
        <h4 class="font-weight-bold <?php echo $h_alert ?>" style="text-align: center;">
          <?php echo $alert ?>
        </h4>
        <div class="content-wrapper">

          <div class="row">
            <div class="col-sm-12 mx-auto">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <form action="" method="get" class="col-sm-5 row">
                      <div class="col-6 p-0">
                        <div class="form-group mb-1">
                          <input type="date" class="form-control form-control-sm" name="date" value="<?php echo $date ?>">
                        </div>
                      </div>
                      <div class="col-4 my-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                      </div>
                    </form>
                    <form action="php/combine.php" method="post" class="col-sm-7 row">
                      <input type="hidden" name="date" value="<?php echo $date ?>">
                      <div class="col-md-6">
                        <div class="form-group mb-1">
                          <select class="js-example-basic-multiple w-100" multiple="multiple" name="classes[]" required>
                            <?php
                            $class_q = mysqli_query($conn, "SELECT * FROM class WHERE status = 'active' AND id != 1");
                            while ($classa = mysqli_fetch_array($class_q)) { ?>
                              <option value="<?php echo $classa['id'] ?>"><?php echo $classa['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-6 col-md-4 p-0">
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Combine Name" required>
                      </div>
                      <div class="col-3 col-md-2 my-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Join</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive pt-1">
                      <table class="table table-striped project-orders-table">
                        <thead>
                          <tr>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Submitted By</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($class = mysqli_fetch_array($class_query)) {
                            $class_id = $class['id'];
                            $class_name = $class['name'];
                            $combine_class_query = mysqli_query($conn, "SELECT * FROM combine_class WHERE event_date = '$date' AND classes LIKE '%$class_id%'");

                            if (mysqli_num_rows($combine_class_query) > 0) {
                              $combine_class = mysqli_fetch_array($combine_class_query);
                              $class_id = $combine_class['id'];
                              $class_name = $combine_class['name'];

                              if (in_array($class_id, $last_combine_id)) {
                                $skip = 1;
                              } else {
                                $link = "?combine_class=$class_id&date=$date";
                                $att = mysqli_query($conn, "SELECT * FROM attendance WHERE combine_class = $class_id AND date = '$date'");
                                $class_n = 'combine_class';
                                
                                array_push($last_combine_id, $class_id);
                              }
                            } else {
                              $class_n = 'class';
                              $link = "?class=$class_id&date=$date";
                              $att = mysqli_query($conn, "SELECT * FROM attendance WHERE class = $class_id AND date = '$date'");
                              $skip = 0;
                            }

                            if ($skip == 0) {
                              if (mysqli_num_rows($att) > 0) {
                                $status_text = 'Submitted';
                                $status_c = 'success';
                                $button_text = 'Edit';
                                $button_logo = 'edit';
                                $button_c = 'info';
                                $att_array = mysqli_fetch_array($att);
                                $editor_id = $att_array['user'];
                                $total = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total) FROM attendance WHERE $class_n = $class_id AND date = '$date'"))[0];
                                $editor = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE id = " . $editor_id))['name'];
                              } else {
                                $status_text = 'Pending';
                                $status_c = 'danger';
                                $button_text = 'New Entry';
                                $button_logo = 'plus';
                                $button_c = 'success';
                                $editor = 'None';
                                $total = "0";
                              }

                              ?>
                              <tr>
                                <td><?php echo $class_name ?></td>
                                <td>
                                  <div class="d-flex align-items-center">
                                    <button class="btn btn-<?php echo $status_c ?> btn-rounded btn-sm btn-icon-text" disabled>
                                      <?php echo $status_text ?>
                                    </button>
                                  </div>
                                </td>
                                <td><?php echo $total ?></td>
                                <td><?php echo $editor ?></td>
                                <td>
                                  <div class="d-flex align-items-center">
                                    <a href="attendance_1.php<?php echo $link ?>" class="btn-<?php echo $button_c ?> btn-sm btn-icon-text mr-3">
                                      <?php echo $button_text ?>
                                      <i class="typcn typcn-<?php echo $button_logo ?> btn-icon-append"></i>
                                    </a>
                                  </div>
                                </td>
                              </tr>
                            <?php }
                          } ?>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.php -->
        <?php include('partials/_footer.php') ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/select2.js"></script>
  <!-- End custom js </body> for this page-->
</body>

</html>