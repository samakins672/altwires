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

$last_combine_id = 0;
$skip = 0;

$class_query = mysqli_query($conn, "SELECT * FROM class WHERE name != 'Elementary'");
$service_query = mysqli_query($conn, "SELECT * FROM service WHERE id != 1");

$table = 1;
$event_available = 0;
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
            <div class="col-lg-10 mx-auto grid-margin stretch-card">
              <div class="card">
                <div class="card-header">
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <h4 class="card-title mb-1">Attendance Report</h4>
                      <p class="text-gray mb-0"><?php echo $date; ?></p>
                    </div>
                    <div class="col-md-8">
                      <form action="#" method="get" class="col-12">
                        <div class="form-group mb-0">
                          <input type="date" class="form-control form-control-sm w-50 d-inline" name="date" value="<?php echo $date ?>">
                          <button type="submit" class="btn btn-primary btn-sm">Search</button>
                          <button type="button" class="btn btn-success btn-sm" onclick="printReport('attendance')">Print</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                  <?php
                  $check_event = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM attendance WHERE service = 1 AND class != 1 AND date = '$date'"));
                  if ($check_event > 0) {
                    $event_available = 1;
                    ?>
                              <div class="col-lg-12 grid-margin" id="attendance-table1">
                                <h4 class="card-title mb-2 bg-primary text-white py-2" style="text-align: center;">Sunday School</h4>
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
                                      $teacher_male = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(worker_m) FROM service_attd WHERE service = 1 AND class != 1 AND event_date = '$date'"))[0];
                                      $teacher_female = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(worker_f) FROM service_attd WHERE service = 1 AND class != 1 AND event_date = '$date'"))[0];
                                      $total_teacher = $teacher_male + $teacher_female;
                                      ?>
                                      <tr>
                                        <td>Teachers</td>
                                        <td><?php echo $teacher_male ?></td>
                                        <td><?php echo $teacher_female ?></td>
                                        <td><?php echo $total_teacher ?></td>
                                      </tr>
                                      <?php while ($class = mysqli_fetch_array($class_query)) {
                                        $total_per_class = 0;
                                        $class_id = $class['id'];
                                        $class_name = $class['name'];
                                        $combine_class_query = mysqli_query($conn, "SELECT * FROM combine_class WHERE event_date = '$date' AND classes LIKE '%$class_id%'");

                                        if (mysqli_num_rows($combine_class_query) > 0) {
                                          $combine_class = mysqli_fetch_array($combine_class_query);
                                          $class_id = $combine_class['id'];
                                          $class_name = $combine_class['name'];

                                          if ($last_combine_id != $class_id) {
                                            $last_combine_id = $class_id;
                                            $class_n = 'combine_class';
                                          } else {
                                            $skip = 1;
                                          }
                                        } else {
                                          $class_n = 'class';
                                          $skip = 0;
                                        }

                                        if ($skip == 0) {

                                          $male = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(brethren) FROM sun_sch_attd WHERE $class_n = $class_id AND event_date = '$date' AND gender = 'male'"))[0];
                                          $female = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(brethren) FROM sun_sch_attd WHERE $class_n = $class_id AND event_date = '$date' AND gender = 'female'"))[0];

                                          $vistor_query = mysqli_query($conn, "SELECT * FROM service_attd WHERE $class_n = $class_id AND event_date = '$date'");
                                          if (mysqli_num_rows($vistor_query) >= 1) {
                                            $visitor = mysqli_fetch_array($vistor_query);
                                            $visitor_male = $visitor['total_visitor_m'];
                                            $visitor_female = $visitor['total_visitor_f'];
                                          } else {
                                            $visitor_male = 0;
                                            $visitor_female = 0;
                                          }
                                          $male += $visitor_male;
                                          $female += $visitor_female;

                                          $total_per_class = $male + $female;
                                          ?>
                                                <tr>
                                                  <td><?php echo $class_name ?></td>
                                                  <td><?php echo $male ?></td>
                                                  <td><?php echo $female ?></td>
                                                  <td><?php echo $total_per_class ?></td>
                                                </tr>
                                      <?php }
                                      }
                                      $total_male = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(brethren) FROM sun_sch_attd WHERE class != 1 AND event_date = '$date' AND gender = 'male'"))[0];
                                      $total_female = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(brethren) FROM sun_sch_attd WHERE class != 1 AND event_date = '$date' AND gender = 'female'"))[0];

                                      $vistor_query2 = mysqli_query($conn, "SELECT * FROM service_attd WHERE service = 1 AND class != 1 AND event_date = '$date'");
                                      if (mysqli_num_rows($vistor_query2) >= 1) {
                                        $total_visitor_male = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total_visitor_m) FROM service_attd WHERE service = 1 AND class != 1 AND event_date = '$date'"))[0];
                                        $total_visitor_female = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total_visitor_f) FROM service_attd WHERE service = 1 AND class != 1 AND event_date = '$date'"))[0];
                                      } else {
                                        $total_visitor_male = 0;
                                        $total_visitor_female = 0;
                                      }

                                      $total_male += $total_visitor_male + $teacher_male;
                                      $total_female += $total_visitor_female + $teacher_female;
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
                  <?php } ?>

                  <?php
                  $check_event2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM attendance WHERE class = 1 AND date = '$date'"));
                  if ($check_event2 > 0) {
                    $event_available = 1;
                    $table += 1;
                    ?>
                              <?php
                              $elementary_query = mysqli_query($conn, "SELECT * FROM `service_attd` WHERE `class` = 1 AND `event_date` = '$date'");
                              // echo $elementary_query;
                              if (mysqli_num_rows($elementary_query) > 0) {
                                $elementary = mysqli_fetch_array($elementary_query);
                                $elementary_teacher_male = $elementary['worker_m'];
                                $elementary_teacher_female = $elementary['worker_f'];
                                $elementary_visitor_male = $elementary['total_visitor_m'];
                                $elementary_visitor_female = $elementary['total_visitor_f'];

                                $elementary_male = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(brethren) FROM sun_sch_attd WHERE class = 1 AND event_date = '$date' AND gender = 'male'"))[0];
                                $elementary_female = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(brethren) FROM sun_sch_attd WHERE class = 1 AND event_date = '$date' AND gender = 'female'"))[0];
                                $elementary_male += $elementary_visitor_male;
                                $elementary_female += $elementary_visitor_female;

                                $total_elementary = $elementary_male + $elementary_female;
                                $total_elementary_teacher = $elementary_teacher_male + $elementary_teacher_female;

                                $total_male = $elementary_male + $elementary_teacher_male;
                                $total_female = $elementary_female + $elementary_teacher_female;
                                $grand_total = $total_male + $total_female;
                              } else {
                                $elementary_teacher_male = 0;
                                $elementary_teacher_female = 0;

                                $total_elementary = 0;
                                $total_elementary_teacher = 0;

                                $elementary_male = 0;
                                $elementary_female = 0;

                                $total_male = 0;
                                $total_female = 0;
                                $grand_total = 0;
                              }
                              ?>
                              <div class="col-lg-12 grid-margin" id="attendance-table<?php echo $table ?>">
                                <h4 class="card-title mb-2 bg-primary text-white py-2" style="text-align: center;">Children's Service</h4>
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
                                      <tr>
                                        <td>Teachers</td>
                                        <td><?php echo $elementary_teacher_male ?></td>
                                        <td><?php echo $elementary_teacher_female ?></td>
                                        <td><?php echo $total_elementary_teacher ?></td>
                                      </tr>
                                      <tr>
                                        <td>Children</td>
                                        <td><?php echo $elementary_male ?></td>
                                        <td><?php echo $elementary_female ?></td>
                                        <td><?php echo $total_elementary ?></td>
                                      </tr>
                                      <tr class="table-success">
                                        <td>Grand Total</td>
                                        <td><?php echo $total_male ?></td>
                                        <td><?php echo $total_female ?></td>
                                        <td><?php echo $grand_total ?></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                    <?php } ?>

                    <?php
                    while ($service = mysqli_fetch_array($service_query)) {
                      $service_id = $service['id'];

                      $check_event3 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM attendance WHERE service = $service_id AND date = '$date'"));
                      if ($check_event3 > 0) {
                        $event_available = 1;
                        $table += 1;

                        $service_data_query = mysqli_query($conn, "SELECT * FROM `service_attd` WHERE `service` = $service_id AND `event_date` = '$date'");
                        if (mysqli_num_rows($service_data_query) > 0) {
                          $service_data = mysqli_fetch_array($service_data_query);

                          $worker_m = $service_data['worker_m'];
                          $worker_f = $service_data['worker_f'];

                          $adult_m = $service_data['total_adult_m'];
                          $adult_f = $service_data['total_adult_f'];

                          $children_m = $service_data['total_children_m'];
                          $children_f = $service_data['total_children_f'];

                          $visitor_m = $service_data['total_visitor_m'];
                          $visitor_f = $service_data['total_visitor_f'];
                        } else {
                          $worker_m = 0;
                          $worker_f = 0;

                          $adult_m = 0;
                          $adult_f = 0;

                          $children_m = 0;
                          $children_f = 0;

                          $visitor_m = 0;
                          $visitor_f = 0;

                        }

                        $total_worker = $worker_m + $worker_f;
                        $total_adult = $adult_m + $adult_f;
                        $total_children = $children_m + $children_f;
                        $total_visitor = $visitor_m + $visitor_f;

                        $total_male = $worker_m + $adult_m + $children_m + $visitor_m;
                        $total_female = $worker_f + $adult_f + $children_f + $visitor_f;
                        $grand_total = $total_male + $total_female;
                        ?>
                                      <div class="col-lg-12 grid-margin" id="attendance-table<?php echo $table ?>">
                                        <h4 class="card-title mb-2 bg-primary text-white py-2" style="text-align: center;"><?php echo $service['name'] ?></h4>
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
                                              <tr>
                                                <td>Workers</td>
                                                <td><?php echo $worker_m ?></td>
                                                <td><?php echo $worker_f ?></td>
                                                <td><?php echo $total_worker ?></td>
                                              </tr>
                                              <tr>
                                                <td>Adults</td>
                                                <td><?php echo $adult_m ?></td>
                                                <td><?php echo $adult_f ?></td>
                                                <td><?php echo $total_adult ?></td>
                                              </tr>
                                              <tr>
                                                <td>Children</td>
                                                <td><?php echo $children_m ?></td>
                                                <td><?php echo $children_f ?></td>
                                                <td><?php echo $total_children ?></td>
                                              </tr>
                                              <tr>
                                                <td>Visitors</td>
                                                <td><?php echo $visitor_m ?></td>
                                                <td><?php echo $visitor_f ?></td>
                                                <td><?php echo $total_visitor ?></td>
                                              </tr>
                                              <tr class="table-success">
                                                <td>Grand Total</td>
                                                <td><?php echo $total_male ?></td>
                                                <td><?php echo $total_female ?></td>
                                                <td><?php echo $grand_total ?></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>
                      
                            <?php }
                    } ?>
                  
                  <?php
                  if ($event_available == 0) {
                    ?>
                          <div class="col-lg-12 grid-margin" id="table1">
                            <h4 class="card-title mb-2 bg-danger text-white py-2" style="text-align: center;">No Service Recorded on <?php echo $date ?></h4>
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
      report.document.write('<h3>ATTENDANCE: <?php echo $date ?></h3>');
      for (i = 1; i <= <?php echo $table ?>; i++) {
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
