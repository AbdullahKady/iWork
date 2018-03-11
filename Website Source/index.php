<?php
    session_start();
    // TODO : Homepage some kind of style
    include_once 'includes/db_connect.php';
    // parse all query strings and create variables with them
    // Example: index.php?username=banana
    // will create a variable username with value banana
    parse_str($_SERVER['QUERY_STRING']);
    if(isset($status)){
      if($status == "login"){
        $flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Successfully logged in! Welcome back '. $_SESSION["logged_in_user"]['username'] . '</div>';
      }
      else if($status == "registered"){
        $flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Successfully registered! Welcome to iWork '. $_SESSION["logged_in_user"]['username'] . '</div>';
      }
      else if($status == "logout"){
         $flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Successfully logged-out! come back soon :) </div>';
      }  
      else{
        $flash_message = null;
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
    <?php include_once 'templates/company_list_type.tpl.php';?>
  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
