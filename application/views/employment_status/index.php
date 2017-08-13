<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
    		</div>
    		<div class="col-sm-4">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		            <?php #if (isset($search_form)): ?>
			            <?php $this->load->view('employment_status/search_form'); ?>
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
					
					<th width='15%'>Employment Status Code</th>
					<th width='15%'>Employment Status</th>
					<th width='30%'>Remarks</th>

					<th width='7%'>Action</th>
				</tr>

				<?php if (count($employment_statuses)): ?>
					<?php foreach ($employment_statuses as $employment_status): ?>
						<tr <?php echo $this->session->flashdata('id') == $employment_status->employment_status_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							
							<td><?php echo $employment_status->employment_status_code;?></td>
							<td><?php echo $employment_status->employment_status;?></td>
							<td><?php echo $employment_status->remarks;?></td>
							
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit('employment_status/'. $employment_status->employment_status_id . '/edit');?>
									<?php echo btn_delete('employment_status/'. $employment_status->employment_status_id . '/delete');?>
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
