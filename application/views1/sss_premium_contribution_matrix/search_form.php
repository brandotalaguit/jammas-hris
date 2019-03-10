
<form class="form-inline" role="form" method="post" action="<?php echo site_url('sss_premium_contribution_matrix') ?>">

			<div class="input-group">
	            <select name="by" id="by" class="form-control" style="width:40%">
	            	<option value="salary_range">Salary Range</option>
	            </select>
	          
	            <input type="text" class="form-control deci" name="search" id="search" placeholder="Enter Salary..." style="width:60%">
	            <span class="input-group-btn">
	                <button class="btn btn-default" name="btn_action" type="submit" value="Search"><span class="fa fa-search"></span></button>
	            </span>
	        </div>
	        
</form>

