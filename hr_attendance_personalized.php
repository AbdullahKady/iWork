<?php
    session_start();

    include_once 'includes/db_connect.php';
	  $username = $_SESSION['logged_in_user']['username'];
	  $staff_member = $_POST["staff_member"];

	  if(isset($_POST['year'])){
	  	$year = $_POST['year'];
	  	$month = $_POST['month'];
			$total_hours = array();
    	$sql_total_hours = "EXEC viewTotalHoursHR '" . $username . "','". $staff_member . "','" .$year."','".$month."'";
  		$stmt_total_hours = sqlsrv_query($conn, $sql_total_hours);
  		if(!$stmt_total_hours) {
    		die( print_r( sqlsrv_errors(), true));
    	}
    	while($row = sqlsrv_fetch_array($stmt_total_hours, SQLSRV_FETCH_ASSOC)) {
    		array_push($total_hours, $row);
    	}
    	if($total_hours[0][''] == ''){
    		$total_hours[0][''] = 0;
    	}
    	$flash_message = '<div class="alert alert-info text-center">Total hours during the month <b>'. $month."-".$year.' </b> is <strong>'. $total_hours[0][''] .'</strong> hour(s)</div>';
	  }



		$name = array();
    $sql_name = "SELECT ISNULL(first_name,'') + ' ' + ISNULL(middle_name,'') + ' ' + ISNULL(last_name,'') AS 'Name' FROM Users WHERE username = " . "'". $staff_member . "'";
  	$stmt_name = sqlsrv_query($conn, $sql_name);
  	if(!$stmt_name) {
    	die( print_r( sqlsrv_errors(), true));
    }
    while($row = sqlsrv_fetch_array($stmt_name, SQLSRV_FETCH_ASSOC)) {
    	array_push($name, $row);
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

		<h3 class="text-center">Attendance page of <strong><?php echo $name[0]['Name']?></strong></h3>
		<hr>
		<h4 class="text-center">Check all records during a specific duration : </h4>
		<form action="hr_attendance_records.php" method="POST" class="form-group">
			<div class="row">
				<div class="col-md-5">
					<label for="start_date"><strong>Start Date</strong></label>
					<input class="form-control" type=date name="start_date" id="start" required>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-5">
					<label for="end_date"><strong>End Date</strong> (must be later than the start date)</label>
					<input class="form-control" type=date name="end_date" id="end" required>
				</div>
			</div>
			<hr>
			<button type="submit" name="staff_member" value=<?php echo $staff_member?> class ="btn btn-info btn-block btn-lg">Check <b>all records</b></button>
		</form>
		<hr>

		<h4 class="text-center">Check the total duration (in hours) during a certain month </h4>
		<form action="hr_attendance_personalized.php" method="POST" class="form-group">
			<div class="row">
				<div class="col-md-5">
					<label for="year"><strong>Year</strong></label>
					<input class="form-control" type="number" name="year" min="1950" max="2018" placeholder="eg: 2017" required>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-5">
					<label for="month"><strong>Month</strong> (In numbers)</label>
					<input class="form-control" type="number" name="month" min="1" max="12" placeholder="eg: enter 3 for March" required>
				</div>
			</div>
			<hr>
			<button type="submit" name="staff_member" value=<?php echo $staff_member?> class ="btn btn-info btn-block btn-lg">Check <b>total hours</b></button>
		</form>


	</div>

  <?php include_once 'includes/scripts.php';?>
  <script>
		var start = document.getElementById('start');
		var end = document.getElementById('end');
		
		start.addEventListener('change', function() {
		    if (start.value)
		        end.min = start.value;
		}, false);
		end.addEventListener('change', function() {
		    if (end.value)
		        start.max = end.value;
		}, false);
	</script>


</body>
</html>
