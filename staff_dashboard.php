
<?php
  session_start();
  include_once 'includes/db_connect.php';
  $username = $_SESSION['logged_in_user']['username'];
  if(isset($_SESSION["logged_in_user"])) {
 		switch ($_SESSION["logged_in_user"]['role']) {
  		case "Manager":
  		  $personalized_path = 'manager.php';
  		  break;
  		case "HR":
  		  $personalized_path = 'human_resources.php';
  		  break;
  		case "Regular":
  		  $personalized_path = 'regular.php';
  		  break;
  		default:
  		  $personalized_path = 'index.php';
  	}

	}

    $procedure_params['username'] = $username;
    $procedure_params['company'] = '';
    $procedure_params['department_name'] = '';
    $procedure_params['job_string'] = '';
    $procedure_params['department_code'] = '';

    $procedure_passed_params = array(
      array(&$procedure_params['username'], SQLSRV_PARAM_IN),
      array(&$procedure_params['company'], SQLSRV_PARAM_OUT),
      array(&$procedure_params['department_name'], SQLSRV_PARAM_OUT),
      array(&$procedure_params['job_string'], SQLSRV_PARAM_OUT),
      array(&$procedure_params['department_code'], SQLSRV_PARAM_OUT),
    );

    // EXEC the procedure
    $sql = "EXEC currentStatusStaff @username = ?, @company = ?, @department_name = ?, @job_string = ?, @department_code = ?";
    $prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    if(!$prepared_stmt) {
      die( print_r( sqlsrv_errors(), true));
    }
    sqlsrv_execute($prepared_stmt);
    $company = $procedure_params['company'];
    $department_name = $procedure_params['department_name'];
    $job_string = $procedure_params['job_string'];
    $department_code = $procedure_params['department_code'];


?>

<!DOCTYPE html>
<html>
<head>
	<?php include_once 'includes/header.php' ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <style>
        textarea {
            resize: none;
        }
        .card {
            color: #3498db;
            margin-top: 15px;
            margin-bottom: 15px;
            border: 1px solid #cacaca;
            border-radius: 5px;
            transition: background-color 500ms ease;
        }
        .card:hover {
            background-color: #0f0f0f0f;
            transition: background-color 500ms ease;
        }
        .card i {
            padding-top: 20px;
        }
        .center {
            margin: 0 auto;
        }
        body {
            margin-bottom: 20px;
        }
        .btn-circle.btn-xl {
            width: 70px;
            height: 70px;
            padding: 10px 16px;
            font-size: 24px;
            line-height: 1.33;
            border-radius: 35px;
        }
    </style>
</head>

<body>
	<?php include_once 'templates/navbar.tpl.php';?>

    <div class="container">
    		<h3 class="text-center">Choose which functionalities to use</h3>
        <div class="row">
            <div class="col-md-6">
                <a href="staff_member.php">
                    <div class="card text-center">
                        <i class="fa fa-users fa-2x"></i>
                        <h3 class="text-center card-text">Generic staff member</h3>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="<?php echo $personalized_path ?>">
                    <div class="card text-center">
                        <i class="fa fa-user fa-2x"></i>
                        <h3 class="text-center card-text">Personalized dashboard</h3>
                    </div>
                </a>
            </div>
        </div>
        <hr>
        <h3>Current status :</h3>
        <ul class="list-group">
          <li class="list-group-item">Current Job : <?php echo $job_string ?> </li>
          <li class="list-group-item">Current Company : <?php echo $company ?> </li>
          <li class="list-group-item">Current Department : <?php echo $department_name . ' ('.$department_code.')' ?>  </li>
        </ul>
    </div>


	<?php include_once 'includes/scripts.php';?>
</body>
</html>