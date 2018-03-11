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

  if(isset($_GET['apply'])){

    $sql_pk = "select j.department, j.company from Jobs j, Departments d, Companies c where c.name = '" 
    . $_GET['company_keyword'] . "' and d.name = '" 
    . $_GET['department_keyword']. "' and j.title = '" 
    . $_GET['title_keyword'] . "' and d.code = j.department and c.email = j.company";

    $stmt_pk = sqlsrv_query($conn, $sql_pk);

    if(!$stmt_pk) {
      die( print_r( sqlsrv_errors(), true));

    }

    $pk = sqlsrv_fetch_array($stmt_pk, SQLSRV_FETCH_ASSOC);
      
    $username = $_SESSION['logged_in_user']['username'];
    $title = $_GET['title_keyword'];
    if(!empty($pk)){
      $department = $pk['department'];
      $company = $pk['company'];
    }
    //$department = $_POST['department_keyword'];
    //$company = $_POST['company_keyword'];

    $procedure_params['username'] = $_SESSION['logged_in_user']['username'];
    $procedure_params['title'] = $title;
    $procedure_params['department'] = $department;
    $procedure_params['company'] = $company;
    $procedure_params['output'] = "";

    $procedure_passed_params = array(
      array(&$procedure_params['username'], SQLSRV_PARAM_IN),
      array(&$procedure_params['title'], SQLSRV_PARAM_IN),
      array(&$procedure_params['department'], SQLSRV_PARAM_IN),
      array(&$procedure_params['company'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    $sql_apply = "EXEC Apply_Job @username = ?, @title = ?, @department = ?, @company = ?, @output = ?";
    
    $stmt_apply = sqlsrv_prepare($conn, $sql_apply, $procedure_passed_params);

    if(!$stmt_apply) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($stmt_apply)) {
      while($res = sqlsrv_next_result($stmt_apply)) {/* pass */};
      
      if ($procedure_params['output'] === 'Succesfully Applied for job!' ) {
        

        header("Location: seeker_job_questions.php?company_keyword=".$procedure_params['company']."&department_keyword=".$procedure_params['department']."&title_keyword=".$procedure_params['title']);
        die();
      }elseif ($procedure_params['output'] === 'Minimum experience years is not met!'){
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" 
          aria-label="close">&times;</a> Minimum experience years requirement not met. </div>';
      } elseif ($procedure_params['output'] === 'You already applied to this job!') {
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> You have already applied for this job, please check for status changes.</div>';
      }else{
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Please Register First. </div>';
      }
    } else {
      die( print_r( sqlsrv_errors(), true));
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

  <?php if(isset($flash_message)): ?>
    <div class="container">
      <div class = "row">
        <div class="col-sm-12">
         <?php echo $flash_message; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <div class="container">
    <h2 class="text-center">Search for jobs !</h2>

    <form class="form-group" action="seeker_apply_job.php" method="POST">
      <div class="row">
        <div class="col-md-10">
          <input class="form-control" type="text" placeholder="Software Engineer" maxlength="120" name="job_keyword">
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
            <th>Application</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($jobs as $job): ?>
            <tr>
              <td><?php echo $job['Company'] . ''?></td>
              <td><?php echo $job['Department'] ?></td>
              <td><?php echo $job['title'] ?></td>
              <td><?php echo $job['short_description'] ?></td>
              <td><?php echo $job['detailed_description'] ?></td>
              <td><?php echo $job['min_experience'] ?></td>
              <td><?php echo $job['salary'] ?></td>
              <td><?php echo $job['no_of_vacancies'] ?></td>
              <td><?php echo $job['working_hours'] ?></td>
              <td><?php echo $job['deadline']->format('m/d/Y') ?></td>
              <td>
                <form action = 'seeker_apply_job.php' method= "GET">
                  <input  type = 'hidden' name = 'company_keyword' value = "<?php echo $job['Company']?>">
                  <input  type = 'hidden' name = 'department_keyword' value = "<?php echo $job['Department']?>">
                  <input  type = 'hidden' name = 'title_keyword' value = "<?php echo $job['title'] ?>">
                  <button class="btn btn-primary" type="submit" name = "apply">Apply</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
