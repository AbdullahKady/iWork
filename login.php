<?php
  session_start();
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

    <!-- MARKUP -->

    <!-- START NAVBAR -->
    

    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">iWork</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="#">something</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="login.php">Login</a>
            </li>
            <li>
                <a href="signup.php">Signup</a>
            </li>

          </ul>

        </div>
      </div>
    </nav>

    <!-- END NAVBAR -->

  <form action="" class="input-group container">
    <div class="container">
      <label><b>Username</b></label>
      <input class="input-control" type="text" placeholder="Enter Username" name="username" required>

      <label><b>Password</b></label>
      <input class="input-control" type="password" placeholder="Enter Password" name="password" required>

      <button class="btn btn-primary" type="submit">Login</button>
      <a href="index.php" class="btn">Cancel</a>
    </div>


  </form>

</body>
</html>