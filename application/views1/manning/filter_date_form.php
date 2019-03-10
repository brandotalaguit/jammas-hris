<form class="form-inline" role="form" method="post" action="<?php echo site_url('manning_list') ?>">
			<div class="input-group">
				<div class="col-sm-3">
	            <label for="date_filter" class="control-label pull-right" style="margin-top:7px">Date Filter</label>
	          	</div>
	          	<select name="by" id="by" class="form-control" style="width:25%">
	            	<option value="date_of_birth">Date of Birth</option>
	            	<option value="date_hired">Date Hired</option>
	            	<option value="date_renew">Date Renewed</option>
	            	<option value="contract_expiry_date">Contract Expiry Date</option>
	            	
	            </select>
	            <input type="date" class="form-control" name="date_start" id="date_start" placeholder="Date Start" style="display:inline-block;width:25%">
	            <input type="date" class="form-control" name="date_end" id="date_end" placeholder="Date End" style="display:inline-block;width:25%">
	            <span class="input-group-btn">
	                <button class="btn btn-default" name="btn_date_filter" type="submit" value="Search"><span class="fa fa-search"></span></button>
	            </span>
	        </div>
	     
</form>