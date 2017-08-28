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
	// die(dump($project));
?>
	<?php foreach ($project as $key => $proj): ?>

	<!-- start of openning tags -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
		    <table class="table table-condensed table-hover table-bordered table-striped">

			    <thead>
			    	<tr>

			    		<th colspan="8" class="text-center th-caption">

		    	<h4>JAMMAS INC.</h4>
		    	<h5>
		    		<p><?= $proj['project_title'] ?></p>
		    		<p><?= $page_title ?></p>
		    		<p><?= $this->input->post('report_format') == 1 ? 'SUMMARY' : 'DETAIL' ?></p>
		    		<p><?= $covered_period ?></p>
		    	</h5>
		    	<small>Run Date <?php echo date('Y-m-d H:iA'); ?></small>
		    <br/>

			    		</th>
			    	</tr>

					<tr>
				        <th class="text-center" width="2%"><div style="width: 10px;">#</div></th>
				        <th width='13%' class="text-left">EMPLOYEE NO.</th>
				        <th width='25%' class="text-left">EMPLOYEE NAME</th>
				        <?php if ($this->input->post('report_format') == 2): ?>
				        <th width='10%' class="text-left">DATE</th>
				        <?php endif ?>

				        <th width='12%' class="text-left">TYPE</th>
				        <th width='20%' class="text-left">DESCRIPTION</th>
				        <th width='10%' class="text-center">AMOUNT</th>
				    </tr>

			    </thead>
				<tbody>

				<?php $ctr = 0; ?>
			    <?php $company_share = $employee_share = $total = 0; ?>
				<?php foreach ($proj['project_data'] as $row): ?>
	<!-- start result here -->
				<tr>
					<td>
						<?php echo ++$ctr;?>.
					</td>
					<td>
						<?php echo $row->employee_no;?>
					</td>
					<td>
	                    <?php echo $row->lastname . ', ' . $row->firstname . ' ' . substr($row->middlename, 0, 1); ?>
					</td>

					<?php if ( ! empty($row->payroll_date)): ?>
					<td>
						<?php echo date('m/d/Y', strtotime($row->payroll_date));?>
					</td>
					<?php endif ?>

					<td>PAYROLL</td>
					<td>
						<?php echo $row->deduction_category;?>
					</td>
					<td class="text-right">
	                    <?php
	                    	echo nf($row->amount);
	                    	?>
					</td>
				</tr>
				<?php
						$total += $row->amount;
					?>
	<!-- end result here -->
				<?php endforeach ?>
		</tbody>

		<tfoot>
			<tr>

				<th colspan = "<?php echo ($this->input->post('report_format') == 1) ? '5' : '6'; ?>">Sub-Total</th>

				<th class="text-right"><?php echo nf($total); ?></th>
			</tr>
		</tfoot>
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

