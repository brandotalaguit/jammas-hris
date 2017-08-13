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
 		.table > thead > tr > th {
 		    vertical-align: bottom;
 		    border-bottom: 1px solid #000;
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
	// $projects = array_unique(array_map(function ($ar) {return $ar->title;}, $result), SORT_REGULAR);
	// dump($project);
	$subtotal_company_share = $subtotal_employee_share = $subtotal_share = $subtotal_ecc_share = $company_share = $employee_share = $ecc_share = $total_share = 0;
	$subtotal = array();
	$title = FALSE;
?>

<?php /*foreach ($project as $proj): ?>
	<?php foreach ($result as $value): ?>
		
	<?php endforeach ?>
<?php endforeach */?>

<?php foreach ($result as $row): ?>

	<!-- start of closing tags -->
	<?php if ($project != $row->title && $ctr > 0): ?>
				</tbody>
				<thead>
					<tr>
						<th colspan="4">Sub-Total</th>
						<th class="text-right"><?php echo nf($company_share); ?></th>
						<th class="text-right"><?php echo nf($employee_share); ?></th>
						<th class="text-right"><?php echo nf($employee_share+$company_share); ?></th>
						<th class="text-right"><?php echo nf($ecc_share); ?></th>
						<th class="text-right"><?php echo nf($total_share); ?></th>
					</tr>
				</thead>
		    </table>
		    <?php $subtotal_company_share += $company_share; ?>
		    <?php $subtotal_employee_share += $employee_share; ?>
		    <?php $subtotal_ecc_share += $ecc_share; ?>
		    <?php $subtotal_share += $total_share; ?>
		    <?php 
		    	$subtotal[] = array(
		    							'project' => $title,
		    							'company_share' => $company_share,
		    							'employee_share' => $employee_share,
		    							'ecc_share' => $ecc_share,
		    							'total_share' => $total_share,
	    							);
			?>
		    <?php $company_share = $employee_share = $ecc_share = $total_share = 0; ?>
		    <?php echo display_button(); ?>
		<!-- </div> -->
		</div>
	<?php endif ?>
	<!-- end of closing tag -->

	<!-- start of openning tags -->
	<?php if ($project != $row->title): ?>
		<?php $project = $row->title; ?>
		<div class="content invoice">
			<?php echo display_button(); ?>
		    <table class="table table-condensed table-hover" border="1" width="100%">
			    <thead>
			    	<tr>
			    		<th class="text-center" colspan="9">
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
				        <th rowspan="2" width='15%' class="text-center">SSS NO.</th>
			    		<th colspan="5" width="" class="text-center">C O N T R I B U T I O N</th>
				    </tr>
			    	<tr>
				        <th width='11%' class="text-center">Company Share</th>
				        <th width='11%' class="text-center">Employee Share</th>
				        <th width='11%' class="text-center">SSS Total</th>
				        <th width='11%' class="text-center">Co. ECC</th>
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
	                    <?php echo $row->philhealth_no; ?> <br>
					</td>
					
					<td class="text-right">
	                    <?php echo nf($row->employer_share_sss); ?> <br>
					</td>
					<td class="text-right">
	                    <?php echo nf($row->employee_share_sss); ?> <br>
					</td>
					<td class="text-right">
	                    <?php echo nf($row->employee_share_sss + $row->employer_share_sss); ?> <br>
					</td>
					<td class="text-right">
	                    <?php echo nf($row->employee_compensation_program_sss); ?> <br>
					</td>
					<td class="text-right">
	                    <?php echo nf($row->total_monthly_premium_sss); ?> <br>
					</td>
				</tr>
				<?php $company_share += $row->employer_share_sss; ?>
				<?php $employee_share += $row->employee_share_sss; ?>
				<?php $ecc_share += $row->employee_compensation_program_sss; ?>
				<?php $total_share += $row->total_monthly_premium_sss; ?>
				<?php $title = $row->title; ?>
	<!-- end result here -->
	<?php endif ?>

	

<?php endforeach ?>
		
		<thead>
			<tr>
				<th colspan="4">Sub-Total</th>
				<th class="text-right"><?php echo nf($company_share); ?></th>
				<th class="text-right"><?php echo nf($employee_share); ?></th>
				<th class="text-right"><?php echo nf($employee_share+$company_share); ?></th>
				<th class="text-right"><?php echo nf($ecc_share); ?></th>
				<th class="text-right"><?php echo nf($total_share); ?></th>
			</tr>
		</thead>
	    <?php 
	    	$subtotal[] = array(
	    							'project' => $title,
	    							'company_share' => $company_share,
	    							'employee_share' => $employee_share,
	    							'ecc_share' => $ecc_share,
	    							'total_share' => $total_share,
    							);
		?>
		<?php $subtotal_company_share += $company_share; ?>
		<?php $subtotal_employee_share += $employee_share; ?>
		<?php $subtotal_ecc_share += $ecc_share; ?>
		<?php $subtotal_share += $total_share; ?>
		</tbody>
		</table>
		</div>
		<?php $ctr = 0; ?>
		<div class="content invoice">
			<?php echo display_button(); ?>
		    <table class="table table-condensed table-hover" border="1" width="100%">
		<thead>
			<tr>
				<th colspan="7" class="text-center">S U M M A R Y</th>
			</tr>
			<tr>
		        <th rowspan="2" class="text-center"><div style="width: 10px;">#</div></th>
		        <th rowspan="2" class="text-center">PROJECT</th>
	    		<th colspan="5" width="" class="text-center">C O N T R I B U T I O N</th>
		    </tr>
	    	<tr>
		        <th width='11%' class="text-center">Company Share</th>
		        <th width='11%' class="text-center">Employee Share</th>
		        <th width='11%' class="text-center">SSS Total</th>
		        <th width='11%' class="text-center">Co. ECC</th>
		        <th width='11%' class="text-center">TOTAL</th>
	    	</tr>
			<?php foreach ($subtotal as $summary): ?>
			<tr>
				<td><div style="width: 10px;"><?php echo ++$ctr; ?></div></td>
				<td><?php echo $summary['project']; ?></td>
				<td class="text-right"><?php echo nf($summary['company_share']); ?></td>
				<td class="text-right"><?php echo nf($summary['employee_share']); ?></td>
				<td class="text-right"><?php echo nf($summary['employee_share'] + $summary['company_share']); ?></td>
				<td class="text-right"><?php echo nf($summary['ecc_share']); ?></td>
				<td class="text-right"><?php echo nf($summary['total_share']); ?></td>
			</tr>
			<?php endforeach ?>
			<tr>
				<th colspan="2">Total</th>
				<th class="text-right"><?php echo nf($subtotal_company_share); ?></th>
				<th class="text-right"><?php echo nf($subtotal_employee_share); ?></th>
				<th class="text-right"><?php echo nf($subtotal_employee_share + $subtotal_company_share); ?></th>
				<th class="text-right"><?php echo nf($subtotal_ecc_share); ?></th>
				<th class="text-right"><?php echo nf($subtotal_share); ?></th>
			</tr>
		</thead>

    </table>
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
	
