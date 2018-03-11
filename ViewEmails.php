<?php
    session_start();
  
    include_once 'includes/db_connect.php';
    $username = $_SESSION['logged_in_user']['username'];
    $vars = array();
  // EXEC the procedure
    $sql = "EXEC view_emails"."'".$username."'";

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
    <h1 class="text-center">Emails</h1>


  


   <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Sender</th>
          <th>Subject</th>
          <th>Type</th>
          <th>Description</th>

        </tr>
      </thead>

      <tbody>
      <?php foreach ($vars as $var): ?>
        <tr>
          <td><?php echo (int)$var['ID']  ?></td>          
          <td><?php echo $var['sender'] ?></td>
          <td><?php echo $var['subject'] ?></td>
          <td><?php echo $var['body']?> </td>
          <td><?php echo $var['date']->format('d/m/Y')?> </td>
          <td> <a href="<?php echo 'Reply_Email.php?mail=' . $var['ID'] ?>">Reply</a> </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

  <?php include_once 'includes/scripts.php';?>
  </div>
</body>
</html>
