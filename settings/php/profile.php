<?php
include('../../php/config.php');
session_start();
$id = $_SESSION['id'];

if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  
  mysqli_query($conn, "UPDATE user SET name = '$name', email = '$email', phone = '$phone' WHERE id = $id");
  $_SESSION['name'] = $name;
}

$user_query = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
$user = mysqli_fetch_array($user_query);

?>
<div class="card-header row mx-0">
  <h5 class="text-titlecase my-auto">My Profile</h5>
  <button id="edit" type="button" class="btn btn-primary btn-sm btn-icon-text ml-auto" onclick="hideInput(this.id)">                    
    <i class="typcn typcn-edit text-light btn-icon-prepend"></i> Edit
  </button>
  <button id="cancel" type="button" class="btn btn-danger btn-sm btn-icon-text ml-auto d-none" onclick="hideInput(this.id)">                    
    <i class="typcn typcn-times text-light btn-icon-prepend"></i> Cancel
  </button>
</div>
<div class="card-body">
    <form class="row font-weight-bold" method="post">
      <div class="col-sm-4 mb-3">
        <figure class="avatar mx-auto mb-4 mb-md-0">
          <img src="../assets/images/admins/<?php echo $user['picture'] ?>" alt="<?php echo $user['name'] ?>" class="w-50 h-50" style="border-radius: 10px;">
          <button id="change_pic" type="button" class="btn btn-white btn-rounded btn-icon ml-2 input" style="display: none;" onclick="newPage(this.id)">                    
            <i class="typcn typcn-edit text-secondary"></i>
          </button>
        </figure>
      </div>
      <div class="col-sm-8">
        <p>
          Name:
        </p>
        <p class="mb-2">
          <p class="output text-primary">
            <?php echo $user['name'] ?>
          </p>
          <input type="text" class="form-control form-control-sm input" id="name" value="<?php echo $user['name'] ?>" style="display: none;" required>
        </p>
        <p>
          Email:
        </p>
        <p class="mb-2">
          <p class="output text-primary">
            <?php echo $user['email'] ?>
          </p>
          <input type="email" class="form-control form-control-sm input" id="email" value="<?php echo $user['email'] ?>" style="display: none;" required>
        </p>
      </div>
      <div class="col-sm-6">
        <p class="font-weight-bold">
          Phone:
        </p>
        <p class="mb-2">
          <p class="output text-primary">
            <?php echo $user['phone'] ?>
          </p>
          <input type="text" class="form-control form-control-sm input" id="phone" value="<?php echo $user['phone'] ?>" style="display: none;" required>
        </p>
      </div>
      <div class="col-sm-6">
        <p class="text-white"> . </p>
        <button id="saveProfile" type="button" class="btn btn-success btn-sm btn-icon-text mt-auto input" style="display: none;" onclick="saveProf()">                    
          <i class="typcn typcn-document text-light btn-icon-prepend"></i> Save
        </button>
      </div>
    </form> 
    <form action="php/change_password.php" method="post" class="row font-weight-bold"> 
      <div class="col-sm-12">
        <hr>
        <p class="mb-3">
          <a id="password" href="javascript:;" class="text-danger" onclick="inputToggle(this.id)">
            Change Password
          </a>
          <div class="col-sm-6 mb-2">
            <input type="password" class="form-control form-control-sm passwordInput" name="curr_password" placeholder="Current Password" style="display: none;">
          </div>
          <div class="col-sm-6">
            <input type="password" class="form-control form-control-sm passwordInput mb-2" name="password" placeholder="New Password" style="display: none;">
            <button type="submit" class="btn btn-secondary btn-sm btn-icon-text mt-auto passwordInput" style="display: none;">                    
              <i class="typcn typcn-document text-light btn-icon-prepend"></i> Submit
            </button>
          </div>
        </p>
        <p>
          <a id="deactivate" href="javascript:;" class="mb-2 text-danger" onclick="inputToggle(this.id)">
            Deactivate Account
          </a>
          <div class="col-sm-6">
            <input type="text" class="form-control form-control-sm deactivateInput mb-2" id="pass" placeholder="Password" style="display: none;">
            <button type="button" class="btn btn-danger btn-sm btn-icon-text mt-auto deactivateInput" style="display: none;" onclick="deactivateAcct()">                    
              <i class="typcn typcn-close text-light btn-icon-prepend"></i> Deactivate
            </button>
          </div>
        </p>
      </div>
    </form> 
  </div>
</div>
