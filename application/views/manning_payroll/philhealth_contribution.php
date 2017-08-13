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
		    <caption>
		    	<h4>JAMMAS INC.</h4>
		    	<h5>
		    		<p><?= $proj['project_title'] ?></p>
		    		<p><?= $page_title ?></p>
		    		<p><?= $covered_period ?></p>
		    	</h5>
		    	<small>Run Date <?php echo date('Y-m-d H:iA'); ?></small>
		    </caption>
			    <thead>
					<tr>
				        <th rowspan="2" class="text-center"><div style="width: 10px;">#</div></th>
				        <th rowspan="2" width='15%' class="text-center">EMPLOYEE NO.</th>
				        <th rowspan="2" width='25%' class="text-center">EMPLOYEE NAME</th>
				        	
				        <th rowspan="2" width='15%' class="text-center">
					        <?php if ($contribution == 'philhealth'): ?>
					        	PHILHEALTH NO.
					        <?php elseif ($contribution == 'pagibig'): ?>
					        	PAG-IBIG NO.
					        <?php elseif ($contribution == 'sss'): ?>
					        	SSS NO.
					        <?php endif ?>
				        </th>

				        <?php if ( ! empty($contribution != 'sss')): ?>
				        <th rowspan="2" width='12%' class="text-center">GROSS INCOME</th>
				        <?php endif ?>

			    		<th colspan="<?= $contribution == 'sss' ? '6' : '4' ?>" width="" class="text-center">C O N T R I B U T I O N</th>
				    </tr>
			    	<tr>
				        <th width='11%' class="text-center">COMPANY SHARE</th>
				        <th width='11%' class="text-center">EMPLOYEE SHARE</th>
				        <?php if ($contribution == 'sss'): ?>
				        <th width='11%' class="text-center">SSS TOTAL</th>
				        <th width='11%' class="text-center">CO.ECC</th>
				        <?php endif ?>
				        <th width='8%' class="text-center">TOTAL</th>
			    	</tr>
			    </thead>
				<tbody>

				<?php $ctr = 0; ?>
			    <?php $company_share = $employee_share = $total_share = 0; ?>
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
					<td>
	                    <?php 
	                    	$tmp = $contribution . '_no';
	                    	echo $row->$tmp; 
	                    	?> 
					</td>

					<?php if ( $contribution != 'sss'): ?>
					<td class="text-right">
	                    <?php echo nf($row->gross_income); ?> 
					</td>
					<?php endif ?>
					
					<td class="text-right">
	                    <?php 
	                    	$tmp_1 = 'employer_share_' . $contribution;
	                    	echo nf($row->$tmp_1);
	                    	?> 
					</td>
					<td class="text-right">
						<?php 
							$tmp_2 = 'employee_share_' . $contribution;
							echo nf($row->$tmp_2);
							?> 
					</td>

					<?php if ($contribution == 'sss'): ?>
					<td>
						<?php 
							echo nf($tmp_1 + $tmp_2);
							?> 
					</td>
					<td>
						<?php 
							echo nf($row->employee_compensation_program_sss);
							?> 
					</td>
					<?php endif ?>

					<td class="text-right">
						<?php 
							$tmp_3 = 'total_monthly_premium_' . $contribution;
							echo nf($row->$tmp_3);
							?> 
					</td>
				</tr>
				<?php 
						$company_share += $row->$tmp_1; 
						$employee_share += $row->$tmp_2; 
						$total_share += $row->$tmp_3; 
						if ($contribution == 'sss') 
						$ecc_share += $row->employee_compensation_program_sss;
					?>
	<!-- end result here -->
				<?php endforeach ?>
		</tbody>
		
		<tfoot>
			<tr>
				<th colspan="<?= $contribution == 'sss' ? '4' : '5' ?>">Sub-Total</th>
				<th class="text-right"><?php echo nf($company_share); ?></th>
				<th class="text-right"><?php echo nf($employee_share); ?></th>
				<?php if ($contribution == 'sss'): ?>
				<th class="text-right"><?php echo nf($company_share + $employee_share); ?></th>
				<th class="text-right"><?php echo nf($ecc_share); ?></th>
				<?php endif ?>
				<th class="text-right"><?php echo nf($total_share); ?></th>
			</tr>
		</tfoot>
	    <?php 
	    	/*$subtotal[] = array(
	    							'project' => $title,
	    							'company_share' => $company_share,
	    							'employee_share' => $employee_share,
	    							'total_share' => $total_share,
    							);
		
			$subtotal_company_share += $company_share; 
			$subtotal_employee_share += $employee_share; 
			$subtotal_share += $total_share; */
		?>
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
	