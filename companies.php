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
    <?php include_once 'templates/company_search.tpl.php';?>
    <hr>
    <?php include_once 'templates/company_list_type.tpl.php';?>
  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
