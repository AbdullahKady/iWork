<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  $vacancies = array();

  $sql_jobs = "view_request_status '" . $_SESSION['logged_in_user']['username'] ."'";

  $stmt_jobs = sqlsrv_query($conn, $sql_jobs);

  if(!$stmt_jobs) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt_jobs, SQLSRV_FETCH_ASSOC)) {
    array_push($vacancies, $row);
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
    <h2 class="text-center">Requests for <?php echo $_SESSION['logged_in_user']['username']?></h2>

    <table class="table table-hover">
      <thead>
        <tr>
          <th>Start Date</th>
          <th>HR response</th>
          <th>Manager Response</th>
         
        </tr>
      </thead>

      <tbody>
        <?php foreach ($vacancies as $vacancy): ?>
          <tr>
            <td><?php echo $vacancy['start_date'] ->format('d/m/Y') ?></td>
            <td><?php echo $vacancy['hr_response'] ?></td>
            <td><?php echo $vacancy['manager_response']  ?></td>
         
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>



  <?php include_once 'includes/scripts.php';?>

</body>
</html>
