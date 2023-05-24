<?php
session_start();
include('php/config.php');
include('php/page-config.php');

$date = $_GET['date'];
$service_id = $_GET['service'];

$service = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM service WHERE id = '$service_id'"))['name'];

$brethren_query = mysqli_query($conn, "SELECT * FROM brethren WHERE status = 'active' ORDER BY name");

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
          <p class="mb-0"><?php echo $service ?></p>
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
                  <form action="php/absentees_attd.php" method="post">
                    <input type="hidden" name="service" value="<?php echo $service_id ?>">
                    <input type="hidden" name="date" value="<?php echo $date ?>">
                    <table class="table table-striped project-orders-table">
                      <thead>
                        <tr>
                          <th class="ml-5"></th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Role</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      if (mysqli_num_rows($brethren_query) > 0) {
                        while ($brethren = mysqli_fetch_array($brethren_query)) {
                          $brethren_id = $brethren['id'];
                          $role_id = $brethren['role'];
                          $role = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM role WHERE id = '$role_id'"))['name'];

                          $abs = mysqli_query($conn, "SELECT * FROM absentee WHERE service = $service_id AND date = '$date'");
                          if (mysqli_num_rows($abs) == 1) {
                            $individual_abs = mysqli_query($conn, "SELECT * FROM absentee_attd WHERE brethren = $brethren_id AND service = $service_id AND event_date = '$date'");
                            
                            if (mysqli_num_rows($individual_abs) == 1) {
                              $check = 'checked';
                            } else {
                              $check = '';
                            }
                          } else {
                            $att1 = mysqli_query($conn, "SELECT * FROM absentee_attd WHERE brethren = $brethren_id AND event_date = '$date'");
                            $att2 = mysqli_query($conn, "SELECT * FROM sun_sch_attd WHERE brethren = $brethren_id AND event_date = '$date'");
                            
                            if (mysqli_num_rows($att1) >= 1 || mysqli_num_rows($att2) < 1) {
                              $check = 'checked';
                            } else {
                              $check = '';
                            }
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
                            <div class="ml-3 form-check form-check-danger">
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
                          <td colspan="5" class="text-center py-2">No Member is registered yet!</td>
                        </tr>
                      <?php } ?>
                        <tr>
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
                              <button type="submit" class="btn btn-success btn-sm btn-icon-text mr-3">
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