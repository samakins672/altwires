<?php
session_start();
include('config.php');

$user_id = $_SESSION['id'];
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$gender = $_POST['gender'];
$marital_status = $_POST['marital_status'];
$dob = $_POST['dob'];
$origin_state = mysqli_real_escape_string($conn, $_POST['state']);
$origin_country = $_POST['country'];
$class = $_POST['class'];
$role = $_POST['role'];
$qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
$occupation = mysqli_real_escape_string($conn, $_POST['occupation']);

if ($_FILES['picture']['name'] == '') {

  if (isset($_POST['submit-member'])) {
    $picture = 'user.jpg';
  } elseif (isset($_POST['edit-member'])) {
    $member_id = $_POST['member_id'];
    $picture = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM brethren WHERE id = $member_id"))['picture'];
  }

} else {
  $picture = $_FILES['picture']['name'];
  $tempname = $_FILES['picture']['tmp_name'];
  $extension = pathinfo($picture, PATHINFO_EXTENSION);
  $picture = "member".time(). "." . $extension;
  $destination = "../assets/images/members/{$picture}";

  if (isset($_POST['edit-member'])) {
    $member_id = $_POST['member_id'];
    $last_picture = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM brethren WHERE id = $member_id"))['picture'];
    if ($last_picture !== 'user.jpg') {
      unlink("../assets/images/members/{$last_picture}");
    }
  }
  move_uploaded_file($tempname, $destination);
}

if (isset($_POST['submit-member'])) {
  mysqli_query($conn, "INSERT INTO brethren (name,	email,	phone,	address,	gender,	marital_status,	dob,	origin_state,	origin_country,	picture,	class,	role,	qualification,	occupation, added_by) 
    VALUES ('$name', '$email', '$phone', '$address', '$gender', '$marital_status',	'$dob', '$origin_state', '$origin_country',	'$picture',	$class,	$role, '$qualification', '$occupation', $user_id)");
  if (mysqli_affected_rows($conn) < 0) {
    header('Location: ../new_member.php?err1');
  } else {
    if ($_SESSION['role'] == 'user') {
      header('Location: ../new_member.php?new');
    } else {
      header('Location: ../brethren.php?new');
    }
  }
}

if (isset($_POST['edit-member'])) {
  mysqli_query($conn, "UPDATE brethren SET name = '$name', 	email = '$email',	phone = '$phone',	address = '$address',	
    gender = '$gender',	marital_status = '$marital_status',	dob = '$dob',	
    origin_state = '$origin_state',	origin_country = '$origin_country',	
    picture = '$picture',	class = $class,	role = $role,	qualification = '$qualification',	
    occupation = '$occupation', added_by = $user_id WHERE id = $member_id");

  if (mysqli_affected_rows($conn) < 0) {
    header("Location: ../individual_edit.php?id=$member_id&err1");
  } else {
    header("Location: ../individual_view.php?id=$member_id&edited");
  }
}

?>