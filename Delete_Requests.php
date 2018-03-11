<?php
  session_start();
  include_once 'includes/db_connect.php';

  if(isset($_POST["start_date"])) {
    // Fetch data from the form
    $username = $_SESSION['logged_in_user']['username'];
    $start_date = $_POST["start_date"];
   

    // specify params - MUST be a variable that can be passed by reference!
    $procedure_params['username'] = $username;
    $procedure_params['start_date'] = $start_date;
    $procedure_params['output'] = "";

    // Set up the procedure params array - be sure to pass the param by reference
    $procedure_passed_params = array(
      array(&$procedure_params['username'], SQLSRV_PARAM_IN),
      array(&$procedure_params['start_date'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC delete_request @username = ?, @start_date = ?,  @output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($res = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      
      if ($procedure_params['output'] === 'Done Deleting') {
        // Execution completed, login the user
                $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Done Deleting !! </div>';
        die();
      } else {
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Cannot Delete !! </div>';
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

  <form action="Delete_Requests.php" method="POST" class="form-group container">
    <div >
    

      <label><strong>Date</strong></label>
      <input class="form-control" type="date" placeholder="MM/DD/YYYY" name="start_date" required>
      <input type='submit' name='submit' value='Enter' />


      <hr>


    </div>

    <a href="Requests.php" class="btn">Cancel</a> 


  </form>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>