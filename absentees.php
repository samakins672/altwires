<?php
session_start();
include('php/config.php');
include('php/page-config.php');

$h_alert = "d-none";
if (isset($_GET['success'])) {
  $alert = "Absentees Has Been Submitted Successfully!";
  $h_alert = 'text-success';
}

if (isset($_GET['err'])) {
  $alert = "Absentees failed to submit, Please try again!";
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

$absentee_query = mysqli_query($conn, "SELECT * FROM absentee WHERE date = '$date' ORDER BY service");
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
          <p class="mb-0">Absentees</p>
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
            <div class="col-md-10 col-sm-12 mx-auto">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <form action="" method="get" class="col-sm-6 row">
                      <div class="col-6 p-0">
                        <div class="form-group mb-1">
                          <input type="date" class="form-control form-control-sm" name="date" value="<?php echo $date ?>">
                        </div>
                      </div>
                      <div class="col-4 my-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                      </div>
                    </form>
                    <form action="absentees_attd.php" method="get" class="col-sm-6 row">
                      <input type="hidden" name="date" value="<?php echo $date ?>">
                      <div class="col-7 p-0">
                        <div class="form-group mb-1">
                          <select class="form-control form-control-sm" name="service" required>
                            <?php
                            $service_q = mysqli_query($conn, "SELECT * FROM service WHERE status = 'active'");
                            while ($service = mysqli_fetch_array($service_q)) { ?>
                                <option value="<?php echo $service['id'] ?>"><?php echo $service['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-5 my-auto">
                        <button type="submit" class="btn btn-success btn-sm btn-icon-text">
                          <i class="typcn typcn-plus btn-icon-append"></i>
                          New
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive pt-1">
                      <table class="table table-striped project-orders-table">
                        <thead>
                          <tr>
                            <th>Service</th>
                            <th>Total</th>
                            <th>Submitted By</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (mysqli_num_rows($absentee_query) > 0) {

                            while ($absentees = mysqli_fetch_array($absentee_query)) {
                              $service_id = $absentees['service'];
                              $service_name = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM service WHERE id = $service_id"))['name'];
                              $link = "?service=$service_id&date=$date";
                              $total = $absentees['total'];
                              
                              $editor_id = $absentees['created_by'];
                              $editor = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE id = $editor_id"))['name'];

                              ?>
                              <tr>
                                <td><?php echo $service_name ?></td>
                                <td><?php echo $total ?></td>
                                <td><?php echo $editor ?></td>
                                <td>
                                  <div class="d-flex align-items-center">
                                    <a href="absentees_attd.php<?php echo $link ?>" class="btn-info btn-sm btn-icon-text mr-3">
                                      <i class="typcn typcn-edit btn-icon-append"></i>
                                      Edit
                                    </a>
                                  </div>
                                </td>
                              </tr>
                              <?php }
                          } else { ?>
                          <tr>
                            <td colspan="4" style="text-align: center;">No Service Absentees Recorded Yet!</td>
                          </tr>
                          <?php }?>
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