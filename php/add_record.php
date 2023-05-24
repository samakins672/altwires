<?php
session_start();
include("config.php");

  if ($_POST['blessing'] != 0) {
  $sex = $_POST['gender'];
  $other_blessing = $_POST['other_blessing'];
  $meeting = $_POST['meeting'];
  $member_id = $_POST['member'];
  $event_date = $_POST['event_date'];
  $uploaded_by = $_SESSION['id'];
  
  if ($meeting == 0) {
    $meeting_name = mysqli_real_escape_string($conn, $_POST['new_meeting']);
  } else {
    $meeting_name = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM service WHERE id = $meeting"))['name'];
  }
  
  if ($member_id == '0') {
    $member = mysqli_real_escape_string($conn, $_POST['new_member']);
    $member_phone = $_POST['number'];
  } else {
    $q = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM brethren WHERE id = $member_id"));
    $member = $q['name'];
    $member_phone = $q['phone'];
  }
  
  $query = "INSERT INTO blessing_record (brethren_name, brethren_id, brethren_phone, sex,	other_blessing,	meeting, meeting_name,	event_date,	uploaded_by) 
    VALUES ('$member', $member_id, '$member_phone', '$sex',	'$other_blessing',	$meeting, '$meeting_name',	'$event_date',	$uploaded_by)";
  if (mysqli_query($conn, $query)) {
    $blessing_id = mysqli_insert_id($conn);
    
    foreach ($_POST['blessing'] as $blessing) {
      mysqli_query($conn, "INSERT INTO has_blessing (blessing_record, blessing) VALUES ($blessing_id, $blessing)");
    }

    $blessing_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id) FROM blessing_record WHERE meeting = '$meeting' AND meeting_name = '$meeting_name' AND event_date = '$event_date'"))[0];
    echo "<span class='text-success font-weight-bold'>$member blessings recorded, Total Blessings Recorded: $blessing_count</span>";
  
  } else {
    echo "<span class='text-danger font-weight-bold'>$member blessings not recorded, Please try again later!</span>";
  }
} else {
  echo "<span class='text-danger font-weight-bold'>Please select a blessing and try again!</span>";
}
?>