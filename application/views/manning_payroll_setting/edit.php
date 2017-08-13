<?php echo form_open(NULL, ['class' => '', 'role' => 'form']); ?>
<div class="row">
<div class="col-xs-12">
	<div class="box box-solid">
	    <div class="box-body">
	        <div class="table-responsive">
	        	<table class="table table-hover table-bordered">
	        		<thead>
	        			<tr>
	        				<th rowspan="2" width="60%">Wage</th>
	        				<th colspan="3" width="40%">Pay Period</th>
	        			</tr>
	        			<tr>
	        				<th width="15%">
	        					1<sup>st</sup>
	        					<p><code>1 time deduction</code></p>
	        				</th>
	        				<th width="15%">
	        					2<sup>2nd</sup>
	        					<p><code>1 time deduction</code></p>
	        				</th>
	        				<th width="15%">
	        					Every Pay
	        					<p><code>(Total amount/2)</code></p>
	        				</th>
	        			</tr>
	        		</thead>
	        		<tbody>
	        			<tr>
	        				<td>PAGIBIG</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_pagibig" id="pagibig1" value="1" <?php $config->mode_of_payment_pagibig == '1' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_pagibig', '1', $check);?> >
	        					</label>
	        				</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_pagibig" id="pagibig2" value="2" <?php $config->mode_of_payment_pagibig == '2' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_pagibig', '2', $check);?> >
	        					</label>
	        				</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_pagibig" id="pagibig3" value="3" <?php $config->mode_of_payment_pagibig == '3' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_pagibig', '3', $check);?> >
	        					</label>
	        				</td>
	        			</tr>
	        			<tr>
	        				<td>PHILHEALTH</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_philhealth" id="philhealth1" value="1" <?php $config->mode_of_payment_philhealth == '1' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_philhealth', '1', $check);?> >
	        					</label>
	        				</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_philhealth" id="philhealth2" value="2" <?php $config->mode_of_payment_philhealth == '2' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_philhealth', '2', $check);?> >
	        					</label>
	        				</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_philhealth" id="philhealth3" value="3" <?php $config->mode_of_payment_philhealth == '3' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_philhealth', '3', $check);?> >
	        					</label>
	        				</td>
	        			</tr>
	        			<tr>
	        				<td>SSS</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_sss" id="sss1" value="1" <?php $config->mode_of_payment_sss == '1' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_sss', '1', $check);?> >
	        					</label>
	        				</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_sss" id="sss2" value="2" <?php $config->mode_of_payment_sss == '2' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_sss', '2', $check);?> >
	        					</label>
	        				</td>
	        				<td>
	        					<label class="radio-inline">
	        					  <input type="radio" name="mode_of_payment_sss" id="sss3" value="3" <?php $config->mode_of_payment_sss == '3' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment_sss', '3', $check);?> >
	        					</label>
	        				</td>
	        			</tr>
	        		</tbody>
	        	</table>
	        </div>
	        <div class="clearfix"></div>
	        
	    </div><!-- /.box-body -->
	    
	    <div class="box-body clearfix">
	    	        <div class="row">
	    	        	<div class="col-md-4">
	    	        		<div class="form-group">
	    		        		<label>Save Option</label>
	    		        		<div class="radio margin">
	    		        			<label>
	    		        				<input type="radio" name="save_option" id="save_option" value="1">
	    		        				 <span class="pad">Apply to all projects</span>
	    		        			</label>
	    		        		</div>
	    		        		<div class="radio margin">
	    		        			<label>
	    		        				<input type="radio" name="save_option" id="save_option" value="2" checked="checked">
	    		        				 <span class="pad">Apply to selected project(s)</span>
	    		        			</label>
	    		        		</div>
	    	        		</div>

	    	                
	    	        	</div>
	    	        	<div class="col-md-8">
	    	        		        <div class="form-group">
	    	        		            <label for="projects">Projects</label>
	    	        				    <?php echo form_dropdown('projects[]', $projects, $this->input->post('projects[]') ? $this->input->post('projects[]') : $this->uri->segment(3), 'id="projects" class="form-control" multiple' ) ?>
	    	        		        </div>
	    	        	</div>
	    	        </div>
	    </div>

	    <div class="box-footer clearfix">

	        <?= form_submit([
		        	'name' => 'btn_action', 
		        	'value' => 'SUBMIT SETTINGS',
		        	'class' => 'btn btn-lg btn-block btn-primary',
		        	'style' => 'font-weight: bold;'
	        	]); ?>
	    </div>
	</div>
	
</div>



	
</div>
<?php echo form_close(); ?>