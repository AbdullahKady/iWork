<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  //edited 
  if(isset($status)){
    if($status === 'done')
      $flash_message='<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Successfully applied to job! </div>';
  }
  //

   if(isset($_POST['delete'])){

    $username = $_SESSION['logged_in_user']['username'];
    $job = $_POST['job_keyword'];
    $department = $_POST['department_keyword'];
    $company = $_POST['company_keyword'];

    $procedure_params['username'] = $_SESSION['logged_in_user']['username'];
    $procedure_params['job'] = $job;
    $procedure_params['department'] = $department;
    $procedure_params['company'] = $company;
    $procedure_params['output'] = "";

    $procedure_passed_params = array(
      array(&$procedure_params['username'], SQLSRV_PARAM_IN),
      array(&$procedure_params['job'], SQLSRV_PARAM_IN),
      array(&$procedure_params['department'], SQLSRV_PARAM_IN),
      array(&$procedure_params['company'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );
    $sql_delete = "EXEC Delete_Application @username = ?, @job = ?, @department = ?, @company = ?, @output = ?";
    
    $stmt_delete = sqlsrv_prepare($conn, $sql_delete, $procedure_passed_params);

    if(!$stmt_delete) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($stmt_delete)) {
      while($res = sqlsrv_next_result($stmt_delete)) {/* pass */};
      
      if ($procedure_params['output'] === 'Succesfully deleted!' ) {
        $flash_message='<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Deleted Application Successfully </div>';

       //header("Location: seeker_job_questions.php");
       // die();
      }else{
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Cannot Delete Non-Pending Application </div>';
      }
    } else {
      die( print_r( sqlsrv_errors(), true));
    }
  }

    if(isset($_POST['choose'])){

    $username = $_SESSION['logged_in_user']['username'];
    $job = $_POST['job_keyword'];
    $department = $_POST['department_keyword'];
    $company = $_POST['company_keyword'];
    $dayoff = $_POST['dayoff'];

    $procedure_params['username'] = $_SESSION['logged_in_user']['username'];
    $procedure_params['job'] = $job;
    $procedure_params['department'] = $department;
    $procedure_params['company'] = $company;
    $procedure_params['dayoff'] = $dayoff;
    $procedure_params['output'] = "";

    $procedure_passed_params = array(
      array(&$procedure_params['username'], SQLSRV_PARAM_IN),
      array(&$procedure_params['job'], SQLSRV_PARAM_IN),
      array(&$procedure_params['department'], SQLSRV_PARAM_IN),
      array(&$procedure_params['company'], SQLSRV_PARAM_IN),
      array(&$procedure_params['dayoff'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );
    $sql_choose = "EXEC Choose_Job @username = ?, @job = ?, @department = ?, @company = ?, @dayoff = ?, @output = ?";
    
    $stmt_choose = sqlsrv_prepare($conn, $sql_choose, $procedure_passed_params);

    if(!$stmt_choose) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($stmt_choose)) {
      while($res = sqlsrv_next_result($stmt_choose)) {/* pass */};
      
      if ($procedure_params['output'] === 'Manager' ) {
        $_SESSION[logged_in_user][role] = 'Manager';

       header("Location: manager.php?status=success");
        die();
      }else if($procedure_params['output'] === 'Regular'){
        $_SESSION[logged_in_user][role] = 'Regular';

       header("Location: regular.php?status=success");
        die();
      }else if($procedure_params['output'] === 'HR'){
        $_SESSION[logged_in_user][role] = 'HR';

       header("Location: human_resources.php?status=success");
        die();
      }else if($procedure_params['output'] === 'Job Application Not Accepted!'){
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Invalid job selection </div>';

      }else{
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Invalid dayoff </div>';
      }
    } else {
      die( print_r( sqlsrv_errors(), true));
    }

  }

  
  $jobs = array();

  $sql_status = "EXEC View_Status '" . $_SESSION['logged_in_user']['username'] . "'";

  $stmt_status = sqlsrv_query($conn, $sql_status);

  if(!$stmt_status) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt_status, SQLSRV_FETCH_ASSOC)) {
    array_push($jobs, $row);
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

    <hr>

    <?php if(isset($jobs)): ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Company</th>
            <th>Department</th>
            <th>Title</th>
            <th>HR Response</th>
            <th>Manager Response</th>
            <th>Score</th>
            <th>Action</th>

          </tr>
        </thead>

        <tbody>
          <?php foreach ($jobs as $job): ?>
            <tr>
              <td><?php echo $job['company'] ?></td>
              <td><?php echo $job['department'] ?></td>
              <td><?php echo $job['job'] ?></td>
              <td><?php echo ((isset($job['hr_response']))? (($job['hr_response'] === 1)? 'Approved':'Rejected'):'Pending'); ?></td>
              <td><?php echo ((isset($job['manager_response']))? (($job['manager_response'] === 1)? 'Approved':'Rejected'):'Pending'); ?></td>
              <td><?php echo $job['score'] ?></td>
              
                                
                <form action = "seeker_view_status.php" method="POST" class="form-group container">
                  <input  type = 'hidden' name = 'company_keyword' value = "<?php echo $job['company']?>">
                  <input  type = 'hidden' name = 'department_keyword' value = "<?php echo $job['department']?>">
                  <input  type = 'hidden' name = 'job_keyword' value = "<?php echo $job['job'] ?>">
                  <td>
                  <?php if($job['hr_response'] !== 0 && $job['manager_response'] == 0): ?>
                    <button type="submit" class="btn btn-warning" name = "delete">Delete</button>
                  <?php endif; ?>
                  <?php if($job['hr_response'] === 1 && $job['manager_response'] === 1): ?>
                    <label><strong>Pick your dayoff</strong></label>
                    <div class="form-group">
                      <select class="form-control" id="sel1" name = "dayoff" style = "width: 150px">
                      <option value="Saturday">Saturday</option>
                      <option value="Sunday">Sunday</option>
                      <option value="Monday">Monday</option>
                      <option value="Tuesday">Tuesday</option>
                      <option value="Wednesday">Wednesday</option>
                      <option value="Thursday">Thursday</option>
                      </select>
                    </div>

                    <button type="submit" class="btn btn-primary" name = "choose">Confirm</button>
                  <?php endif; ?>
                  </td>

                </form>
                        
              
              
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
