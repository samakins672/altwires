<?php
session_start();
include('php/config.php');
include('php/page-config.php');

if (isset($_GET['id'])) {
  $member_id = $_GET['id'];
}

$brethren_query = mysqli_query($conn, "SELECT * FROM brethren WHERE id = $member_id");
$member = mysqli_fetch_array($brethren_query);

$role_id = $member['role'];
$role = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM role WHERE id = '$role_id'"))['name'];

$branch_id = $member['branch'];
$branch = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM branch WHERE id = '$branch_id'"))['name'];

$class_id = $member['class'];
$class = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM class WHERE id = '$class_id'"))['name'];

$h_alert = 'd-none';
if (isset($_GET['edited'])) {
  $alert = "Member's information Edited Successfully!";
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
          <h6 class="mb-0">Youth Db</h6>
          <i class="typcn typcn-chevron-right"></i>
          <p class="mb-0">Brethren</p>
          <i class="typcn typcn-chevron-right"></i>
          <p class="mb-0"><?php echo $role ?></p>
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
          <div class="col-md-10 col-sm-12 mx-auto">
              <div class="card">
                <div class="card-header">
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <h4 class="card-title m-auto"><?php echo strtoupper($member['name']) ?></h4>
                      <p class="text-gray mb-0">
                        <?php echo $role ?>
                      </p>
                    </div>
                    <div class="col-md-6">
                      <div class="d-flex align-items-right">
                        <button class="btn btn-primary btn-sm ml-auto btn-icon-text">
                          <a href="individual_edit.php?id=<?php echo $member_id ?>" class="text-light">
                          <i class="typcn typcn-edit btn-icon-prepend"></i> Edit</a>
                        </button>
                        <?php if ($member['status'] == 'active'): ?>
                          <button id="status" type="button" class="ml-1 btn btn-danger btn-sm"onclick="changeStatus(this.id)">Deactivate
                        <?php else: ?>
                          <button id="status" type="button" class="ml-1 btn btn-success btn-sm"onclick="changeStatus(this.id)">Activate
                        <?php endif; ?>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mb-4">
                    <div class="col-md-6">
                      <img style="width: 120px; height: 120px; object-fit: cover;" class="mb-none" src="assets/images/members/<?php echo $member['picture'] ?>" alt="<?php echo $member['name'] ?> Picture" />
                    </div>
                    <div class="col-md-6">
                      <address>
                        <p class="font-weight-bold">
                          Phone Number
                        </p>
                        <p class="mb-2 text-primary">
                          <?php echo $member['phone'] ?>
                        </p>
                        <p class="font-weight-bold">
                          E-mail
                        </p>
                        <p class="mb-2 text-primary">
                          <?php echo $member['email'] ?>
                        </p>
                      </address>
                    </div>  
                    <div class="col-md-6">
                      <address>
                        <p class="font-weight-bold">
                          Branch
                        </p>
                        <p class="mb-2">
                          <?php echo $branch ?>.
                        </p>
                      </address>
                    </div>
                    <div class="col-md-6">
                      <address>
                        <p class="font-weight-bold">
                          Address
                        </p>
                        <p class="mb-2">
                          <?php echo $member['address'] ?>.
                        </p>
                      </address>
                    </div>
                    <div class="col-sm-6">
                      <address>
                        <p class="font-weight-bold">
                          Place of Origin
                        </p>
                        <p class="mb-2">
                          <?php echo $member['origin_state'] . ', ' . $member['origin_country']; ?>.
                        </p>
                      </address>
                    </div>
                    <div class="col-sm-6">
                        <p class="font-weight-bold">
                          Date of Birth
                        </p>
                        <p class="mb-2">
                          <?php echo $member['dob'] ?>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="font-weight-bold">
                          Gender
                        </p>
                        <p class="mb-2">
                          <?php echo $member['gender'] ?>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="font-weight-bold">
                          Marital Status
                        </p>
                        <p class="mb-2">
                          <?php echo $member['marital_status'] ?>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="font-weight-bold">
                          Occupation
                        </p>
                        <p class="mb-2">
                          <?php echo $member['occupation'] ?>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="font-weight-bold">
                          Qualification
                        </p>
                        <p class="mb-2">
                          <?php echo $member['qualification'] ?>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="font-weight-bold">
                          Class
                        </p>
                        <p class="mb-2 font-weight-bold text-primary">
                          --- <?php echo $class ?> ---
                        </p>
                    </div>
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

  <!-- Status Change jQuery Code -->
    <script>
        function changeStatus(id) {
          if (document.getElementById(id).innerHTML == 'Deactivate') {
            document.getElementById(id).innerHTML = 'Activate';
            document.getElementById(id).classList.remove('btn-danger');
            document.getElementById(id).classList.add('btn-success');
            action = 'inactive';
          } else {
            document.getElementById(id).innerHTML = 'Deactivate';
            document.getElementById(id).classList.remove('btn-success');
            document.getElementById(id).classList.add('btn-danger');
            action = 'active';
          }

          $.ajax({
            type: "POST",
            url: "php/manage_member.php",
            data: {
              manage: '1',
              member: <?php echo $member_id ?>,
              action: action
            }
          });
        }
    </script>

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