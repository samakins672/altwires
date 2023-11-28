<?php
session_start();
include('php/config.php');
include('php/page-config.php');

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

          <div class="row">
            <div class="col-12 m-auto stretch-card">
              <!-- Total Number of Members -->
              <div class="col-6 col-md-3">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Total Members</h5>
                    <p class="h1 text-primary">1500</p>
                  </div>
                </div>
              </div>

              <!-- Total Number of Visitors -->
              <div class="col-6 col-md-3">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Total Visitors</h5>
                    <p class="h1 text-primary">500</p>
                  </div>
                </div>
              </div>

              <!-- Total Number of Branches -->
              <div class="col-6 col-md-3">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Total Branches</h5>
                    <p class="h1 text-primary">10</p>
                  </div>
                </div>
              </div>

              <!-- Total Number of Workers -->
              <div class="col-6 col-md-3">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Total Workers</h5>
                    <p class="h1 text-primary">200</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table for Upcoming Birthdays -->
            <div class="row mt-4">
              <div class="col-md-6 col-12">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Upcoming Birthdays</h5>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>John Doe</td>
                          <td>2023-05-15</td>
                        </tr>
                        <tr>
                          <td>Jane Smith</td>
                          <td>2023-06-10</td>
                        </tr>
                      </tbody>
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