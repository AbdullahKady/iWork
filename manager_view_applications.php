<?php
include_once 'manager_dash_temp.php';
 ?>
Job Applications</h3>
</div>
<div class="panel-body">
<?php


if(filter_has_var(INPUT_POST, 'submit')){


  $applications = array();
  $procedure_params['user'] =$_SESSION['logged_in_user']['username'];
  $procedure_params['job'] =$_POST['job'];

  $procedure_passed_params = array(
    array(&$procedure_params['job'], SQLSRV_PARAM_IN),
    array(&$procedure_params['user'], SQLSRV_PARAM_IN)

  );

  // EXEC the procedure
  $sql = "EXEC view_applications @job = ? , @username = ?";
  $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

    if(!$stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      array_push($applications, $row);
    }

}

?>
<?php if(filter_has_var(INPUT_POST, 'submit')) : ?>

<table class="table table-hover">
      <thead>
        <tr>
          <th>Title</th>
          <th># Vacancies</th>
          <th>Deadline</th>
          <th>Fist Name</th>
          <th>Last Name</th>
          <th>Details</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($applications as $application): ?>
          <tr>
            <td><?php echo $application['title'] ?></td>
            <td><?php if(isset($application['no_of_vacancies'])) {echo ($application['no_of_vacancies']);}?></td>
            <td><?php if(isset($application['deadline'])) {echo ($application['deadline']->format('d/m/Y'));} ?></td>
            <td><?php if(isset($application['first_name'])) echo $application['first_name'] ?></td>
            <td><?php if(isset($application['last_name'])) echo $application['last_name'] ?></td>
            <?php $newphrase = urlencode($application['department']); echo  $newphrase; ?>
            <td><a href= "<?php echo 'manager_application_details.php?applicant='.$application['username'].'&title='.$application['title'].'&dept='.$newphrase.'&comp='.$application['company'] ?>">Details </a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else : ?>
    <h5 class="text-center">Search for job applications !</h5>
    <form class="form-group" action="manager_view_applications.php" method="POST">
      <div class="row">
        <div class="col-md-8">
          <input class="form-control" type="text" placeholder="job" maxlength="50" name="job">
        </div>
        <div class="col-md-2">
          <button class="btn btn-info" name="submit"type="submit">Search</button>
        </div>
      </div>
    </form>
  <?php endif ?>
  </div>
  </div>
</div>


</div>
</div>
</section>
</body>
</html>
