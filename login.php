<?php
  session_start();
  include_once 'includes/db_connect.php';

  if(isset($_POST["username"])) {
    // Fetch data from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // specify params - MUST be a variable that can be passed by reference!
    $procedure_params['user'] = $username;
    $procedure_params['pass'] = $password;
    $procedure_params['output'] = '';

    // Set up the procedure params array - be sure to pass the param by reference
    $procedure_passed_params = array(
      array(&$procedure_params['user'], SQLSRV_PARAM_IN),
      array(&$procedure_params['pass'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC login @user = ?, @pass = ?, @output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($flash_message = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      $output = $procedure_params['output'];
      if ($output === 'Password incorrect') {
        $flash_message='<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Login failed. Password entered is incorrect. </div>';
      }else if($output === 'Not registered'){
        $flash_message='<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Login failed. Username is not registered. Feel free to register  <a href="register.php">here</a> </div>'; 
      } else {
        $_SESSION['logged_in_user']['username'] = $username;
        $_SESSION['logged_in_user']['role'] = $output;
        header("Location: index.php?status=login");
        die();
      }
    } else {
      die( print_r( sqlsrv_errors(), true));
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


  <form action="login.php" method="POST" class="form-group container">
    <div class="container">
      <label><b>Username</b></label>
      <input class="form-control" type="text" placeholder="Enter Username" name="username" required maxlength="20">

      <label><b>Password</b></label>
      <input class="form-control" type="password" placeholder="Enter Password" name="password" required maxlength="20">

      <button class="btn btn-primary" type="submit">Login</button>
      <a href="index.php" class="btn">Cancel</a>
    </div>


  </form>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>