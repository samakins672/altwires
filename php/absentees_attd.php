<?php
session_start();
include('config.php');

$total_brethren = 0;
$user_id = $_SESSION['id'];

$date = $_POST['date'];
$members = $_POST['member_id'];
$service = $_POST['service'];

mysqli_query($conn, "DELETE FROM absentee WHERE service = $service AND date = '$date'");
mysqli_query($conn, "DELETE FROM absentee_attd WHERE service = $service AND event_date = '$date'");

foreach ($members as $member) {
  $gender = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM brethren WHERE id = $member"))['gender'];
  mysqli_query($conn, "INSERT INTO absentee_attd (brethren, gender, service, event_date)
      VALUES ($member, '$gender', $service, '$date')");
  $total_brethren++;
}

mysqli_query($conn, "INSERT INTO absentee (service, created_by, date, total)
  VALUES ($service, $user_id, '$date', $total_brethren)");

header("Location: ../absentees.php?date=$date&success");
?>