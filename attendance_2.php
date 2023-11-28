<?php
session_start();
include('php/config.php');
include('php/page-config.php');

$service_id = $_GET['type'];
$service = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM service WHERE id = $service_id"))['name'];

$total_children_m = 0;
$total_children_f = 0;
$total_adult_m = 0;
$total_adult_f = 0;
$worker_m = 0;
$worker_f = 0;
$total_visitor_m = 0;
$total_visitor_f = 0;

if (isset($_GET['date'])) {
  $date = $_GET['date'];
  $attd_q = mysqli_query($conn, "SELECT * FROM service_attd WHERE service = $service_id AND event_date = '$date'");
  if (mysqli_num_rows($attd_q) == 1) {
    $attd = mysqli_fetch_array($attd_q);
    
    $total_children_m = $attd['total_children_m'];	
    $total_children_f = $attd['total_children_f'];	
    $total_adult_m = $attd['total_adult_m'];	
    $total_adult_f = $attd['total_adult_f'];	
    $worker_m = $attd['worker_m'];	
    $worker_f = $attd['worker_f'];	
    $total_visitor_m = $attd['total_visitor_m'];	
    $total_visitor_f = $attd['total_visitor_f'];
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
        <div class="content-wrapper">
          <div class="row">
            <div class="col-8 m-auto stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo date('D', strtotime($date)).', ' . date('d', strtotime($date)) . ' '.date('F', strtotime($date)).', '.date('Y', strtotime($date))?></h4>
                  <!-- <p class="card-description">
                    Basic form elements
                  </p> -->
                  <form action="php/service_attd.php" method="post" class="forms-sample">
                    <input type="hidden" name="service_id" value="<?php echo $service_id?>">
                    <input type="hidden" name="date" value="<?php echo $date?>">
                    <div class="form-group">
                      <label for="childrem_m">Children (Male)</label>
                      <input type="number" class="form-control" name ="children_m" value = "<?php echo $total_children_m ?>">
                    </div>
                    <div class="form-group">
                      <label for="childrem_f">Children (Female)</label>
                      <input type="number" class="form-control" name ="children_f" value = "<?php echo $total_children_f?>">
                    </div>
                    <div class="form-group">
                      <label for="adult_m">Adults (Male)</label>
                      <input type="number" class="form-control" name ="adult_m" value = "<?php echo $total_adult_m?>">
                    </div>
                    <div class="form-group">
                      <label for="adult_f">Adults (Female)</label>
                      <input type="number" class="form-control" name ="adult_f" value = "<?php echo $total_adult_f?>">
                    </div>
                    <div class="form-group">
                      <label for="worker_m">Workers (Male)</label>
                      <input type="number" class="form-control" name ="worker_m" value = "<?php echo $worker_m?>">
                    </div>
                    <div class="form-group">
                      <label for="worker_f">Workers (Female)</label>
                      <input type="number" class="form-control" name ="worker_f" value = "<?php echo $worker_f?>">
                    </div>
                    <div class="form-group">
                      <label for="visitor_m">Visitors (Male)</label>
                      <input type="number" class="form-control" name ="visitor_m" value = "<?php echo $total_visitor_m?>">
                    </div>
                    <div class="form-group">
                      <label for="visitor_f">Visitors (Female)</label>
                      <input type="number" class="form-control" name ="visitor_f" value = "<?php echo $total_visitor_f?>">
                    </div>
                    <button name="submit-attd" type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Reset</button>
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
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
  <!-- End custom js </body> for this page-->
</body>

</html>