<?php
    session_start();
    include_once 'includes/db_connect.php';
    parse_str($_SERVER['QUERY_STRING']);
		$username = $_SESSION['logged_in_user']['username'];

  	if(isset($_POST["job_title"])) {
      $job_title = $_POST["job_title"];
  		$role = $_POST["role"];

      $job_title = $role . ' - ' . $job_title;

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
      	while($res = sqlsrv_next_result($prepared_stmt)) {};
      
      
      	if ($procedure_params['output'] === 'Success') {
          //INSERTING QUESTIONS AFTER MAKING SURE THE JOB INSERTION WAS SUCCESSFULL
          if(isset($_POST['questions'])){
            $questions = $_POST['questions'];
            foreach ($questions as $question) {
              $question_body = $question["'question_body'"];
              $answer = $question["'answer'"];

              $sql_questions = "EXEC addQuestionsJob '". $username . "','" . $job_title . "','" . $question_body . "',". $answer;
              $stmt= sqlsrv_query($conn, $sql_questions);
            }

          }
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

  <style>
    textarea {
      resize: none;
    }
    .container-radiobtns {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 22px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

/* Hide the browser's default radio button */
    .container-radiobtns input {
      position: absolute;
      opacity: 0;
    }

/* Create a custom radio button */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 25px;
      width: 25px;
      background-color: #eee;
      border-radius: 50%;
    }

/* On mouse-over, add a grey background color */
    .container-radiobtns:hover input ~ .checkmark {
      background-color: #ccc;
    }

/* When the radio button is checked, add a blue background */
    .container-radiobtns input:checked ~ .checkmark {
      background-color: #2196F3;
    }

/* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

/* Show the indicator (dot/circle) when checked */
    .container-radiobtns input:checked ~ .checkmark:after {
      display: block;
    }

/* Style the indicator (dot/circle) */
    .container-radiobtns .checkmark:after {
      top: 9px;
      left: 9px;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: white;
    }
</style>
</head>

<body>
  <?php include_once 'templates/navbar.tpl.php';?>
	<div class="container">
  	<?php if(isset($flash_message)): ?>
      <?php echo $flash_message; ?>
  	<?php endif; ?>

		<h3 class="text-center">Add a new job</h3>
		<hr>
		<form action="hr_add_job.php" method="POST" class="form-group">
      <div class="row">
        <div class="col-md-3">
          <label><strong>Role</strong></label>
          <select name="role" class="form-control">
            <option>Manager</option>
            <option>HR</option>
            <option>Regular Employee</option>
          </select>
        </div>

        <div class="col-md-9">
          <label><strong>Job Title</strong></label>
          <input class="form-control" type="text" placeholder="Enter job title" name="job_title" required maxlength="50">
        </div>
      </div>
      

      <label><strong>Short Description</strong></label>
      <input class="form-control" type="text" placeholder="Enter a short description for the job" name="short_description" required maxlength="120">
      <label><strong>Detailed Description</strong></label>
      <textarea class="form-control" type="text" placeholder="Enter a detailed description for the job" name="detailed_description" required maxlength="3000" rows="3"></textarea>
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
      <div class="row">
        <div class="col-md-9" id="questions-container">
          <h6>Add interview question(s) (optional)</h6>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2" id="answers-container">
          <h6>Model answer(s)</h6>
        </div>
      </div>
      <br>
      <a href="#" id="add-new-question-btn" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add an extra question</a>
      <hr>
      <button class="btn btn-primary">Add job</button>
    	<a href="human_resources.php" class="btn">Cancel</a> 
		</form>

  <?php include_once 'includes/scripts.php';?>
  <script>
    let addNewQuestionButton = document.querySelector('#add-new-question-btn');
    let i = 0;
    addNewQuestionButton.addEventListener('click', event => {
      event.preventDefault();

      document.getElementById("questions-container").insertAdjacentHTML('beforeend', `<textarea class="form-control" name="questions[${i}]['question_body']" type="text" placeholder="Insert your question" rows="3" maxlength="20" required></textarea><br>`);
  
      document.getElementById("answers-container").insertAdjacentHTML('beforeend', `
            <label class="container-radiobtns">Yes
              <input type="radio" value="1" name="questions[${i}]['answer']" checked>
              <span class="checkmark"></span>
            </label>
            <label class="container-radiobtns">No
              <input type="radio" value="0" name="questions[${i}]['answer']">
              <span class="checkmark"></span>
            </label>
            `);
      i++;
    });

  </script>
</body>
</html>
