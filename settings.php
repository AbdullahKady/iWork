<?php
  session_start();
  include_once 'includes/db_connect.php';

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
	      <input type="text" class="form-control" name="first_name" value="<?php echo $_SESSION['logged_in_user']; ?>">
	    </div>

	    <div class="form-group">
	      <label for="last_name">Last Name</label>
	      <input type="text" class="form-control" name="last_name" value="<?php echo $_SESSION['logged_in_user']; ?>">
	    </div>

	    <div class="form-group">
	      <label for="email">Email</label>
	      <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['logged_in_user']; ?>">
	    </div>

	    <div class="form-group">
	      <label for="old_password">Old Password</label>
	      <input type="password" class="form-control" name="old_password" placeholder="•••••••">
	    </div>

	    <div class="form-group">
	      <label for="new_password">New Password</label>
	      <input type="password" class="form-control" name="new_password" placeholder="•••••••">
	    </div>

	    <div class="form-group">
	      <label for="confirm_password">New Password</label>
	      <input type="password" class="form-control" name="confirm_password" placeholder="•••••••">
	    </div>

	    <button type="submit" class="btn btn-primary">Save</button>
	    <a href="index.php" class="btn">Cancel</a>

	  </form>

	</div>

</body>
</html>
