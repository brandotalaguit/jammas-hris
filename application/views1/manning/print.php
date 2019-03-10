<div class="box matrix">
	<table class="table table-condensed table-hover">

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

					<?php if(in_array("date_resigned", $fields)): ?>
					<th width='10%'>Date Resigned</th>
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
					<?php if(in_array("allowance, allowance_mode_of_payment", $fields)): ?>
					<th width='15%'>Allowance</th>
					<?php endif; ?>



					
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

							<?php if(in_array("date_resigned", $fields)): ?>
							<td><?php echo date_convert_to_php($employee->date_resigned, "M d, Y");?></td>
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
							<td><?php echo $employee->allowance; ?></td>
							<?php
							if($employee->allowance_mode_of_payment == 1)
								echo 'Per Day';
							else if($employee->allowance_mode_of_payment == 2)
								echo 'Per Semi-Monthly';
							else  if($employee->allowance_mode_of_payment == 3)								
								echo 'Per Month';
							?>
					
							<?php endif; ?>

							
							
							
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
</div>