<?php
  session_start();
  include_once 'includes/db_connect.php';

  if(isset($_POST["recipient_email"])) {
    // Fetch data from the form
    $username = $_SESSION['logged_in_user']['username'];
    $Rec = $_POST["recipient_email"];
    $subject = $_POST["subject"];
    $body = $_POST["body"];
   

    // specify params - MUST be a variable that can be passed by reference!
    $procedure_params['sender'] = $username;
    $procedure_params['recipient_email'] = $Rec;
    $procedure_params['subject'] = $subject;
    $procedure_params['body'] = $body;
 
    $procedure_params['output'] = "";

    // Set up the procedure params array - be sure to pass the param by reference
    $procedure_passed_params = array(
      array(&$procedure_params['sender'], SQLSRV_PARAM_IN),
      array(&$procedure_params['recipient_email'], SQLSRV_PARAM_IN),
      array(&$procedure_params['subject'], SQLSRV_PARAM_IN),
      array(&$procedure_params['body'], SQLSRV_PARAM_IN),
    
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC send_email @sender = ?, @recipient_email = ?, @subject = ?, @body = ?,  @output = ?";
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

  <form action="Send_Email.php" method="POST" class="form-group container">
    <div>
     

      <label><strong>Recipient Email</strong></label>
      <input class="form-control" type="text" placeholder="john@doe.com" name="recipient_email" required maxlength="50" required="">


      <label><strong>Subject</strong></label>
      <input class="form-control" type="text" placeholder="john" name="subject" maxlength="20">

      <label><strong>Body</strong></label>
      <input class="form-control" type="text" placeholder="doe" name="body" maxlength="500">

<input type='submit' name='submit' value='Enter' class='register' />

    </div>

    <a href="index.php" class="btn">Cancel</a> 


  </form>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>