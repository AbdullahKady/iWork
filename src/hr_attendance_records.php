<?php
    session_start();
    include_once 'includes/db_connect.php';
	  $username = $_SESSION['logged_in_user']['username'];

	  if(isset($_POST["staff_member"])) {
	  	$attendances = array();
	  	$staff_member =$_POST["staff_member"];
	  	$start_date =$_POST["start_date"];
	  	$end_date =$_POST["end_date"];
    	$sql_attendances = "EXEC viewAttendanceHR'" . $username . "','" . $staff_member ."','".$start_date."','".$end_date."'";
    	$stmt_attendances = sqlsrv_query($conn, $sql_attendances);
    	if(!$stmt_attendances) {
    		die( print_r( sqlsrv_errors(), true));
    	}
    	while($row = sqlsrv_fetch_array($stmt_attendances, SQLSRV_FETCH_ASSOC)) {
    		array_push($attendances, $row);
    	}

    	/* Some of the worst possible coding, I DON'T CARE ANYMORE! */
    	$name = array();
    	$sql_name = "SELECT ISNULL(first_name,'') + ' ' + ISNULL(middle_name,'') + ' ' + ISNULL(last_name,'') AS 'Name' FROM Users WHERE username = " . "'". $staff_member . "'";
  		$stmt_name = sqlsrv_query($conn, $sql_name);
  		if(!$stmt_name) {
    		die( print_r( sqlsrv_errors(), true));
    	}
    	while($row = sqlsrv_fetch_array($stmt_name, SQLSRV_FETCH_ASSOC)) {
    		array_push($name, $row);
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

	<h5 class="text-center">Attednace records for <?php echo $name[0]['Name'] ?> </h5>
	<h6 class="text-center">From: <?php echo $start_date?>, through: <?php echo $end_date?></h6>

	<hr>

	<?php if(isset($attendances)): ?>
	  <table class="table table-hover">
	      <thead>
	          <tr>
	              <th>Day</th>
	              <th>Check-in Time</th>
	              <th>Check-out Time</th>
	              <th>Duration</th>
	              <th>Missed Hours</th>
	          </tr>
	      </thead>
	      <tbody>
						<?php if(!empty($attendances)): ?>
	          <?php foreach ($attendances as $attendance): ?>
	              <tr>
	                  <td><?php echo $attendance['Day']->format('Y-m-d') ?></td>
	                  <td><?php echo $attendance['Check-in time'] ?></td>
	                  <td><?php echo $attendance['Check-out time'] ?></td>
	                  <td><?php echo $attendance['Duration'] ?></td>
	                  <td><?php echo $attendance['Missed Hours'] ?></td>
	              </tr>
	          <?php endforeach; ?>
						<?php else : ?>
							<div class="alert alert-info">Looks like there are no <strong>attendance records</strong> for <b><?php echo $name[0]['Name'] ?></b> in the specified duration.</div>
						<?php endif; ?>
	      </tbody>
	  </table>
	<?php endif; ?>

</div>

</body>
</html>
