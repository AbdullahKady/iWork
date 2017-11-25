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

  <div class="container">
    <h1 class="text-center">I Am A Regular Employee !</h1>
  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
