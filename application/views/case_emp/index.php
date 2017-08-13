<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
    			<form class="form-inline" role="form" target="_blank" method="post" action="<?php echo site_url('case_emp/print_pdf') ?>">
		        <input type="hidden" name="last_query" value="<?php echo isset($last_query) ? $last_query : ""; ?>" /> 
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
		        </form>
    		</div>

    	</div>
    </div>
</div>
<form class="" role="form"  method="post" action="<?php echo site_url('case_emp') ?>">
  <div class="box">  
    <div class="box-header">
    	<div class="row">
    		<div class="col-sm-9">
    			
		        <h3 class="box-title">Data Filters</h3>
		    	
    		</div>
    		
    		
    	</div>
    	<div class="row">		
    		<div class="col-sm-3">
		        <div class="box-tools" style="padding: 10px 10px 10px 10px">

		          <?php echo form_dropdown('project_id', $projects, $this->input->post('project_id'), 'id="project_id" class="form-control"' ) ?>

		        </div>
    		</div>
    		<div class="col-sm-3">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">
		        	<?php echo form_dropdown('employee_id', $employees, $this->input->post('employee_id'), 'id="employee_id" class="form-control"' ) ?>
		            

		        </div>
    		</div>
    		<div class="col-sm-3">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		           <?php echo form_dropdown('case_category_id', $case_categories, $this->input->post('case_category_id'), 'id="case_category_id" class="form-control"' ) ?>

		        </div>
    		</div>

    		<div class="col-sm-3">
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
					<th width='20%'>Employee Name</th>
					<th width='15%'>Project</th>
					<th width='10%'>Category</th>
					<th width='25%'>Remarks</th>
					<th width='8%'>Action</th>
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
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit('case_emp/'. $case->case_id . '/edit');?>
									<?php echo btn_delete('case_emp/'. $case->case_id . '/delete');?>
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
</form>