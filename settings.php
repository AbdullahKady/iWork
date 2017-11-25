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

	// TODO: Add flash message
	if(isset($_POST["first_name"])) {
		
 		// Fetch data from the form
    $password = $_POST["new_password"];
    $email = $_POST["email"];
    $birth_date = $_POST["birth_date"];
    $years_of_experience = $_POST["years_of_experience"];
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];

	  // specify params - MUST be a variable that can be passed by reference!
    $procedure_params['name'] = $username;
    $procedure_params['pass'] = $password;
    $procedure_params['p_email'] = $email;
    $procedure_params['bd'] = $birth_date;
    $procedure_params['exp'] = $years_of_experience;
    $procedure_params['f_name'] = $first_name;
    $procedure_params['m_name'] = $middle_name;
    $procedure_params['l_name'] = $last_name;


    // Set up the procedure params array - be sure to pass the param by reference
    $procedure_passed_params = array(
      array(&$procedure_params['name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['pass'], SQLSRV_PARAM_IN),
      array(&$procedure_params['p_email'], SQLSRV_PARAM_IN),
      array(&$procedure_params['bd'], SQLSRV_PARAM_IN),
      array(&$procedure_params['exp'], SQLSRV_PARAM_IN),
      array(&$procedure_params['f_name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['m_name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['l_name'], SQLSRV_PARAM_IN)
      
    );

	  // EXEC the procedure
    $sql = "EXEC Edit_personal_information @name = ?, @pass = ?, @p_email = ?, @bd = ?, @exp = ?, @f_name = ?, @m_name = ?, @l_name = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {

        echo "Success";
      
    } else {
      die( print_r( sqlsrv_errors(), true));
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

	<div class="container" id="profile">

	  <div class="centered">
	    <h2>
	    	<strong>
	    		<?php echo $_SESSION['logged_in_user']['username']; ?>'s profile
	    	</strong>
	    </h2>
	  </div>

	  <form action="settings.php" method="POST">

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

	    <div class="form-group">
	      <label for="birth_date">Birth Date</label>
	      <input type="text" class="form-control" name="birth_date" value="<?php echo $user_data['birth_date']->format('m/d/Y') ?>">
	    </div>

	    <div class="form-group">
	      <label for="years_of_experience">Years of Experience</label>
	      <input type="number" class="form-control" name="years_of_experience" value="<?php echo $user_data['years_of_experience'] ?>">
	    </div>

			<div class="form-group">
      <label for="age">Age</label>
      <input type="number" class="form-control" disabled value="<?php echo $user_data['age'] ?>">
	    </div>

	    <div class="form-group">
	      <label for="new_password">New Password</label>
	      <input type="password" class="form-control" name="new_password" placeholder="•••••••" required>
	    </div>

	    <button type="submit" class="btn btn-primary">Save</button>
	    <a href="index.php" class="btn">Cancel</a>

	  </form>

	</div>

	<?php include_once 'includes/scripts.php';?>

</body>
</html>
