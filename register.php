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
    <div class="container">
      <label><strong>Username</strong></label>
      <input class="input-control" type="text" placeholder="Enter Username" name="username" required>

      <label><strong>Password</strong></label>
      <input class="input-control" type="password" placeholder="Enter Password" name="password" required>

      <label><strong>Email</strong></label>
      <input class="input-control" type="text" placeholder="Enter Username" name="username" required>

      <label><strong>Username</strong></label>
      <input class="input-control" type="text" placeholder="Enter Username" name="username" required>
      
      <label><strong>Username</strong></label>
      <input class="input-control" type="text" placeholder="Enter Username" name="username" required>




      <button class="btn btn-primary" type="submit">Register</button>
      <a href="index.php" class="btn">Cancel</a>
    </div>


  </form>

</body>
</html>