<?php
session_start();
include('../php/config.php');
include('../php/page-config.php');

$h_alert = "d-none";
if (isset($_GET['password'])) {
  if ($_GET['password'] == 'success') {
    $alert = "Password Changed Successfully!";
    $h_alert = 'text-success';
  } else {
    $alert = "Current password invalid, Please try again!";
    $h_alert = 'text-danger';
  }
}
if (isset($_GET['change_pic'])) {
  if ($_GET['change_pic'] == 'success') {
    $alert = "Picture Changed Successfully!";
    $h_alert = 'text-success';
  } else {
    $alert = "Picture change unsuccessful, Please try again!";
    $h_alert = 'text-danger';
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
        <div class="col-8 d-flex align-items-center align-items-baseline my-auto">
          <h6 class="mb-0">Settings</h6>
          <i class="typcn typcn-chevron-right"></i>
          <p class="mb-0">Home</p>
        </div>
        <div class="input-group col-4">
          <input type="search" class="form-control form-control-sm" placeholder="Search..." aria-label="search"
            aria-describedby="search">
        </div>
    </nav> 
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.php -->
      <?php include('../partials/_settings-panel.php') ?>
      <!-- partial -->
      <!-- partial:partials/_sidebar.php -->
      <?php include('partials/_sidebar.php') ?>
      <!-- partial -->
      <div class="main-panel">
        <h4 class="alerts font-weight-bold <?php echo $h_alert ?>" style="text-align: center;">
          <?php echo $alert ?>
        </h4>
        <div class="content-wrapper">

          <div class="row">
            <div class="col-xl-12 stretch-card">
              <div id="main" class="card"></div> 
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
      <!-- partial:partials/_footer.php -->
      <footer class="footer col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright &copy; <?php echo date('Y') ?> ALTWIRES. All
                        rights reserved.</span>
                </div>
            </div>
        </div>
      </footer>
      <!-- partial -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../js/jquery-3.6.4.min.js"></script>
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script>
    $(document).ready(function() {
      $("#main").load("php/profile.php");
    });
    
    function hideInput(id){
      $(".input").toggle("fast");
      $(".output").toggle("fast");

      if (id == "edit") {
        $("#"+id).addClass("d-none");
        $("#cancel").removeClass("d-none");
      } else {
        $("#"+id).addClass("d-none");
        $("#edit").removeClass("d-none");
      }
    }

    function inputToggle(id){
      $("."+id+"Input").toggle("fast");
    }

    function upload() {
      var file = $('.file-upload-default');
      file.trigger('click');
      
      $('.file-upload-default').on('change', function() {
        $('.show-filename').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        var button = $('#form');
        button.trigger('submit');
      });
    }

    function newPage(id) {
      $(".alerts").hide();
      $("#main").load("php/"+id+".php");
    }

    function editPage(id) {
      $(".alerts").hide();
      $("#main").load("php/"+id);
    }
  </script>
  <!-- Script for sending profile data to php/profile.php for editing profile information -->
  <script>
    function saveProf() {
      var name = $('#name').val();
      var email = $('#email').val();
      var phone = $('#phone').val();

      $.ajax({
        type: "POST",
        url: "php/profile.php",
        data: {
          save: '1',
          name: name,
          email: email,
          phone: phone
        }
      })
      .done(function (msg) {
        $('#main').html(msg);
      });
    }

    function saveService() {
      var service_id = $('#service_id').val();
      var name = $('#name').val();
      var repeat = $('#repeat').val();
      var event_date = $('#event_date').val();
      if (repeat == 'weekly') {
        var repeat_day = $('#repeat_day').val();
      } else {
        var repeat_day = "-";
      }

      $.ajax({
        type: "POST",
        url: "php/manage_service.php",
        data: {
          save: '1',
          service_id: service_id,
          name: name,
          repeat: repeat,
          event_date: event_date,
          repeat_day: repeat_day
        }
      })
      .done(function (msg) {
        $('#main').html(msg);
      });
    }

    function saveUser() {
      var name = $('#name').val();
      var phone = $('#phone').val();
      var email = $('#email').val();
      var role = $('#role').val();
      var password = $('#password').val();

      $.ajax({
        type: "POST",
        url: "php/manage_user.php",
        data: {
          save: '1',
          name: name,
          phone: phone,
          email: email,
          role: role,
          password: password
        }
      })
      .done(function (msg) {
        $('#main').html(msg);
      });
    }

    function showDay(val) {
      if (val == "weekly") {
        document.getElementById('days').classList.remove('d-none');
      } else {
        document.getElementById('days').classList.add('d-none');
      }
    }
  </script>
  <script src="../js/dashboard.js"></script>
  <!-- End custom js </body> for this page-->
</body>

</html>