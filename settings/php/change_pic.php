<?php
include('../../php/config.php');
session_start();
$id = $_SESSION['id'];
if (isset($_POST['change_pic'])) {
  $picture = $_FILES['picture']['name'];
  $tempname = $_FILES['picture']['tmp_name'];
  $extension = pathinfo($picture, PATHINFO_EXTENSION);
  $picture = $_SESSION['role'] . time() . "." . $extension;
  $destination = "../../assets/images/admins/{$picture}";

  $last_picture = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE id = $id"))['picture'];
  if ($last_picture !== 'user.jpg') {
    unlink("../../assets/images/admins/{$last_picture}");
  }
  if(move_uploaded_file($tempname, $destination)) {
    mysqli_query($conn, "UPDATE user SET picture = '$picture' WHERE id = $id");
  
    header('Location: ../index.php?change_pic=success');
  } else {
    header('Location: ../index.php?change_pic=err');
  }

}

?>
<div class="card-header row mx-0">
  <h5 class="text-titlecase my-auto">Change Picture</h5>
  <button id="profile" type="button" class="btn btn-danger btn-sm btn-icon-text ml-auto" onclick="newPage(this.id)">                    
    <i class="typcn typcn-times text-light btn-icon-prepend"></i> Cancel
  </button>
</div>
<div class="card-body profile-card">
  <form action="php/change_pic.php" enctype="multipart/form-data" method="post">
  <div class="row">
      <div class="col-8 mx-auto">
        <div class="form-group input">
          <input type="file" accept="image/*" name="picture" class="file-upload-default">
          <div class="input-group col-xs-12">
            <input type="text" class="form-control form-control-sm file-upload-info show-filename" disabled placeholder="Upload Image">
            <span class="input-group-append">
              <button class="file-upload-browse btn btn-sm btn-primary" type="button" onclick="upload()">Upload</button>
            </span>
          </div>
        </div>
        
      </div>
      <div class="col-3 mb-3">
        <button id="submit" name="change_pic" type="submit" class="btn btn-success btn-sm btn-icon-text d-inline mx-auto">                    
          <i class="typcn typcn-document text-light btn-icon-prepend"></i> Save
        </button>
      </div>
    </div>
  </form>
</div>