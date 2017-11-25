<?php
  session_start();
  include_once 'includes/db_connect.php';

	$username = $_SESSION['logged_in_user']['username'];
	$user_data = array();
  // EXEC the procedure
  $sql = "SELECT * FROM Users WHERE username = " . "'". $username . "'";

  $stmt = sqlsrv_query($conn, $sql);

  if(!$stmt) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $user_data = $row;
	}

	print_r($user_data)

?>

<!DOCTYPE html>
<html>
<head>
	<?php include_once 'includes/header.php' ?>
</head>

<body>

  <?php include_once 'templates/navbar.tpl.php';?>  

	<div class="container" id="profile">

	  <div class="centered">
	    <h2>
	    	<strong>
	    		<?php echo $_SESSION['logged_in_user']['username']; ?>'s profile
	    	</strong>
	    </h2>
	  </div>

	  <form action="settings.php" method="post" id="update-profile-form">

	    <div class="form-group">
	      <label for="first_name">First Name</label>
	      <input type="text" class="form-control" name="first_name" value="<?php echo $user_data['first_name'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="middle_name">Middle Name</label>
	      <input type="text" class="form-control" name="middle_name" value="<?php echo $user_data['middle_name'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="last_name">Last Name</label>
	      <input type="text" class="form-control" name="last_name" value="<?php echo $user_data['last_name'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="email">Email</label>
	      <input type="email" class="form-control" name="email" value="<?php echo $user_data['personal_email'] ?>">
	    </div>

	    <!-- TODO: Populate others -->
	    <div class="form-group">
	      <label for="birth_date">Birth Date</label>
	      <input type="text" class="form-control" name="birth_date" value="<?php echo $user_data['birth_date']->format('m/d/Y') ?>">
	    </div>

	    <div class="form-group">
	      <label for="new_password">New Password</label>
	      <input type="password" class="form-control" name="new_password" placeholder="•••••••">
	    </div>

	    <button type="submit" class="btn btn-primary">Save</button>
	    <a href="index.php" class="btn">Cancel</a>

	  </form>

	</div>

</body>
</html>
