<?php
session_start();
include('config.php');

$user_id = $_SESSION['id'];
$event_date = $_POST['date'];
$name = $_POST['name'];

$classes = '';
if (count($_POST['classes']) > 1) {
  
  foreach ($_POST['classes'] as $class_id) {
    $combine_class_check = mysqli_query($conn, "SELECT * FROM combine_class WHERE event_date = '$event_date' AND classes LIKE '%$class_id%'");
    if (mysqli_num_rows($combine_class_check) > 0) {
      $error = 1;
    }
    $classes .= $class_id . ',';
  }
  
  $class = explode(',', $classes);
  array_pop($class);
  $classes = implode(',', $class);
  
  echo $error;
  if ($error == 1) {
    header("Location: ../sun_sch_attd.php?date=$event_date&err1");
  } else {
    $query = "INSERT INTO combine_class (name, classes, event_date, created_by) 
      VALUES ('$name', '$classes', '$event_date', $user_id)";
    
    if (mysqli_query($conn, $query)) {
      $combine_id = mysqli_insert_id($conn);
      
      foreach ($class as $class_id) {
        mysqli_query($conn, "UPDATE attendance SET combine_class = '$combine_id' WHERE class = $class_id AND date = '$event_date'");
        mysqli_query($conn, "UPDATE service_attd SET combine_class = '$combine_id' WHERE class = $class_id AND event_date = '$event_date'");
        mysqli_query($conn, "UPDATE sun_sch_attd SET combine_class = '$combine_id' WHERE class = $class_id AND event_date = '$event_date'");
      }
      header("Location: ../sun_sch_attd.php?date=$event_date&combined");
    }
  }
  
} else {
  header("Location: ../sun_sch_attd.php?date=$event_date&err2");
}

?>