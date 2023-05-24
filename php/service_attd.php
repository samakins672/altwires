<?php
include('config.php');
session_start();

if (isset($_POST['submit-attd'])) {
  $user_id = $_SESSION['id'];
  $date = $_POST['date'];
  $service_id = $_POST['service_id'];

  $children_m = $_POST['children_m'];
  $children_f = $_POST['children_f'];
  $adult_m = $_POST['adult_m'];
  $adult_f = $_POST['adult_f'];
  $worker_m = $_POST['worker_m'];
  $worker_f = $_POST['worker_f'];
  $visitor_m = $_POST['visitor_m'];
  $visitor_f = $_POST['visitor_f'];

  $sum = $children_m + $children_f + $adult_m + $adult_f + $worker_m + $worker_f + $visitor_m + $visitor_f;

  $query = mysqli_query($conn, "SELECT * FROM attendance WHERE service = $service_id AND date = '$date'");
  if (mysqli_num_rows($query)) {

    mysqli_query($conn, "UPDATE attendance SET user = $user_id, total = $sum WHERE service = $service_id AND date = '$date'");

    mysqli_query($conn, "UPDATE service_attd SET total_children_m = $children_m, total_children_f = $children_f, total_adult_m = $adult_m, total_adult_f = $adult_f, worker_m = $worker_m, worker_f = $worker_f, total_visitor_m = $visitor_m, total_visitor_f = $visitor_f WHERE service = $service_id AND event_date = '$date'");
  } else {

    mysqli_query($conn, "INSERT INTO attendance (service, user, date, total)
    VALUES ($service_id, $user_id, '$date', $sum)");

    mysqli_query($conn, "INSERT INTO service_attd (service, total_children_m, total_children_f, total_adult_m, total_adult_f, worker_m, worker_f, total_visitor_m, total_visitor_f, event_date)
    VALUES ($service_id, $children_m, $children_f, $adult_m, $adult_f, $worker_m, $worker_f, $visitor_m, $visitor_f, '$date')");
  }
  
  header("Location: ../service_attd.php?type=$service_id&success");
}

mysqli_close($conn);

?>