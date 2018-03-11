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
    <h1 class="text-center">Email</h1>

  <a href="ViewEmails.php" class="btn">View</a>  
  <a href="staff_member.php" class="btn">Back</a>
  <a href="Send_Email.php" class="btn">Send</a>
 

  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>