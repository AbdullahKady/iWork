<?php
    session_start();
    include_once 'includes/db_connect.php';
    parse_str($_SERVER['QUERY_STRING']);
		$username = $_SESSION['logged_in_user']['username'];

  	if(isset($_POST["job_title"])) {
  		$job_title = $_POST["job_title"];
    	$short_description = $_POST["short_description"];
    	$detailed_description = $_POST["detailed_description"];
    	$min_experience = $_POST["min_experience"];
    	$salary = $_POST["salary"];
    	$deadline = $_POST["deadline"];
    	$no_of_vacancies = $_POST["no_of_vacancies"];
    	$working_hours = $_POST["working_hours"];

    	$procedure_params['username'] = $username;
    	$procedure_params['job_title'] = $job_title;
    	$procedure_params['short_description'] = $short_description;
    	$procedure_params['detailed_description'] = $detailed_description;
    	$procedure_params['min_experience'] = $min_experience;
    	$procedure_params['salary'] = $salary;
    	$procedure_params['deadline'] = $deadline;
    	$procedure_params['no_of_vacancies'] = $no_of_vacancies;
    	$procedure_params['working_hours'] = $working_hours;
    	$procedure_params['output'] = "";

			$procedure_passed_params = array(
      	array(&$procedure_params['username'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['job_title'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['short_description'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['detailed_description'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['min_experience'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['salary'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['deadline'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['no_of_vacancies'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['working_hours'], SQLSRV_PARAM_IN),
      	array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    	);

			$sql = "EXEC addJobHR @username = ? , @title = ? , @short_description = ? , @detailed_description = ? , @min_experience = ?, @salary = ? , @deadline = ? ,@no_of_vacancies = ? , @working_hours = ? , @status =?";
   	  $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

   		if(!$prepared_stmt) {
      	die( print_r( sqlsrv_errors(), true));
   		}

    	if(sqlsrv_execute($prepared_stmt)) {
      	while($res = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      
      	if ($procedure_params['output'] === 'Success') {
      	  $flash_message='<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b>Success!</b> The job has been added successfully to the department </div>';
      	} else {
      	  $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b>Failed!</b> Sorry, the job you are trying to add already exists in the department. </div>';
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
	<div class="container">
  	<?php if(isset($flash_message)): ?>
      <?php echo $flash_message; ?>
  	<?php endif; ?>

		<h3 class="text-center">Add a new job</h3>
		<hr>
		<form action=<?php echo "hr_add_job.php" ?> method="POST" class="form-group">
			<label><strong>Job Title</strong></label>
      <input class="form-control" type="text" placeholder="Enter job title" name="job_title" required maxlength="20">
      <label><strong>Short Description</strong></label>
      <input class="form-control" type="text" placeholder="Enter a short description for the job" name="short_description" required maxlength="120">
      <label><strong>Detailed Description</strong></label>
      <input class="form-control" type="textarea" placeholder="Enter a detailed description for the job" name="detailed_description" required maxlength="3000">
      <label><strong>Minimum years of experience</strong></label>
      <input class="form-control" type="number" min="0" max="100" placeholder="Enter the minimum required years of experience" name="min_experience" required maxlength="20">
      <label><strong>Salary</strong></label>
      <input class="form-control" type="number" step="0.01" placeholder="Enter the salary" name="salary" required min ="0">
    	<label><strong>Deadline</strong></label>
      <input class="form-control" type="date" placeholder="Enter the deadline for the job" name="deadline" min="1900-12-12" max="2018-11-11"  required>
			<label><strong>Number of vacancies</strong></label>
      <input class="form-control" type="number" placeholder="Enter the number of avaliable vacancies for the job" name="no_of_vacancies" min="0" required>
			<label><strong>Number of working hours</strong></label>
      <input class="form-control" type="number" placeholder="Enter the number of working hours for the job" name="working_hours" min="0" required>
      <br>
      <button class="btn btn-primary" type="submit">Add job</button>
    	<a href="human_resources.php" class="btn">Cancel</a> 
		</form>

  <?php include_once 'includes/scripts.php';?>
</body>
</html>
