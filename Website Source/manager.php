<?php
include_once 'manager_dash_temp.php';
parse_str($_SERVER['QUERY_STRING']);
 ?>
Dashboard</h3>
</div>
<div class="panel-body">
  <p> Welcome Mr/Mrs &nbsp; <?php echo $_SESSION['logged_in_user']['username']; ?></p>
    </div>
    </div>
  </div>
  </div>
  </div>
  </section>

  </body>
  </html>
