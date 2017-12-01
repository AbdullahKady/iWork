
<?php
    session_start();

    include_once 'includes/db_connect.php';

    parse_str($_SERVER['QUERY_STRING']);
	$username = $_SESSION['logged_in_user']['username'];

    if(isset($status)){
    	// Handling the case where I'm redirected from a job edit form.
    	if($status === "job_edited") {
    		if(isset($_POST["title"])) {
			 		// Fetch data from the form
    			$title = $_POST["title"];
    			$short_description = $_POST["short_description"];
    			$detailed_description = $_POST["detailed_description"];
    			$salary = $_POST["salary"];
    			$no_of_vacancies = $_POST["no_of_vacancies"];
    			$min_experience = $_POST["min_experience"];
    			$working_hours = $_POST["working_hours"];
    			$deadline = $_POST["deadline"];

				  // specify params - MUST be a variable that can be passed by reference!
    			$procedure_params['username'] = $username;
    			$procedure_params['title'] = $title;
    			$procedure_params['short_description'] = $short_description;
    			$procedure_params['detailed_description'] = $detailed_description;
    			$procedure_params['salary'] = $salary;
    			$procedure_params['no_of_vacancies'] = $no_of_vacancies;
    			$procedure_params['min_experience'] = $min_experience;
    			$procedure_params['working_hours'] = $working_hours;
    			$procedure_params['deadline'] = $deadline;


			    // Set up the procedure params array - be sure to pass the param by reference
    			$procedure_passed_params = array(
    				array(&$procedure_params['username'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['title'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['short_description'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['detailed_description'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['salary'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['no_of_vacancies'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['min_experience'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['working_hours'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['deadline'], SQLSRV_PARAM_IN)

    			);

				  // EXEC the procedure			
    			$sql = "EXEC editJobHR @username = ?, @title = ?, @short_description = ?, @detailed_description = ?, @salary = ?, @no_of_vacancies = ?, @min_experience = ?, 			@working_hours = ?, @deadline=?";
    			$prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);

    			if(!$prepared_stmt) {
    				die( print_r( sqlsrv_errors(), true));
    			}

    			if(sqlsrv_execute($prepared_stmt)) {			

    				$flash_message ='<div class="alert alert-success alert-dismissable "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Success! </			strong>Job information has been updated</div>';      
    			} else {
    				die( print_r( sqlsrv_errors(), true));
    			}

    		}


    		$flash_message='<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Job has been edited successfully</div>';
    		
    	}else if($status == "announcment_posted"){

    		if(isset($_POST["announcment_title"])) {
    			$announcment_title = $_POST["announcment_title"];
    			$announcment_type = $_POST["announcment_type"];
    			$announcment_description = $_POST["announcment_description"];

    			$procedure_params['$announcment_title'] = $announcment_title;
    			$procedure_params['username'] = $username;
    			$procedure_params['$announcment_type'] = $announcment_type;
    			$procedure_params['$announcment_description'] = $announcment_description;

    			$procedure_passed_params = array(
    				array(&$procedure_params['$announcment_title'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['username'], SQLSRV_PARAM_IN),
						array(&$procedure_params['$announcment_type'], SQLSRV_PARAM_IN),
    				array(&$procedure_params['$announcment_description'], SQLSRV_PARAM_IN)
    			);

    			$sql = "EXEC postAnnouncmentHR @title = ?, @username = ?, @type = ?, @description = ?";
    			$prepared_stmt = sqlsrv_prepare($conn, $sql, $procedure_passed_params);
					if(!$prepared_stmt) {
    				die( print_r( sqlsrv_errors(), true));
    			}

    			if(sqlsrv_execute($prepared_stmt)) {			

    				$flash_message ='<div class="alert alert-success alert-dismissable "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Success! </			strong>Announcment has been posted</div>';      
    			} else {
    				die( print_r( sqlsrv_errors(), true));
    			}
    		}

    	}
    }



    $jobs = array();
    $sql_jobs = "EXEC viewDeptJobs'" . $username . "'";
    $stmt_jobs = sqlsrv_query($conn, $sql_jobs);
    if(!$stmt_jobs) {
    	die( print_r( sqlsrv_errors(), true));
    }
    while($row = sqlsrv_fetch_array($stmt_jobs, SQLSRV_FETCH_ASSOC)) {
    	array_push($jobs, $row);
    }
    
?>

    <!DOCTYPE html>
    <html>
    <head>
    	<?php include_once 'includes/header.php' ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

        <style>
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
        </style>
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

    	<!-- ALL JOBS VIEW -->
    	<div class="container">
    		<div class="col-md-8">
              <h3 class="text-center"> All Jobs </h3>
                <?php if(isset($jobs)): ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Short Description</th>
                                <th>Number Of Vacancies</th>
                                <th>Job details & Active applications</th>
                                <th>Edit Job's Info</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($jobs as $job): ?>
                                <tr>
                                    <td><?php echo $job['title'] ?></td>
                                    <td><?php echo $job['short_description'] ?></td>
                                    <td><?php echo $job['no_of_vacancies'] ?></td>
                                    <td><a class="btn btn-primary" href="<?php echo "hr_applications.php?job=". $job['title'] ?>"> View details</a></td>
                                    <td><a class ="btn btn-default" href="<?php echo "hr_edit_jobs.php?job=". $job['title'] ?>"> Edit</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>      
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-3">
                  <!-- ANNOUNCMENTS POSTING -->
                <h3 class="text-center">Post Announcments</h3>
                <form action="human_resources.php?status=announcment_posted" method="POST" class="form-group">

                    <input class="form-control" type="text" placeholder="Title" name="announcment_title" required maxlength="20">
                    <br>
                    <input class="form-control" type="text" placeholder="Type" name="announcment_type" required maxlength="10"> 
                    <br>
                    <textarea class="form-control" type="text" placeholder="Description" name="announcment_description" required maxlength="120" rows="6"></textarea>
                    <br>
                    <button class="btn btn-primary btn-block" type="submit"><strong>Post Announcment!</strong></button>
                </form>
            </div>
    	</div>
    	
    	<hr>

    	<!-- ALL REQUESTS CATEGORIZED -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="hr_requests.php">
                        <div class="card text-center">
                            <i class="fa fa-calendar fa-2x"></i>
                            <h4 class="text-center card-text">Requests</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="hr_attendance.php">
                        <div class="card text-center">
                            <i class="fa fa-clock-o fa-2x"></i>
                            <h4 class="text-center card-text">Attendance</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#">
                        <div class="card text-center">
                            <i class="fa fa-trophy fa-2x"></i>
                            <h4 class="text-center card-text">Achievements</h3>
                        </div>
                    </a>
                </div>
            </div>    
        </div>
        






    	<?php include_once 'includes/scripts.php';?>

    </body>
    </html>