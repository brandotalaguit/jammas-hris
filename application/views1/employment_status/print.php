<div class="box matrix">
	<table class="table table-condensed table-hover">

			<tbody>
				<tr>
					<th width='3%'>#</th>
					
					<th width='20%'>Employment Status Code</th>
					<th width='45%'>Employment Status</th>
					<th width='25%'>Remarks</th>

					
				</tr>

				<?php if (count($employment_statuses)): ?>
					<?php foreach ($employment_statuses as $employment_status): ?>
						<tr <?php echo $this->session->flashdata('id') == $employment_status->employment_status_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							
							<td><?php echo $employment_status->employment_status_code;?></td>
							<td><?php echo $employment_status->employment_status;?></td>
							<td><?php echo $employment_status->remarks;?></td>
							
							
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