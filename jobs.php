<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  if (isset($_POST['job_keyword'])) {
    $jobs = array();

    $sql_jobs = "EXEC search_jobs1 '" . $_POST['job_keyword'] . "'";

    $stmt_jobs = sqlsrv_query($conn, $sql_jobs);

    if(!$stmt_jobs) {
      die( print_r( sqlsrv_errors(), true));
    }

    while($row = sqlsrv_fetch_array($stmt_jobs, SQLSRV_FETCH_ASSOC)) {
      array_push($jobs, $row);
    }
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
    <h2 class="text-center">Search for jobs !</h2>

    <form class="form-group" action="jobs.php" method="POST">
      <div class="row">
        <div class="col-md-10">
          <input class="form-control" type="text" placeholder="Software Engineer" name="job_keyword">
        </div>
        <div class="col-md-2">
          <button class="btn btn-info" type="submit">Search</button>
        </div>
      </div>
    </form>

    <hr>

    <?php if(isset($jobs)): ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Company</th>
            <th>Department</th>
            <th>Title</th>
            <th>Short Description</th>
            <th>Detailed Description</th>
            <th>Min Experience</th>
            <th>Salary</th>
            <th># Of vacancies</th>
            <th>working hours</th>
            <th>Deadline</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($jobs as $job): ?>
            <tr>
              <td><?php echo $job['Company'] ?></td>
              <td><?php echo $job['Department'] ?></td>
              <td><?php echo $job['title'] ?></td>
              <td><?php echo $job['short_description'] ?></td>
              <td><?php echo $job['detailed_description'] ?></td>
              <td><?php echo $job['min_experience'] ?></td>
              <td><?php echo $job['salary'] ?></td>
              <td><?php echo $job['no_of_vacancies'] ?></td>
              <td><?php echo $job['working_hours'] ?></td>
              <td><?php echo $job['deadline']->format('m/d/Y') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
