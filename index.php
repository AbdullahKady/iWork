<?php
    session_start();
    
    $serverName = "DESKTOP-N1RE9II\SQLEXPRESS";

    $connectionOptions = array(
        "Database" => "iWork"
    );

    // Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    // Sanity check
    if(!$conn) {
        echo "CONNECTION FAILED TO THE DATABASE";
    }
    
    // parse all query strings and create variables with them
    // Example: index.php?username=adolf
    // will create a variable username with value adolf
    parse_str($_SERVER['QUERY_STRING']);

    $sql = "SELECT username FROM Users ";
    $stmt = sqlsrv_query( $conn, $sql );

    $users = array();
    
    if( $stmt === false) {
        echo "stmt false";
    }
    else {

        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              array_push($users, $row['username']);
        }

    }

    sqlsrv_free_stmt($stmt);

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

    <a href="index.php?search_user=Adolf_Hitler" class="btn btn-danger">SEARCH</a>

    <ul>
        <?php if(isset($search_user)): ?>
            <?php foreach ($users as $user): ?>
                <li><?php echo $user?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>