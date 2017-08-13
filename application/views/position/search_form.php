
<form class="form-inline" role="form" method="post" action="<?php site_url('position') ?>">

			<div class="input-group">
	            <select name="by" id="by" class="form-control" style="width:40%">
	            	<option value="Position">Position</option>
	            	<!-- <option value="position_code">Position Code</option> -->
	            	<option value="Remarks">Remarks</option>
	            </select>
	          
	            <input type="text" class="form-control" name="search" id="search" placeholder="Search term..." style="width:60%">
	            <span class="input-group-btn">
	                <button class="btn btn-default" name="btn_action" type="submit" value="Search"><span class="fa fa-search"></span></button>
	            </span
	        </div>
	        </div>
</form>