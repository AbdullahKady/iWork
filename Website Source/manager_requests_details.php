<?php
include_once 'manager_dash_temp.php';



if(filter_has_var(INPUT_POST, 'submit')){

  $date = str_replace('/', '-', $_POST['start_d']);


  $procedure_params['manager'] =$_SESSION['logged_in_user']['username'];
  $procedure_params['applicant'] =$_POST['app'];
  $procedure_params['start'] =date('Y-m-d', strtotime($date));;




  if(isset($_POST['options']) && $_POST['options']=="accept" ){
    $procedure_params['response'] =1;
    $procedure_passed_params = array(
      array(&$procedure_params['manager'], SQLSRV_PARAM_IN),
      array(&$procedure_params['applicant'], SQLSRV_PARAM_IN),
      array(&$procedure_params['start'], SQLSRV_PARAM_IN),
      array(&$procedure_params['response'], SQLSRV_PARAM_IN)
    );


    // EXEC the procedure
    $sql = "EXEC respond_to_requests @manager=? , @applicant =? , @start= ? , @response = ?";

    $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

      if(!$stmt) {
          die( print_r( sqlsrv_errors(), true));
      }

     $URL="manager.php?alert_message=Request Accepted";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
elseif(isset($_POST['options']) && $_POST['options']=="reject" && isset($_POST['reason'])){
  $procedure_params['response'] =0;
  $procedure_params['reason'] =$_POST['reason'];
  $procedure_passed_params = array(
    array(&$procedure_params['manager'], SQLSRV_PARAM_IN),
    array(&$procedure_params['applicant'], SQLSRV_PARAM_IN),
    array(&$procedure_params['start'], SQLSRV_PARAM_IN),
    array(&$procedure_params['response'], SQLSRV_PARAM_IN),
    array(&$procedure_params['reason'], SQLSRV_PARAM_IN)
  );

  // EXEC the procedure
  $sql = "EXEC respond_to_requests @manager=? , @applicant =? , @start= ? , @response = ?, @reason =?" ;

  $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

    if(!$stmt) {
        die( print_r( sqlsrv_errors(), true));
    }

   $URL="manager.php?alert_message=Request Rejected";
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

}

}


$sql_query="";

parse_str($_SERVER['QUERY_STRING']);
$date = str_replace('/', '-', $start);
$start= date('Y-m-d', strtotime($date));




if(isset($type) && $type == "l"){

$sql_query="select r.applicant,r.start_date,r.total_days,r.end_date,r.request_date,l.type
from Requests r inner join Leave_Requests l on l.applicant=r.applicant and l.start_date = r.start_date
where r.applicant = "."'".$applicant."'" ." and r.start_date = "."'" .$start."'";



}
elseif (isset($type) && $type=="b") {

$sql_query="select r.applicant,r.start_date,r.total_days,r.end_date,r.request_date,l.destination,l.purpose
from Requests r inner join Business_Trip_Requests l on l.applicant=r.applicant and l.start_date = r.start_date
where r.applicant = "."'".$applicant."'" ." and r.start_date = "."'" .$start."'";

}

$stmt_request = sqlsrv_query($conn, $sql_query);

if(!$stmt_request){
die( print_r( sqlsrv_errors(), true));
}
$requests= array();
while($row = sqlsrv_fetch_array($stmt_request, SQLSRV_FETCH_ASSOC)) {
$requests = $row;
}



 ?>

Request Detatils</h5>
</div>
<div class="panel-body">

  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <ul class="list-group">


            <li class="list-group-item">Applicant</li>
            <li class="list-group-item">Start Date</li>
            <li class="list-group-item">Total Days</li>
            <li class="list-group-item">End Date</li>
            <li class="list-group-item">Request Date</li>
            <?php if($type=="l") : ?>
            <li class="list-group-item">Type</li>
            <?php else : ?>
            <li class="list-group-item">Destination</li>
            <li class="list-group-item">Purpose</li>
          <?php endif; ?>
      </ul>
      </div>
      <div class="col-md-5">

        <ul class="list-group">


            <li class="list-group-item"><?php echo $requests['applicant'] ?></li>
            <li class="list-group-item"><?php echo $requests['start_date']->format('d/m/Y') ?></li>
            <li class="list-group-item"><?php if(isset($requests['total_days'])) echo $requests['total_days']->format('d/m/Y'); else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($requests['end_date'])) echo $requests['end_date']->format('d/m/Y'); else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($requests['request_date'])) echo $requests['request_date']->format('d/m/Y'); else echo "&nbsp;"; ?></li>
            <?php if($type=="l") : ?>
            <li class="list-group-item"><?php if(isset($requests['type'])) echo $requests['type']; else echo "&nbsp;"; ?></li>
            <?php else : ?>
            <li class="list-group-item"><?php if(isset($requests['destination'])) echo $requests['destination']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($requests['purpose'])) echo $requests['purpose']; else echo "&nbsp;"; ?></li>
          <?php endif; ?>
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
    <div class="form-group col-sm-offset-2 col-sm-7">
        <label> Reason </label>
        <textarea name="reason" class="form-control" > reason!</textarea>
      </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" name="app" value=<?php echo $requests['applicant'] ?>>
        <input type="hidden" name="start_d" value=<?php echo $requests['start_date']->format('d/m/Y') ?>>
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
