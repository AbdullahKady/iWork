<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  if(isset($_GET['fix'])){

     $username = $_SESSION['logged_in_user']['username'];
    $task = $_GET["task_keyword"];
    $project = $_GET["project_keyword"];
    $company = $_GET["company_keyword"];
    

    $procedure_params['name'] = $username;
    $procedure_params['task'] = $task;
    $procedure_params['project'] = $project;
    $procedure_params['company'] = $company;
    $procedure_params['output'] = "";


    $procedure_passed_params = array(
      array(&$procedure_params['name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['task'], SQLSRV_PARAM_IN),
      array(&$procedure_params['project'], SQLSRV_PARAM_IN),
      array(&$procedure_params['company'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC Change_Status @username = ?, @name = ?, @project = ?, @company = ?, @output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($res = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      
      if ($procedure_params['output'] === 'Succesful') {
        $flash_message='<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Successfully updated status! </div>';
      } else if($procedure_params['output'] === 'Cannot change status of overdue task'){
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Cannot change status after deadline! </div>';
      }


    }
  }

  if(isset($_GET['modify'])){

     $username = $_SESSION['logged_in_user']['username'];
    $task = $_GET["task_keyword"];
    $project = $_GET["project_keyword"];
    $company = $_GET["company_keyword"];
    

    $procedure_params['name'] = $username;
    $procedure_params['task'] = $task;
    $procedure_params['project'] = $project;
    $procedure_params['company'] = $company;
    $procedure_params['output'] = "";


    $procedure_passed_params = array(
      array(&$procedure_params['name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['task'], SQLSRV_PARAM_IN),
      array(&$procedure_params['project'], SQLSRV_PARAM_IN),
      array(&$procedure_params['company'], SQLSRV_PARAM_IN),
      array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
    );

    // EXEC the procedure
    $sql = "EXEC Rechange_Status @username = ?, @name = ?, @project = ?, @company = ?, @output = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    if(sqlsrv_execute($prepared_stmt)) {
      while($res = sqlsrv_next_result($prepared_stmt)) {/* pass */};
      
      
      if ($procedure_params['output'] === 'Succesful') {
        $flash_message='<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Successfully updated status! </div>';
      } else if($procedure_params['output'] === 'Cannot change status of overdue task'){
        $flash_message='<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Cannot change status after deadline! </div>';
      }


    }
  }
  
  
    $tasks = array();

    $sql_tasks = "EXEC View_Task '" . $_SESSION['logged_in_user']['username'] . "', '" .$_GET['project_keyword']."', '" .
    $_GET['company_keyword']. "'" ;

    $stmt_tasks = sqlsrv_query($conn, $sql_tasks);

    if(!$stmt_tasks) {
      die( print_r( sqlsrv_errors(), true));
    }

    while($row = sqlsrv_fetch_array($stmt_tasks, SQLSRV_FETCH_ASSOC)) {
      array_push($tasks, $row);
    }


    //edited
    $comments = array();
    foreach ($tasks as $task) {
        

      $sql_comments = "EXEC View_Task_Comments '" . $_SESSION['logged_in_user']['username'] . "', '" .$task['name']. "', '" 
      .$_GET['project_keyword']."', '" .$_GET['company_keyword']. "'" ;

      $stmt_comments = sqlsrv_query($conn, $sql_comments);

      if(!$stmt_comments) {
        die( print_r( sqlsrv_errors(), true));
      }

      while($row = sqlsrv_fetch_array($stmt_comments, SQLSRV_FETCH_ASSOC)) {
        array_push($comments, $row);
      }
    }
    //
  

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

    <?php if(isset($tasks)): ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Project</th>
            <th>Company</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Description</th>
            <th>Manager</th>
            <!-- edited -->
            <th>Comment(s)</th>
            <!-- -->
            <th>Action</th>

          </tr>
        </thead>

        <tbody>
          <?php foreach ($tasks as $task): ?>
            <tr>
              <td><?php echo $task['name'] ?></td>
              <td><?php echo $task['project'] ?></td>
              <td><?php echo $task['company'] ?></td>
              <td><?php echo $task['deadline'] ->format('d/m/Y H:i') ?></td>
              <td><?php echo $task['status'] ?></td>
              <td><?php echo $task['description'] ?></td>
              <td><?php echo $task['manager'] ?></td>
              <!-- edited -->
              <td>
              <ul>
              <?php foreach ($comments as $comment): ?>
                <?php if($task['name'] === $comment['task_name'] && 
                $task['project'] === $comment['project'] && 
                $task['company'] === $comment['company']): ?>
                <li><?php echo $comment['comment'] ?></li>
              <?php endif; ?>
              <?php endforeach; ?>
              </ul>
              </td>
              <!-- -->
                      
                <form action = "regular_view_tasks.php" method="GET" class="form-group container">
                  <input  type = 'hidden' name = 'company_keyword' value = "<?php echo $task['company']?>">
                  <input  type = 'hidden' name = 'project_keyword' value = "<?php echo $task['project']?>">
                  <input  type = 'hidden' name = 'task_keyword' value = "<?php echo $task['name']?>">
                  <?php if($task['status'] === 'Assigned'): ?>
                  <td><button type="submit" class="btn btn-warning" name = "fix">Fix Task</button></td>
                  <?php endif; ?>
                  <?php if($task['status'] === 'Fixed'): ?>
                  <td><button type="submit" class="btn btn-primary" name = "modify">Modify Task</button></td>
                  <?php endif; ?>
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
