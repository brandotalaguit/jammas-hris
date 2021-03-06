 <style type="text/css">
 	td {
 		vertical-align: top;
 	}

	section.invoice > .row {
 				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;

 	}
 	@media print {
 		html {
 				padding-bottom: 3cm;
 				padding-left: 1cm;
 				padding-right: 1cm;
 				padding-top: 0cm;
 		}
 		body {
 				/*font-family: Menlo,Monaco,Consolas,"Courier New",monospace;*/

 				-moz-osx-font-smoothing: grayscale;
 				-webkit-font-smoothing: antialiased;
 				background: #fff !important;
 				color: #000 !important;
 				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
 				font-size: 1rem;
 				line-height: 1.5;
 				/*margin: 0 auto;*/
 				text-rendering: optimizeLegibility;

 			}
 		table,tr,td,th {
 				font-size: 10px !important;
 		}
 		.table > thead > tr > th {
 		    vertical-align: bottom;
 		}

 		section.invoice > .row {
 			page-break-after: always;
 		}

 		section.invoice:last-child {
 			page-break-after: avoid;
 		}

 	}
 	@page {
 	        /*margin: 10px 0px;*/
 	     }
 </style>
<?php $ctr = 0; ?>
<?php if (count($project)): ?>

<?php
	// $projects = array_unique(array_map(function ($ar) {return $ar->title;}, $result), SORT_REGULAR);
	// dump($project);
	$subtotal_company_share = $subtotal_employee_share = $subtotal_share = $company_share = $employee_share = $total_share = $ecc_share = 0;
	$subtotal = array();
	$title = FALSE;
?>
	<?php foreach ($project as $key => $proj): ?>

	<!-- start of openning tags -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
		    <table class="table table-condensed table-hover table-bordered table-striped">

			    <thead>
			    	<tr>

			    		<th colspan="<?php echo '7' ?>" class="text-center th-caption">

		    	<h4>JAMMAS INC.</h4>
		    	<h5>
		    		<p><?= $proj['project_title'] ?></p>
		    		<p>Thirteen Month Benefits <?php echo $report_type ?> Report</p>
		    		<p><?= $covered_period ?></p>
		    	</h5>
		    	<small>Run Date <?php echo date('Y-m-d H:iA'); ?></small>
		    <br/>
		    <?php //dd(trim($report_type)) ?>
			    		</th>
			    	</tr>
					<tr>
				        <th width="1px" class="text-center"><div style="width: 10px;">#</div></th>
				        <th width='15%' class="text-center">EMPLOYEE NO.</th>
				        <th width='25%' class="text-center">LASTNAME</th>
				        <th width='25%' class="text-center">FIRSTNAME</th>
				        <th width='15%' class="text-center">MIDDLENAME</th>
				        <?php /* if (trim($report_type) != 'Summary'): ?>
				        <th width='10%' class="text-center">PAYROLL DATE</th>
				        <?php endif */ ?>
				        <th width='15%' class="text-center">AMOUNT</th>
				    </tr>
			    </thead>
				<tbody>

				<?php $ctr = 0; ?>
			    <?php $total_amount = 0; ?>

				<?php foreach ($proj['project_data'] as $row): ?>
	<!-- start result here -->
				<?php
						$total_amount += get_key($row, 'r_13thmonth', 0);
					?>
				<tr>
					<td><?php echo ++$ctr;?>.</td>
					<td><?php echo $row->employee_no;?></td>
					<td><?php echo $row->lastname ?></td>
					<td><?php echo $row->firstname ?></td>
					<td><?php echo $row->middlename; ?></td>
			        <?php /*if (trim($report_type) != 'Summary'): ?>
					<td>
	                    <?php
	                    	$payroll_date = get_key($row, 'payroll_date', '');
	                    	if ($payroll_date > '')
                    		echo date('m/d/Y', strtotime($payroll_date));
	                    ?>
					</td>
					<?php endif*/ ?>
					<td class="text-right">
	                    <?php
	                    	echo nf(get_key($row,'r_13thmonth', 0));
	                    ?>
					</td>
				</tr>
	<!-- end result here -->
				<?php endforeach ?>

		<!-- <tfoot> -->
			<tr>
				<th colspan="<?= '5' ?>">Sub-Total</th>
				<th class="text-right"><?php echo nf($total_amount); ?></th>
			</tr>
		<!-- </tfoot> -->
		</tbody>
		</table>
		</div>
	</div>
<?php endforeach ?>
<script type="text/javascript">
	window.print()
</script>
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

