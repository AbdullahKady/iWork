<?php
include_once 'manager_dash_temp.php';
 ?>
Assign Employees To Tasks</h3>
</div>
<div class="panel-body">
<?php
$alert;

if(filter_has_var(INPUT_POST, 'submit')){



    $manager = $_SESSION['logged_in_user']['username'];
    $employee =$_POST['employee'];
    $task =$_POST['task'];
    $project =$_POST['project'];
    $deadline =$_POST['deadline'];
    $output ="";


    if(!empty($deadline) && !empty($task) && !empty($project) && !empty($employee)){

      $procedure_params['manager'] =$manager;
      $procedure_params['employee'] =$employee;
      $procedure_params['task'] =$task;
      $procedure_params['project'] =$project;
      $procedure_params['deadline'] =$deadline;
      $procedure_params['output'] ="";


      $procedure_passed_params = array(
        array(&$procedure_params['manager'], SQLSRV_PARAM_IN),
        array(&$procedure_params['employee'], SQLSRV_PARAM_IN),
        array(&$procedure_params['task'], SQLSRV_PARAM_IN),
        array(&$procedure_params['project'], SQLSRV_PARAM_IN),
        array(&$procedure_params['deadline'], SQLSRV_PARAM_IN),
        array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
      );

      // EXEC the procedure
 $sql = "EXEC change_Task_Employee @manager=?, @employee =?,@task =? , @project =? ,@deadline=?, @output =?";
 $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);
 if(!$prepared_stmt) {
       die( print_r( sqlsrv_errors(), true));
 }

 if(sqlsrv_execute($prepared_stmt)) {
   if($procedure_params['output'] == 'Employee not assigned to the project'){


      $sql = "EXEC assign_Task @manager=?, @employee =?,@task =? , @project =? ,@deadline=?, @output =?";
      $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
        die( print_r( sqlsrv_errors(), true));
      }
      if(sqlsrv_execute($prepared_stmt)){
        if($procedure_params['output'] == 'Employee not assigned to the project'){
          $alert =$procedure_params['output'];
        }
        else{

        $URL="manager.php?alert_message=Employee Assigned To Task";
       echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
       echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
      }
      else{
        die( print_r( sqlsrv_errors(), true));
      }
   }
   else{
     

      $URL="manager.php?alert_message=Changed Employee Assigned To Task";
   echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
   echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

   }
 }
 else{
       die( print_r( sqlsrv_errors(), true));
 }
}
else{
 $alert ="Fill All Fields";
}
}


?>
<?php if(!filter_has_var(INPUT_POST, 'submit') || isset($alert)) : ?>
  <h5 class="text-center">Assign Regular Employee!</h5>
  <form class="form-group" action="manager_assign_tasks.php" method="POST">
  <div class="form-group">
    <label >Employee</label>
    <input type="text" class="form-control" name="employee" placeholder="Employee Username " maxlength="20">
  </div>
  <div class="form-group">
    <label >Task</label>
    <input type="text" class="form-control" name="task" placeholder="Task name"  maxlength="20">
  </div>
  <div class="form-group">
    <label >Project</label>
    <input type="text" class="form-control" name="project" placeholder="Project Name"  maxlength="20">
  </div>
  <div class="form-group">
    <label >Deadline</label>
    <input type="date" class="form-control" name="deadline" placeholder="">
  </div>
  <div class="form-group">
    <button <button class="btn btn-primary form-control" name="submit"type="submit">Assign</button>
  </div>
</form>
<?php if(isset($alert)) : ?>
  <div class="alert alert-danger" role="alert">
  <strong>Oh snap!</strong> <?php echo $alert ?>
</div>
  <?php endif ?>
  <?php endif ?>
  </div>
  </div>
</div>


</div>
</div>
</section>
</body>
</html>
