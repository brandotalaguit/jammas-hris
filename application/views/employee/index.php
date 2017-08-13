<style type="text/css">
	.popover {
		max-width: 500px;
	}

</style>
<div class="box">
	
	<div class="box-header">
	    <div class="row">
    		<div class="col-sm-8">
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
    		</div>
    		<div class="col-sm-4">
	    		<div class="box-tools" style="padding: 10px 10px 10px 0px">
			        <?php echo $search_form ?>
		        </div>
    		</div>
    	</div>
    </div>

	<div class="box-body table-responsive no-padding">
		
		<table class="table table-condensed table-hover">
			
			
			<tbody>
				<tr>
					<th width='2%'>#</th>
					<th width='10%'>Employee ID</th>
					<th width='10%'>Lastname</th>
					<th width='10%'>Firstname</th>
					<th width='10%'>Middlename</th>
					<th width='10%'>Contact Nos</th>
					<th width='10%'>Status</th>
					<th width='9%'>Action</th>
				</tr>
				<?php if (count($employees)): ?>
					<?php foreach ($employees as $employee): ?>
						<tr <?php echo $this->session->flashdata('id') === $employee->employee_id ? "class='success'" : ''; ?>>
							<td><?php echo ++$counter; ?>.</td>
							<td><?php echo $employee->employee_id; ?></td>
							<td><?php echo $employee->lastname; ?></td>
							<td><?php echo $employee->firstname; ?></td>
							<td><?php echo $employee->middlename; ?></td>
							<td><?php echo $employee->contact_nos; ?></td>
							<td><?php echo $employee->employment_status;?></td>
							<td>
								<div class="btn-group">
									<?php echo btn_edit('employee/'. $employee->employee_id . '/edit');?>
									<?php #echo btn_achor('loan_receivable/'. $employee->employee_id . '/employee', '<i class="fa fa-bar-chart-o"></i>', 'class="btn btn-info" target="_blank"');?>
									<?php echo btn_delete('employee/'. $employee->employee_id . '/delete');?>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
						<tr>
							<td colspan="10" class="text-center">
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

<script>
	$(function(){
		$('.popup-ajax').popover({
		        "html": true,
		        "content": function(){
		            var div_id =  "div-id-" + $.now();
		            return details_in_popup("<?php echo base_url();?>employee/" + $(this).data('accountnos') + "/info", div_id)
		        }});

		function details_in_popup(link, div_id){
		    $.ajax({
		        url: link,
		        success: function(response){
		            $('#'+div_id).html(response)}});
		    return '<div id="'+ div_id +'">Loading...</div>'
		}

		$('.number').number(true, <?php echo DECIMAL_PLACES; ?>);		
	});
</script>

