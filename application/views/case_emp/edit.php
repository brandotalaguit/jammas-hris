

<?php echo $form_url; ?>
<div class="container">
	

<div class="row">
	<div class="col-sm-10">

		 <label for="employee_id" class="col-sm-2 control-label">Employee</label>
		 <div class="form-group">
		 	<div class="col-sm-6">
			
				<?php echo form_dropdown('employee_id', $employees, $this->input->post('employee_id') ? $this->input->post('employee_id') : $cases->employee_id, 'id="employee_id" class="form-control"' ) ?>
	        </div>
	        <span class="help-block"></span>
    	</div>

    	<label for="project_id" class="col-sm-2 control-label">Project</label>
			 <div class="form-group">
			 	<div class="col-sm-6">
					<?php echo form_dropdown('project_id', $projects, $this->input->post('project_id') ? $this->input->post('project_id') : $cases->project_id, 'id="project_id" class="form-control"' ) ?>
		        </div>
		        <span class="help-block"></span>
	    </div>

    	<label for="deduction_category_id" class="col-sm-2 control-label">Case Category</label>
    	<div class="form-group">
    		<div class="col-sm-6">
			    <?php echo form_dropdown('case_category_id', $case_categories, $this->input->post('case_category_id') ? $this->input->post('deduction_category_id') : $cases->case_category_id, 'id="case_category_id" class="form-control"' ) ?>
	        </div>
	        <span class="help-block"></span>
    	</div>

		<label for="date_filed" class="col-sm-2 control-label">Date Filed</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="date" name="date_filed" id="date_filed" class="form-control" placeholder="Date Filed" value="<?php echo set_value('date_filed', $cases->date_filed);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		
		
		<label for="remarks" class="col-sm-2 control-label">Remarks</label>
		<div class="form-group">
			<div class="col-sm-6">			
				<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $cases->remarks);?></textarea>
			</div>
			<span class="help-block"></span>
		</div>


		




	</div>

</div>

<div class="row">
	<div class="col-sm-10">
	
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-6">
	  <div class="btn-group">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
		  <a href="<?php echo site_url('case_emp')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

</div>