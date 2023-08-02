
<?php
if (!isset($_SESSION['id'])) {
  header('Location: login.php');
}

$id = $_SESSION['id'];

// Gets user picture
$user_ = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE id = $id"));
$user_image = $user_['picture'];
$user_email = $user_['email'];
$user_phone = $user_['phone'];

$message = '';
$sidebar = '';

$date = date('Y-m-d');
$_day = date('w');
$day = jddayofweek($_day - 1, 1);
$short_day = jddayofweek($_day - 1, 2);

if (isset($_GET['user'])) {
  date_default_timezone_set('Africa/Lagos');
  $current_login = date('Y-m-d H:i:s');
  $last_login = mysqli_fetch_array(mysqli_query($conn, "SELECT last_login FROM user WHERE id = '$id'"))[0];
  $last_login = new DateTime($last_login);
  
  $diff = $last_login->diff(new DateTime($current_login));
  if ($diff->y != 0) {
    $message = 'Last login was ' . $diff->y . ' years ago';
  } elseif ($diff->m != 0) {
    $message = 'Last login was ' . $diff->m . ' months ago';
  } elseif ($diff->d != 0) {
    $message = 'Last login was ' . $diff->d . ' days ago';
  } elseif ($diff->h != 0) {
    $message = 'Last login was ' . $diff->h . ' hours ago';
  } elseif ($diff->i != 0) {
    $message = 'Last login was ' . $diff->i . ' minutes ago';
  } else {
    $message = 'Last login was ' . $diff->s . ' seconds ago';
  }

  mysqli_query($conn, "UPDATE user SET last_login = '$current_login' WHERE id ='$id'");
}


if ($_SESSION['role'] != 'admin') {
  $sidebar = 'd-none';
}

$church = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM organization WHERE id = 1"));
?>
