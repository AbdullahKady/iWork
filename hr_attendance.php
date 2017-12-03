<?php
    session_start();
    include_once 'includes/db_connect.php';
	  $username = $_SESSION['logged_in_user']['username'];


    $staff_members = array();
    $sql_staff_members = "EXEC viewAllMembersHR'" . $username . "'";
    $stmt_staff_members = sqlsrv_query($conn, $sql_staff_members);
    if(!$stmt_staff_members) {
    	die( print_r( sqlsrv_errors(), true));
    }
    while($row = sqlsrv_fetch_array($stmt_staff_members, SQLSRV_FETCH_ASSOC)) {
    	array_push($staff_members, $row);
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
	<h3 class="text-center"> Choose the duration for the attendance records </h3>
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
		
		<br>
		<?php if(isset($staff_members)): ?>
		    <table class="table table-hover">
		        <thead>
		            <tr>
		                <th>Employee's Name</th>
		                <th>Company E-mail</th>
		                <th>Job</th>
		                <th>Day-Off</th>
		                <th>View attendance</th>

		            </tr>
		        </thead>
		        <tbody>
		            <?php foreach ($staff_members as $staff_member): ?>
		                <tr>
		                    <td><?php echo $staff_member['Name'] ?></td>
		                    <td><?php echo $staff_member['company_email'] ?></td>
		                    <td><?php echo $staff_member['job'] ?></td>
		                    <td><?php echo $staff_member['day_off'] ?></td>
		                    <td><button type="submit" name="staff_member" value=<?php echo $staff_member['username']?> class ="btn btn-info"> Check attendance</button></td>

		                </tr>
		            <?php endforeach; ?>
		        </tbody>
		    </table>
		<?php endif; ?>

	</form>
</div>

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
