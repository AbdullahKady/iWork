<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);
  
  $projects = array();

  $sql_projects = "EXEC View_Projects '" . $_SESSION['logged_in_user']['username'] . "'";

  $stmt_projects = sqlsrv_query($conn, $sql_projects);

  if(!$stmt_projects) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt_projects, SQLSRV_FETCH_ASSOC)) {
    array_push($projects, $row);
  }

 

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

    <?php if(isset($projects)): ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Company</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Manager</th>
            <th>Action</th>

          </tr>
        </thead>

        <tbody>
          <?php foreach ($projects as $project): ?>
            <tr>
              <td><?php echo $project['name'] ?></td>
              <td><?php echo $project['company'] ?></td>
              <td><?php echo $project['start_date'] ->format('d/m/Y H:i') ?></td>
              <td><?php echo $project['end_date'] ->format('d/m/Y H:i') ?></td>
              <td><?php echo $project['manager'] ?></td>
              
                      
                <form action = "regular_view_tasks.php" method="GET" class="form-group container">
                  <input  type = 'hidden' name = 'company_keyword' value = "<?php echo $project['company']?>">
                  <input  type = 'hidden' name = 'project_keyword' value = "<?php echo $project['name']?>">
                  <td><button type="submit" class="btn btn-warning" name = "task">View Tasks</button></td>
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
