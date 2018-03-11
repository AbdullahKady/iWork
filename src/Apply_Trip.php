<?php
  session_start();
  include_once 'includes/db_connect.php';

  if(isset($_POST["start_date"])) {
    // Fetch data from the form
    $start_date = $_POST["start_date"];
    $username = $_SESSION['logged_in_user']['username'];
    $replacement = $_POST["replacement"];
    $end_date = $_POST["end_date"];
    $destination = $_POST["destination"];
    $destination = $_POST["purpose"];

    

    // specify params - MUST be a variable that can be passed by reference!
    $procedure_params['start'] = $start_date;
    $procedure_params['applicant'] = $username;
    $procedure_params['replacement'] = $replacement;
    $procedure_params['end_date'] = $end_date;
    $procedure_params['destination'] = $destination;
    $procedure_params['purpose'] = $purpose;
        $procedure_params['output'] = '';

    

    // Set up the procedure params array - be sure to pass the param by reference
    $procedure_passed_params = array(
      array(&$procedure_params['start'], SQLSRV_PARAM_IN),
      array(&$procedure_params['applicant'], SQLSRV_PARAM_IN),
      array(&$procedure_params['replacement'], SQLSRV_PARAM_IN),
      array(&$procedure_params['end_date'], SQLSRV_PARAM_IN),
      array(&$procedure_params['destination'], SQLSRV_PARAM_IN),
      array(&$procedure_params['purpose'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC Leave_Request_for_all @start = ?, @applicant = ?, @replacement = ?, @end_date = ?,@destination =? , @purpose =?,@output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($res = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      
      if ($procedure_params['output'] === 'You used all the allowed annual leaves') {
        // Execution completed, login the user
      $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>You used all the allowed annual leaves </div>';
      }  
      if ($procedure_params['output'] === 'It is a conflicting date') {
        // Execution completed, login the user
      $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>It is a conflicting date </div>';
      }   if ($procedure_params['output'] === 'ur replacement is not of the same type') {
        // Execution completed, login the user
      $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>ur replacement is not of the same type </div>';
      }  
      if ($procedure_params['output'] === 'Request sent') {
        // Execution completed, login the user
      $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Request sent </div>';
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

  <form action="register.php" method="POST" class="form-group container">
    <div>
      <label><strong>Start</strong></label>
      <input class="form-control" type="date" placeholder="MM/DD/YYYY" name="start_date"  required>

      <label><strong>Replacement </strong></label>
      <input class="form-control" type="text" placeholder="Ahmed" name="replacement" required maxlength="50" required>

      <label><strong>End</strong></label>
      <input class="form-control" type="date" placeholder="MM/DD/YYYY" name="end_date"   required>
      
      <label><strong>Destnation</strong></label>
      <input class="form-control" type="text" name="destination" required>


      <label><strong>Purpose</strong></label>
      <input class="form-control" type="text" name="purpose" required>

      <hr>

    </div>

    <button class="btn btn-primary" type="submit">Submit</button>
    <a href="index.php" class="btn">Cancel</a> 


  </form>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>