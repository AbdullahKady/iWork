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
	<h3 class="text-center"> Choose an Employee to check his attendance </h3>
	<form action="hr_attendance_personalized.php" method="POST" class="form-group">
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

</body>
</html>
