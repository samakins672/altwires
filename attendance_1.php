<?php
session_start();
include('php/config.php');
include('php/page-config.php');

$date = $_GET['date'];
$visitors_m = 0;
$visitors_f = 0;
$teachers_m = 0;
$teachers_f = 0;

if (isset($_GET['combine_class'])) {
  $class_id = $_GET['combine_class'];
  
  $class_q = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM combine_class WHERE id = '$class_id'"));
  $class = $class_q['name'];
  $classes = $class_q['classes'];

  $service_query = mysqli_query($conn, "SELECT * FROM service_attd WHERE combine_class = '$class_id' AND event_date = '$date'");
  if (mysqli_num_rows($service_query) >= 1) {
    $teachers_m = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(worker_m) FROM service_attd WHERE combine_class = '$class_id' AND event_date = '$date'"))[0];
    $teachers_f = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(worker_f) FROM service_attd WHERE combine_class = '$class_id' AND event_date = '$date'"))[0];

    $visitors_m = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total_visitor_m) FROM service_attd WHERE combine_class = '$class_id' AND event_date = '$date'"))[0];
    $visitors_f = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total_visitor_f) FROM service_attd WHERE combine_class = '$class_id' AND event_date = '$date'"))[0];
  }

  $brethren_query = mysqli_query($conn, "SELECT * FROM brethren WHERE class IN ($classes) AND status = 'active' ORDER BY name");
} else {
  $class_id = $_GET['class'];
  
  $class = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM class WHERE id = '$class_id'"))['name'];
  
  $service_query = mysqli_query($conn, "SELECT * FROM service_attd WHERE service = 1 AND class = '$class_id' AND event_date = '$date'");
  if (mysqli_num_rows($service_query) == 1) {
    $service_data = mysqli_fetch_array($service_query);
    $teachers_m = $service_data['worker_m'];
    $teachers_f = $service_data['worker_f'];
    
    $visitors_m = $service_data['total_visitor_m'];
    $visitors_f = $service_data['total_visitor_f'];
  }
  
  $brethren_query = mysqli_query($conn, "SELECT * FROM brethren WHERE class = $class_id AND status = 'active' ORDER BY name");
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
          <p class="mb-0">Sunday School</p>
          <i class="typcn typcn-chevron-right"></i>
          <p class="mb-0"><?php echo $class ?></p>
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
        <div class="content-wrapper">

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="table-responsive pt-1">
                  <form action="php/sun_sch_attd.php" method="post">
                    <?php if (isset($_GET['combine_class'])): ?>
                    <input type="hidden" name="combine_class" value="<?php echo $class_id ?>">
                    <?php else: ?>
                    <input type="hidden" name="class" value="<?php echo $class_id ?>">
                    <?php endif; ?>
                    <input type="hidden" name="date" value="<?php echo $date ?>">
                  <table class="table table-striped project-orders-table">
                    <thead>
                      <tr>
                        <th class="ml-5"></th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (mysqli_num_rows($brethren_query) > 0) {
                        while ($brethren = mysqli_fetch_array($brethren_query)) {
                          $brethren_id = $brethren['id'];
                          $role_id = $brethren['role'];
                          $class_id = $brethren['class'];
                          $role = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM role WHERE id = '$role_id'"))['name'];
                          $att = mysqli_query($conn, "SELECT * FROM sun_sch_attd WHERE brethren = $brethren_id AND event_date = '$date'");
                          if (mysqli_num_rows($att) == 1) {
                            $check = 'checked';
                          } else {
                            $check = '';
                          }
                          $progress = 0;
                          $progress_w = 0;
                          $d_date = $date;

                          if (isset($_GET['combine_class'])) {
                            $class_id = $_GET['combine_class'];
                            $chk_query = mysqli_query($conn, "SELECT * FROM attendance WHERE combine_class = $class_id OR class IN ($classes) ORDER BY date DESC LIMIT 4");
                          } else {
                            $chk_query = mysqli_query($conn, "SELECT * FROM attendance WHERE service = 1 AND class = $class_id AND date <= '$date' ORDER BY date DESC LIMIT 4");
                          }

                          while ($date_array = mysqli_fetch_array($chk_query)) {
                            $c_date = $date_array['date'];
                            $chk = mysqli_query($conn, "SELECT * FROM sun_sch_attd WHERE brethren = $brethren_id AND event_date = '$c_date'");
                            if (mysqli_num_rows($chk) == 1) {
                              $progress_w += 25;
                              $progress++;
                            }
                          }
                          $progress_c = 'warning';
                          if ($progress_w > 50) {
                            $progress_c = 'success';
                          }
                          ?>
                      <tr>
                        <td class="py-2">
                          <a href="individual_view.php?id=<?php echo $brethren['id'] ?>">
                            <img src="assets/images/members/<?php echo $brethren['picture'] ?>" alt="image" />
                          </a>
                        </td>
                        <td class="py-2"><?php echo strtoupper($brethren['name']) ?></td>
                        <td class="py-2"><?php echo $brethren['phone'] ?></td>
                        <td class="py-2"><?php echo $role ?></td>
                        <td class="py-2">
                          <div class="progress">
                            <div class="progress-bar bg-<?php echo $progress_c ?>" role="progressbar" style="width: <?php echo $progress_w?>%"><?php echo $progress ?>/4</div>
                          </div>
                        </td>
                        <td class="py-2">
                          <div class="ml-3 form-check form-check-success">
                            <label class="form-check-label">
                              <input name="member_id[]" value="<?php echo $brethren['id'] ?>" type="checkbox" class="form-check-input" <?php echo $check ?>>
                              <i class="input-helper"></i>
                            </label>
                          </div>
                        </td>
                      </tr>
                      <?php }
                      } else { ?>
                      <tr>
                        <td colspan="6" class="text-center py-2">No Member is registered to this class!</td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td></td>
                        <td>TEACHERS</td>
                        <td>Male</td>
                        <td>
                          <div class="form-group p-0 mb-0">
                              <input value="<?php echo $teachers_m ?>" style="width: 100px; height: 25px;" name="teacher_m" type="number" class="form-control px-2 mr-0">
                          </div>
                        </td>
                        <td>Female</td>
                        <td>
                          <div class="form-group p-0 mb-0">
                              <input value="<?php echo $teachers_f ?>" style="width: 100px; height: 25px;" name="teacher_f" type="number" class="form-control px-2 mr-0">
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>VISITORS</td>
                        <td>Male</td>
                        <td>
                          <div class="form-group p-0 mb-0">
                              <input value="<?php echo $visitors_m ?>" style="width: 100px; height: 25px;" name="visitor_m" type="number" class="form-control px-2 mr-0">
                          </div>
                        </td>
                        <td>Female</td>
                        <td>
                          <div class="form-group p-0 mb-0">
                              <input value="<?php echo $visitors_f ?>" style="width: 100px; height: 25px;" name="visitor_f" type="number" class="form-control px-2 mr-0">
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                          <div class="d-flex align-items-center">
                            <button type="reset" class="btn btn-danger btn-sm btn-icon-text">
                              Reset
                              <i class="typcn typcn-delete-outline btn-icon-append"></i>
                            </button>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex align-items-center">
                            <button name="upload_attd" type="submit" class="btn btn-success btn-sm btn-icon-text mr-3">
                              Submit
                              <i class="typcn typcn-edit btn-icon-append"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </form>
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