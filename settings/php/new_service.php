<?php
include('../../php/config.php');

$s_name = '';
$s_repeat = '';
$s_date = '';
$s_day = '';
$showDay = 'd-none';
$btn_text = "Create";
$header_text = "Add New Service";

$repeat_arr = ['no-repeat','daily','weekly','monthly','annually'];
$days_arr = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

if (isset($_GET['service'])) {
  $s_id = $_GET['service'];
  $service_query = mysqli_query($conn, "SELECT * FROM service WHERE id = '$s_id'");
  $service = mysqli_fetch_array($service_query);

  $s_name = $service['name'];
  $s_repeat = $service['repetition'];
  $s_date = $service['start_date'];
  $s_day = $service['repeat_day'];
  $btn_text = "Save";
  $header_text = "Edit Service";
} else {
  $s_id = 0;
}

if ($s_repeat == 'weekly') {
  $showDay = '';
}
?>
<div class="card-header">
  <h5 class="text-titlecase"><?php echo $header_text ?></h5>
</div>
<div class="card-body col-8">
  <!-- <p class="card-description">
    Basic form elements
  </p> -->
  <form class="forms-sample row">
    <div class="form-group col-sm-7">
      <input type="hidden" id="service_id" value="<?php echo $s_id ?>">
      <label for="name">Name</label>
      <input type="text" class="form-control form-control-sm" id="name" value="<?php echo $s_name ?>">
    </div>
    <div class="form-group col-sm-5">
      <label for="repeat">Repeat</label>
      <select class="form-control form-control-sm" id="repeat" onchange="showDay(this.value)">
      <?php foreach ($repeat_arr as $rep): ?>
        <?php if ($s_repeat == $rep): ?>
        <option selected value="<?php echo $rep ?>"><?php echo $rep ?></option>
        <?php else: ?>
        <option value="<?php echo $rep ?>"><?php echo $rep ?></option>
        <?php endif; ?>
      <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group col-sm-7">
      <label for="event_date">Event Start Date</label>
      <input type="date" class="form-control form-control-sm" id="event_date" value="<?php echo $s_date ?>">
    </div>
    <div class="form-group col-sm-5 <?php echo $showDay ?>" id="days">
      <label for="repeat_day">Day of the week</label>
      <select class="form-control form-control-sm" id="repeat_day">
      <?php foreach ($days_arr as $day): ?>
        <?php if ($s_day == $day): ?>
          <option selected value="<?php echo $day ?>"><?php echo $day ?></option>
        <?php else: ?>
          <option value="<?php echo $day ?>"><?php echo $day ?></option>
        <?php endif; ?>
      <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group col-sm-12">
      <button type="button" class="btn btn-sm btn-primary mr-2" onclick="saveService()"><?php echo $btn_text ?></button>
    </div>
  </form>
</div>