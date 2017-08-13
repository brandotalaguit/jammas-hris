<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-4">
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
    		</div>
    		<div class="col-sm-4">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		            

		        </div>
    		</div>

    		<div class="col-sm-4">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		            <?php #if (isset($search_form)): ?>
			            <?php $this->load->view('sss_premium_contribution_matrix/search_form'); ?>
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
					<th width='10%'>Salary Range Start</th>
					<th width='10%'>Salary Range End</th>
					<th width='15%'>Monthly Salary Credit</th>
					<th width='10%'>Employee Share</th>
					<th width='10%'>Employer Share</th>
					<th width='10%'>Employee Compensation Program</th>
					<th width='15%'>Total Monthly Contribution</th>
					
					<th width='7%'>Action</th>
				</tr>

				<?php if (count($sss_matrix)): ?>
					<?php foreach ($sss_matrix as $sss_matrix_row): ?>
						<tr <?php echo $this->session->flashdata('id') == $sss_matrix_row->ssspc_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							
							<td>Php. <?php echo nf($sss_matrix_row->salary_range_start);?></td>
							<td>Php. <?php echo nf($sss_matrix_row->salary_range_end);?></td>
							<td>Php. <?php echo nf($sss_matrix_row->monthly_salary_credit);?></td>
							<td>Php. <?php echo nf($sss_matrix_row->employee_share);?></td>
							<td>Php. <?php echo nf($sss_matrix_row->employer_share);?></td>
							<td>Php. <?php echo nf($sss_matrix_row->employee_compensation_program);?></td>
							<td>Php. <?php echo nf($sss_matrix_row->total_monthly_premium);?></td>
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit('sss_premium_contribution_matrix/'. $sss_matrix_row->ssspc_id . '/edit');?>
									<?php echo btn_delete('sss_premium_contribution_matrix/'. $sss_matrix_row->ssspc_id . '/delete');?>
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
