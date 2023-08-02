<?php
session_start();
include('config.php');

if (isset($_POST['manage'])) {
  $status = $_POST['action'];
  $id_ = $_POST['member'];

  mysqli_query($conn, "UPDATE brethren SET status = '$status' WHERE id = $id_");
}

?>