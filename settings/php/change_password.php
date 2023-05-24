<?php
include('../../php/config.php');
session_start();
$id = $_SESSION['id'];

if (isset($_POST['password'])) {
  $curr_password = md5($_POST['curr_password']);
  $chk_pass = mysqli_query($conn, "SELECT * FROM user WHERE password = '$curr_password' AND id = $id");
  
  if (mysqli_num_rows($chk_pass) == 1) {
    $password = md5($_POST['password']);
    mysqli_query($conn, "UPDATE user SET password = '$password' WHERE id = $id");
    
    header('Location: ../index.php?password=success');
  } else {
    header('Location: ../index.php?password=err');
  }
}
?>