<?php
include_once 'manager_dash_temp.php';
 ?>
Leave Requests</h3>
</div>
<div class="panel-body">
<?php
$requests = array();
$procedure_params['user'] =$_SESSION['logged_in_user']['username'];

$procedure_passed_params = array(
  array(&$procedure_params['user'], SQLSRV_PARAM_IN)
);

// EXEC the procedure
$sql = "EXEC view_buisness_requests @user = ?";
$stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

  if(!$stmt) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    array_push($requests, $row);
  }

?>
<table class="table table-hover">
      <thead>
        <tr>
          <th>Applicant</th>
          <th>Start Date</th>
          <th>Total Days</th>
          <th>Destination</th>
          <th>Details</this>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($requests as $request): ?>
          <tr>
            <td><?php echo $request['applicant'] ?></td>
            <td><?php echo ($request['start_date']->format('d/m/Y')); $start = ($request['start_date']->format('d/m/Y'));?></td>
            <td><?php if(isset($request['total_days'])) {echo ($request['total_days']->format('d/m/Y'));} ?></td>
            <td><?php if(isset($request['destination'])) echo $request['destination'] ?></td>
            <td><a href= "<?php echo 'manager_requests_details.php?applicant='.$request['applicant'].'&start='.$start.'&type=b' ?>">Details</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
  </div>
</div>


</div>
</div>
</section>
</body>
</html>
