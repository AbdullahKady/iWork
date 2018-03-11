<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  if (isset($_POST['Start']) && isset($_POST['End'])) {
    $jobs = array();
 //$flash_message='<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Failed to ///Check in as it is a day off. </div>';
    $sql_jobs = "EXEC View_My_Attendance '" . $_SESSION['logged_in_user']['username'] . "'"  .",". "'".$_POST['Start']."'".","."'".$_POST['End']."'";

    $stmt_jobs = sqlsrv_query($conn, $sql_jobs);

    if(!$stmt_jobs) {
      die( print_r( sqlsrv_errors(), true));
    }

    while($row = sqlsrv_fetch_array($stmt_jobs, SQLSRV_FETCH_ASSOC)) {
      array_push($jobs, $row);
    }
  }

  

?>


<!DOCTYPE html>
<html>
<head>
    <?php include_once 'includes/header.php' ?> 
</head>

<body>

  <?php include_once 'templates/navbar.tpl.php';?>

  <?php if(isset($flash_message)): ?>
    <div class="container">
      <div class = "row">
        <div class="col-sm-12">
         <?php echo $flash_message; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <div class="container">
    <h2 class="text-center">View Attendance between those two dates !</h2>

    <form class="form-group" action="View_Attendance.php" method="POST">
      <div class="row">
        <div class="col-md-10">
          <input  type="date" value="2017/08/01" name = "Start">
          <input  type="date" value="2018/06/01" name = "End">
        </div>
        <div class="col-md-2">
<input type='submit' name='submit' value='Enter' class='register' />
      <a href="Attendance.php" class="btn">Back</a>

        </div>
      </div>
    </form>

    <hr>

    <?php if(isset($jobs)): ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Duration</th>
            <th>Missing Hours</th>
            
          </tr>
        </thead>

        <tbody>
          <?php foreach ($jobs as $job): ?>
            <tr>
              <td><?php echo $job['date']->format('d/m/Y')?></td>
              <td><?php echo $job['start_time']->format('h:i:s')?></td>
              <td><?php echo $job['end_time'] ->format('h:i:s')?></td>
              <td><?php echo $job['duration'] ?></td>
               <td><?php echo $job['Missing Hours'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>