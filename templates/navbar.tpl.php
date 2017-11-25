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
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="companies.php">Companies</a></li>
        <li><a href="jobs.php">Jobs</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <?php if(isset($_SESSION["logged_in_user"])): ?>
          <li>
            <a href="dashboard.php">Dashboard</a>
          </li>

          <li>
            <a href="settings.php"><?php echo $_SESSION["logged_in_user"]['username'] . "'s" . " profile" ?></a>
          </li>

          <li>
            <a href="logout.php">Logout</a>
          </li>  
        <?php else: ?>
          <li>
              <a href="login.php">Login</a>
          </li>
          <li>
              <a href="register.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>

    </div>
  </div>
</nav>
<!-- END NAVBAR -->	