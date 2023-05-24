<?php
session_start();
include('php/config.php');
include('php/page-config.php');

$query = mysqli_query($conn, "SELECT * FROM brethren WHERE status = 'active'");
$total_rows = mysqli_num_rows($query);

$limit = 10;
$total_pages = ceil($total_rows/$limit);

$h_alert = 'd-none';
if (isset($_GET['new'])) {
  $alert = "One member has been added Successfully!";
  $h_alert = 'text-success';
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
              <p class="mb-0">Brethren</p>
              <i class="typcn typcn-chevron-right"></i>
              <p class="mb-0">All</p>
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
            <div class="col-md-12">
              <div class="card">
                <div class="card-header row m-0">
                    <div class="col-md-2">
                      <div class="form-group mb-0">
                        <select class="form-control form-control-sm" id="order_by">
                          <option value="name">Name</option>
                          <option value="phone">Phone</option>
                          <option value="role">Role</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group mb-0">
                        <select class="form-control form-control-sm" id="limit">
                          <?php if ($total_pages > 1): ?>
                            <option value="10">10</option>
                          <?php endif; ?>
                          <?php if ($total_pages > 8): ?>
                            <option value="20">20</option>
                          <?php endif; ?>
                          <?php if ($total_pages > 12): ?>
                            <option value="30">30</option>
                          <?php endif; ?>
                          <?php if ($total_pages > 16): ?>
                            <option value="40">40</option>
                          <?php endif; ?>
                          <?php if ($total_pages > 20): ?>
                            <option value="50">50</option>
                          <?php endif; ?>
                          <?php if ($total_pages > 50): ?>
                            <option value="100">100</option>
                          <?php endif; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <button type="button" id="filter" class="btn btn-sm btn-primary m-0" onclick="filter(this.id)">Filter</button>
                    </div>
                    <div class="col-md-4">
                      <input type="search" class="form-control form-control-sm" id="query" placeholder="Search Member's name">
                    </div>
                </div>
                <div id="table" class="table-responsive pt-1"></div>
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
  <script src="js/jquery-3.6.4.min.js"></script>
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
  <script>
    $(document).ready(function() {
      $("#table").load("php/pagination.php?pg_num=1");
    });
  </script>
  <script>
    function filter(status) {
      var order_by = $('#order_by').val();
      var pg_num = $('#pg_num').val();
      var limit = $('#limit').val();
      // var gender = $.trim($('input[name=gender]:radio:checked').val());

      $.ajax({
        method: "GET",
        url: "php/pagination.php",
        data: {
          pg_num: pg_num,
          status: status,
          order_by: order_by,
          limit: limit
        },
        cache: false,
        success: function(result) {
          $("#table").html(result);
        }
      });
    }
  </script>
  <script>
    $('#query').on("keyup", function() {
      var query = $(this).val();

      $.ajax({
        method: "GET",
        url: "php/pagination.php",
        data: {
          search: query
        },
        cache: false,
        success: function(result) {
          $("#table").html(result);
        }
      });
    });
  </script>
  <script src="js/dashboard.js"></script>
  <!-- End custom js </body> for this page-->
</body>

</html>