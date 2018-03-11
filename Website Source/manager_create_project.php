<?php
include_once 'manager_dash_temp.php';
$alert="none";

if(filter_has_var(INPUT_POST, 'submit')){

  $name = htmlspecialchars($_POST['name']);
  $start = htmlspecialchars($_POST['start']);
  $end = htmlspecialchars($_POST['end']);


  if(!empty($start) && !empty($name) && !empty($end)){


    $procedure_params['manager'] =$_SESSION['logged_in_user']['username'];
    $procedure_params['name'] =$name;
    $procedure_params['start'] =$start;
    $procedure_params['end'] =$end;
    $procedure_passed_params = array(
      array(&$procedure_params['name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['start'], SQLSRV_PARAM_IN),
      array(&$procedure_params['end'], SQLSRV_PARAM_IN),
      array(&$procedure_params['manager'], SQLSRV_PARAM_IN)
    );

    // EXEC the procedure
    $sql = "EXEC create_project @name=? , @start_date =? , @end_date= ? , @manager= ?";
    $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

      if(!$stmt) {
        die( print_r( sqlsrv_errors(), true));
      }
      else{
          $alert="Project Created Successfullly";
      }
  }
  else{
    $alert="Fill All Fields Correctly";
  }
}

 ?>
Create Project</h3>
</div>
<div class="panel-body">
<?php  if($alert == "none" || $alert =="Fill All Fields Correctly" ) : ?>

<form class="form-horizontal" method="post" action="manager_create_project.php">
  <div class="form-group">
    <label  class="col-sm-2 control-label">Project Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name"  placeholder="Name" maxlength="20">
    </div>
  </div>
  <div class="form-group">
    <label  class="col-sm-2 control-label">Start Date</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" name="start" placeholder="mm/dd/yyyy">
    </div>
  </div>
  <div class="form-group">
  <label  class="col-sm-2 control-label">End Date</label>
  <div class="col-sm-10">
    <input type="date" class="form-control" name="end" placeholder="mm/dd/yyyy">
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
<div class="alert alert-success" role="alert">Project Created Successfullly</div>

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
