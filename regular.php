<?php
    session_start();

    include_once 'includes/db_connect.php';
    parse_str($_SERVER['QUERY_STRING']);
    if(isset($status)){
    	 $flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Successfully Joined Regular Employees!</div>';
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
  	<center>
    <h1 class="text-center">Regular Employee Dashboard</h1>
    <input type="button" class="btn btn-info" value="View Projects & Tasks" onclick="location.href = 'regular_view_projects.php';">
	</center>
  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
