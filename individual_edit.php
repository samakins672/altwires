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
$class_id = $member['class'];
$class = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM class WHERE id = '$class_id'"))['name'];
$role = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM role WHERE id = '$role_id'"))['name'];

$role_query = mysqli_query($conn, "SELECT * FROM role WHERE status = 'active' AND id != $role_id");
$class_query = mysqli_query($conn, "SELECT * FROM class WHERE status = 'active' AND id != $class_id");
$branch_query = mysqli_query($conn, "SELECT * FROM branch WHERE status = 'active'");

$h_alert = 'd-none';
if (isset($_GET['err1'])) {
  $alert = "Changes Not Saved, Please try again!";
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
                <div class="card-header">
                  <h4 class="card-title my-2">Edit Member's Information</h4>
                </div>
                <div class="card-body">
                  <form action="php/new_member.php" enctype="multipart/form-data" method="post" class="forms-sample">
                    <input type="hidden" name="member_id" value="<?php echo $member_id ?>">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3" for="name">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $member['name'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-5" for="phone">Phone Number</label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo $member['phone'] ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3" for="email">Email address</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $member['email'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-5" for="dob">Date of Birth</label>
                          <div class="col-sm-7">
                            <input type="date" class="form-control" name="dob" value="<?php echo $member['dob'] ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3" for="gender">Gender</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="gender">
                              <option <?php if ($member['gender'] == 'male') {
                                echo 'selected';
                              } ?> value="male">Male</option>
                              <option <?php if ($member['gender'] == 'female') {
                                echo 'selected';
                              } ?> value="female">Female</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-5" for="marital_status">Marital Status</label>
                          <div class="col-sm-7">
                            <select class="form-control" name="marital_status">
                              <option <?php if ($member['marital_status'] == 'single') {
                                echo 'selected';
                              } ?> value="single">Single</option>
                              <option <?php if ($member['marital_status'] == 'married') {
                                echo 'selected';
                              } ?> value="married">Married</option>
                              <option <?php if ($member['marital_status'] == 'widow') {
                                echo 'selected';
                              } ?> value="widow">Widow</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="card-description">
                      Place of Origin
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="branch">Branch</label>
                            <select name="branch" class="form-control">
                              <?php while ($branch = mysqli_fetch_array($branch_query)) { ?>
                                <option value="<?php echo $branch['id'] ?>"> <?php echo $branch['name'] ?></option>
                            <?php } ?>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="address">Home address</label>
                          <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $member['address'] ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <input name="state" type="text" class="form-control"  value="<?php echo $member['origin_state'] ?>"/>
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
                      <label>Passport Photograph <span class="text-danger"> (please ignore if you don't want to change the current picture)</span></label>
                      <input type="file" accept="image/*" name="picture" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-5" for="occupation">Occupation</label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" name="occupation" placeholder="Occupation" value="<?php echo $member['occupation'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-5" for="qualification">Qualification</label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" name="qualification" placeholder="Qualification" value="<?php echo $member['qualification'] ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-5" for="role">Role in Church</label>
                          <div class="col-sm-7">
                            <select class="form-control" name="role">
                              <option selected value="<?php echo $role_id ?>"> <?php echo $role ?></option>
                            <?php while ($roles = mysqli_fetch_array($role_query)) { ?>
                              <option value="<?php echo $roles['id'] ?>"> <?php echo $roles['name'] ?></option>
                            <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-5" for="class">Sunday Class</label>
                          <div class="col-sm-7">
                            <select class="form-control" name="class">
                              <option selected value="<?php echo $class_id ?>"><?php echo $class ?></option>
                              <?php while ($class = mysqli_fetch_array($class_query)) { ?>
                                  <option value="<?php echo $class['id'] ?>"><?php echo $class['name'] ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button name="edit-member" type="submit" class="btn btn-primary mr-2">Save</button>
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