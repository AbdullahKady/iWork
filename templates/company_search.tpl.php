<form action="settings.php" method="post" class="container">
	<h3>Search Companies</h3>

  <div class="row">
  	<div class="col-md-6">
  		<div class="form-group">
		    <label for="company_name">Company name</label>
		    <input type="text" placeholder="Simens" class="form-control" name="company_name">
		  </div>	
  	</div>

  	<div class="col-md-6">
  		<div class="form-group">
		    <label for="company_address">Company address</label>
		    <input type="text" placeholder="Planet Earth" class="form-control" name="company_address">
		  </div>
  	</div>
  </div>

  <div class="radio">
	  <label>
	    <input type="radio" name="company_type" value="national" checked>
	    National
	  </label>
	</div>

	<div class="radio">
	  <label>
	    <input type="radio" name="company_type" value="international">
	    International
	  </label>
	</div>


  <button type="submit" class="btn btn-primary">Save</button>
  <a href="index.php" class="btn">Cancel</a>

</form>