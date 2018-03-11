<?php
    session_start();

    include_once 'includes/db_connect.php';
?>


<!DOCTYPE html>
<html>
<head>
    <?php include_once 'includes/header.php' ?> 
</head>

<body>
  <?php include_once 'templates/navbar.tpl.php';?>

  <div class="container"> <center>
    <h1 class="text-center">Job Seeker Dashboard</h1>
    <input type="button" class="btn btn-info" value="Apply For A Job" onclick="location.href = 'seeker_apply_job.php';">
    <input type="button" class="btn btn-info" value="View Status" onclick="location.href = 'seeker_view_status.php';">
    <center>
  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
