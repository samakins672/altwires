<?php
session_start();
include('config.php');

$id = $_SESSION['id'];
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = md5($_POST['password']);
$role = $_POST['role'];

if ($_FILES['picture']['name'] == '') {
  // echo "empty";
  $picture = 'user.jpg';
} else {
  // echo "available";
  $picture = $_FILES['picture']['name'];
  $tempname = $_FILES['picture']['tmp_name'];
  $extension = pathinfo($picture, PATHINFO_EXTENSION);
  $picture = "user" . time() . "." . $extension;
  $destination = "../assets/images/admins/{$picture}";

  move_uploaded_file($tempname, $destination);
}

if (isset($_POST['submit-user'])) {

  mysqli_query($conn, "INSERT INTO user (name, email, phone,picture, password, status, role, created_by) 
    VALUES ('$name', '$email', '$phone', '$picture', '$password', 'active', '$role', $id)");
  if (mysqli_affected_rows($conn) < 0) {
    header('Location: ../new_user.php?err1');
  } else {
    header('Location: ../users.php?new');
  }
}

if (isset($_POST['edit-user'])) {
  
}

?>