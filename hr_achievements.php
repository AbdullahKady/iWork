<?php
    session_start();
    include_once 'includes/db_connect.php';
		$username = $_SESSION['logged_in_user']['username'];


	  if(isset($_POST['year'])){
	  	$year = $_POST['year'];
	  	$month = $_POST['month'];
			$achievers = array();
    	$sql_achievers = "EXEC viewHighestAchiever '" . $username . "','" .$year."','".$month."'";
  		$stmt_achievers = sqlsrv_query($conn, $sql_achievers);
  		if(!$stmt_achievers) {
    		die( print_r( sqlsrv_errors(), true));
    	}
    	while($row = sqlsrv_fetch_array($stmt_achievers, SQLSRV_FETCH_ASSOC)) {
    		array_push($achievers, $row);
    	}

    	/*$flash_message = '<div class="alert alert-info text-center">Total hours during the month <b>'. $month."-".$year.' </b> is <strong>'. $achievers[0][''] .'</strong> hour(s)</div>';*/
	  }
	  if(isset($_POST['serialized_achievers'])){
	  	$year = $_POST['year'];
	  	$month = $_POST['month'];
	  	$serialized_achievers = $_POST["serialized_achievers"];
			$unserialized_achievers = unserialize(base64_decode($serialized_achievers));
			foreach ($unserialized_achievers as $unserialized_achiever) {
				$achiever_username = $unserialized_achiever['Username'];
    		$sql = "EXEC sendMailAchiever '" . $username . "','" . $achiever_username. "','" .$year."','".$month."'";
  			$stmt= sqlsrv_query($conn, $sql);
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
		<?php if(isset($serialized_achievers)): ?>
			<div class="alert alert-success alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <b>Success!</b> Emails has been sent to the top 3 achievers.
			</div>
		<?php endif; ?>


		<h3 class="text-center">Choose a month to display the top 3 high achievers in your department </h3>
		<h6 class="text-center">(A high achiever is a regular employee who stayed the longest hours in the company for a certain month and all tasks assigned to him/her with deadline within this month are fixed.)</h6>
		<hr>
		<form action="hr_achievements.php" method="POST" class="form-group">
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
			<br>
			<button type="submit" class ="btn btn-info btn-block btn-lg">View top 3 achievers!</button>
		</form>

		<?php if(isset($achievers)): ?>
			<?php if(!empty($achievers)): ?>
				<h3 class="text-center"> The top 3 achievers in <b><?php echo $month." - ".$year ." are:" ?></b></h3>
				<hr>
				<div class="text-center">
					<?php foreach ($achievers as $achiever): ?>
						<p>
							<?php echo  "<b>" . $achiever['Name'] ."</b>" .', worked for a total of ' . $achiever['HoursAttended'] . "<b> hours.</b>" ?>
						</p>
					<?php endforeach; ?>
				</div>
				<hr>
				<form action="hr_achievements.php" method="POST" class="form-group">
					<h6 class="text-center"> You can send them a <b>congratulations email</b>, just click on the button below</h6>
					<input type="hidden" name="year" value=<?php echo $year ?> >
					<input type="hidden" name="month" value=<?php echo $month ?> >
					<input type="hidden" name="serialized_achievers" value="<?php print base64_encode(serialize($achievers)) ?>" >
					<button type="submit" class ="btn btn-success btn-block btn-lg">CLICK HERE TO SEND THEM MAILS!</button>
				</form>
			<?php else : ?>
				<div class="alert alert-info">Looks like there are no <strong>top achievers</strong> for the month of <b><?php echo $month." - ".$year ?></b> .</div>
			<?php endif; ?>
		<?php endif; ?>


	</div>




  <?php include_once 'includes/scripts.php';?>
</body>
</html>
