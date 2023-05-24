<?php
session_start();
$day = date('w');
$_SESSION['day'] = jddayofweek($day - 1, 1);
$message = 'Happy '.$_SESSION['day'];
$color = '';

if(isset($_GET['logout'])) {
  session_destroy();
  $message = 'You\'re blessed';
}

if (isset($_GET['err1'])) {
  $message = 'Invalid login details';
  $color = 'text-danger';
}

if (isset($_GET['err2'])) {
  $message = 'Oops! Your account is currently restricted!';
  $color = 'text-danger';
}

if (isset($_GET['new'])) {
  $message = 'Account Created!';
  $color = 'text-success';
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
              <h4 class="<?php echo $color ?>"><?php echo $message?>!</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form action="php/login.php" method="post" class="pt-3">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button name="login" type="submit" class="btn btn-block btn-primary btn-sm font-weight-large auth-form-btn">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <!-- <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div> --> <br>
                  <a href="#" class="auth-link text-black text-primary">Forgot password?</a>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.php" class="text-primary">Create</a>
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
  <!-- End custom js </body> for this page-->
</body>

</html>
