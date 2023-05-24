<?php
session_start();
include('php/config.php');
include('php/page-config.php');

if ($_SESSION['role'] != 'admin') {
  header("Location: sun_sch_attd.php");
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
          <p class="mb-0">Home</p>
          <i class="typcn typcn-chevron-right"></i>
          <p class="mb-0">Main Dahboard</p>
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
          <h3 class="mb-2 text-uppercase font-weight-bold">Dashboard is under contruction, stay tuned!</h3>

          <div class="row">
            <div class="col-xl-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body border-bottom">
                  <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-2 mb-md-0 text-uppercase font-weight-medium">####</h6>
                    <div class="dropdown">
                      <button class="btn bg-white p-0 pb-1 text-muted btn-sm dropdown-toggle" type="button"
                        id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Last # days
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                        <h6 class="dropdown-header">Settings</h6>
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="sales-chart-c" class="mt-2"></canvas>
                  <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 mt-4">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">######</p>
                      <h5>###</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-success mb-0">0.5%</p>
                        <i class="typcn typcn-arrow-up-thick text-success"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">####</p>
                      <h5>##k</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-success mb-0">0.8%</p>
                        <i class="typcn typcn-arrow-up-thick text-success"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">####</p>
                      <h5>###</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-danger mb-0">-04%</p>
                        <i class="typcn typcn-arrow-down-thick text-danger"></i>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="dropdown">
                      <button class="btn bg-white p-0 pb-1 pt-1 text-muted btn-sm dropdown-toggle" type="button"
                        id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Last # days
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                        <h6 class="dropdown-header">Settings</h6>
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                      </div>
                    </div>
                    <p class="mb-0">overview</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-xl-4 grid-margin stretch-card">
              <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                  <div class="card newsletter-card bg-gradient-warning">
                    <div class="card-body">
                      <div class="d-flex flex-column align-items-center justify-content-center h-100">
                        <h5 class="mb-3 text-white">######</h5>
                        <form class="form d-flex flex-column align-items-center justify-content-between w-100">
                          <div class="form-group mb-2 w-100">
                            <input type="text" class="form-control" placeholder="#### ##">
                          </div>
                          <button class="btn btn-danger btn-rounded mt-1" type="submit">######</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 stretch-card">
                  <div class="card profile-card bg-gradient-primary">
                    <div class="card-body">
                      <div class="row align-items-center h-100">
                        <div class="col-md-4">
                          <figure class="avatar mx-auto mb-4 mb-md-0">
                            <img src="assets/images/admins/<?php echo $user_image ?>" alt="avatar">
                          </figure>
                        </div>
                        <div class="col-md-8">
                          <h5 class="text-white text-center text-md-left"><?php echo $_SESSION['name'] ?></h5>
                          <p class="text-white text-center text-md-left"><?php echo $user_email ?></p>
                          <div class="d-flex align-items-center justify-content-between info pt-2">
                            <div>
                              <p class="text-white font-weight-bold">Phone:</p>
                            </div>
                            <div>
                              <p class="text-white"><?php echo $user_phone ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-xl-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body border-bottom">
                  <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-2 mb-md-0 text-uppercase font-weight-medium">####</h6>
                    <div class="dropdown">
                      <button class="btn bg-white p-0 pb-1 text-muted btn-sm dropdown-toggle" type="button"
                        id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Last # days
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                        <h6 class="dropdown-header">Settings</h6>
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="sales-chart-c" class="mt-2"></canvas>
                  <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 mt-4">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">######</p>
                      <h5>###</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-success mb-0">0.5%</p>
                        <i class="typcn typcn-arrow-up-thick text-success"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">####</p>
                      <h5>##k</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-success mb-0">0.8%</p>
                        <i class="typcn typcn-arrow-up-thick text-success"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <p class="text-muted">####</p>
                      <h5>###</h5>
                      <div class="d-flex align-items-baseline">
                        <p class="text-danger mb-0">-04%</p>
                        <i class="typcn typcn-arrow-down-thick text-danger"></i>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="dropdown">
                      <button class="btn bg-white p-0 pb-1 pt-1 text-muted btn-sm dropdown-toggle" type="button"
                        id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Last # days
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                        <h6 class="dropdown-header">Settings</h6>
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                      </div>
                    </div>
                    <p class="mb-0">overview</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="table-responsive pt-3">
                  <table class="table table-striped project-orders-table">
                  </table>
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
  
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  
  <!-- End custom js </body> for this page-->
</body>

</html>