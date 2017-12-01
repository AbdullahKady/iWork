<?php
  session_start();
  include_once 'includes/db_connect.php';
  parse_str($_SERVER['QUERY_STRING']);
  $username = $_SESSION['logged_in_user']['username'];

  if(isset($accept,$applicant,$start_date)){
    $sql = "EXEC finalizeReqHR '".$username."' , " . $accept . ",'" . $start_date."','".$applicant."'" ;
    $stmt = sqlsrv_query($conn,$sql);
    if($accept == 1){
      $flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success! </strong>The request has been <strong>accepted</strong></div>'; 
    }
    else{
      $flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success! </strong>The request has been <strong>rejected</strong></div>'; 
    }
  }

  $leave_requests = array();
  $business_requests = array();
  $sql_leave = "EXEC viewRequestsHR '".$username."','"."Leave'";
  $sql_business = "EXEC viewRequestsHR '".$username."','"."Business'";
  $stmt_leave = sqlsrv_query($conn, $sql_leave);
  $stmt_business = sqlsrv_query($conn, $sql_business);
  if(!$stmt_leave || !$stmt_business) {
      die( print_r( sqlsrv_errors(), true));
  }
  while($row = sqlsrv_fetch_array($stmt_leave, SQLSRV_FETCH_ASSOC)) {
      array_push($leave_requests, $row);
  }
  while($row = sqlsrv_fetch_array($stmt_business, SQLSRV_FETCH_ASSOC)) {
      array_push($business_requests, $row);
  }
  include_once 'includes/db_connect.php';
?>


<!DOCTYPE html>
<html>
<head>
    <?php include_once 'includes/header.php' ?> 
</head>

<body>
  <?php include_once 'templates/navbar.tpl.php';?>

<div class = "container">
  <?php if(isset($flash_message)): ?>
    <div class="container">
      <div class = "row">
        <div class="col-sm-12">
          <?php echo $flash_message; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- <div class="row"> -->
    <!-- <div class="col-md-6"> -->

      <h5 class="text-center">Leave requests</h5>
      <?php if(!empty($leave_requests)): ?>

      <hr>
          <table class="table table-hover">
              <thead>
                <tr>
                  <th>Employee's full name</th>
                  <th>Request Date</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Total Days</th>
                  <th>Type</th>
                  <th>Decide on Request</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($leave_requests as $leave_request): ?>
                  <tr>
                    <td><?php echo $leave_request['Name'] ?></td>
                    <td><?php echo $leave_request['request_date']->format('m/d/Y') ?></td>
                    <td><?php echo $leave_request['start_date']->format('m/d/Y') ?></td>
                    <td><?php echo $leave_request['end_date']->format('m/d/Y') ?></td>
                    <td><?php echo $leave_request['total_days'] ?></td>
                    <td><?php echo $leave_request['type'] ?></td>
                    <?php $request_path = "hr_requests.php?start_date=".$leave_request['start_date']->format('m/d/Y') ."&applicant=".$leave_request['username']."&accept="  ?>
              <td><a href="<?php echo $request_path."1" ?>" class = "btn btn-success">Accept</a> <a href ="<?php echo $request_path . "0" ?>" class="btn btn-danger">Reject</a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
          </table>
        <?php else : ?>
          <div class="alert alert-info">Looks like there are no <strong>pending Leave Requests</strong> in your department.</div>
        <?php endif; ?>
    <!-- </div> -->
    <br>
    <!-- <div class="col-md-6"> -->
      <h5 class="text-center">Business Trip Requests</h5>
      <?php if(!empty($business_requests)): ?>

      <hr>
          <table class="table table-hover">
              <thead>
                <tr>
                  <th>Employee's full name</th>
                  <th>Request Date</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Total Days</th>
                  <th>Destination</th>
                  <th>Purpose</th>
                  <th>Decide on Request</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($business_requests as $business_request): ?>
                  <tr>
                    <td><?php echo $business_request['Name'] ?></td>
                    <td><?php echo $business_request['request_date']->format('m/d/Y') ?></td>
                    <td><?php echo $business_request['start_date']->format('m/d/Y') ?></td>
                    <td><?php echo $business_request['end_date']->format('m/d/Y') ?></td>
                    <td><?php echo $business_request['total_days'] ?></td>
                    <td><?php echo $business_request['destination'] ?></td>
                    <td><?php echo $business_request['purpose'] ?></td>
                    <?php $request_path = "hr_requests.php?start_date=".$business_request['start_date']->format('m/d/Y') ."&applicant=".$business_request['username']."&accept="  ?>
              <td><a href="<?php echo $request_path."1" ?>" class = "btn btn-success">Accept</a> <a href ="<?php echo $request_path . "0" ?>" class="btn btn-danger">Reject</a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
          </table>
        <?php else : ?>
          <div class="alert alert-info">Looks like there are no <strong>pending Business Requests</strong> in your department.</div>
        <?php endif; ?>
    <!-- </div> -->
  <!-- </div> -->
</div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>















