<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
    			<h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
    			<h3 class="box-title"><?php echo isset($page_btn_view_all) ? $page_btn_view_all : ""; ?></h3>
    			<form class="form-inline" role="form" target="_blank" method="post" action="<?php echo site_url('manning_list/export_pdf_excel') ?>">
		        <input type="hidden" name="last_query" value="<?php if(isset($last_query)) echo $last_query; ?>" /> 
		        <?php foreach($fields as $field): ?>
		        	<input type="hidden" name="last_fields[]" value="<?php echo $field; ?>" /> 
		    	<?php endforeach; ?>
		        <h3 class="box-title"><?php echo isset($page_btn_print) ? $page_btn_print : ""; ?></h3>
		    	<h3 class="box-title"><?php echo isset($page_btn_download) ? $page_btn_download : ""; ?></h3>
		    	</form>
		    	

    		</div>

    		<div class="col-sm-3" >
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

	        
					<div class="input-group">
				

	       			 </div>


		        </div>
    		</div>
    		

    		<div class="col-sm-4">
		        
    		</div>
    	</div>

    	

    </div><!-- /.box-header -->
</div>
<form class="form-inline" role="form"  method="post" action="<?php echo site_url('manning_list') ?>">
<div class="box">
    
    <div class="box-header">
    	<div class="row">
    		<div class="col-sm-7">
    			
		        <h3 class="box-title">Search</h3>
		    	
    		</div>

    		

    		<div class="col-sm-5 pull-right">
    			
		        <h3 class="box-title">Sort By</h3>
		    	
    		</div>
    		

    		
    	</div>
    	<div class="row">
    		
    		<div class="col-sm-7">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">	
		        
		            <?php #if (isset($search_form)): ?>
			            <?php $this->load->view('manning/search_form'); ?>
		            <?php #endif ?>

		        </div>
    		</div>
    		
    		<div class="col-sm-5">
	    		<div class="box-tools" style="padding: 10px 10px 10px 0px">     
						<div class="input-group">
							
							<div class="col-sm-6">
							    <select name="orderby" id="orderby" class="form-control" >
							    	<option value="0">Select Field</option>
							    	<option value="lastname">Lastname</option>
							    	<option value="firstname">Firstname</option>
							    	<option value="position_id">Position</option>
							    	<option value="project_id">Project</option>
							    	<option value="date_of_birth">Date of Birth</option>
							    	<option value="age">Age</option>
							    	<option value="length_of_service">Length of Service</option>
							    	<option value="date_hired">Date Hired</option>
									<option value="daily_rate">Daily Rate</option>
							    </select>
							</div>
							<div class="col-sm-6">
							  	<select name="orderbyascdesc" id="orderbyascdesc" class="form-control" >
							    	<option value="asc">Ascending</option>
							    	<option value="desc">Descending</option>       	
							    </select>
							</div>
						</div>
			    </div>
	    	</div>

    	</div>

    </div><!-- /.box-header -->
</div>


<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-12">
    			
		        <h3 class="box-title">Display Fields</h3>
		    	
    		</div>

    		

    		
    	</div>
    	<div class="row">
    		


    		<div class="col-sm-12" id="orderby_form">
				<div class="box-tools" style="padding: 10px 10px 10px 0px">
    				<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="lastname,firstname,middlename" <?php if(in_array("lastname,firstname,middlename", $fields)): ?> checked <?php endif; ?>> Name
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="gender" <?php if(in_array("gender", $fields)): ?> checked <?php endif; ?>> Gender
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="date_of_birth" <?php if(in_array("date_of_birth", $fields)): ?> checked <?php endif; ?>> Date of Birth
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="age" <?php if(in_array("age", $fields)): ?> checked <?php endif; ?>> Age
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="address1,address2" <?php if(in_array("address1,address2", $fields)): ?> checked <?php endif; ?>> Address
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="mobile_no" <?php if(in_array("mobile_no", $fields)): ?> checked <?php endif; ?>> Mobile No
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="telephone_no" <?php if(in_array("telephone_no", $fields)): ?> checked <?php endif; ?>> Telephone No
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="email" <?php if(in_array("email", $fields)): ?> checked <?php endif; ?>> Email
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="employee_no" <?php if(in_array("employee_no", $fields)): ?> checked <?php endif; ?>> Employee No.
					</label>,   
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="d.title as title" <?php if(in_array("d.title as title", $fields)): ?> checked <?php endif; ?>> Project
					</label>
					
					
		        </div>
    		</div>

    		<div class="col-sm-12" id="orderby_form">
				<div class="box-tools" style="padding: 10px 10px 10px 0px">
    				
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="e.position as position" <?php if(in_array("e.position as position", $fields)): ?> checked <?php endif; ?>> Position
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="f.employment_status as employment_status" <?php if(in_array("f.employment_status as employment_status", $fields)): ?> checked <?php endif; ?>> Employment Status 
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="length_of_service" <?php if(in_array("length_of_service", $fields)): ?> checked <?php endif; ?>> Length of Service
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="date_hired" <?php if(in_array("date_hired", $fields)): ?> checked <?php endif; ?>> Date Hired
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="date_renew" <?php if(in_array("date_renew", $fields)): ?> checked <?php endif; ?>> Date Renewed
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="date_resigned" <?php if(in_array("date_resigned", $fields)): ?> checked <?php endif; ?>> Date Resigned
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="contract_expiry_date" <?php if(in_array("contract_expiry_date", $fields)): ?> checked <?php endif; ?>> Contract Expiry Date
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="sss_no" <?php if(in_array("sss_no", $fields)): ?> checked <?php endif; ?>> SSS No.
					</label>
		        </div>
    		</div>

    		<div class="col-sm-12" id="orderby_form">
				<div class="box-tools" style="padding: 10px 10px 10px 0px">
    				
					
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="philhealth_no" <?php if(in_array("philhealth_no", $fields)): ?> checked <?php endif; ?>> PhilHealth No.
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="pagibig_no" <?php if(in_array("pagibig_no", $fields)): ?> checked <?php endif; ?>> PagIbig No.
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="tin_no" <?php if(in_array("tin_no", $fields)): ?> checked <?php endif; ?>> TIN No.
					</label>

					
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="daily_rate" <?php if(in_array("daily_rate", $fields)): ?> checked <?php endif; ?>> Daily Rate
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="semi_monthly_rate" <?php if(in_array("semi_monthly_rate", $fields)): ?> checked <?php endif; ?>> Semi-Monthly Rate
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="monthly_rate" <?php if(in_array("monthly_rate", $fields)): ?> checked <?php endif; ?>> Monthly Rate
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="e_cola" <?php if(in_array("e_cola", $fields)): ?> checked <?php endif; ?>> E-Cola
					</label>
					<label class="checkbox-inline">
					  <input type="checkbox" name="columns[]" value="allowance,allowance_mode_of_payment" <?php if(in_array("allowance,allowance_mode_of_payment", $fields)): ?> checked <?php endif; ?>> Allowance
					</label>
		        </div>
    		</div>
    		
    		
    	</div>

    	

    </div><!-- /.box-header -->
</div>
<div class="box data-filters">
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-9">
    			
		        <h3 class="box-title">Data Filters</h3>
		    	
    		</div>
    		
    		
    	</div>

    	<div class="row">
    		
    		<div class="col-sm-4" id="">
		       <div class="box-tools" style="padding: 10px 10px 10px 10px">
		       		<div class="">
				
	          		<?php echo form_dropdown('project_id', $projects, $this->input->post('project_id'), 'id="project_id" class="form-control"' ) ?>
	          	
	         
	           
	        		</div>
		       </div>
    		</div>
    		<div class="col-sm-4" id="">
		        <div class="box-tools" style="padding: 10px 10px 10px 10px">
					<div class="">
				
	          	<?php echo form_dropdown('position_id', $positions, $this->input->post('position_id'), 'id="position_id" class="form-control"' ) ?>
	       
	            
	       			 </div>

		        </div>
    		</div>

    		<div class="col-sm-4" id="">
		        <div class="box-tools" style="padding: 10px 10px 10px 10px">
					<div class="">
				

				
	          	<?php echo form_dropdown('employment_status_id', $employment_statuses, $this->input->post('employment_status_id'), 'id="employment_status_id" class="form-control"' ) ?>
	       
	            
	       			 

	       			 </div>

		        </div>
    		</div>

    		
		    		
    		
    	</div>	
    		


    	
    </div><!-- /.box-header -->
   
</div>

<div class="box data-filters">
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-7">
    			
		        <h3 class="box-title">Date Filters</h3>
		    	
    		</div>
    		<div class="col-sm-5">
    			
		        <h3 class="box-title">Expired Contracts</h3>
		    	
    		</div>
    		
    	</div>

    	<div class="row">
    		
    		

    		<div class="col-sm-7">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

			       
				        <div class="col-md-4">	
						  	<select name="dateby" id="dateby" class="form-control" >
						    	<option value="0">Select Date Field</option>
						    	<option value="date_of_birth">Date of Birth</option>
						    	<option value="date_hired">Date Hired</option>
						    	<option value="date_renew">Date Renewed</option>
						    	<option value="date_resigned">Date Resigned</option>
						    	<option value="contract_expiry_date">Contract Expiry Date</option>   	
						    </select>
						</div>
					    <div class="col-md-8">
					    	<input type="date" class="form-control" name="date_start" id="date_start" placeholder="Date Start" style="display:inline-block; width: 45%">
					    	<input type="date" class="form-control" name="date_end" id="date_end" placeholder="Date End" style="display:inline-block; width: 45%">
					    </div>
					   
	    
		        </div>
    		</div>
		    		
    		<div class="col-sm-5">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">	
		        
		            <label class="checkbox-inline">
					  <input type="radio" name="expired_contract" value="1" <?php if(in_array("1", $fields)): ?> checked <?php endif; ?>> 0 days 
					</label>
					<label class="checkbox-inline">
					  <input type="radio" name="expired_contract" value="2" <?php if(in_array("2", $fields)): ?> checked <?php endif; ?>> 30 days 
					</label>
					<label class="checkbox-inline">
					  <input type="radio" name="expired_contract" value="3" <?php if(in_array("3", $fields)): ?> checked <?php endif; ?>> 60 days
					</label>
					<label class="checkbox-inline">
					  <input type="radio" name="expired_contract" value="4" <?php if(in_array("4", $fields)): ?> checked <?php endif; ?>> 90 days
					</label>
		        </div>
    		</div>
    	</div>	
    		


    	
    </div><!-- /.box-header -->
   
</div>

<div class="box">
    <div class="box-body table-responsive no-padding">
        <table class="table table-condensed table-hover manning">
			<tbody>
				<tr>
					<th width='3%'>#</th>

					<?php if(in_array("lastname,firstname,middlename", $fields)): ?>
					<th width='15%'>Employee Name</th>
					<?php endif; ?>
					<?php if(in_array("gender", $fields)): ?>
					<th width='5%'>Gender</th>
					<?php endif; ?>
					<?php if(in_array("date_of_birth", $fields)): ?>
					<th width='10%'>Date of Birth</th>
					<?php endif; ?>
					<?php if(in_array("age", $fields)): ?>
					<th width='5%'>Age</th>
					<?php endif; ?>
					<?php if(in_array("address1,address2", $fields)): ?>
					<th width='15%'>Address</th>
					<?php endif; ?>
					<?php if(in_array("mobile_no", $fields)): ?>
					<th width='10%'>Mobile No</th>
					<?php endif; ?>
					<?php if(in_array("telephone_no", $fields)): ?>
					<th width='10%'>Telephone No</th>
					<?php endif; ?>
					<?php if(in_array("email", $fields)): ?>
					<th width='10%'>Email</th>
					<?php endif; ?>
					<?php if(in_array("employee_no", $fields)): ?>
					<th width='15%'>Employee No</th>
					<?php endif; ?>
					<?php if(in_array("d.title as title", $fields)): ?>
					<th width='15%'>Project</th>
					<?php endif; ?>

					<?php if(in_array("e.position as position", $fields)): ?>
					<th width='10%'>Position</th>
					<?php endif; ?>

					<?php if(in_array("f.employment_status as employment_status", $fields)): ?>
					<th width='10%'>Employment Status</th>
					<?php endif; ?>

					<?php if(in_array("length_of_service", $fields)): ?>
					<th width='5%'>Length of Service</th>
					<?php endif; ?>
					
					<?php if(in_array("date_hired", $fields)): ?>
					<th width='10%'>Date Hired</th>
					<?php endif; ?>
					<?php if(in_array("date_renew", $fields)): ?>
					<th width='10%'>Date Renewed</th>
					<?php endif; ?>
					<?php if(in_array("contract_expiry_date", $fields)): ?>
					<th width='10%'>Contract Expiry Date</th>
					<?php endif; ?>

					<?php if(in_array("sss_no", $fields)): ?>
					<th width='10%'>SSS No.</th>
					<?php endif; ?>
					
					<?php if(in_array("philhealth_no", $fields)): ?>
					<th width='10%'>Philhealth No.</th>
					<?php endif; ?>
					<?php if(in_array("pagibig_no", $fields)): ?>
					<th width='10%'>PagIbig No</th>
					<?php endif; ?>
					<?php if(in_array("tin_no", $fields)): ?>
					<th width='10%'>TIN No.</th>
					<?php endif; ?>

					<?php if(in_array("daily_rate", $fields)): ?>
					<th width='10%'>Daily Rate</th>
					<?php endif; ?>

					<?php if(in_array("semi_monthly_rate", $fields)): ?>
					<th width='10%'>Semi-Monthly Rate</th>
					<?php endif; ?>
					
					<?php if(in_array("monthly_rate", $fields)): ?>
					<th width='10%'>Monthly Rate</th>
					<?php endif; ?>
					<?php if(in_array("e_cola", $fields)): ?>
					<th width='10%'>E-Cola</th>
					<?php endif; ?>
					<?php if(in_array("allowance,allowance_mode_of_payment", $fields)): ?>
					<th width='15%'>Allowance</th>
					<?php endif; ?>



					<th width='23%'>Action</th>
				</tr>

				<?php if (count($employees)): ?>
					<?php foreach ($employees as $employee): ?>
						<tr <?php echo $this->session->flashdata('id') == $employee->manning_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							
							

							<?php if(in_array("lastname,firstname,middlename", $fields)): ?>
							<td><?php echo $employee->lastname . ', ' . $employee->firstname . ' ' . $employee->middlename;?></td>
							<?php endif; ?>
							<?php if(in_array("gender", $fields)): ?>
							<td><?php echo $employee->gender; ?></td>
							<?php endif; ?>
							<?php if(in_array("date_of_birth", $fields)): ?>
							<td><?php echo date_convert_to_php($employee->date_of_birth, "M d, Y");?></td>
							<?php endif; ?>
							<?php if(in_array("age", $fields)): ?>
							<td><?php echo $employee->age; ?></td>
							<?php endif; ?>
							<?php if(in_array("address1,address2", $fields)): ?>
							<td><?php echo $employee->address1 . ' ' . $employee->address2  ; ?></td>
							<?php endif; ?>
							<?php if(in_array("mobile_no", $fields)): ?>
							<td><?php echo $employee->mobile_no; ?></td>
							<?php endif; ?>
							<?php if(in_array("telephone_no", $fields)): ?>
							<td><?php echo $employee->telephone_no; ?></td>
							<?php endif; ?>
							<?php if(in_array("email", $fields)): ?>
							<td><?php echo $employee->email; ?></td>
							<?php endif; ?>
							<?php if(in_array("employee_no", $fields)): ?>
							<td><?php echo $employee->employee_no; ?></td>
							<?php endif; ?>
							<?php if(in_array("d.title as title", $fields)): ?>
							<td><?php echo $employee->title; ?></td>
							<?php endif; ?>

							<?php if(in_array("e.position as position", $fields)): ?>
							<td><?php echo $employee->position; ?></td>
							<?php endif; ?>

							<?php if(in_array("f.employment_status as employment_status", $fields)): ?>
							<td><?php echo $employee->employment_status; ?></td>
							<?php endif; ?>

							<?php if(in_array("length_of_service", $fields)): ?>
							<td><?php echo $employee->length_of_service; ?></td>
							<?php endif; ?>
							
							<?php if(in_array("date_hired", $fields)): ?>
							<td><?php echo date_convert_to_php($employee->date_hired, "M d, Y");?></td>
							<?php endif; ?>
							<?php if(in_array("date_renew", $fields)): ?>
							<td><?php echo date_convert_to_php($employee->date_renew, "M d, Y");?></td>
							<?php endif; ?>
							<?php if(in_array("contract_expiry_date", $fields)): ?>
							<td><?php echo date_convert_to_php($employee->contract_expiry_date, "M d, Y");?></td>
							<?php endif; ?>

							<?php if(in_array("sss_no", $fields)): ?>
							<td><?php echo $employee->sss_no; ?></td>
							<?php endif; ?>
							
							<?php if(in_array("philhealth_no", $fields)): ?>
							<td><?php echo $employee->philhealth_no; ?></td>
							<?php endif; ?>
							<?php if(in_array("pagibig_no", $fields)): ?>
							<td><?php echo $employee->pagibig_no; ?></td>
							<?php endif; ?>
							<?php if(in_array("tin_no", $fields)): ?>
							<td><?php echo $employee->tin_no; ?></td>
							<?php endif; ?>

							<?php if(in_array("daily_rate", $fields)): ?>
							<td><?php echo $employee->daily_rate; ?></td>
							<?php endif; ?>

							<?php if(in_array("semi_monthly_rate", $fields)): ?>
							<td><?php echo $employee->semi_monthly_rate; ?></td>
							<?php endif; ?>
							
							<?php if(in_array("monthly_rate", $fields)): ?>
							<td><?php echo $employee->monthly_rate; ?></td>
							<?php endif; ?>
							<?php if(in_array("e_cola", $fields)): ?>
							<td><?php echo $employee->e_cola; ?></td>
							<?php endif; ?>
							<?php if(in_array("allowance,allowance_mode_of_payment", $fields)): ?>
							<td><?php echo $employee->allowance; ?>
							<?php
							if($employee->allowance_mode_of_payment == 1)
								echo 'Per Day';
							else if($employee->allowance_mode_of_payment == 2)
								echo 'Per Semi-Monthly';
							else  if($employee->allowance_mode_of_payment == 3)								
								echo 'Per Month';
							?>
					
							<?php endif; ?>

							</td>
							
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit('manning_list/'. $employee->manning_id . '/edit');?>
									<?php echo btn_view('manning_list/'. $employee->manning_id . '/view');?>
									<?php echo btn_print('manning_list/'. $employee->manning_id . '/print_profile');?>
									<?php echo btn_delete('manning_list/'. $employee->manning_id . '/delete');?>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
						<tr>
							<td colspan="7">
								<span class="label label-danger">No record found!.</span>
							</td>
						</tr>
				<?php endif ?>
			</tbody>
        </table>
    </div><!-- /.box-body -->

    <div class="box-footer clearfix">
	    <?php 
	    	if (isset($pagination))
	    	echo $pagination;	
	    ?>
    </div><!-- /.box-footer -->

</div><!-- /.box -->
</form>