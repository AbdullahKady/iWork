<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  $vacancies = array();

  $sql_jobs = "EXEC View_All_Vacancies '" . $company_mail . "', '" . $department_code . "'";

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
    <h2 class="text-center">Jobs available in <?php echo $department_code ?></h2>

    <table class="table table-hover">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Min Experience</th>
          <th>Salary</th>
          <th># Of vacancies</th>
          <th>working hours</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($vacancies as $vacancy): ?>
          <tr>
            <td><?php echo $vacancy['title'] ?></td>
            <td><?php echo $vacancy['short_description'] ?></td>
            <td><?php echo $vacancy['min_experience'] ?></td>
            <td><?php echo $vacancy['salary'] ?></td>
            <td><?php echo $vacancy['no_of_vacancies'] ?></td>
            <td><?php echo $vacancy['working_hours'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>



  <?php include_once 'includes/scripts.php';?>

</body>
</html>
