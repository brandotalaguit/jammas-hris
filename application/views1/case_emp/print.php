<div class="box matrix">
	<table class="table table-condensed table-hover">

			<tbody>
				<tr>
					<th width='3%'>#</th>
					<th width='8%'>Date Filed</th>
					<th width='20%'>Employee Name</th>
					<th width='15%'>Project</th>
					<th width='10%'>Category</th>
					<th width='25%'>Remarks</th>
					
					
				</tr>

				<?php if (count($cases)): ?>
					<?php foreach ($cases as $case): ?>
						<tr <?php echo $this->session->flashdata('id') == $case->case_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							<td><?php echo date_convert_to_php($case->date_filed, "M d, Y");?></td>
							<td><?php echo $case->lastname . ', ' . $case->firstname . ' ' . $case->middlename;?></td>
							<td><?php echo $case->title; ?></td>
							<td><?php echo $case->case_category;?></td>
							<td>
								<?php echo $case->remarks;?>
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
</div>