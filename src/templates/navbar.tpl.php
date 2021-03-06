<?php
$dashboard_path = '';
if(isset($_SESSION["logged_in_user"])) {
  switch ($_SESSION["logged_in_user"]['role']) {
    case "Manager":
      $dashboard_path = 'staff_dashboard.php';
      break;
    case "Seeker":
      $dashboard_path = 'seeker.php';
      break;
    case "HR":
      $dashboard_path = 'staff_dashboard.php';
      break;
    case "Regular":
      $dashboard_path = 'staff_dashboard.php';
      break;
    default:
      $dashboard_path = 'index.php';
  }
} 
?>

<!-- START NAVBAR -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">iWork</a>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="<?php echo ($_SERVER['PHP_SELF'] == "/iwork-project/index.php" ? "active" : "");?>" ><a href="index.php">Home</a></li>
        <li class="<?php echo ($_SERVER['PHP_SELF'] == "/iwork-project/companies.php" ? "active" : "");?>" ><a href="companies.php">Companies</a></li>
        <li class="<?php echo ($_SERVER['PHP_SELF'] == "/iwork-project/jobs.php" ? "active" : "");?>" ><a href="jobs.php">Jobs</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <?php if(isset($_SESSION["logged_in_user"])): ?>
          <li>
            <a href="<?php echo $dashboard_path ?>">Dashboard</a>
          </li>

          <li class="<?php echo ($_SERVER['PHP_SELF'] == "/iwork-project/settings.php" ? "active" : "");?>">
            <a href="settings.php" ><?php echo $_SESSION["logged_in_user"]['username'] . "'s" . " profile" ?></a>
          </li>

          <li>
            <a href="logout.php">Logout</a>
          </li>  
        <?php else: ?>
          <li class="<?php echo ($_SERVER['PHP_SELF'] == "/iwork-project/login.php" ? "active" : "");?>">
              <a href="login.php">Login</a>
          </li>
          <li class="<?php echo ($_SERVER['PHP_SELF'] == "/iwork-project/register.php" ? "active" : "");?>">
              <a href="register.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>

    </div>
  </div>
</nav>
<!-- END NAVBAR -->	