<?php
    session_start();

    include_once 'includes/db_connect.php';

    parse_str($_SERVER['QUERY_STRING']);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- FlatUI Theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.css">


    <link rel="stylesheet" href="css\style.css">



    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/js/flat-ui.min.js"></script>


    <title>iWork | Manager</title>
  </head>
  <body style="background:#EEEEEE;">

      <?php include_once 'templates/navbar.tpl.php';?>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/js/flat-ui.min.js"></script>


    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>


    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h5 ><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Manager Dashboard</h5>
          </div>
        </div>
      </div>
    </header>

    <section id="main" >
       <div class="container">
         <div class="row">
           <div class="col-md-3">
             <div class="list-group main-color-bg">
                <a href="manager.php" class="list-group-item active main-color-bg"> Dashboard</a>
                <a href="manager_view_leaverequests.php" class="list-group-item ">View Leave Requests </a>
                <a href="manager_view_buisnessrequests.php" class="list-group-item ">View Buisness Requests </a>
                <a href="manager_view_applications.php" class="list-group-item">View Applications</a>
                <a href="manager_create_project.php" class="list-group-item">Create a New project</a>
                <a href="manager_assign_employeesProjects.php" class="list-group-item">Assign Employees to Projects</a>
                <a href="manager_remove_employeeProject.php" class="list-group-item">Remove Employee from Project</a>
                <a href="manager_create_task.php" class="list-group-item">Create a New Task</a>
                <a href="manager_view_tasks.php" class="list-group-item">View Tasks</a>
                <a href="manager_assign_tasks.php" class="list-group-item">Assign Employee To Tasks</a>



              </div>
           </div>
           <div class="col-md-9">
             <div class="panel panel-default">
               <?php if(isset($alert_message)) : ?>
                 <div class="alert alert-success" role="alert">
                   <strong>Done!</strong> <?php echo $alert_message; ?>
                 </div>
               <?php endif ?>
               <div class="panel-heading">
                 <h3 class="panel-title">
