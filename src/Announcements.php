<?php
    session_start();

    include_once 'includes/db_connect.php';
    $username = $_SESSION['logged_in_user']['username'];
    $vars = array();
  // EXEC the procedure
    $sql = "EXEC view_announcements"."'".$username."'";

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
    <h1 class="text-center">Announcements</h1>


  


   <table class="table table-hover">
      <thead>
        <tr>
          <th>Title</th>
          <th>Date</th>
          <th>Type</th>
          <th>Description</th>

        </tr>
      </thead>

      <tbody>
      <?php foreach ($vars as $var): ?>
        <tr>
          <td><?php echo $var['title'] ?></td>
          <td><?php echo $var['date'] ->format('d/m/Y');?></td>
          <td><?php echo $var['type']?> </td>
          <td><?php echo $var['description']?> </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

  <?php include_once 'includes/scripts.php';?>
  </div>
</body>
</html>
