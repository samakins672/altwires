<?php
session_start();
include('php/config.php');
include('php/page-config.php');

if (isset($_GET['date'])) {
  $date = strtotime($_GET['date']);
  $date = date('Y-m-d', $date);
} else {
  if ($short_day !== 'Sun') {
    $date = date('Y-m-d', strtotime("last Sunday"));
  }
}

$blessing_table = 0;
$blessing_available = 0;
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
          <p class="mb-0">Reports</p>
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
            <div id="blessing-table" class="col-lg-10 mx-auto grid-margin stretch-card">
              <div class="card">
                <div class="card-header">
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <h4 class="card-title mb-1">Blessings Report</h4>
                      <p class="text-gray mb-0"><?php echo $date; ?></p>
                    </div>
                    <div class="col-md-8">
                      <form action="#blessing-table" method="get" class="col-12">
                        <div class="form-group mb-0">
                          <input type="date" class="form-control form-control-sm w-50 d-inline" name="date" value="<?php echo $date ?>">
                          <button type="submit" class="btn btn-primary btn-sm">Search</button>
                          <button type="button" class="btn btn-success btn-sm" onclick="printReport('blessing')">Print</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                  <?php
                  $meeting_query = mysqli_query($conn, "SELECT DISTINCT meeting, meeting_name FROM blessing_record WHERE event_date = '$date'");
                  if (mysqli_num_rows($meeting_query) > 0) {
                    while ($meeting = mysqli_fetch_array($meeting_query)) {
                      $blessing_available += 1;
                      $blessing_table += 1;

                      $meeting_id = $meeting['meeting'];
                      $meeting_name_show = $meeting['meeting_name'];
                      $meeting_name = mysqli_real_escape_string($conn, $meeting['meeting_name']);

                      $blessing_query = mysqli_query($conn, "SELECT * FROM blessing WHERE status = 'active'");
                      ?>
                            <div class="col-lg-12 grid-margin" id="blessing-table<?php echo $blessing_table ?>">
                              <h4 class="card-title mb-2 bg-primary text-white py-2" style="text-align: center;"><?php echo $meeting_name_show ?></h4>
                              <div class="table-responsive pt-1">
                                <table class="table table-bordered project-orders-table">
                                  <thead>
                                    <tr>
                                      <th></th>
                                      <th>Male</th>
                                      <th>Female</th>
                                      <th>Total</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    while ($blessing = mysqli_fetch_array($blessing_query)) {
                                      $blessing_id = $blessing['id'];
                                      $blessing_name = mysqli_real_escape_string($conn, $blessing['name']);
                                      $total_per_blessing = 0;

                                      $male = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id) FROM blessing_record INNER JOIN has_blessing 
                                    ON blessing_record.id = has_blessing.blessing_record WHERE blessing = $blessing_id AND meeting = $meeting_id AND meeting_name = '$meeting_name' AND event_date = '$date' AND sex = 'M'"))[0];
                                      $female = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id) FROM blessing_record INNER JOIN has_blessing 
                                    ON blessing_record.id = has_blessing.blessing_record WHERE blessing = $blessing_id AND meeting = '$meeting_id' AND meeting_name = '$meeting_name' AND event_date = '$date' AND sex = 'F'"))[0];

                                      $total_per_blessing = $male + $female;
                                      ?>
                                              <tr>
                                                <td><?php echo $blessing_name ?></td>
                                                <td><?php echo $male ?></td>
                                                <td><?php echo $female ?></td>
                                                <td><?php echo $total_per_blessing ?></td>
                                              </tr>
                                    <?php }
                                    $total_male = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id) FROM blessing_record INNER JOIN has_blessing 
                                    ON blessing_record.id = has_blessing.blessing_record WHERE meeting = $meeting_id AND event_date = '$date' AND sex = 'M'"))[0];
                                    $total_female = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id) FROM blessing_record INNER JOIN has_blessing 
                                    ON blessing_record.id = has_blessing.blessing_record WHERE meeting = $meeting_id AND event_date = '$date' AND sex = 'F'"))[0];

                                    $grand_total = $total_male + $total_female;
                                    ?>
                                    <tr class="table-success">
                                      <td>Grand Total</td>
                                      <td><?php echo $total_male ?></td>
                                      <td><?php echo $total_female ?></td>
                                      <td><?php echo $grand_total; ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        <?php }
                  } else {
                    ?>
                          <div class="col-lg-12 grid-margin" id="table1">
                            <h4 class="card-title mb-2 bg-danger text-white py-2" style="text-align: center;">No Blessing Recorded on <?php echo $date ?></h4>
                          </div>
                  <?php } ?>
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
  <script src="vendors/select2/select2.min.js"></script>
  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
  <script>
    function printReport(reportName) {
      var report = window.open();
      var style = "body {font-family: garamond;} .card, h2 {margin-top: 15px;} h4 {margin: 2px;} p {margin-top: 0; font-size: 1em;} p, h2, h3, h4 {text-align: center; margin-bottom: 0;} h2, h4 {text-transform: uppercase;}table {border-collapse: collapse; margin: 25px 0; font-weight: 600; font-size: 1em; width: 90%; margin: auto; }  th, td { padding: 4px 15px; border: 1px solid #000;}  tbody tr { border-bottom: 1px solid #dddddd; }";
      
      report.document.write('<html>');
      report.document.write('<head>');
      report.document.write('<title>Attendance Report:<?php echo $date ?></title>');
      report.document.write('<style>');
      report.document.write(style);
      report.document.write('</style>');
      report.document.write('</head>');
      report.document.write('<body>');
      report.document.write('<h2><?php echo $church['name'] ?></h2>');
      report.document.write('<h4><?php echo $church['chapter'] ?></h4>');
      report.document.write('<p><?php echo $church['address'] ?></p>');
      report.document.write('<h3>Record Of Blessing: <?php echo $date ?></h3>');
      for (i = 1; i <= <?php echo $blessing_table ?>; i++) {
        contents = document.getElementById(reportName+'-table'+i).innerHTML;
        report.document.write('<div class="card">'+contents+'</div>');
      }
      report.document.write('</html>');
      report.print();
    }
  </script>
  <!-- End custom js </body> for this page-->
</body>

</html>
