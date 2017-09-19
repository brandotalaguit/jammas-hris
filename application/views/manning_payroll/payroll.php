<?php
	$this->load->model(['manning_payroll_earning_m', 'manning_payroll_deduction_m']);

	$GLOBALS['billing_rates'] = $billing_rates = $this->projects->get_field();
	$GLOBALS['tardiness'] = $tardiness = ['r_late_amount', 'r_absent_rate', 'r_absent_rate_per_day'];
	$GLOBALS['earning'] = $GLOBALS['deduction'] = array();

	$GLOBALS['reliever_payroll'] = $reliever_payroll;

    function get_earnings($payroll, $fields, $totalOnly = FALSE)
    {
    	$billing_rates = $GLOBALS['billing_rates'];
    	$tardiness = $GLOBALS['tardiness'];

        $total = 0.00;
        $data = array();

        foreach (explode(',', $fields) as $wage_name)
        {
            $rate_data = $billing_rates[$wage_name];
        	if ( ! in_array($billing_rates[$wage_name]['payroll'], $tardiness))
        	{
        		if ($totalOnly == FALSE)
        		{

		           	if (empty($GLOBALS['earning'][$wage_name]))
		           	{
		           		$GLOBALS['earning'][$wage_name] = array(
	           												'description' => $rate_data['abbr'],
	           												'amount' => $payroll->$rate_data['payroll'],
	           												'multiplier' => $payroll->$rate_data['payroll'] == 0 ? '' : $payroll->$rate_data['multiplier'],
	           											);
		           	}
		           	else
		           	{
		           		$GLOBALS['earning'][$wage_name]['amount'] += $payroll->$rate_data['payroll'];
		           		$GLOBALS['earning'][$wage_name]['multiplier'] += $payroll->$rate_data['payroll'] == 0 ? '' : $payroll->$rate_data['multiplier'];
		           	}

		            $data[] = array(
		                        'name' => $wage_name,
		                        'description' => $rate_data['abbr'],
		                        'amount' => $payroll->$rate_data['payroll'],
								'multiplier' => $payroll->$rate_data['payroll'] == 0 ? '' : $payroll->$rate_data['multiplier'],
		                      );

        		}
        		else
        		{
        			$data[] = $GLOBALS['earning'][$wage_name];
        		}

        	}
        }

        if ($totalOnly == FALSE)
        {
        	// e-cola
	       	if (empty($GLOBALS['earning']['r_cola']))
	       		$GLOBALS['earning']['r_cola'] = array(
	   												'description' => 'E-COLA',
	   												'amount' => $payroll->r_cola,
	   												'multiplier' => '',
	   											);
	       	else
	       	{
	       		$GLOBALS['earning']['r_cola']['amount'] += $payroll->r_cola;
	       		$GLOBALS['earning']['r_cola']['multiplier'] += '';
	       	}
        	// 13th month benefits
        	if ( ! $GLOBALS['reliever_payroll'])
        	{
		       	if (empty($GLOBALS['earning']['r_13thmonth']))
		       		$GLOBALS['earning']['r_13thmonth'] = array(
		   												'description' => '13th Month',
		   												'amount' => $payroll->r_13thmonth,
		   												'multiplier' => '',
		   											);
		       	else
		       	{
		       		$GLOBALS['earning']['r_13thmonth']['amount'] += $payroll->r_13thmonth;
		       		$GLOBALS['earning']['r_13thmonth']['multiplier'] += '';
		       	}
        	}
	       	// allowance
   	    	if (empty($GLOBALS['earning']['r_allowance']))
   	    		$GLOBALS['earning']['r_allowance'] = array(
   													'description' => 'Allowance',
   													'amount' => $payroll->r_allowance,
   													'multiplier' => '',
   												);
   	    	else
   	    	{
   	    		$GLOBALS['earning']['r_allowance']['amount'] += $payroll->r_allowance;
   	    		$GLOBALS['earning']['r_allowance']['multiplier'] += '';
   	    	}
	       	$data[] = array(
							'description' => 'E-COLA',
							'amount' => $payroll->r_cola,
							'multiplier' => '',
						);
	       	if ( ! $GLOBALS['reliever_payroll'])
	       	{
		       	$data[] = array(
								'description' => '13th Month',
								'amount' => $payroll->r_13thmonth,
								'multiplier' => '',
							);
	       	}

	       	$data[] = array(
							'description' => 'Allowance',
							'amount' => $payroll->r_allowance,
							'multiplier' => '',
						);
        }
        else
        {
	       	$data[] = $GLOBALS['earning']['r_cola'];
	       	if ( ! $GLOBALS['reliever_payroll'])
	       	$data[] = $GLOBALS['earning']['r_13thmonth'];
	       	$data[] = $GLOBALS['earning']['r_allowance'];
        }

        // dump($data);
        return $data;
    }

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
 		.page-break {
 			/*page-break-before: always;*/
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

<?php
?>
<div class="content invoice pad margin">

	<?php echo display_button(); ?>
    <table class="table table-condensed table-hover" border="1" width="100%">
	    <thead>
	    	<tr>
	    		<th class="text-center" colspan="8">
					<h5>
						<b>JAMMAS INC.</b><br>
						<?php echo $page_title ?>
						<br><small>Period Covered: <?php echo payroll_date($payroll_info->date_start) ?> To: <?php echo payroll_date($payroll_info->date_end) ?></small>
						<br>
						<br>
						<b><?php echo $payroll_info->title; ?></b>
						<br><small>Run Date <?php echo php_date(date('Y-m-d H:i:s'), 'Y-m-d H:iA'); ?></small>
					</h5>
	    		</th>
	    	</tr>
			<tr>
		        <th rowspan="2" width='20%' class="text-center">E M P L O Y E E</th>
		        <th width='30%' class="text-center">E A R N I N G S</th>
		        <th width='30%' class="text-center">D E D U C T I O N S</th>
		        <th rowspan="2" width='20%' class="text-center">T O T A L S</th>
		    </tr>
		    <tr>
			<td>
		    	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		    	<tr>
		        <th width="50%">Description</th>
		        <th class="text-right" width="15%">Hr/Min.</th>
		        <th class="text-right" width="35%">Amount</th>
		    	</tr>
		    	</table>
			</td>
			<td>
		    	<table border="0" cellspacing="0" cellpadding="0" width="100%">
		    	<tr>
		        <th width="50%">Description</th>
		        <th class="text-right" width="15%">Hr/Min.</th>
		        <th class="text-right" width="35%">Amount</th>
		    	</tr>
		    	</table>
			</td>
		    </tr>
	    </thead>
		<tbody>

			<?php if (count($payroll)): ?>
					<?php

						$fields = $payroll_info->fields;
						$project = $this->projects->get($payroll_info->project_id);
						// dump($this->manning_payroll_deduction_m->deduction_field());
						// $reg_deduction = $reliever_payroll ? [] : $this->manning_payroll_deduction_m->deduction_field();
						$reg_deduction = $this->manning_payroll_deduction_m->deduction_field($reliever_payroll);
					    $fields = 'hourly_rate,' . $fields;
					    $fields = 'daily_rate,' . $fields;
					    $fields = 'semi_monthly_rate,' . $fields;
					    $fields = 'monthly_rate,' . $fields;

						$earning_total = $deduction_total = $ctr = 0;
					 ?>

					<?php foreach ($payroll as $row): ?>
						<tr class="<?= $ctr % 6 == 0 ? 'page-break' : '' ?>">
							<?php
								$earnings = get_earnings($row, $fields);
								$deductions = explode('|', $row->deductions);
								$earning_subtotal = $deduction_subtotal = 0;
							?>
							<td>
								<?php echo ++$ctr;?>.)
								<b>Emp. No.</b>: <?php echo $row->employee_no;?> <br>
			                    <?php echo $row->lastname . ', ' . $row->firstname . ' ' . substr($row->middlename,0,1); ?> <br>
			                    <?php echo $row->position ?> <br>
			                    <?php
			                        if ($row->semi_monthly_rate > 0)
			                        echo "Semi-monthly Rate: " . nf($row->semi_monthly_rate);
			                        elseif ($row->monthly_rate > 0)
			                        echo "Monthly Rate: " . nf($row->semi_monthly_rate);
			                        else
			                        echo "Basic Rate: " . nf($row->daily_rate);

			                    	echo "<p><small>Trans No.: {$row->manning_payroll_deduction_id}</small></p>" ;
								 ?>
							</td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<?php foreach ($earnings as $earning): ?>
									<?php if ($earning['amount'] > 0): ?>
									<tr>
										<td width="50%"><?php echo $earning['description'] ?></td>
										<td class="text-right" width="15%"><?php if ($earning['multiplier'] > 0) echo nf($earning['multiplier']) ?></td>
										<td class="text-right" width="35%"><?php echo nf($earning['amount']) ?></td>
									</tr>
									<?php endif ?>

								<?php $earning_subtotal += $earning['amount']; ?>
								<?php endforeach ?>
								</table>
							</td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<?php if ( ! empty($row->deductions)): ?>
								<?php foreach ($deductions as $deduction): ?>
									<?php $deduct = explode('#', $deduction); ?>
									<?php if (count($deduct)): ?>
									<tr>
										<td width="50%"><?php echo $deduct[0] ?></td>
										<td class="text-right" width="15%">&nbsp;<?php #echo $earning['multiplier'] ?></td>
										<td class="text-right" width="35%"><?php echo nf($deduct[1]) ?></td>
									</tr>
									<?php $deduction_subtotal += $deduct[1]; ?>
									<?php endif ?>
								<?php endforeach ?>
								<?php endif ?>

								<?php foreach ($reg_deduction as $deduction2): ?>
									<?php if (!empty($row->$deduction2['payroll'])): ?>
									<?php if (abs($row->$deduction2['payroll']) > 0): ?>
										<?php
								           	if (empty($GLOBALS['deduction'][$deduction2['payroll']]))
								           	{
								           		$GLOBALS['deduction'][$deduction2['payroll']] = array(
							           												'description' => $deduction2['abbr'],
							           												'amount' => abs($row->$deduction2['payroll']),
							           												'multiplier' => $deduction2['multiplier'] == '' ? '' : $row->$deduction2['multiplier'],
							           											);
								           	}
								           	else
								           	{
								           		$GLOBALS['deduction'][$deduction2['payroll']]['amount'] += abs($row->$deduction2['payroll']);
								           		$GLOBALS['deduction'][$deduction2['payroll']]['multiplier'] += $deduction2['multiplier'] == '' ? '' : $row->$deduction2['multiplier'];
								           	}
										 ?>
									<tr>
										<td width="50%"><?php echo $deduction2['abbr'] ?></td>
										<td class="text-right" width="15%"><?php echo $deduction2['multiplier'] == '' ? '' : nf($row->$deduction2['multiplier']) ?></td>
										<td class="text-right" width="35%"><?php echo nf(abs($row->$deduction2['payroll'])) ?></td>
									</tr>
									<?php $deduction_subtotal += abs($row->$deduction2['payroll']); ?>
									<?php endif ?>
									<?php endif ?>
								<?php endforeach ?>
								</table>
							</td>
							<td>
								<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr>
									<td>Total Earnings</td>
									<td class="text-right">
										<?php
												echo nf($earning_subtotal);
												$earning_total += $earning_subtotal;
											?>
									</td>
								</tr>
								<tr>
									<td>Total Deductions</td>
									<td class="text-right">
										<?php
												echo nf($deduction_subtotal);
												$deduction_total += $deduction_subtotal;
											?>
									</td>
								</tr>
								<tr>
									<th>NET PAY</th>
									<td class="text-right"><?php echo nf($earning_subtotal - $deduction_subtotal) ?></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<!-- <th>&nbsp;</th> -->
									<td colspan="2" style="border-top: 1px solid #000;" class="text-center">Signature</td>
								</tr>
								</table>
							</td>
						</tr>
					<?php endforeach ?>
					<thead>
						<tr>

							<td>
									<b>GRAND TOTAL FOR<br>
									POSITIVE NET PAYS</b>
							</td>
							<td>
								<?php
									$totalOnly = TRUE;
									$earnings = get_earnings(NULL, $fields, $totalOnly);
								?>
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<?php foreach ($earnings as $earning): ?>
									<tr>
										<td width="50%"><?php echo $earning['description'] ?></td>
										<td class="text-right" width="15%"><?php if ($earning['multiplier'] > 0) echo nf($earning['multiplier']) ?></td>
										<td class="text-right" width="35%"><?php echo nf($earning['amount']) ?></td>
									</tr>
								<?php endforeach ?>
								</table>
							</td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<?php foreach ($GLOBALS['deduction'] as $deduction): ?>
									<tr>
										<td width="50%"><?php echo $deduction['description'] ?></td>
										<td class="text-right" width="15%"><?php if ($deduction['multiplier'] > 0) echo nf($deduction['multiplier']) ?></td>
										<td class="text-right" width="35%"><?php echo nf($deduction['amount']) ?></td>
									</tr>
								<?php endforeach ?>
								</table>
							</td>
							<td>
								<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr>
									<td>Grand Earnings</td>
									<td class="text-right">
										<?php
												echo nf($earning_total);
											?>
									</td>
								</tr>
								<tr>
									<td>Grand Deductions</td>
									<td class="text-right">
										<?php
												echo nf($deduction_total);
											?>
									</td>
								</tr>
								<tr>
									<th>Grand Net</th>
									<td class="text-right"><?php echo nf($earning_total - $deduction_total); $grand_net = ($earning_total - $deduction_total); ?></td>
								</tr>
								</table>
							</td>
						</tr>
						<tr class="visible-print">
							<td class="text-center" colspan="7">
								<br>
								<br>
								<p>
									I HEREBY CERTIFY that I have personally paid to each employee whose name appears in the above payroll the amount<br>
									set opposite his/her name. The total amount paid in this payroll for employees receiving positive(+) net pays is<br>
									<?php $my_total = explode('.', $grand_net); ?>
									<?php echo ucwords((convert_number_to_words($my_total[0]))); ?>
									<?php
									    if ( ! empty($my_total[1]))
									    echo ' & ' . substr(nf( '.' . $my_total[1] ),2,10) . '/100';
									?>
									(P &nbsp;&nbsp;&nbsp; <?php echo nf($grand_net) ?>), inclusive of overtime pay.
									<br>
									<br>
									<p  class="pad">
										<span style="border-top: 1px solid #000;" class="pad"  >
											Date of Payment
										</span>
									</p>
									<br>
									<div class="row">
										<div class="col-xs-4">
											<br>
											<p class="pad margin" style="border-bottom: 1px solid #000;">
												PREPARED BY
											</p>
										</div>
										<div class="col-xs-4">
											<br>
											<p class="pad margin" style="border-bottom: 1px solid #000;">
												CHECKED &amp; VERIFIED BY
											</p>
										</div>
										<div class="col-xs-4">
											<br>
											<p class="pad margin" style="border-bottom: 1px solid #000;">
												APPROVED BY
											</p>
										</div>
									</div>
								</p>
							</td>
						</tr>


					</thead>
				<?php else: ?>
						<tr>
							<td colspan="7">
								<span class="label label-danger">No record found!.</span>
							</td>
						</tr>
				<?php endif ?>
		</tbody>
    </table>
					<?php echo display_button(); ?>
<!-- </div> -->
</div>
