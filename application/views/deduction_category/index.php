<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
    		</div>
    		<div class="col-sm-4">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		            <?php #if (isset($search_form)): ?>
			            <?php $this->load->view('deduction_category/search_form'); ?>
		            <?php #endif ?>

		        </div>
    		</div>
    	</div>

    </div><!-- /.box-header -->

    <div class="box-body table-responsive no-padding">
        <table class="table table-condensed table-hover">

			<tbody>
				<tr>
					<th width='3%'>#</th>
					<th width='15%'>Type</th>
					<th width='15%'>Category Code</th>
					<th width='35%'>Category Description</th>
					<th width='20%'>Remarks</th>

					<th width='12%'>Action</th>
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
							
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit('deduction_category/'. $deduction_category->deduction_category_id . '/edit');?>
									<?php echo btn_delete('deduction_category/'. $deduction_category->deduction_category_id . '/delete');?>
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
