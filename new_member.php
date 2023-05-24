<?php
session_start();
include('php/config.php');
include('php/page-config.php');
$h_alert = 'd-none';

$role_query = mysqli_query($conn, "SELECT * FROM role WHERE status = 'active'");
$class_query = mysqli_query($conn, "SELECT * FROM class WHERE status = 'active'");

if (isset($_GET['new'])) {
  $alert = "A Member Has Been Uploaded Successfully!";
  $h_alert = 'text-success';
}
if (isset($_GET['err'])) {
  $alert = "Upload Unsuccessful, Please try again!";
  $h_alert = 'text-danger';
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
    <!-- partial -->
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
            <div class="col-12 m-auto stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">
                    Member's Form
                  </h4>
                  <form action="php/new_member.php" enctype="multipart/form-data" method="post" class="forms-sample">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label for="phone">Phone Number</label>
                      <input type="text" class="form-control" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input type="email" class="form-control" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <label for="address">Home address</label>
                      <input type="text" class="form-control" name="address" placeholder="Address">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3" for="gender">Gender</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="gender">
                              <option value="male">Male</option>
                              <option value="female">Female</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3" for="marital_status">Marital Status</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="marital_status">
                              <option value="single">Single</option>
                              <option value="married">Married</option>
                              <option value="widow">Widow</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="dob">Date of Birth</label>
                      <input type="date" class="form-control" name="dob">
                    </div>
                    <p class="card-description">
                      Place of Origin
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <input name="state" type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country</label>
                          <div class="col-sm-9">
                            <select name="country" class="form-control">
                              <!-- partial:partials/_countries-list.php -->
                              <?php include('partials/_countries-list.php') ?>
                              <!-- partial -->
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Passport Photograph</label>
                      <input type="file" accept="image/*" name="picture" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="occupation">Occupation</label>
                      <input type="text" class="form-control" name="occupation" placeholder="Occupation">
                    </div>
                    <div class="form-group">
                      <label for="qualification">Qualification</label>
                      <input type="text" class="form-control" name="qualification" placeholder="Qualification">
                    </div>
                    <div class="form-group">
                      <label for="role">Role in Church</label>
                      <select class="form-control" name="role">
                        <?php while ($roles = mysqli_fetch_array($role_query)) { ?>
                          <option <?php if ($roles['name'] == 'member') {
                            echo 'selected';
                          } ?> 
                            value="<?php echo $roles['id'] ?>">
                            <?php echo $roles['name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="class">Sunday Class</label>
                      <select class="form-control" name="class">
                        <?php while ($class = mysqli_fetch_array($class_query)) { ?>
                          <option value="<?php echo $class['id'] ?>"><?php echo $class['name'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <button name="submit-member" type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
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
  <script src="js/select2.js"></script>
  <!-- End custom js </body> for this page-->
</body>

</html>