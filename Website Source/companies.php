<?php
  session_start();

  include_once 'includes/db_connect.php';

  parse_str($_SERVER['QUERY_STRING']);

  if (isset($_POST['company_name'])) {
    $companies = array();
    $company_name = $_POST['company_name'];
    $company_address = $_POST['company_address'];
    $company_type = $_POST['company_type'];
    // Cuz retarded MSSQL doesn't have boolean literals.
    $sql_query = 'SELECT C.name, C.address, C.type,C.email  FROM Companies C WHERE 1=1 AND';

    if ($company_name != "") {
      $sql_query .= " C.name =" . "'" . $company_name . "' AND" ;
    }

    if ($company_address != "") {
      $sql_query .=  " C.address =" . "'" . $company_address . "' AND";
    }

    if ($company_type != "both") {
      $sql_query .=  " C.type =" . "'" . $company_type . "' AND" ;
    }


    $sql_query.= " 1=1";

    $stmt = sqlsrv_query($conn, $sql_query);

    if(!$stmt) {
      die( print_r( sqlsrv_errors(), true));
    }

    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      array_push($companies, $row);
    }
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
    <?php include_once 'templates/company_search.tpl.php';?>
    <hr>


    <?php if(isset($companies)): ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Company</th>
            <th>Address</th>
            <th>Type</th>
            <th>Details</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($companies as $company): ?>
            <tr>
              <td><?php echo $company['name'] ?></td>
              <td><?php echo $company['address'] ?></td>
              <td><?php if($company['type'] == "international"){ echo "International"; }else{ echo "National";} ?></td>
              <td><a href="<?php echo 'company_details.php?company_mail=' . $company['email'] ?>">Show details</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>



  <?php include_once 'includes/scripts.php';?>

</body>
</html>
