<?php
    session_start();

    include_once 'includes/db_connect.php';
    $vars = array();
    $sql = "EXEC Having_Highest_Salary";
    $stmt = sqlsrv_query($conn, $sql);
    if(!$stmt) {
    	die( print_r( sqlsrv_errors(), true));
  	}

	  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	    array_push($vars,$row) ;
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
    <h1 class="text-center">Highest paying companies</h1>
    <h3 class="text-center">(Average of salaries)</h1>

  


   <table class="table table-hover">
      <thead>
        <tr>
          <th>Company</th>
          <th>Email</th>
          <th>Average Salary</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($vars as $var): ?>
        <tr>
          <td><?php echo $var['name'] ?></td>
          <td><?php echo $var['email'] ?></td>
          <td><?php echo $var['avg'] ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

  <?php include_once 'includes/scripts.php';?>
	</div>
</body>
</html>
