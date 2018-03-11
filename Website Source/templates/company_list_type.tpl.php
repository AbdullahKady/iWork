<?php 

	$national_companies = array();
	$international_companies = array();
  
  // EXEC the procedure
  $sql_national = "SELECT name, email FROM Companies WHERE type = 'national'";
  $sql_international = "SELECT name, email FROM Companies WHERE type = 'international'";

  $stmt_national = sqlsrv_query($conn, $sql_national);
  $stmt_international = sqlsrv_query($conn, $sql_international);

  if(!$stmt_national || !$stmt_international) {
    die( print_r( sqlsrv_errors(), true));
  }

  while($row = sqlsrv_fetch_array($stmt_national, SQLSRV_FETCH_ASSOC)) {
    array_push($national_companies, $row);
	}

	while($row = sqlsrv_fetch_array($stmt_international, SQLSRV_FETCH_ASSOC)) {
    array_push($international_companies, $row);
	}

?>

<h3 class = "text-center">Our Companies</h3>

<div class="row">
	<div class="col-md-6">
		<h5 class="text-center">National :</h5>
		<ul>
			<?php foreach ($national_companies as $company): ?>
				<li>
					<?php echo $company['name'] ?>
					<a href="<?php echo 'company_details.php?company_mail=' . $company['email'] ?>">view info</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<div class="col-md-6">
		<h5 class="text-center">International :</h5>
		<ul>
			<?php foreach ($international_companies as $company): ?>
				<li>
					<?php echo $company['name'] ?>
					<a href="<?php echo 'company_details.php?company_mail=' . $company['email'] ?>">view info</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>