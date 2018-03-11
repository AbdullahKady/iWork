<?php
  session_start();
  include_once 'includes/db_connect.php';

	$username = $_SESSION['logged_in_user']['username'];
	$user_data = array();
  // EXEC the procedure
  parse_str($_SERVER['QUERY_STRING']);
  if(isset($status)){
    $flash_message ='<div class="alert alert-success alert-dismissable "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b>Success! </b>Your information has been updated.</div>';   
  }
  if(isset($deletedJob)){
    $sql = "DELETE FROM User_Jobs WHERE username = " . "'". $username . "' AND job="."'"."$deletedJob"."'";
    $stmt = sqlsrv_query($conn, $sql);
    $flash_message ='<div class="alert alert-success alert-dismissable "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b>Success! </b>The job has been deleted from your previous jobs titles.</div>';   
  }

  $sql = "SELECT * FROM Users WHERE username = " . "'". $username . "'";

  $stmt = sqlsrv_query($conn, $sql);

  if(!$stmt) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $user_data = $row;
	}

  $user_jobs = array();
  $sql_jobs = "SELECT job FROM User_Jobs WHERE username =".  "'". $username . "'";
  $stmt_jobs = sqlsrv_query($conn, $sql_jobs);
  if(!$stmt_jobs) {
    die( print_r( sqlsrv_errors(), true));
  }
  while($row_jobs = sqlsrv_fetch_array($stmt_jobs, SQLSRV_FETCH_ASSOC)) {
    array_push($user_jobs, $row_jobs);
  }


	
	if(isset($_POST["first_name"])) {
		
 		// Fetch data from the form
    $password = $_POST["new_password"];
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


    // Set up the procedure params array - be sure to pass the param by reference
    $procedure_passed_params = array(
      array(&$procedure_params['name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['pass'], SQLSRV_PARAM_IN),
      array(&$procedure_params['p_email'], SQLSRV_PARAM_IN),
      array(&$procedure_params['bd'], SQLSRV_PARAM_IN),
      array(&$procedure_params['exp'], SQLSRV_PARAM_IN),
      array(&$procedure_params['f_name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['m_name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['l_name'], SQLSRV_PARAM_IN)
      
    );

	  // EXEC the procedure
    $sql = "EXEC Edit_personal_information @name = ?, @pass = ?, @p_email = ?, @bd = ?, @exp = ?, @f_name = ?, @m_name = ?, @l_name = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      if(isset($_POST['previous_jobs'])){
        $previous_jobs = $_POST['previous_jobs'];
        foreach ($previous_jobs as $previous_job) {
          $sql_previous = "EXEC addPreviousJob '". $username . "','" . $previous_job . "'";
          $stmt_previous= sqlsrv_query($conn, $sql_previous);
        }
      }
      header("Location: settings.php?status=updated");
      die();
			   
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

	<div class="container" id="profile">

	  <div class="centered">
	    <h2>
	    	<strong>
	    		<?php echo $_SESSION['logged_in_user']['username']; ?>'s profile
	    	</strong>
	    </h2>
	  </div>

	  <form action="settings.php" method="POST">

	    <div class="form-group">
	      <label for="first_name">First Name</label>
	      <input type="text" class="form-control" maxlength="20" name="first_name" value="<?php echo $user_data['first_name'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="middle_name">Middle Name</label>
	      <input type="text" class="form-control" maxlength="20" name="middle_name" value="<?php echo $user_data['middle_name'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="last_name">Last Name</label>
	      <input type="text" class="form-control" maxlength="20" name="last_name" value="<?php echo $user_data['last_name'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="email">Email</label>
	      <input type="email" class="form-control" maxlength="50" name="email" value="<?php echo $user_data['personal_email'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="birth_date">Birth Date</label>
	      <input type="date" class="form-control" min="1900-12-12" max="2017-12-12" name="birth_date" value="<?php echo $user_data['birth_date']->format('Y-m-d') ?>">
	    </div>

	    <div class="form-group">
	      <label for="years_of_experience">Years of Experience</label>
	      <input type="number" class="form-control" min="0" max="60" name="years_of_experience" value="<?php echo $user_data['years_of_experience'] ?>">
	    </div>

			<div class="form-group">
      <label for="age">Age</label>
      <input type="number" class="form-control" disabled value="<?php echo $user_data['age'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="new_password">New Password (re-enter the old password if you don't want to change it)</label>
	      <input type="password" class="form-control" maxlength="20" name="new_password" placeholder="•••••••" required>
	    </div>
      <h6 class="text-center"> <b>Previous job titles</b> (deleting will refresh this page, thus losing any edited info)</h6>

      <?php foreach ($user_jobs as $previous_job): ?>
        <li>
          <?php echo $previous_job['job'] ?>
          <a href="settings.php?deletedJob=<?php echo $previous_job['job'] ?>" > delete this job</a>
        </li>
      <?php endforeach; ?><br>
      <div id="previous-container">
        <h6>Add new previous job titles</h6><br>
      </div>
      <a href="#" id="add-prev-job-btn" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add an extra job</a>
      <hr>
	    <button type="submit" class="btn btn-primary">Save</button>
	    <a href="index.php" class="btn">Cancel</a>
      

	  </form>
    <br>
	</div>

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
