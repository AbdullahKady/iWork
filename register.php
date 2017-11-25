<?php
  session_start();
  include_once 'includes/db_connect.php';
?>


<!DOCTYPE html>
<html>
<head>
    <title>iWork</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>

<body>

	<?php include_once 'templates/navbar.tpl.php';?>

  <form action="" class="input-group container">
    <div>
      <label><strong>Username</strong></label>
      <input class="input-control" type="text" placeholder="Enter Username" name="username" required>

      <label><strong>Password</strong></label>
      <input class="input-control" type="password" placeholder="Enter Password" name="password" required>

      <label><strong>Personal Email</strong></label>
      <input class="input-control" type="text" placeholder="john@doe.com" name="email" required>

      <label><strong>Birth date</strong></label>
      <input class="input-control" type="text" placeholder="MM/DD/YYYY" name="birth_date" required>
      
      <label><strong>Years of Experience</strong></label>
      <input class="input-control" type="number" name="years_of_experience" min="0" max="99" required>

      <hr>

      <label><strong>First Name</strong></label>
      <input class="input-control" type="text" placeholder="john" name="first_name">

      <label><strong>Middle Name</strong></label>
      <input class="input-control" type="text" placeholder="doe" name="middle_name">

      <label><strong>Last Name</strong></label>
      <input class="input-control" type="text" placeholder="smith" name="last_name">

    </div>

    <button class="btn btn-primary" type="submit">Register</button>
    <a href="index.php" class="btn">Cancel</a> 


  </form>

</body>
</html>