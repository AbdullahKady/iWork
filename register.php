<?php
  session_start();
  include_once 'includes/db_connect.php';

  if(isset($_POST["username"])) {
    // Fetch data from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $birth_date = $_POST["birth_date"];
    $years_of_experience = $_POST["years_of_experience"];
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];

    // specify params - MUST be a variable that can be passed by reference!
    $procedure_params['name'] = $username;
    $procedure_params['pass'] = $password;
    $procedure_params['p_email'] = $email;
    $procedure_params['bd'] = $birth_date;
    $procedure_params['exp'] = $years_of_experience;
    $procedure_params['f_name'] = $first_name;
    $procedure_params['m_name'] = $middle_name;
    $procedure_params['l_name'] = $last_name;
    $procedure_params['output'] = "";

    // Set up the procedure params array - be sure to pass the param by reference
    $procedure_passed_params = array(
      array(&$procedure_params['name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['pass'], SQLSRV_PARAM_IN),
      array(&$procedure_params['p_email'], SQLSRV_PARAM_IN),
      array(&$procedure_params['bd'], SQLSRV_PARAM_IN),
      array(&$procedure_params['exp'], SQLSRV_PARAM_IN),
      array(&$procedure_params['f_name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['m_name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['l_name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC Register1 @name = ?, @pass = ?, @p_email = ?, @bd = ?, @exp = ?, @f_name = ?, @m_name = ?, @l_name = ?, @output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($res = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      
      if ($procedure_params['output'] === 'Registeration successful') {
        // Execution completed, login the user
        if(isset($_POST['previous_jobs'])){
          $previous_jobs = $_POST['previous_jobs'];
          foreach ($previous_jobs as $previous_job) {
            $sql_previous = "EXEC addPreviousJob '". $username . "','" . $previous_job . "'";
            $stmt_previous= sqlsrv_query($conn, $sql_previous);
          }
        }


        $_SESSION['logged_in_user']['username'] = $username;
        $_SESSION['logged_in_user']['role'] = 'Seeker';

        header("Location: index.php?status=registered");
        die();
      } else {
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Registeration failed, the username is used. Please choose another username and try again </div>';
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
      <label><strong>Username*</strong></label>
      <input class="form-control" type="text" placeholder="Enter Username" name="username" required maxlength="20">

      <label><strong>Password*</strong></label>
      <input class="form-control" type="password" placeholder="Enter Password" name="password" required maxlength="20">

      <label><strong>Personal Email*</strong></label>
      <input class="form-control" type="text" placeholder="john@doe.com" name="email" required maxlength="50">

      <label><strong>Birth date*</strong></label>
      <input class="form-control" type="date" placeholder="MM/DD/YYYY" name="birth_date" min="1900-12-12" max="2017-11-11"  required>
      
      <label><strong>Years of Experience*</strong></label>
      <input class="form-control" type="number" name="years_of_experience" min="0" max="60" required>

      <hr>

      <label><strong>First Name*</strong></label>
      <input class="form-control" type="text" placeholder="john" name="first_name" maxlength="20" required>

      <label><strong>Middle Name</strong></label>
      <input class="form-control" type="text" placeholder="doe" name="middle_name" maxlength="20">

      <label><strong>Last Name*</strong></label>
      <input class="form-control" type="text" placeholder="smith" name="last_name" maxlength="20" required>
      <br>
      <div id="previous-container">
        <h6>Your previous jobs (optional)</h6><br>
      </div>
      <a href="#" id="add-prev-job-btn" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add an extra job</a>
      <hr>

    </div>
    <br>
    <button class="btn btn-primary" type="submit">Register</button>
    <a href="index.php" class="btn">Cancel</a> 


  </form>

  <?php include_once 'includes/scripts.php';?>
  <script>
    let addPreviousJobButton = document.querySelector('#add-prev-job-btn');
    let i = 0;
    addPreviousJobButton.addEventListener('click', event => {
      event.preventDefault();

      document.getElementById("previous-container").insertAdjacentHTML('beforeend', `<textarea class="form-control" name="previous_jobs[${i}]" type="text" placeholder="Insert your previous job title" rows="3" maxlength="50" required></textarea><br>`);
  
      i++;
    });
  </script>
</body>
</html>