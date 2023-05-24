<?php
session_start();
include('config.php');
include('page-config.php');

$f_query = "SELECT * FROM brethren WHERE status = 'active'";

$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
$order_by = (isset($_GET['order_by'])) ? $_GET['order_by'] : 'name';

if (isset($_GET['search'])) {
  $content = $_GET['search'];
  $f_query .= " AND name LIKE '%$content%' OR phone LIKE '%$content%' OR email LIKE '%$content%'";
  $query = mysqli_query($conn, $f_query);
} else {
  $query = mysqli_query($conn, $f_query);
}

$total_rows = mysqli_num_rows($query);

$total_pages = ceil($total_rows / $limit);

if (isset($_GET['status'])) {
  $status = $_GET['status'];

  if ($status == 'filter' || $status == 'first') {
    $pg_num = 1;
  } elseif ($status == 'prev') {
    $pg_num = $_GET['pg_num'] - 1;
  } elseif ($status == 'next') {
    $pg_num = $_GET['pg_num'] + 1;
  } elseif ($status == 'pg_num') {
    $pg_num = $_GET['pg_num'];
  } elseif ($status == 'last') {
    $pg_num = $total_pages;
  }
} else {
  $pg_num = 1;
}

$initial_pg = ($pg_num - 1) * $limit;

$brethren_query = mysqli_query($conn, $f_query . " ORDER BY $order_by LIMIT $initial_pg, $limit");

?>

<table class="table table-striped project-orders-table">
  <thead>
    <tr>
      <th></th>
      <th>Name</th>
      <th>Phone</th>
      <th>Role</th>
      <th>Attendance</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (mysqli_num_rows($brethren_query) > 0) {
      while ($brethren = mysqli_fetch_array($brethren_query)) {
        $brethren_id = $brethren['id'];
        $role_id = $brethren['role'];
        $role = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM role WHERE id = '$role_id'"))['name'];
        $progress = 0;
        $progress_w = 0;
        $chk_query = mysqli_query($conn, "SELECT DISTINCT service, date FROM attendance WHERE service = 1 AND date <= '$date' ORDER BY date DESC LIMIT 4");
        while ($date_array = mysqli_fetch_array($chk_query)) {
          $c_date = $date_array['date'];
          $chk = mysqli_query($conn, "SELECT * FROM sun_sch_attd WHERE brethren = $brethren_id AND event_date = '$c_date'");
          if (mysqli_num_rows($chk) == 1) {
            $progress_w += 25;
            $progress++;
          }
        }
        $progress_c = 'warning';
        if ($progress_w > 50) {
          $progress_c = 'success';
        }
        ?>
        <tr>
          <td>
            <a href="individual_view.php?id=<?php echo $brethren['id'] ?>" target="_blank">
              <img src="assets/images/members/<?php echo $brethren['picture'] ?>" alt="image" />
            </a>
          </td>
          <td><?php echo strtoupper($brethren['name']) ?></td>
          <td><?php echo $brethren['phone'] ?></td>
          <td><?php echo $role ?></td>
          <td>
            <div class="progress">
              <div class="progress-bar bg-<?php echo $progress_c ?>" role="progressbar" style="width: <?php echo $progress_w ?>%"><?php echo $progress ?>/4</div>
            </div>
          </td>
          <td>
            <div class="d-flex align-items-center">
              <button class="btn btn-info btn-rounded btn-icon mr-2">
                <a href="individual_view.php?id=<?php echo $brethren['id'] ?>" target="_blank" class="text-light">
                <i class="typcn typcn-eye"></i></a>
              </button>
              <button class="btn btn-primary btn-rounded btn-icon mr-2">
                <a href="individual_edit.php?id=<?php echo $brethren['id'] ?>" target="_blank" class="text-light">
                <i class="typcn typcn-edit"></i></a>
              </button>
            </div>
          </td>
        </tr>
      <?php }
    } else { ?>
        <tr>
          <td colspan="6" class="text-center py-2">No Member is registered yet!</td>
        </tr>
    <?php } ?>
  </tbody>
</table>

<div class="col-12 col-md-8 mx-auto">
  <div class="card">
    <div class="card-header" style="box-sizing: border-box;">
      <div class="form-group row mb-0">
        <?php if ($pg_num != 1): ?>
          <div class="col-4">
            <button id="first" type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon mr-4" onclick="filter(this.id)"><<</button>
            <button id="prev" type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" onclick="filter(this.id)"><</button>
          </div>
        <?php endif; ?>
        <div class="col-4">
          <select class="form-control form-control-sm" id="pg_num" onchange="filter(this.id)">
          <?php for ($num = 1; $num <= $total_pages; $num++): ?>
              <?php if ($num == $pg_num): ?>
                  <option selected value="<?php echo $num; ?>"><?php echo $num; ?></option>
              <?php else: ?>
                  <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
              <?php endif; ?>
          <?php endfor; ?>
          </select>
        </div>
        <?php if ($pg_num != $total_pages): ?>
          <div class="col-4">
            <button id="next" type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon mr-4" onclick="filter(this.id)">></button>
            <button id="last" type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" onclick="filter(this.id)">>></button>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>