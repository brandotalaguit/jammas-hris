<form class="form-inline case_category_filter" role="form" method="post" action="<?php echo site_url('case_emp') ?>">
			<div class="input-group">
				
	          	<?php echo form_dropdown('case_category_id', $case_categories, $this->input->post('case_category_id'), 'id="case_category_id" class="form-control"' ) ?>
	       
	           
	        </div>
	     
</form>
