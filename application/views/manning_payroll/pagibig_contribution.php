<?php 
	function display_button()
	{
		return '<div class="row no-print margin">
				<p>
					<span class="pull-right">
						<button class="btn btn-default btn-md" onclick="window.print()">
							<span class="fa fa-print" aria-hidden="true"></span> Print
						</button>
						<button class="btn btn-primary btn-md">
							<span class="fa fa-download" aria-hidden="true"></span> Generate PDF
						</button>
					</span>
				</p>
			</div>';
	}
 ?>
 <style type="text/css">
 	td {
 		vertical-align: top;
 	}
 	@media print {
 		body {
 				font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
 			}
 		table,tr,td,th {
 				font-size: 10px !important;
 		}
 		/*section.content .box .table, 
 		section.content .box .table tr, 
 		section.content .box .table th, 
 		section.content .box .table td {
 				border: 1px solid #000;
 		}*/
 	}
 	@page {
 	        margin: 10px 0px;
 	     }
 </style>
<!-- <div class="col-xs-12"> -->
<?php $project = FALSE; ?>
<?php $ctr = 0; ?>
<?php if (count($result)): ?>

<?php  
	$ids = array_map(function ($ar) {return $ar['id'];}, $users);

?>

<?php foreach ($result as $row): ?>

	<!-- start of closing tags -->
	<?php if ($project != $row->title && $ctr > 0): ?>
				</tbody>
		    </table>
			<?php echo display_button(); ?>
		<!-- </div> -->
		</div>
	<?php endif ?>
	<!-- end of closing tag -->

	<!-- start of openning tags -->
	<?php if ($project != $row->title): ?>
		<?php $project = $row->title; ?>
		<div class="box matrix content no-pad no-margin">
			<?php echo display_button(); ?>
		    <table class="table table-condensed table-hover" border="1" width="100%">
			    <thead>
			    	<tr>
			    		<th class="text-center" colspan="8">
							<h5>
								<b>JAMMAS INC.</b><br>
								<?php echo $page_title ?>
								<br><small>Period Covered: <?php echo payroll_date($row->date_start) ?> To: <?php echo payroll_date($row->date_end) ?></small>
								<br>
								<br>
								<b><?php echo $row->title; ?></b>
								<br><small>Run Date <?php echo php_date(date('Y-m-d H:i:sA'), 'Y-m-d H:iA'); ?></small>
							</h5>
			    		</th>
			    	</tr>
					<tr>
				        <th rowspan="2" class="text-center"><div style="width: 10px;">#</div></th>
				        <th rowspan="2" width='9%' class="text-center">EMPLOYEE NO.</th>
				        <th rowspan="2" width='30%' class="text-center">EMPLOYEE NAME</th>
				        <th rowspan="2" width='15%' class="text-center">PAG-IBIG NO.</th>
				        <th rowspan="2" width='5%' class="text-center">DATE</th>
			    		<th colspan="4" width="" class="text-center">C O N T R I B U T I O N</th>
				    </tr>
			    	<tr>
				        <th width='11%' class="text-center">Company Share</th>
				        <th width='11%' class="text-center">Employee Share</th>
				        <th width='11%' class="text-center">TOTAL</th>
			    	</tr>
			    </thead>
				<tbody>
				<?php $ctr = 0; ?>
	<?php endif ?>
	<!-- end of openning tag -->

	<?php if ($project == $row->title): ?>
	<!-- start result here -->
				<tr>
					<td>
						<?php echo ++$ctr;?>.
					</td>
					<td>
						<?php echo $row->employee_no;?> <br>
					</td>
					<td>
	                    <?php echo $row->lastname . ', ' . $row->firstname . $row->middlename; ?> <br>
					</td>
					<td>
	                    <?php echo $row->pagibig_no; ?> <br>
					</td>
					<td>
	                    <?php echo php_date($row->date_printed); ?> <br>
					</td>
					<td class="text-right">
	                    <?php echo $row->employer_share_pagibig; ?> <br>
					</td>
					<td class="text-right">
	                    <?php echo $row->employee_share_pagibig; ?> <br>
					</td>
					<td class="text-right">
	                    <?php echo $row->total_monthly_premium_pagibig; ?> <br>
					</td>
				</tr>
	<!-- end result here -->
	<?php endif ?>

	

<?php endforeach ?>


<?php else: ?>
	<div class="error-page">
		<div class="pad margin no-print">
	        <div class="alert alert-danger" style="margin-bottom: 0!important;">
	            <i class="fa fa-exclamation"></i>
	            <b>Note:</b> No record found.
	        </div>
	    </div>
		
	</div>

<?php endif ?>
	
