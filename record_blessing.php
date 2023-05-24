<?php
session_start();
include('php/config.php');
include('php/page-config.php');

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
              <p class="mb-0">Record of Blessing</p>
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
            <div class="col-12 m-auto stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Record of Blessing</h4>
                  <!-- <p class="card-description">
                    Basic form elements
                  </p> -->
                  <form class="forms-sample">
                    <div class="form-group row">
                      <div class="col-md-6 row mb-2">
                        <label for="other_blessing" class="col-4 col-md-3 pt-2">Meeting</label>
                        <div class="col-8">
                          <select id="meeting" class="js-example-basic-single col-10" onchange="checkMeeting(this.id, this.value)">
                          <?php
                          $service_query = mysqli_query($conn, "SELECT * FROM service WHERE id != 1 AND status = 'active'");
                          while ($service = mysqli_fetch_array($service_query)) {
                            ?>
                                  <option value="<?php echo $service['id'] ?>"><?php echo $service['name'] ?></option>
                              <?php } ?>
                              <option value="0">New Meeting</option>
                          </select>
                        </div>
                        <div id="new-meeting" class="col-sm-12 d-none mt-2">
                          <input type="text" class="form-control form-control-sm" name="new_meeting" placeholder="Meeting Name">
                        </div>
                      </div>
                      <div class="col-md-6 row">
                        <label for="event_date" class="col-5 col-md-4 pt-2">Event Date</label>
                        <input type="date" class="form-control form-control-sm col-6" id="event_date" value="<?php echo $date ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="other_blessing" class="col-sm-2 pt-2">Name</label>
                        <div class="col-sm-10">
                          <select id="member" class="js-example-basic-single col-sm-12 col-md-6" onchange="checkMeeting(this.id, this.value)">
                          <?php
                          $brethren_query = mysqli_query($conn, "SELECT * FROM brethren WHERE status = 'active'");
                          while ($brethren = mysqli_fetch_array($brethren_query)) {
                            ?>
                                  <option value="<?php echo $brethren['id'] ?>"><?php echo $brethren['name'] ?></option>
                              <?php } ?>
                              <option value="0">New Member</option>
                          </select>
                        </div>
                        <div id="new-member" class="col-sm-12 row d-none mt-2">
                          <input type="text" class="form-control form-control-sm col-12 col-md-6 mr-4 mb-3" name="new_member" placeholder="Member's Name">
                          <input type="number" class="form-control form-control-sm col-12  col-md-4 mb-3" name="number" placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="form-group row">
                      <label for="gender" class="col-sm-2" id="gender">Gender</label>
                      <div class="col-sm-10 row">
                      <div class="form-check col-4 col-md-3 pr-0">
                        <label class="form-check-label d-inline">
                          <input type="radio" class="form-check-input" name="gender" value="M">
                          Male
                        <i class="input-helper"></i></label>
                      </div>
                      <div class="form-check col-4 col-md-3 pr-0">
                        <label class="form-check-label d-inline">
                          <input type="radio" class="form-check-input" name="gender" value="F" checked="">
                          Female
                        <i class="input-helper"></i></label>
                      </div>
                      </div>
                    </div>
                    <!-- <div class="form-group row">
                      <label for="age" class="col-sm-2">Age</label>
                      <div class="col-sm-12 row">
                        ?php
                        // $age_query = mysqli_query($conn, "SELECT * FROM age_range WHERE status = 'active'");
                        // while ($age = mysqli_fetch_array($age_query)) {
                        //   $age_range = $age['age_from'] . ' - ' . $age['age_to'];
                        
                        //   if ($age['age_to'] == 'above' || $age['age_to'] == 'upward') {
                        //     $age_range = '> ' . $age['age_from'];
                        //   }
                        ?>
                            <div class="form-check col-4 col-md-3 pr-0">
                              <label class="form-check-label mb-0">
                                <input type="radio" class="form-check-input" name="age" value="?php //echo $age['id'] ?>">
                                ?php //echo $age_range; ?>
                                <i class="input-helper m-0"></i></label>
                              </div>
                        ?php //} ?>
                      </div>
                    </div> -->
                    <div class="form-group row">
                      <label for="blessing" class="col-sm-2">Blessings</label>
                      <div class="col-12 row">
                        <?php
                        $blessing_id = 0;
                        $blessing_query = mysqli_query($conn, "SELECT * FROM blessing WHERE status = 'active' ORDER BY id");
                        while ($blessing = mysqli_fetch_array($blessing_query)) {
                          $blessing_id += 1;
                          ?>
                                <div class="form-check col-6 col-md-4 pr-0">
                                  <label class="form-check-label mb-0">
                                    <input type="checkbox" class="form-check-input" name="blessing<?php echo $blessing_id ?>" value="<?php echo $blessing['id'] ?>">
                                    <?php echo $blessing['name']; ?>
                                    <i class="input-helper m-0"></i>
                                  </label>
                               </div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="other_blessing" class="col-md-2">Others (Optional)</label>
                      <input type="text" class="form-control form-control-sm col-md-10" id="other_blessing" placeholder="Separate with commas">
                    </div>
                    <button id="addRecord" type="button" class="btn btn-sm btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-sm btn-light">Reset</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-12 m-auto stretch-card">
              <div class="card">
                  <div class="card-header">
                      <div id="result" class="text-center">
                          Blessing Status Display...
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
  <script src="js/jquery-3.6.4.min.js"></script>
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
  <!-- Js for adding new meeting-->
  <script>
    $("#addRecord").click(function(){
      var meeting_id = $('#meeting').val();
      var member_id = $('#member').val();
      var event_date = $('#event_date').val();
      var new_meeting = $.trim($('input[name=new_meeting]').val());
      var new_member = $.trim($('input[name=new_member]').val());
      var number = $.trim($('input[name=number]').val());
      var gender = $.trim($('input[name=gender]:radio:checked').val());
      var age = $.trim($('input[name=age]:radio:checked').val());

      blessing = new Array();
      for (i = 1; i <= <?php echo $blessing_id ?>; i++) {
        each_blessing = $.trim($('input[name=blessing'+i+']:checkbox:checked').val());
        if (each_blessing !== '') {
          blessing.push(each_blessing);
        }
      }

      if (blessing.length < 1) {
        blessing = 0;
      }
      var other_blessing = $('#other_blessing').val();

      $.ajax({
        type: "POST",
        url: "php/add_record.php",
        data: {
          meeting: meeting_id,
          member: member_id,
          new_meeting: new_meeting,
          new_member: new_member,
          number: number,
          event_date: event_date,
          gender: gender,
          age: age,
          blessing: blessing,
          other_blessing: other_blessing
        }
      })
      .done(function (msg) {
        $('#result').html(msg);
      });
    });
  </script>
  <!-- Js for adding new meeting-->
  <script>
    function checkMeeting(id, val) {
      if (val == 0) {
        document.getElementById('new-'+id).classList.remove('d-none');
      } else {
        document.getElementById('new-'+id).classList.add('d-none');
      }
    }
  </script>

  <script src="js/file-upload.js"></script>
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
  <!-- End custom js </body> for this page-->
</body>

</html>