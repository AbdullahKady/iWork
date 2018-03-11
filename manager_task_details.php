<?php
include_once 'manager_dash_temp.php';



if(filter_has_var(INPUT_POST, 'submit')){


  $date = str_replace('/', '-', $_POST['deadline']);
  $procedure_params['manager'] =$_SESSION['logged_in_user']['username'];
  $procedure_params['name'] =$_POST['name'];
  $procedure_params['project'] =$_POST['project'];
  $procedure_params['deadline'] =date('Y-m-d', strtotime($date));




  if(isset($_POST['options']) && $_POST['options']=="accept" ){
    $procedure_params['response'] =1;
    $procedure_passed_params = array(
      array(&$procedure_params['manager'], SQLSRV_PARAM_IN),
      array(&$procedure_params['project'], SQLSRV_PARAM_IN),
      array(&$procedure_params['name'], SQLSRV_PARAM_IN),
      array(&$procedure_params['response'], SQLSRV_PARAM_IN),
      array(&$procedure_params['deadline'], SQLSRV_PARAM_IN)

    );


    // EXEC the procedure
    $sql = "EXEC review_task @manager=? , @project =? , @task= ? , @response = ?, @deadline =?";

    $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

      if(!$stmt) {
          die( print_r( sqlsrv_errors(), true));
      }

     $URL="manager.php?alert_message=Task Accepted";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
elseif(isset($_POST['options']) && $_POST['options']=="reject" && isset($_POST['reason'])){
  $procedure_params['response'] =0;
  $procedure_passed_params = array(
    array(&$procedure_params['manager'], SQLSRV_PARAM_IN),
    array(&$procedure_params['project'], SQLSRV_PARAM_IN),
    array(&$procedure_params['name'], SQLSRV_PARAM_IN),
    array(&$procedure_params['response'], SQLSRV_PARAM_IN),
    array(&$procedure_params['deadline'], SQLSRV_PARAM_IN)

  );

  // EXEC the procedure
  $sql = "EXEC respond_to_requests @manager=? , @applicant =? , @start= ? , @response = ?, @reason =?" ;

  $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

    if(!$stmt) {
        die( print_r( sqlsrv_errors(), true));
    }

   $URL="manager.php?alert_message=Task Rejected";
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

}

}


$sql_query="";

parse_str($_SERVER['QUERY_STRING']);


$sql_query="select *
from Tasks
where name = "."'".$name."'" ." and project = "."'" .$project."'"." and company = "."'" .$company."'";



$stmt_request = sqlsrv_query($conn, $sql_query);

if(!$stmt_request){
die( print_r( sqlsrv_errors(), true));
}
$task= array();
while($row = sqlsrv_fetch_array($stmt_request, SQLSRV_FETCH_ASSOC)) {
$task = $row;
}



 ?>

Request Detatils</h5>
</div>
<div class="panel-body">

  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <ul class="list-group">
            <li class="list-group-item">Name</li>
            <li class="list-group-item">Project</li>
            <li class="list-group-item">Deadline</li>
            <li class="list-group-item">Status</li>
            <li class="list-group-item">Description</li>
            <li class="list-group-item">Employee</li>
      </ul>
      </div>
      <div class="col-md-5">

        <ul class="list-group">


            <li class="list-group-item"><?php echo $task['name'] ?></li>
            <li class="list-group-item"><?php echo $task['project'] ?></li>
            <li class="list-group-item"><?php if(isset($task['deadline'])) echo $task['deadline']->format('d/m/Y'); else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($task['status'])) echo $task['status']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($task['description'])) echo $task['description']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($task['regular_employee'])) echo $task['regular_employee']; else echo "&nbsp;"; ?></li>


      </ul>



      </div>

    </div>
  </div>
  <form class="form-horizontal" method="post" action="#">
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-7">
      <div  data-toggle="buttons">
    <label >
      <input type="radio" name="options" value="accept" autocomplete="off" checked > Accept
    </label>
    <label >
      <input type="radio" name="options" value="reject" autocomplete="off">Reject
    </label>
    </div>

  </div>
    </div>
    <div class="form-group col-md-4">
      <label >Deadline</label>
      <input type="date" class="form-control" name="deadline" placeholder="">
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" name="name" value=<?php echo $task['name'] ?>>
        <input type="hidden" name="project" value=<?php echo $task['project'] ?>>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </form>



  </div>
  </div>
</div>


</div>
</div>
</section>
</body>
</html>
