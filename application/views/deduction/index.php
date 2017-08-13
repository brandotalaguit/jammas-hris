<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
    			<form class="form-inline" role="form" target="_blank" method="post" action="<?php echo site_url('deduction/print_pdf') ?>">
		        <input type="hidden" name="last_query" value="<?php echo isset($last_query) ? $last_query : ""; ?>" /> 
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
		        </form>
    		</div>
    	</div>
    </div>
</div>    	
<form class="" role="form"  method="post" action="<?php echo site_url('deduction') ?>">
<div class="box">
    
    <div class="box-header">	
    <div class="row">
    		<div class="col-sm-5">
		        <div class="box-tools" style="padding: 10px 10px 10px 10px">

		            <?php #if (isset($search_form)): ?>
			            <?php $this->load->view('deduction/filter_form'); ?>
		            <?php #endif ?>

		        </div>
    		</div>
    		<div class="col-sm-3">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">
		        	<?php echo form_dropdown('employee_id', $employees, $this->input->post('employee_id'), 'id="employee_id" class="form-control"' ) ?>
		            

		        </div>
    		</div>
    		<div class="col-sm-2">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		           <?php echo form_dropdown('deduction_category_id', $deduction_categories, $this->input->post('deduction_category_id'), 'id="deduction_category_id" class="form-control"' ) ?>

		        </div>
    		</div>

    		<div class="col-sm-2">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		           <button class='btn btn-primary' name='btn_search' type='submit' style="font-weight:bold; font-family: 'Source Sans Pro Bold', sans-serif !important" value='Search'><span class='fa fa-search'></span> Search </button>	          	

		        </div>
    		</div>
    	</div>

    </div><!-- /.box-header -->

    <div class="box-body table-responsive no-padding">
        <table class="table table-condensed table-hover">

			<tbody>
				<tr>
					<th width='3%'>#</th>
					<th width='8%'>Date Filed</th>
					<th width='15%'>Employee Name</th>
					<th width='10%'>Position</th>
					<th width='10%'>Category</th>
					<th width='8%'>Coverage Start</th>
					<th width='8%'>Coverage End</th>
					
					<th width='10%'>Mode of Payment</th>
					<th width='10%'>Payment Type</th>
					<th width='8%'>Amount</th>
					<th width='10%'>Action</th>
				</tr>

				<?php if (count($deductions)): ?>
					<?php foreach ($deductions as $deduction): ?>
						<tr <?php echo $this->session->flashdata('id') == $deduction->deduction_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							<td><?php echo date_convert_to_php($deduction->date_filed, "M d, Y");?></td>
							<td><?php echo $deduction->lastname . ', ' . $deduction->firstname . ' ' . $deduction->middlename;?></td>
							<td><?php echo $deduction->position; ?></td>
							<td><?php echo $deduction->deduction_category;?></td>
							<td><?php echo date_convert_to_php($deduction->coverage_date_start, "M d, Y"); ?></td>
							<td><?php echo date_convert_to_php($deduction->coverage_date_end, "M d, Y");?></td>
							<td><?php
								if($deduction->mode_of_payment == 1)
									echo 'Beginning of Month';
								else if($deduction->mode_of_payment == 2)
									echo 'Every Pay';
								else  if($deduction->mode_of_payment == 3)								
									echo 'End of Month';
								?>	
							</td>
							<td><?php
								if($deduction->payment_type == 1)
									echo 'Fixed Amount';
								else if($deduction->payment_type == 2)
									echo 'Percentage';
								?>	
							</td>
							<td>
								<?php
								if($deduction->payment_type == 1)
									echo nf($deduction->fixed_amount);
								else if($deduction->payment_type == 2)
									echo nf($deduction->percentage) . '%';
								?>
							</td>
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit('deduction/'. $deduction->deduction_id . '/edit');?>
									<?php echo btn_delete('deduction/'. $deduction->deduction_id . '/delete');?>
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
