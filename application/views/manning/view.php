<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-3">
    			<form class="form-inline" role="form" target="_blank" method="post" action="<?php echo site_url('manning_list/print_pdf') ?>">
		        <input type="hidden" name="last_query" value="<?php echo isset($last_query) ? $last_query : ""; ?>" /> 
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
		    	</form>
    		</div>
    		
    	</div>

    	

    </div><!-- /.box-header -->
</div>

<div class="container-fluid" id="view_employee_details">
	

<div class="row">
	<div class="col-sm-6">
		<div class="box">
		<h4>Personal Information</h4>
		<dl class="dl-horizontal">
		  <dt>Name:</dt>
		  <dd><?php echo $employee->firstname . ' ' . $employee->middlename . ' ' .$employee->lastname; ?></dd>
		  
		  <dt>Gender:</dt>
		  <dd><?php echo  $employee->gender == 'M' ?  "Male" : "Female"; ?></dd>
		  <dt>Date of Birth:</dt>
		  <dd><?php echo ($employee->date_of_birth != '0000-00-00') ? date_convert_to_php($employee->date_of_birth, "M d, Y") : ''; ?></dd>
		  <dt>Age:</dt>
		  <dd><?php echo $employee->age; ?></dd>
		  <dt>Address:</dt>
		  <dd><?php echo $employee->address1 . ' ' . $employee->address2; ?></dd>
		  <dt>Mobile No:</dt>
		  <dd><?php echo $employee->mobile_no; ?></dd>
		  <dt>Telephone No:</dt>
		  <dd><?php echo $employee->telephone_no; ?></dd>
		  <dt>Email:</dt>
		  <dd><?php echo $employee->email; ?></dd>
		  <dt>Remarks:</dt>
		  <dd><?php echo $employee->remarks; ?></dd>
		</dl>
		</div>
	</div>	
	<div class="col-sm-6">
		<div class="box">
		<h4>Contract Details</h4>
		<dl class="dl-horizontal">
		  <dt>Employee No:</dt>
		  <dd><?php echo $employee->employee_no; ?></dd>
		  <dt>Project:</dt>
		  <dd><?php echo $employee->title; ?></dd>
		  <dt>Position:</dt>
		  <dd><?php echo $employee->position; ?></dd>
		  <dt>Employment Status:</dt>
		  <dd><?php echo $employee->employment_status; ?></dd>
		  <dt>Length of Service:</dt>
		  <dd><?php echo $employee->length_of_service; ?></dd>
		  <dt>Date Hired:</dt>
		  <dd><?php echo ($employee->date_hired != '0000-00-00') ? date_convert_to_php($employee->date_hired, "M d, Y") : ''; ?></dd>
		  <dt>Date Renew:</dt>
		  <dd><?php echo ($employee->date_renew != '0000-00-00') ? date_convert_to_php($employee->date_renew, "M d, Y") : ''; ?></dd>
		  <dt>Date Resigned:</dt>
		  <dd><?php echo ($employee->date_resigned != '0000-00-00') ? date_convert_to_php($employee->date_resigned, "M d, Y") : ''; ?></dd>
		  <dt>Contract Expiry Date:</dt>
		  <dd><?php echo ($employee->contract_expiry_date != '0000-00-00') ? date_convert_to_php($employee->contract_expiry_date, "M d, Y") : ''; ?></dd>
		  <dt>Contract Remarks:</dt>
		  <dd><?php echo $employee->contract_remarks; ?></dd>
		</dl>			
		</div>
	</div>
		
</div>	



<div class="row">
	<div class="col-sm-6">
		<div class="box">
		<h4>Salary Details</h4>
		<dl class="dl-horizontal">
		  <dt>Daily Rate:</dt>
		  <dd><?php echo nf($employee->daily_rate); ?></dd>
		  <dt>Semi-Monthly Rate:</dt>
		  <dd><?php echo nf($employee->semi_monthly_rate); ?></dd>
		  <dt>Monthly Rate:</dt>
		  <dd><?php echo  nf($employee->monthly_rate); ?></dd>
		  <dt>E-COLA:</dt>
		  <dd><?php echo nf($employee->e_cola); ?></dd>
		  <dt>Allowance:</dt>
		  <dd><?php echo nf($employee->allowance); ?></dd>
		  <dt>Allowance Mode of Payment:</dt>
		  <dd>
		  <?php
			if($employee->allowance_mode_of_payment == 1)
				echo 'Daily';
			else if($employee->allowance_mode_of_payment == 2)
				echo 'Semi-Monthly';
			else  if($employee->allowance_mode_of_payment == 3)								
				echo 'Monthly';
			?>
		  </dd>		
		  <dt>Allowance Remarks:</dt>
		  <dd><?php echo $employee->allowance_remarks; ?></dd>
		</dl>
		</div>
	</div>	
	
	<div class="col-sm-6">
		<div class="box">
		<h4>Benefits ID Nos.</h4>
		<dl class="dl-horizontal">
		  <dt>SSS No.:</dt>
		  <dd><?php echo $employee->sss_no; ?></dd>
		  <dt>PhilHealth No.:</dt>
		  <dd><?php echo $employee->philhealth_no; ?></dd>
		  <dt>PAGIBIG No.:</dt>
		  <dd><?php echo $employee->pagibig_no; ?></dd>
		  <dt>TIN No.:</dt>
		  <dd><?php echo $employee->tin_no; ?></dd>
		</dl>  
		</div>
	</div>	
</div>		

<div class="row">
	<div class="col-sm-6">
		<div class="box">
		<h4>Requirements Date Submission</h4>
		<dl class="dl-horizontal">
		  <dt>NBA Clearance:</dt>
		  <dd><?php echo ($employee->nbi_clearance_date_submitted != '0000-00-00') ? date_convert_to_php($employee->nbi_clearance_date_submitted, "M d, Y") : ''; ?></dd>
		  <dt>Police Clearance:</dt>
		  <dd><?php echo ($employee->police_clearance_date_submitted != '0000-00-00') ? date_convert_to_php($employee->police_clearance_date_submitted, "M d, Y") : ''; ?></dd>
		  <dt>Barangay Clearance:</dt>
		  <dd><?php echo ($employee->brgy_clearance_date_submitted != '0000-00-00') ? date_convert_to_php($employee->brgy_clearance_date_submitted, "M d, Y") : ''; ?></dd>
		  <dt>Health Certificare Clearance:</dt>
		  <dd><?php echo ($employee->medical_clearance_date_submitted != '0000-00-00') ? date_convert_to_php($employee->medical_clearance_date_submitted, "M d, Y") : ''; ?></dd>
		  <dt>Mayor's Permit Clearance:</dt>
		  <dd><?php echo ($employee->mayors_permit_clerance_date_submitted != '0000-00-00') ? date_convert_to_php($employee->mayors_permit_clerance_date_submitted, "M d, Y") : ''; ?></dd>
		  <dt>Drug Test Clearance:</dt>
		  <dd><?php echo ($employee->drugtest_clearance_date_submitted != '0000-00-00') ? date_convert_to_php($employee->drugtest_clearance_date_submitted, "M d, Y") : ''; ?></dd>
		  <dt>Fit to Work Clearance:</dt>
		  <dd><?php echo ($employee->fit_to_work_date_submitted != '0000-00-00') ? date_convert_to_php($employee->fit_to_work_date_submitted, "M d, Y") : ''; ?></dd>
		  <dt>X-Ray Clearance:</dt>
		  <dd><?php echo ($employee->xray_date_submitted != '0000-00-00') ? date_convert_to_php($employee->xray_date_submitted, "M d, Y") : ''; ?></dd>	
		  <dt>Date Filed:</dt>
		  <dd><?php echo ($employee->date_filed_up != '0000-00-00') ? date_convert_to_php($employee->date_filed_up, "M d, Y") : ''; ?></dd>
		  <dt>Insurance Remarks:</dt>
		  <dd><?php echo $employee->insurance_remarks; ?></dd>
		</dl>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="box">
		<h4>Employee Cases</h4>
		<dl class="dl-horizontal">
		<dt>Name:</dt>
		  <dd><?php echo $employee->firstname . ' ' . $employee->middlename . ' ' .$employee->lastname; ?></dd>
		  </dl>
		</div>
		<?php foreach($employee_cases as $employee_case): ?>
			<div class="box">
		<dl class="dl-horizontal">
			<dt>Date Filed:</dt>
				<dd>
					<?php echo date_convert_to_php($employee_case->date_filed, "M d, Y"); ?></dd>
			<dt>Case Category:</dt>
				<dd>
					<?php echo $employee_case->case_category; ?></dd>
			<dt>Project:</dt>
				<dd>
					<?php echo $employee_case->title; ?></dd>
			<dt>Comment:</dt>
				<dd>
					<?php echo $employee_case->remarks; ?></dd>
			
			
		</dl>
		</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>



</div>


