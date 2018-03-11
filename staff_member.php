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
    <h1 class="text-center">STAFF MEMBER !</h1>

  <a href="Attendance.php" class="btn">Attendance</a>  
  <a href="Emails.php" class="btn">Emails</a>
  <a href="Requests.php" class="btn">Requests</a>
  <a href="Announcements.php" class="btn">Announcements</a>

  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>