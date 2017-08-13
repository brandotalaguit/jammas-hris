<form class="form-inline deduction_category_filter" role="form" method="post" action="<?php echo site_url('deduction') ?>">
			<div class="input-group">
				<div class="col-sm-3">
	            <label for="deduction_category_id" class="control-label pull-right" style="margin-top:7px">Category</label>
	          	</div>
	          	<?php echo form_dropdown('deduction_category_id', $deduction_categories, $this->input->post('deduction_category_id'), 'id="deduction_category_id" class="form-control"' ) ?>
	       
	            <span class="input-group-btn">
	                <button class="btn btn-default" name="btn_deduction_category_filter" type="submit" value="Search"><span class="fa fa-search"></span></button>
	            </span>
	        </div>
	     
</form>
