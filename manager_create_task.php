<?php
include_once 'manager_dash_temp.php';
$alert="none";

if(filter_has_var(INPUT_POST, 'submit')){

  $task = htmlspecialchars($_POST['task']);
  $project = htmlspecialchars($_POST['project']);
  $description = htmlspecialchars($_POST['description']);


  if(!empty($task) && !empty($project) ){


    $procedure_params['manager'] =$_SESSION['logged_in_user']['username'];
    $procedure_params['task'] =$task;
    $procedure_params['project'] =$project;
    $procedure_params['description'] =$description;
    $procedure_passed_params = array(
      array(&$procedure_params['manager'], SQLSRV_PARAM_IN),
      array(&$procedure_params['project'], SQLSRV_PARAM_IN),
      array(&$procedure_params['task'], SQLSRV_PARAM_IN),
      array(&$procedure_params['description'], SQLSRV_PARAM_IN)
    );

    // EXEC the procedure
    $sql = "EXEC create_Task @manager=? , @project =? , @task_name= ? , @description= ?";
    $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

      if(!$stmt) {
        $alert="Fill All Fields Correctly";
      }
      else{
          $alert="Task Created Successfullly";
      }
  }
  else{
    $alert="Fill All Fields Correctly";
  }
}

 ?>
Create Task</h3>
</div>
<div class="panel-body">
<?php  if($alert == "none" || $alert =="Fill All Fields Correctly" ) : ?>

<form class="form-horizontal" method="post" action="manager_create_task.php">
  <div class="form-group">
    <label  class="col-sm-2 control-label">Task Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="task"  placeholder="Name" maxlength="20">
    </div>
  </div>
  <div class="form-group">
    <label  class="col-sm-2 control-label">Project Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="project" placeholder="Project" maxlength="20">
    </div>
  </div>
  <div class="form-group">
  <label  class="col-sm-2 control-label">Description</label>
  <div class="col-sm-10">
    <input type="text" class="form-control textarea" name="description" placeholder="Description" maxlength="120">
  </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="submit" class="btn btn-default">Create</button>
    </div>
  </div>
    <?php  if($alert =="Fill All Fields Correctly" ) : ?>
      <div class="alert alert-danger" role="alert"> Fill All Fields Correctly </div>
    <?php endif ?>
</form>
<?php else : ?>
<div class="alert alert-success" role="alert">Task Created Successfullly</div>

<?php endif ?>
<?php $alert = "none"?>



  </div>
  </div>
</div>


</div>
</div>
</section>
</body>
</html>
