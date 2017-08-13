<form class="form-inline" role="form" method="post" action="<?php echo site_url('manning_list') ?>">
			<div class="input-group">
				<div class="col-sm-3">
	            <label for="date_filter" class="control-label pull-right" style="margin-top:7px">Position Filter</label>
	          	</div>
	          	<?php echo form_dropdown('position_id', $positions, $this->input->post('position_id'), 'id="position_id" class="form-control"' ) ?>
	       
	            <span class="input-group-btn">
	                <button class="btn btn-default" name="btn_position_filter" type="submit" value="Search"><span class="fa fa-search"></span></button>
	            </span>
	        </div>
	     
</form>