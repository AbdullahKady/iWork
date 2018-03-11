<?php
include_once 'manager_dash_temp.php';
 ?>
Remove Regular Employee From Project</h3>
</div>
<div class="panel-body">
<?php
$alert;

if(filter_has_var(INPUT_POST, 'submit')){



  $procedure_params['user'] =$_SESSION['logged_in_user']['username'];
  $procedure_params['project'] =$_POST['project'];
  $procedure_params['employee'] =$_POST['employee'];
  $procedure_params['output'] ="";

  $procedure_passed_params = array(
    array(&$procedure_params['user'], SQLSRV_PARAM_IN),
    array(&$procedure_params['project'], SQLSRV_PARAM_IN),
    array(&$procedure_params['employee'], SQLSRV_PARAM_IN),
    array(&$procedure_params['output'], SQLSRV_PARAM_OUT)
  );

  // EXEC the procedure
  $sql = "EXEC unassign_project @manager=?, @project =? ,@employee =?, @output =?";
  $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

  if(!$prepared_stmt) {
      $alert =$procedure_params['output'];
  }

  if(sqlsrv_execute($prepared_stmt)) {
    if($procedure_params['output'] == "error"){
      $alert =$procedure_params['output'].' employee is assigned to at least one task';
    }
    else{

       $URL="manager.php?alert_message=Employee removed from Project";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

    }
  }
  else{
      $alert =$procedure_params['output'];
  }

}

?>
<?php if(!filter_has_var(INPUT_POST, 'submit') || isset($alert)) : ?>
  <h5 class="text-center">Remove Regular Employee!</h5>
  <form class="form-group" action="manager_remove_employeeProject.php" method="POST">
    <div class="container">
    <div class="row">
      <div class="col-md-4">
        <input class="form-control" type="text" placeholder="employee username" maxlength="50" name="employee">
      </div>
      <div class="col-md-4">
        <input class="form-control" type="text" placeholder="project name" maxlength="50" name="project">
      </div>
        </div>
        <div class="form-group">
        <div class="col-sm-offset-3 col-md-2">
          <button class="btn btn-info" name="submit"type="submit">Remove</button>
        </div>
        </div>
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
