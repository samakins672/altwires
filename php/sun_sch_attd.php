<?php
session_start();
include('config.php');

$user_id = $_SESSION['id'];
$date = $_POST['date'];
$teacher_m = $_POST['teacher_m'];
$teacher_f = $_POST['teacher_f'];
$visitor_m = $_POST['visitor_m'];
$visitor_f = $_POST['visitor_f'];
$members = $_POST['member_id'];
$total_brethren = 0;

if (isset($_POST['class'])) {
  $class = $_POST['class'];

  mysqli_query($conn, "DELETE FROM sun_sch_attd WHERE class = $class AND event_date = '$date'");
  mysqli_query($conn, "DELETE FROM attendance WHERE class = $class AND date = '$date'");
  mysqli_query($conn, "DELETE FROM service_attd WHERE class = $class AND event_date = '$date'");

  foreach ($members as $member) {
    $gender = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM brethren WHERE id = $member"))['gender'];
    mysqli_query($conn, "INSERT INTO sun_sch_attd (brethren, gender, class, event_date)
      VALUES ($member, '$gender', $class, '$date')");
    $total_brethren++;
  }
  $total_brethren = $total_brethren + $visitor_m + $visitor_f + $teacher_m + $teacher_f;

  mysqli_query($conn, "INSERT INTO attendance (service, class, user, date, total)
    VALUES (1, $class, $user_id, '$date', $total_brethren)");

  mysqli_query($conn, "INSERT INTO service_attd (service, class, worker_m, worker_f, total_visitor_m,	total_visitor_f, event_date)
    VALUES (1, $class,$teacher_m, $teacher_f, $visitor_m, $visitor_f, '$date')");
} else {
  $combine_class = $_POST['combine_class'];
  
  mysqli_query($conn, "DELETE FROM sun_sch_attd WHERE combine_class = $combine_class AND event_date = '$date'");
  mysqli_query($conn, "DELETE FROM attendance WHERE combine_class = $combine_class AND date = '$date'");
  mysqli_query($conn, "DELETE FROM service_attd WHERE combine_class = $combine_class AND event_date = '$date'");

  foreach ($members as $member) {
    $mem_q = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM brethren WHERE id = $member"));
    $gender = $mem_q['gender'];
    $class = $mem_q['class'];

    mysqli_query($conn, "INSERT INTO sun_sch_attd (brethren, gender, class, combine_class, event_date)
      VALUES ($member, '$gender', $class, $combine_class, '$date')");
    $total_brethren++;
  }
  $total_brethren = $total_brethren + $visitor_m + $visitor_f + $teacher_m + $teacher_f;

  mysqli_query($conn, "INSERT INTO attendance (service, combine_class, user, date, total)
    VALUES (1, $combine_class, $user_id, '$date', $total_brethren)");

  mysqli_query($conn, "INSERT INTO service_attd (service, combine_class, worker_m, worker_f, total_visitor_m,	total_visitor_f, event_date)
    VALUES (1, $combine_class, $teacher_m, $teacher_f, $visitor_m, $visitor_f, '$date')");

}

header("Location: ../sun_sch_attd.php?date=$date&success");


?>