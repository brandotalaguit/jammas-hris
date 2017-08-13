<div class="box matrix">
    <table class="table table-condensed table-hover">

		<tbody>
			<tr>
				<th width='3%'>#</th>
				<th width='14%'>Salary Range Start</th>
				<th width='14%'>Salary Range End</th>
				<th width='19%'>Salary Base</th>
				<th width='15%'>Employee Share</th>
				<th width='15%'>Employer Share</th>
				<th width='20%'>Total Monthly Contribution</th>
				
				
			</tr>

			<?php if (count($philhealth_matrix)): ?>
					<?php foreach ($philhealth_matrix as $philhealth_matrix_row): ?>
						<tr <?php echo $this->session->flashdata('id') == $philhealth_matrix_row->ppc_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>							
							<td><?php echo nf($philhealth_matrix_row->salary_range_start);?></td>
							<td><?php echo nf($philhealth_matrix_row->salary_range_end);?></td>
							<td><?php echo nf($philhealth_matrix_row->salary_base);?></td>
							<td><?php echo nf($philhealth_matrix_row->employee_share);?></td>
							<td><?php echo nf($philhealth_matrix_row->employer_share);?></td>
							<td><?php echo nf($philhealth_matrix_row->total_monthly_premium);?></td>
							
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