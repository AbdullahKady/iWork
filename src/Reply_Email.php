<?php
  session_start();
  include_once 'includes/db_connect.php';

      parse_str($_SERVER['QUERY_STRING']);


  if(isset($_POST["submit"],$mail)) {
    // Fetch data from the form
    $serial_number = $mail;
    $username = $_SESSION['logged_in_user']['username'];
    $body = $_POST["body"];
   

    // specify params - MUST be a variable that can be passed by reference!
    $procedure_params['serial_number'] = $serial_number;
    $procedure_params['username'] = $username;
    $procedure_params['body'] = $body;
    $procedure_params['output'] = "";

    // Set up the procedure params array - be sure to pass the param by reference
    $procedure_passed_params = array(
      array(&$procedure_params['serial_number'], SQLSRV_PARAM_IN),
      array(&$procedure_params['username'], SQLSRV_PARAM_IN),
      array(&$procedure_params['body'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC reply_email  @serial_number = ?, @username = ?, @body = ?,  @output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($res = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      
      if ($procedure_params['output'] === 'Cannot send Emails to non Staff Members!') {
        // Execution completed, login the user
       
      
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Cannot send Emails to non Staff Members! </div>';
      }

       if ($procedure_params['output'] === 'Email sent') {
        // Execution completed, login the user
       
      
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Email sent </div>';
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

  <form action=<?php echo "Reply_Email.php?mail=".$mail; ?> method="POST" class="form-group container">
    <div>
     


      <label><strong>Body</strong></label>
      <input class="form-control" type="text" placeholder="body" name="body" maxlength="500" required>

<input type='submit' name='submit' value='Enter' class='register' />

    </div>

    <a href="index.php" class="btn">Cancel</a> 


  </form>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>