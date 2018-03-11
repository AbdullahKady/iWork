<?php
    session_start();

    include_once 'includes/db_connect.php'

?>


<!DOCTYPE html>
<html>
<head>
    <?php include_once 'includes/header.php' ?> 
</head>

<body>
  <?php include_once 'templates/navbar.tpl.php';?>

  <div class="container"  style="text-align:center;">
    <h1 class="text-center">Requests</h1>

    <a href="Apply_leave.php" class="btn">Apply for  leave requests</a>  
    <a href="Apply_Trip.php" class="btn">Apply for Trip</a>
    <a href="View_Requests.php" class="btn">View Requests</a>
    <a href="Delete_Requests.php" class="btn">Delete request</a>
    <a href="Staff_member.php" class="btn">Back</a>

  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>