<?php
include_once 'manager_dash_temp.php';
 ?>
View Tasks</h3>
</div>
<div class="panel-body">
<?php


if(filter_has_var(INPUT_POST, 'submit')){


  $tasks = array();
  $procedure_params['user'] =$_SESSION['logged_in_user']['username'];
  $procedure_params['project'] =$_POST['project'];
  $procedure_params['status'] =$_POST['status'];

  $procedure_passed_params = array(
    array(&$procedure_params['user'], SQLSRV_PARAM_IN),
    array(&$procedure_params['project'], SQLSRV_PARAM_IN),
    array(&$procedure_params['status'], SQLSRV_PARAM_IN)
  );

  // EXEC the procedure
  $sql = "EXEC view_tasks @manager = ? ,@project = ?,@status =?";
  $stmt = sqlsrv_query($conn, $sql,$procedure_passed_params);

    if(!$stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      array_push($tasks, $row);
    }

}

?>
<?php if(filter_has_var(INPUT_POST, 'submit')) : ?>

<table class="table table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>Deadline</th>
          <th>Regular Employee</th>
          <th>Details</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($tasks as $task): ?>
          <tr>
            <td><?php echo $task['name'] ?></td>
            <td><?php if(isset($task['deadline'])) {echo ($task['deadline']);} ?></td>
            <td><?php if(isset($task['regular_employee'])) echo $task['regular_employee'] ?></td>
            <td><a href= "<?php echo 'manager_task_details.php?name='.$task['name'].'&project='.$task['project'].'&company='.$task['company'] ?>">Details</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else : ?>
    <h5 class="text-center">View Tasks !</h5>
    <form class="form-group" action="manager_view_tasks.php" method="POST">
    <div class="form-group">
      <label >Project</label>
      <input type="text" class="form-control" name="project" placeholder="Project Name"  maxlength="20">
    </div>
    <div class="form-group">
      <label >Status</label>
      <input type="text" class="form-control" name="status" placeholder="" maxlength="10">
    </div>
    <div class="form-group">
      <button <button class="btn btn-primary form-control" name="submit"type="submit">Search</button>
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
