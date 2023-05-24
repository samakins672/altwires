<?php
session_start();
include('php/config.php');

$message = 'New Here?';
$color = '';

if (isset($_GET['err1'])) {
  $message = 'Code Submitted is invalid, please try again!';
  $color = 'text-danger';
}

if (isset($_GET['err2'])) {
  $message = 'Registration unsuccessful, please try again!';
  $color = 'text-danger';
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- partial:partials/_head.php -->
<?php include('partials/_head.php') ?>
<!-- partial -->

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-6 mx-auto">
            <div class="auth-form-light text-center py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="images/afm-attendance-logo.png" alt="logo">
              </div>
              <h4 class="<?php echo $color ?>"><?php echo $message ?></h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form action="php/login.php" enctype="multipart/form-data" method="post" class="forms-sample pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="name" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="phone" placeholder="Phone Number" required>
                </div>
                <div class="form-group">
                  <input type="file" accept="image/*" name="picture" class="file-upload-default"/>
                  <div class="input-group">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image (Optional)"/>
                    <span class="input-group-append">
                      <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="code" placeholder="Sign Up code" required>
                </div>
                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input" required>
                      I agree to all <i class="input-helper"></i> <a href="#" class="text-primary">Terms &amp; Conditions</a>
                    </label>
                  </div>
                </div>
                <div class="mt-3">
                  <button name="register" type="submit"  class="btn btn-block btn-primary btn-sm font-weight-large auth-form-btn">SIGN IN</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
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
  <!-- Custom js for this page-->
  <script src="js/file-upload.js"></script>
  <!-- End custom js </body> for this page-->
</body>

</html>