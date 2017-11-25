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
      while($res = sqlsrv_next_result($prepared_stmt)) {/* pass */};

      $out = $procedure_params['output'];
      if ($out === 'Password incorrect' || $out === 'Not registered') {
        print_r($out);
      } else {
        // TODO: Check on role !
        $_SESSION['logged_in_user'] = $username;

        header("Location: index.php");
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
    <title>iWork</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>

<body>

  <?php include_once 'templates/navbar.tpl.php';?>  

  <form action="login.php" method="POST" class="input-group container">
    <div class="container">
      <label><b>Username</b></label>
      <input class="input-control" type="text" placeholder="Enter Username" name="username" required>

      <label><b>Password</b></label>
      <input class="input-control" type="password" placeholder="Enter Password" name="password" required>

      <button class="btn btn-primary" type="submit">Login</button>
      <a href="index.php" class="btn">Cancel</a>
    </div>


  </form>

</body>
</html>