<?php
    session_start();

    include_once 'includes/db_connect.php';
    parse_str($_SERVER['QUERY_STRING']);
    $username = $_SESSION['logged_in_user']['username'];
    if(isset($accept,$job,$job_seeker)){
    	$sql = "EXEC decideApplicationHR '".$username."' , '" . $job . "','" . $job_seeker."',".$accept ;
    	$stmt = sqlsrv_query($conn,$sql);
    	if($accept == 1){
    		$flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success! </strong>The application has been <strong>accepted</strong></div>'; 
    	}
    	else{
    		$flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success! </strong>The application has been <strong>rejected</strong></div>'; 
    	}
    }
    

    $jobs = array();
    $sql_jobs = "EXEC viewInformationJobHR '" .$username . "' ,  '" . $job . "'";
    $stmt_jobs = sqlsrv_query($conn, $sql_jobs);
    if(!$stmt_jobs) {
      die( print_r( sqlsrv_errors(), true));
    }
    while($row = sqlsrv_fetch_array($stmt_jobs, SQLSRV_FETCH_ASSOC)) {
      array_push($jobs, $row);
    }

    

		$applications = array();
    $sql_applications = "EXEC viewApplicationHR '" . $username . "' , " . "'". $job . "'";
    $stmt_application = sqlsrv_query($conn, $sql_applications);
    if(!$stmt_application) {
      die( print_r( sqlsrv_errors(), true));
    }
    while($row = sqlsrv_fetch_array($stmt_application, SQLSRV_FETCH_ASSOC)) {
      array_push($applications, $row);
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
			<div class="container">
				<div class = "row">
					<div class="col-sm-12">
						<?php echo $flash_message; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>


		<h3 class = "text-center"> Job Details </h3>

		<?php if(isset($jobs)): ?>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Title</th>
						<th>Short Description</th>
						<th>Detailed Description</th>
						<th>Min Experience</th>
						<th>Salary</th>
						<th># Of vacancies</th>
						<th>working hours</th>
						<th>Deadline</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($jobs as $job_i): ?>
						<tr>
							<td><?php echo $job_i['title'] ?></td>
							<td><?php echo $job_i['short_description'] ?></td>
							<td><?php echo $job_i['detailed_description'] ?></td>
							<td><?php echo $job_i['min_experience'] ?></td>
							<td><?php echo $job_i['salary'] ?></td>
							<td><?php echo $job_i['no_of_vacancies'] ?></td>
							<td><?php echo $job_i['working_hours'] ?></td>
							<td><?php echo $job_i['deadline']->format('m/d/Y') ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>

		<hr>

		
		<?php if(!empty($applications)): ?>
			<h3 class = "text-center"> Pending Applications </h3>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Applicant Name</th>
						<th>Age</th>
						<th>Birth Date</th>
						<th>Years of Experience</th>
						<th>Score</th>
						<th>Decide on Application</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($applications as $application): ?>
						<tr>							
							<td><?php echo $application['first_name'] . " " . $application['middle_name'] . " " . $application['last_name']  ?></td>
							<td><?php echo $application['age'] ?></td>
							<td><?php echo $application['birth_date']->format('m/d/Y') ?></td>
							<td><?php echo $application['years_of_experience'] ?></td>
							<td><?php echo $application['score'] ?></td>
							<?php $application_path = "hr_applications.php?job=".$job ."&job_seeker=". $application['username']."&accept="  ?>
							<td><a href="<?php echo $application_path."1" ?>" class = "btn btn-success">Accept</a> <a href ="<?php echo $application_path . "0" ?>" class="btn btn-danger">Reject</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		<?php else : ?>
			<div class="alert alert-info">Looks like there are no <strong>pending applications</strong> for this job.</div>
		<?php endif; ?>

	</div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
