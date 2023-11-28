<?php
include('../../php/config.php');

$s_name = '';
$showDay = 'd-none';
$btn_text = "Create";
$header_text = "Add New Branch";

if (isset($_GET['branch'])) {
  $s_id = $_GET['branch'];
  $branch_query = mysqli_query($conn, "SELECT * FROM branch WHERE id = '$s_id'");
  $branch = mysqli_fetch_array($branch_query);

  $s_name = $branch['name'];
  $btn_text = "Save";
  $header_text = "Edit Branch";
} else {
  $s_id = 0;
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
      <input type="hidden" id="branch_id" value="<?php echo $s_id ?>">
      <label for="name">Name</label>
      <input type="text" class="form-control form-control-sm" id="name" value="<?php echo $s_name ?>">
    </div>
    <div class="form-group col-sm-12">
      <button type="button" class="btn btn-sm btn-primary mr-2" onclick="savebranch()"><?php echo $btn_text ?></button>
    </div>
  </form>
</div>