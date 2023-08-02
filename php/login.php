<?php
include('config.php');
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = md5($_POST['password']);

if (isset($_POST['register'])) {
  $new_code = bin2hex(random_bytes(3));
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $code = mysqli_real_escape_string($conn, $_POST['code']);

  $query = mysqli_query($conn, "SELECT code FROM engine WHERE code = '$code'");
  if (mysqli_num_rows($query) == 1) {
    if ($_FILES['picture']['name'] == '') {
      // echo "empty";
      $picture = 'user.jpg';
    } else {
      // echo "available";
      $picture = $_FILES['picture']['name'];
      $tempname = $_FILES['picture']['tmp_name'];
      $image_folder = "../assets/docs/" . $picture;
      $extension = pathinfo($picture, PATHINFO_EXTENSION);
      $picture = "member" . time() . "." . $extension;
      $destination = "../assets/images/admins/{$picture}";

      move_uploaded_file($tempname, $destination);
    }

    mysqli_query($conn, "INSERT INTO user (name, email, phone, picture, password, status, role) 
    VALUES ('$name', '$email', '$phone',  '$picture', '$password', 'active', 'admin')");
    if (mysqli_affected_rows($conn) < 0) {
      header('Location: ../register.php?err2');
    } else {
      mysqli_query($conn, "UPDATE engine SET code = '$new_code' WHERE code ='$code'");
      header('Location: ../login.php?new');
    }
  } else {
    header('Location: ../register.php?err1');
  }
}

if (isset($_POST['login'])) {
  $user_query = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' AND password = '$password'");
  
  if (mysqli_num_rows($user_query) == 1) {
    session_start();
    $user = mysqli_fetch_array($user_query);
    if ($user['status'] != 'active') {
      header('Location: ../login.php?err2');
    } else {
      $_SESSION['id'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['role'] = $user['role'];
      if ($_SESSION['role'] == 'user') {
        header('Location: ../sun_sch_attd.php?user');
      } else {
        header('Location: ../index.php?user');
      }
    }
  } else {
    header('Location: ../login.php?err1');
  }
}

mysqli_close($conn);
?>