<?php
    session_start();

    include_once 'includes/db_connect.php';

   $username = $_SESSION['logged_in_user']['username'];
   



    
if(isset($_POST['submit'])){





     //specify params - MUST be a variable that can be passed by reference!
  $procedure_params['user'] = $username;
    $procedure_params['output'] = '';

    // Set up the procedure params array - be sure to pass the param by reference
  $procedure_passed_params = array(
      array(&$procedure_params['user'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC check_in @user = ?, @output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);


    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($flash_message = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      $output = $procedure_params['output'];
      if ($output === 'It is a day off') {
        $flash_message='<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Day OFF. </div>';
      }else if($output === 'Attendance has been entered'){
        $flash_message='<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Attendance has been entered  <a href="staff_member.php">Back to Staff Page</a> </div>'; 
      } else {
        
        die();
      }
    } else {
      die( print_r( sqlsrv_errors(), true));
    }
  }
            
          
      

      if(isset($_POST['submit2'])){    //specify params - MUST be a variable that can be passed by reference!
 
     //specify params - MUST be a variable that can be passed by reference!
  $procedure_params['user'] = $username;
    $procedure_params['output'] = '';

    // Set up the procedure params array - be sure to pass the param by reference
  $procedure_passed_params = array(
      array(&$procedure_params['user'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC check_out @user = ?, @output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);


    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($flash_message = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      $output = $procedure_params['output'];
      if ($output === 'It is a day off') {
        $flash_message='<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Day OFF. </div>';
      }else if($output === 'Check out Successfully'){
        $flash_message='<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Checked out successfully  <a href="staff_member.php">Back to Staff Page</a> </div>'; 
      } else {
        
        die();
      }
    } else {
      die( print_r( sqlsrv_errors(), true));
    }
  }
 

 if(isset($_POST['submit3']))
    header("Location: View_Attendance.php ")






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
    <h1 class="text-center">Attendance</h1>
    <h3 class="text-center">Select CHECK IN OR CHECK OUT to update your attendance 
</h3>
</div>

  <form action="Attendance.php" method="POST" class="form-group container"  >
    <div class="container"  style="text-align:center;">

<input type='submit' name='submit' value='Check in' class='register' />
<input type='submit' name='submit2' value='Check out' class='register' /> 
<input type='submit' name='submit3' value='View Attendance' class='register' />   
     
      <a href="staff_member.php" class="btn">Back</a>
    </div>


  </form>


</body>
</html>

