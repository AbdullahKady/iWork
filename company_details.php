<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  $company = array();
  // EXEC the procedure
  $sql = "SELECT * FROM Companies WHERE email = " . "'". $company_mail . "'";
  $stmt = sqlsrv_query($conn, $sql);

  if(!$stmt) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $company = $row;
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
    <h2 class="text-center"><?php echo $company['name'] ?></h2>


    <table class="table table-hover">
      <thead>
        <tr>
          <th>Address</th>
          <th>Email</th>
          <th>Domain</th>
          <th>Type</th>
          <th>Vision</th>
          <th>Specialization</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo $company['address'] ?></td>
          <td><?php echo $company['email'] ?></td>
          <td><?php echo $company['domain'] ?></td>
          <td><?php echo $company['type'] ?></td>
          <td><?php echo $company['vision'] ?></td>
          <td><?php echo $company['specialization'] ?></td>
        </tr>
      </tbody>
    </table>
    
  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
