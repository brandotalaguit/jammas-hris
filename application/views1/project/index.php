<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
    		</div>
    		<div class="col-sm-4">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		            <?php #if (isset($search_form)): ?>
			            <?php $this->load->view('project/search_form'); ?>
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
					<th width='20%'>Project Title</th>
					<th width='10%'>Project Description</th>
					<th width='5%'>Business Style</th>
					<th width='5%'>P.O. #</th>
					<th width='5%'>T.I.N.</th>
					<th width='7%'>Action</th>
				</tr>

				<?php if (count($projects)): ?>
					<?php foreach ($projects as $project): ?>
						<tr <?php echo $this->session->flashdata('id') == $project->project_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							<td><?php echo $project->title;?></td>
							<td><?php echo $project->description;?></td>
							<td><?php echo $project->business_style;?></td>
							<td><?php echo $project->po;?></td>
							<td><?php echo $project->tin;?></td>
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit('project/'. $project->project_id . '/edit');?>
									<?php echo btn_achor('project_employee/'. $project->project_id . '/detail', '<i class="fa fa-th"></i>', 'class="btn btn-info"');?>
									<?php echo btn_delete('project/'. $project->project_id . '/delete');?>
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
