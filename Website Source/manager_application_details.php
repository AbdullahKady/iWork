<?php
include_once 'manager_dash_temp.php';



if(filter_has_var(INPUT_POST, 'submit')){



  $procedure_params['applicant'] =$_POST['app'];
  $procedure_params['job'] =$_POST['job'];
  $procedure_params['dept'] =$_POST['dept'];
  $procedure_params['comp'] =$_POST['comp'];




  if(isset($_POST['options']) && $_POST['options']=="accept" ){
    $procedure_params['response'] =1;
    $procedure_passed_params = array(
      array(&$procedure_params['job'], SQLSRV_PARAM_IN),
      array(&$procedure_params['dept'] , SQLSRV_PARAM_IN),
      array(&$procedure_params['comp'] , SQLSRV_PARAM_IN),
      array(&$procedure_params['applicant'] , SQLSRV_PARAM_IN),
      array(&$procedure_params['response'], SQLSRV_PARAM_IN)
    );


    // EXEC the procedure
    $sql = "EXEC acceptReject_application @job =?, @department =?,
    @company =?,@job_seeker =?, @response = ?";

    $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

      if(!$stmt) {
          die( print_r( sqlsrv_errors(), true));
      }

       $URL="manager.php?alert_message=Application Accepted";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
elseif(isset($_POST['options']) && $_POST['options']=="reject" ){
  echo "rejected";
  $procedure_params['response'] =0;
  $procedure_passed_params = array(
    array(&$procedure_params['job'], SQLSRV_PARAM_IN),
    array(&$procedure_params['dept'], SQLSRV_PARAM_IN),
    array(&$procedure_params['comp'], SQLSRV_PARAM_IN),
    array(&$procedure_params['applicant'], SQLSRV_PARAM_IN),
    array(&$procedure_params['response'], SQLSRV_PARAM_IN)
  );

  // EXEC the procedure
  $sql = "EXEC acceptReject_application @job =?, @department =?,
  @company =?,@job_seeker =?, @response = ?";
  $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

    if(!$stmt) {
        die( print_r( sqlsrv_errors(), true));
    }

   $URL="manager.php?alert_message=Application Rejected";
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

}

}


$sql_query="";

parse_str($_SERVER['QUERY_STRING']);


$sql_query="select j.title,j.short_description,j.min_experience,j.no_of_vacancies,j.salary,j.deadline  ,u.first_name,u.middle_name,
		u.last_name,u.years_of_experience,u.age,u.personal_email
from Jobs j inner join Jobs_Applied_by_Job_Seekers a on j.title = a.job and j.company=a.company and j.department=a.department
	inner join Job_Seekers s on a.job_seeker = s.username
	inner join Users u  on s.username = u.username
where a.job_seeker = "."'".$applicant."'" ." and a.job = "."'" .$title."'"." and j.department="."'" .$dept."'"." and j.company= "."'".$comp."'";

$stmt_request = sqlsrv_query($conn, $sql_query);

if(!$stmt_request){
die( print_r( sqlsrv_errors(), true));
}
$application= array();
while($row = sqlsrv_fetch_array($stmt_request, SQLSRV_FETCH_ASSOC)) {

$application = $row;
}




 ?>

Request Detatils</h5>
</div>
<div class="panel-body">

  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <ul class="list-group">

            <li class="list-group-item">Job Title</li>
            <li class="list-group-item">Short Description</li>
            <li class="list-group-item">Min Experience</li>
            <li class="list-group-item"># Vacancies</li>
            <li class="list-group-item">Salary</li>
            <li class="list-group-item">Deadline</li>
            <li class="list-group-item">Applicant</li>
            <li class="list-group-item">Years of Experience</li>
            <li class="list-group-item">Age</li>
            <li class="list-group-item">Personal Email</li>

      </ul>
      </div>
      <div class="col-md-5">

        <ul class="list-group">
            <li class="list-group-item"><?php echo $application['title'] ?></li>
            <li class="list-group-item"><?php if(isset($application['short_description'])) echo $application['short_description']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($application['min_experience'])) echo $application['min_experience']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($application['no_of_vacancies'])) echo $application['no_of_vacancies']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($application['salary'])) echo $application['salary']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($application['deadline'])) echo $application['deadline']->format('d/m/Y'); else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php echo $application['first_name']. " ". $application['middle_name']." ". $application['last_name'] ?></li>
            <li class="list-group-item"><?php if(isset($application['years_of_experience'])) echo $application['years_of_experience']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($application['age'])) echo $application['age']; else echo "&nbsp;"; ?></li>
            <li class="list-group-item"><?php if(isset($application['personal_email'])) echo $application['personal_email']; else echo "&nbsp;"; ?></li>


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

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" name="app" value=<?php echo $applicant ?>>
        <input type="hidden" name="job" value=<?php echo $title ?>>
        <input type="hidden" name="dept" value=<?php echo $dept ?>>
        <input type="hidden" name="comp" value=<?php echo $comp ?>>
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
