<?php
  session_start();
  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);
  $username = $_SESSION['logged_in_user']['username'];
	$user_data = array();
  // EXEC the procedure
  $sql = "EXEC viewInformationJobHR " . "'". $username . "','" . $job . "'";

  $stmt = sqlsrv_query($conn, $sql);

  if(!$stmt) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $user_data = $row;
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

	  <form action="human_resources.php?status=job_edited" method="POST">

	    <div class="form-group">
	      <label for="title">Job Title</label>
	      <input type="text" class="form-control" maxlength="50" readonly="readonly" name="title" value="<?php echo $user_data['title'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="short_description">Short Description</label>
	      <input type="text" class="form-control" maxlength="120" name="short_description" value="<?php echo $user_data['short_description'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="detailed_description">Detailed Description</label>
	      <input type="text" class="form-control" maxlength="3000" name="detailed_description" value="<?php echo $user_data['detailed_description'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="salary">Salary</label>
	      <input type="number" class="form-control" min="0" name="salary" value="<?php echo $user_data['salary'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="no_of_vacancies">Number of Vacancies</label>
	      <input type="number" class="form-control" min="0" max="9999" name="no_of_vacancies" value="<?php echo $user_data['no_of_vacancies'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="min_experience">Minimum Years of Experience</label>
	      <input type="number" class="form-control" min="0" max="60" name="min_experience" value="<?php echo $user_data['min_experience'] ?>">
	    </div>

			<div class="form-group">
        <label for="working_hours">Working Hours</label>
        <input type="number" class="form-control"  min="0" max="24" name="working_hours" value="<?php echo $user_data['working_hours'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="deadline">Deadline</label>
	      <input type="date" class="form-control" min="1950-12-12" max="2017-11-11" name="deadline" value="<?php echo $user_data['deadline']->format('Y-m-d') ?>">
	    </div>

	    <button type="submit" class="btn btn-primary">Save</button>
	    <a href="human_resources.php" class="btn">Cancel</a>

	  </form>

	</div>
	<br>

	<?php include_once 'includes/scripts.php';?>

</body>
</html>
