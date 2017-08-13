<div class="box matrix">
	<table class="table table-condensed table-hover">
			<tbody>
				<tr>
					<th width='3%'>#</th>
					<th width='15%'>Type</th>
					<th width='15%'>Category Code</th>
					<th width='32%'>Category Description</th>
					<th width='25%'>Remarks</th>					
				</tr>
				<?php if (count($deduction_categories)): ?>
					<?php foreach ($deduction_categories as $deduction_category): ?>
						<tr <?php echo $this->session->flashdata('id') == $deduction_category->deduction_category_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							<td><?php
								if($deduction_category->deduction_type == 1)
									echo 'SSS';
								else if($deduction_category->deduction_type == 2)
									echo 'PagIbig';
								else  if($deduction_category->deduction_type == 3)								
									echo 'PhilHealth';
								else							
									echo 'Other';
								?>	
							</td>
							<td><?php echo $deduction_category->deduction_category_code;?></td>
							<td><?php echo $deduction_category->deduction_category;?></td>
							<td><?php echo $deduction_category->remarks;?></td>
							
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