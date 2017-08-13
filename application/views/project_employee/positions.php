    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
    			<h3 class="box-title">
    				Project Positions Rate
			        <?php /*echo anchor(base_url("projectPositionRate/$project_id/new"), 
			        '<i class="ion ion-person-add"></i> Add Position', 
			        ['class' => 'btn btn-success btn-sm']);*/ ?>
	    			
	    			
    			</h3>
    		</div>
    		<div class="col-sm-4">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

			            <?php $this->load->view('project_employee/position_search_form'); ?>

		        </div>
    		</div>
    	</div>

    </div><!-- /.box-header -->

    <div class="box-body table-responsive no-padding">

    	<table class="table table-condensed table-hover">
			
			
			<tbody>
				<tr>			
					<th width='2%'>#</th>
					<th width='10%' title="Position">Position</th>
					<th width='20%' title="Description">Description</th>
					<th width='10%'>Daily Rate</th>
					<th width='10%'>Semi Monthly Rate</th>
					<th width='10%'>Monthly Rate</th>
					<th width='7%' title="Action">Action</th>
				</tr>

				<?php if (count($ppr)): ?>

					<?php $counter = 0; ?>

					<?php foreach ($ppr as $rate): ?>
						<tr <?php echo $this->session->flashdata('id') == $rate->position_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							<td><?php echo $rate->position;?></td>
							<td><?php echo $rate->remarks;?></td>
							<td><?php echo nf(floatval($rate->daily_rate));?></td>
							<td><?php echo nf(floatval($rate->semi_monthly_rate));?></td>
							<td><?php echo nf(floatval($rate->monthly_rate));?></td>
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit("projectPositionRate/$rate->project_id/$rate->ppr_id/edit");?>
									<?php echo btn_delete("projectPositionRate/$rate->project_id/delete");?>
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