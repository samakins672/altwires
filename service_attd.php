<?php
session_start();
include('php/config.php');
include('php/page-config.php');

$service_id = $_GET['type'];
$service_q = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM service WHERE id = $service_id"));
$service = $service_q['name'];

$h_alert = "d-none";
if (isset($_GET['success'])) {
  $alert = "Attendance Has Been Submitted Successfully!";
  $h_alert = 'text-success';
}
if (isset($_GET['err'])) {
  $alert = "Attendance submission Unsuccessful, Please try again!";
  $h_alert = 'text-danger';
}

if (isset($_GET['date'])) {
  $date = strtotime($_GET['date']);
  $date = date('Y-m-d', $date);
}

if ($service_q['repetition'] == 'weekly') {
  $date_text = "Current Week";
  $service_day = $service_q['repeat_day'];

  $_service_day = date('w', strtotime($date));
  $_service_day = jddayofweek($_service_day - 1, 2);

  if ($short_day == $_service_day) {
    $service_date = $date;
  } else {
    $service_date = date('Y-m-d', strtotime("last " . $service_day));
  }
} else {
  $service_date = $date;
  $date_text = "Today";
}

if (isset($_GET['from']) || isset($_GET['to'])) {
  $date_from = $_GET['from'];
  $date_to = $_GET['to'];
} else {
  $date_from = date('Y-m-d', strtotime("-4 weeks", strtotime($service_date)));
  $date_to = $date;
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
          <h6 class="mb-0">Mafoluku Zone</h6>
          <i class="typcn typcn-chevron-right"></i>
          <p class="mb-0"><?php echo $service ?></p>
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
        <h4 class="mx-auto font-weight-bold <?php echo $h_alert ?>">
          <?php echo $alert ?>
        </h4>
        <div class="content-wrapper">

          <div class="row">
            <div class="col-md-12 col-sm-12 mx-auto">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <form action="" method="get" class="col-lg-8">
                      <input type="hidden" class="form-control form-control-sm" name="type" value="<?php echo $service_id ?>">
                      <div class="col-sm-12 p-0 d-inline-block">
                        <div class="form-group mb-0">
                          <div class="col-sm-2 d-inline">
                            <label for="from" class="d-inline pt-4">From</label>
                          </div>
                          <div class="col-sm-3 p-0 d-inline-block">
                            <input type="date" class="form-control form-control-sm" name="from" value="<?php echo $date_from ?>">
                          </div>
                          <div class="col-sm-2 d-inline">
                            <label for="to" class="d-inline pt-4">To</label>
                          </div>
                          <div class="col-sm-3 p-0 d-inline-block">
                            <input type="date" class="form-control form-control-sm" name="to" value="<?php echo $date_to ?>">
                          </div>
                          <div class="col-sm-3 p-0 d-inline-block">
                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive pt-1">
                      <table class="table table-striped project-orders-table">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Submitted By</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (strtotime($date_to) >= strtotime($service_date)) {
                            $today_attd = mysqli_query($conn, "SELECT * FROM attendance WHERE service = $service_id AND date = '$service_date'");
                            if (mysqli_num_rows($today_attd) == 1) {
                              $today_attds = mysqli_fetch_array($today_attd);
                              $status_text = 'Submitted';
                              $status_c = 'success';
                              $total_attd = $today_attds['total'];
                              $editor_id = $today_attds['user'];
                              $editor = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE id = " . $editor_id))['name'];
                              $button_text = 'Edit';
                              $button_logo = 'edit';
                              $button_c = 'info';
                            } else {
                              $status_text = 'Pending';
                              $status_c = 'danger';
                              $total_attd = 0;
                              $editor = 'None';
                              $button_text = 'New Entry';
                              $button_logo = 'plus';
                              $button_c = 'success';
                            }
                            ?>
                            <tr>
                              <td><?php echo $date_text ?></td>
                              <td>
                                <div class="d-flex align-items-center">
                                  <button class="btn btn-<?php echo $status_c ?> btn-rounded btn-sm btn-icon-text" disabled>
                                    <?php echo $status_text ?>
                                  </button>
                                </div>
                              </td>
                              <td><?php echo $total_attd ?></td>
                              <td><?php echo $editor ?></td>
                              <td>
                                <div class="d-flex align-items-center">
                                  <a href="attendance_2.php?type=<?php echo $service_id . '&date=' . $service_date ?>" class="btn-<?php echo $button_c ?> btn-sm btn-icon-text mr-3">
                                    <?php echo $button_text ?>
                                    <i class="typcn typcn-<?php echo $button_logo ?> btn-icon-append"></i>
                                  </a>
                                </div>
                              </td>
                            </tr>
                          <?php } ?>

                          <?php
                          if (isset($_GET['from']) || isset($_GET['to'])) {
                            $attd_query = mysqli_query($conn, "SELECT * FROM `attendance` WHERE service = $service_id AND `date` BETWEEN '$date_from' AND '$date_to' ORDER BY date DESC;");
                          } else {
                            $attd_query = mysqli_query($conn, "SELECT * FROM attendance WHERE service = $service_id AND date != '$service_date' ORDER BY date DESC LIMIT 4");
                          }

                          if (mysqli_num_rows($attd_query) >= 1) {
                            while ($attd = mysqli_fetch_array($attd_query)) {
                              $attd_date = $attd['date'];
                              $total_attd = $attd['total'];
                              $editor_id = $attd['user'];
                              $editor = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE id = " . $editor_id))['name'];
                              $button_text = 'Edit';
                              $button_logo = 'edit';
                              $button_c = 'info';
                              $link = "attendance_2.php?type=$service_id&date=" . $attd_date;
                              ?>
                                      <tr>
                                        <td><?php echo $attd_date ?></td>
                                        <td>
                                          <div class="d-flex align-items-center">
                                            <button class="btn btn-success btn-rounded btn-sm btn-icon-text" disabled>
                                              Submitted
                                            </button>
                                          </div>
                                        </td>
                                        <td><?php echo $total_attd ?></td>
                                        <td><?php echo $editor ?></td>
                                        <td>
                                          <div class="d-flex align-items-center">
                                            <a href="<?php echo $link ?>" class="btn-<?php echo $button_c ?> btn-sm btn-icon-text mr-3">
                                              <?php echo $button_text ?>
                                              <i class="typcn typcn-<?php echo $button_logo ?> btn-icon-append"></i>
                                            </a>
                                          </div>
                                        </td>
                                      </tr>
                              <?php }
                          } else {
                          ?><tr>
                              <td colspan="5" style="text-align: center;">No Record Found!</td>
                            </tr>
                          <?php } ?>
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
  <script src="vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js </body> for this page-->
</body>

</html>