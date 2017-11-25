<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  $company = array();
  $departments = array();

  $sql_company = "SELECT * FROM Companies WHERE email = " . "'". $company_mail . "'";
  $sql_departments = "EXEC Departements_in_company '" . $company_mail . "'";

  $stmt_company = sqlsrv_query($conn, $sql_company);
  $stmt_departments = sqlsrv_query($conn, $sql_departments);

  if(!$stmt_company || !$stmt_departments) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt_company, SQLSRV_FETCH_ASSOC)) {
    $company = $row;
  }

  while($row = sqlsrv_fetch_array($stmt_departments, SQLSRV_FETCH_ASSOC)) {
    array_push($departments, $row);
  }

?>


<!DOCTYPE html>
<html>
<head>
    <?php include_once 'includes/header.php' ?> 
</head>

<body>

  <?php include_once 'templates/navbar.tpl.php';?>

  <div class="container">
    <h2 class="text-center"><?php echo $company['name'] ?></h2>

    <!-- Company Details -->
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Address</th>
          <th>Email</th>
          <th>Domain</th>
          <th>Type</th>
          <th>Vision</th>
          <th>Specialization</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo $company['address'] ?></td>
          <td><?php echo $company['email'] ?></td>
          <td><?php echo $company['domain'] ?></td>
          <td><?php echo $company['type'] ?></td>
          <td><?php echo $company['vision'] ?></td>
          <td><?php echo $company['specialization'] ?></td>
        </tr>
      </tbody>
    </table>

    <hr>

    <h2 class="text-center">Departments</h2>

    <!-- Department Details -->
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Available Jobs</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($departments as $department): ?>
          <tr>
            <td><?php echo $department['code'] ?></td>
            <td><?php echo $department['name'] ?></td>
            <td>
              <a href="<?php echo 'department_details.php?company_mail=' . $company['email'] . '&department_code=' . $department['code']?>">View jobs</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>

  <?php include_once 'includes/scripts.php';?>

</body>
</html>
