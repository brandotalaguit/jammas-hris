<div class="box matrix">
	<table class="table table-condensed table-hover">
			<tbody>
				<tr>
					<th width='3%'>#</th>
					
					<th width='15%'>Category Code</th>
					<th width='32%'>Category Description</th>
					<th width='25%'>Remarks</th>					
				</tr>
				<?php if (count($case_categories)): ?>
					<?php foreach ($case_categories as $case_category): ?>
						<tr <?php echo $this->session->flashdata('id') == $case_category->case_category_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							
							<td><?php echo $case_category->case_category_code;?></td>
							<td><?php echo $case_category->case_category;?></td>
							<td><?php echo $case_category->remarks;?></td>
							
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