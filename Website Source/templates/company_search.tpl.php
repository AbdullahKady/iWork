<form action="companies.php" method="post" class="container">

			<h3>Search Companies</h3>

  <div class="row">
  	<div class="col-md-6">
  		<div class="form-group">
		    <label for="company_name">Company name</label>
		    <input type="text" placeholder="Simens" class="form-control" maxlength="20" name="company_name">
		  </div>	
  	</div>

  	<div class="col-md-6">
  		<div class="form-group">
		    <label for="company_address">Company address</label>
		    <input type="text" placeholder="Planet Earth" class="form-control" maxlength="100" name="company_address">
		  </div>
  	</div>
  </div>
  
  <h6><strong>Company type :</strong></h4>

  <div class="radio">
	  <label>
	    <input type="radio" name="company_type" value="national" >
	    National
	  </label>
	</div>

	<div class="radio">
	  <label>
	    <input type="radio" name="company_type" value="international">
	    International
	  </label>
	</div>

	<div class="radio">
	  <label>
	    <input type="radio" name="company_type" value="both" checked>
	    Both
	  </label>
	</div>

	<div class="row">
		<div class="col-md-9">
  	<button type="submit" class="btn btn-info btn-wide">Search</button>
  	 	</div>
		<div class="col-md-3">
			 <a href="highest_salary.php" class="btn btn-success">View highest paying companies!</a>
		 	 
		</div>
	</div>



</form>

  