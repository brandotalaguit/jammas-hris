<?php // $cnt1 = 1;
	$this->load->model(['manning_payroll_earning_m', 'manning_payroll_deduction_m']);

	$project = $this->projects->get($payroll_info->project_id);

	$GLOBALS['billing_rates'] = $billing_rates = $this->projects->get_field();
	$GLOBALS['tardiness'] = $tardiness = ['r_late_amount', 'r_absent_rate', 'r_absent_rate_per_day'];
	$GLOBALS['earning'] = $GLOBALS['deduction'] = array();

	$GLOBALS['reliever_payroll'] = $reliever_payroll;
	$GLOBALS['with_13th_month'] = $project->with_13th_month;

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
	           												'amount' => get_key($payroll, $rate_data['payroll'], 0),
	           												'multiplier' => get_key($payroll, $rate_data['payroll'], 0) == 0 ? '' : get_key($payroll, $rate_data['multiplier'], ''),
	           											);
		           	}
		           	else
		           	{
		           		$GLOBALS['earning'][$wage_name]['amount'] += get_key($payroll, $rate_data['payroll'], 0);
		           		$GLOBALS['earning'][$wage_name]['multiplier'] = '';
		           	}

		            $data[] = array(
		                        'name' => $wage_name,
		                        'description' => $rate_data['abbr'],
		                        'amount' => get_key($payroll, $rate_data['payroll'], 0),
								'multiplier' => get_key($payroll, $rate_data['payroll'], 0) == 0 ? '' : get_key($payroll, $rate_data['multiplier'], ''),
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
	    		$GLOBALS['earning']['r_cola']['multiplier'] = '';
	    	}

	        // 13th month benefits
	    	if ($GLOBALS['with_13th_month'] == 1)
	    	{
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
			       		$GLOBALS['earning']['r_13thmonth']['multiplier'] = '';
			       	}
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
   	    		$GLOBALS['earning']['r_allowance']['multiplier'] = '';
   	    	}
	       	$data[] = array(
							'description' => 'E-COLA',
							'amount' => $payroll->r_cola,
							'multiplier' => '',
						);

	       	if ($GLOBALS['with_13th_month'] == 1)
	       	{
		       	if ( ! $GLOBALS['reliever_payroll'])
		       	{
			       	$data[] = array(
									'description' => '13th Month',
									'amount' => $payroll->r_13thmonth,
									'multiplier' => '',
								);
		       	}
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
	       	if ($GLOBALS['with_13th_month'] == 1)
	       	{
		       	if ( ! $GLOBALS['reliever_payroll'])
		       	$data[] = $GLOBALS['earning']['r_13thmonth'];
	       	}
	       	$data[] = $GLOBALS['earning']['r_allowance'];
        }
        // dump($data);
        return $data;
    }

    function get_deductions($payroll, $deductions, $reg_deduction)
    {
    	$data = array();
    	$deduction1 = array();
    	$deduction_subtotal = 0;

    		if ( ! empty($payroll->deductions))
			{
				$ctr = 1;
    			foreach ($deductions as $deduction)
    			{
    				$deduct = explode('#', $deduction);
    				if (count($deduct))
    				{
    					$deduction1[] = array(
    						'name' => 'deduct_' . $ctr++,
    						'description' => $deduct[0],
    						'payroll' => $deduct[1],
    						'multiplier' => '',
    					);
    				}
	    			$deduction_subtotal += $deduct[1];
	    		}
			}

    		foreach ($reg_deduction as $deduction2)
    		{
    			if (!empty(get_key($payroll, $deduction2['payroll'], '')))
    			{
					if (abs(get_key($payroll, $deduction2['payroll'], 0)) > 0)
					{
				           	$deduction1[] = array(
				           		'name' => $deduction2['abbr'],
				           		'description' => $deduction2['abbr'],
				           		'payroll' => abs(get_key($payroll, $deduction2['payroll'], 0)),
				           		'multiplier' => $deduction2['multiplier'] == '' ? '' : get_key($payroll, $deduction2['multiplier'], ''),
				           	);
					}
    			}

    		}

    		return $deduction1;

    }

	$GLOBALS['pid'] = $this->uri->segment(3);
	$GLOBALS['method'] = $this->uri->segment(2);
	function display_button($manning_id)
	{
		$pid = $GLOBALS['pid'];
		$method = $GLOBALS['method'];
		return '<div class="row no-print margin">
				<p>
					<span class="pull-right">
						<button class="btn btn-default btn-md" onclick="window.print()">
							<span class="fa fa-print" aria-hidden="true"></span> Print All
						</button>
						<a href="' . base_url('manning_payroll/'.$method.'/' . $pid . '/' . $manning_id) . '" target="_blank" class="btn btn-primary btn-md">Print this payslip</a>
					</span>
				</p>
			</div>';
	}
 ?>
 <style type="text/css">
 	td {
 		vertical-align: top;
 	}
 	p.total {
 		margin-bottom: 0px;
 	}
 	@media print {
 		body {
 				font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
 			}
 		table,tr,td,th,
 		.col-xs-3
 		{
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

<?php
?>

<?php if (count($payroll)): ?>
		<?php
			$this->load->model('projects');

			$fields = $payroll_info->fields;

			$reg_deduction = $this->manning_payroll_deduction_m->deduction_field($reliever_payroll);

		    $fields = 'hourly_rate,' . $fields;
		    $fields = 'daily_rate,' . $fields;
		    $fields = 'semi_monthly_rate,' . $fields;
		    $fields = 'monthly_rate,' . $fields;

			$earning_total = $deduction_total = $ctr = 0;
			// dump($payroll);
		 ?>
		<?php foreach ($payroll as $row): ?>
<div class="row">
	<div class="col-xs-12">

<div class="box matrix content invoice">

	<?php echo display_button($row->employee_id); ?>
	<!-- <div class="row"> -->
		<!-- <div class="col-xs-3"> -->
	<table class="table-responsive" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
		<tr>
			<td width="25%" class="pad margin">
				<p>
					I acknowledge to have received from
					<b>JAMMAS, INC.</b> the amount stated below and have no
					further claims for services rendered.
				</p>
				<p>
					<small><b>Pay Period: </b> <?php echo payroll_date($payroll_info->date_start) ?> To: <?php echo payroll_date($payroll_info->date_end) ?> </small><br>
					<b>Employee Code: </b> <?php echo $row->employee_no; ?> <br>
					<b>Name: </b> <?php echo $row->lastname . ', ' . $row->firstname . $row->middlename; ?> <br>
					<br>
					<?php
						$total_earnings = $total_deductions = 0;
						$earnings = get_earnings($row, $fields);
						$deductions = explode('|', $row->deductions);
						$deduction3 = get_deductions($row, $deductions, $reg_deduction);

						$earning_subtotal = $deduction_subtotal = 0;

						foreach ($earnings as $earning)
						{
							$earning_subtotal += $earning['amount'];
							$total_earnings += $earning['amount'];
							$earning_total += $earning_subtotal;
							$earning_subtotal = 0;
						}
						foreach ($deduction3 as $deduction4)
						{
							$deduction_subtotal += $deduction4['payroll'];
							$deduction_total += $deduction_subtotal;
							$total_deductions += $deduction4['payroll'];
							$deduction_subtotal = 0;
						}
						// dump($deduction3);
					 ?>
					<p class="total">
						<b class="text-left">Total Earnings: </b> <span class="pull-right text-right"><?php echo nf($total_earnings); ?></span> <br>
					</p>
					<p class="total">
						<b class="text-left">Total Deductions: </b> <span class="pull-right text-right"><?php echo nf($total_deductions); ?></span> <br>
					</p>
					<p class="total">
						<b class="text-left">Net Pay: </b> <span class="pull-right text-right"><?php echo nf($total_earnings - $total_deductions); ?></span> <br>
					</p>

					<div class="row margin">
						<div class="col-xs-offset-2 col-xs-8">
							<br>
							<p class="text-center" style="border-top: 1px solid #000;">
								Signature
							</p>
						</div>
					</div>
				</p>
			</td>
			<td width="75%">
				    <table class="table table-condensed table-hover" border="1" width="100%">
					    <thead>
					    	<tr>
					    		<th class="text-center" colspan="6">
									<h5>
										<b>JAMMAS INC.</b><br>
										<?php echo $page_title ?>
									</h5>
					    		</th>
					    	</tr>
					    	<tr>
					    		<td colspan="6">
					    			<div class="row">
					    				<div class="col-xs-6">
					    					<p class="total"> <b>Name: </b>
					    					<?php echo $row->lastname . ', ' . $row->firstname . ' ' . substr($row->middlename, 0, 1); ?>
					    					</p>
					    				</div>
    				    				<!-- <div class="col-xs-offset-4 col-xs-4">
    					    				<p class="total"> <b>Days of Week: </b>
    				    					&nbsp;
    				    					</p>
    				    				</div> -->
					    			</div>
					    			<div class="row">
					    				<div class="col-xs-6">
						    				<p class="total"> <b>Pay Period: </b>
						    				<?php echo payroll_date($payroll_info->date_start) ?> To: <?php echo payroll_date($payroll_info->date_end) ?>
					    					</p>
					    				</div>
					    				<div class="col-xs-6">
						    				<p class="total"> <b>Project: </b>
					    					<?php echo $payroll_info->title; ?>
					    					</p>
					    				</div>
					    			</div>

					    		</td>
					    	</tr>
							<tr>
						        <th width='30%' class="text-center">E A R N I N G S</th>
						        <th width='30%' class="text-center">D E D U C T I O N S</th>
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

										<tr>
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
														<td width="50%"><?php $deduct_name = $deduct[0]; echo $deduct_name ?></td>
														<td class="text-right" width="15%">&nbsp;<?php #echo $earning['multiplier'] ?></td>
														<td class="text-right" width="35%"><?php $deduct_amount = $deduct[1]; echo nf($deduct_amount) ?></td>
													</tr>
													<?php #$deduction_subtotal += $deduct[1]; ?>

													<!-- store other deduction -->
													<?php
														if ( isset($GLOBALS['deduction'][$deduct_name]))
														{
															$GLOBALS['deduction'][$deduct_name]['amount'] += $deduct_amount;
														}
														else
														{
															$GLOBALS['deduction'][$deduct_name] = array(
																							'description' => $deduct_name,
																							'amount' => $deduct_amount,
																							'multiplier' => 0
																						);
														}
													 ?>
													<!-- end other deduction -->

													<?php endif ?>
												<?php endforeach ?>
												<?php endif ?>

												<?php foreach ($reg_deduction as $deduction2): ?>
													<?php if (!empty(get_key($row, $deduction2['payroll'], ''))): ?>
													<?php if (abs(get_key($row, $deduction2['payroll'], 0)) > 0): ?>
														<?php
												           	if (empty($GLOBALS['deduction'][$deduction2['payroll']]))
												           	{
												           		$GLOBALS['deduction'][$deduction2['payroll']] = array(
											           												'description' => $deduction2['abbr'],
											           												'amount' => abs(get_key($row, $deduction2['payroll'], '0')),
											           												'multiplier' => nf(get_key($row, $deduction2['multiplier'], '')),
											           											);
												           	}
												           	else
												           	{
												           		$GLOBALS['deduction'][$deduction2['payroll']]['amount'] += abs(get_key($row, $deduction2['payroll'], 0));
												           		$GLOBALS['deduction'][$deduction2['payroll']]['multiplier'] = nf(get_key($row, $deduction2['multiplier'], 0));
												           	}
														 ?>
													<tr>
														<td width="50%"><?php echo $deduction2['abbr'] ?></td>
														<td class="text-right" width="15%"><?php echo $deduction2['multiplier'] == '' ? '' : nf(get_key($row, $deduction2['multiplier'], 0)) ?></td>
														<td class="text-right" width="35%"><?php echo nf(abs(get_key($row,$deduction2['payroll'], '0'))) ?></td>
													</tr>

													<?php endif ?>
													<?php endif ?>
												<?php endforeach ?>
												</table>
											</td>

										</tr>
										<tr>
											<td colspan="6">
												<div class="row">
													<div class="col-xs-4">
														<p class="total">
															<b class="text-left">Total Earnings: </b>
															<span class="pull-right text-right"><?php echo nf($total_earnings); ?></span>
														</p>
													</div>
													<div class="col-xs-4">
														<p class="total">
															<b class="text-left">Total Deductions: </b>
															<span class="pull-right text-right"><?php echo nf($total_deductions); ?></span>
														</p>
													</div>
													<div class="col-xs-4">
														<p class="total">
															<b class="text-left">Net Pay: </b>
															<span class="pull-right text-right"><?php echo nf($total_earnings - $total_deductions); ?></span>
														</p>
													</div>
												</div>
											</td>
										</tr>


						</tbody>
				    </table>

					<?php echo display_button($row->employee_id); ?>
			</td>
		</tr>
	</table>


		<!-- </div> -->
		<!-- <div class="col-xs-9"> -->

		<!-- </div> -->
	<!-- </div> -->

</div>

	</div>
</div>

<?php // $cnt1++; if($cnt1 == 3 ) die() ?>

<?php endforeach ?>

<div class="row hidden-print">
	<div class="col-xs-12 table-responsive">
	<table class="table table-bordered table-condensed" cellpadding="0" cellspacing="0" border="0">
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
					<b>EARNINGS</b>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<?php foreach ($earnings as $earning): ?>
						<tr>
							<td width="50%"><?php echo $earning['description'] ?></td>
							<td class="text-right" width="15%"><?php echo nf($earning['multiplier']) ?></td>
							<td class="text-right" width="35%"><?php echo nf($earning['amount']) ?></td>
						</tr>
					<?php endforeach ?>
					</table>
				</td>
				<td>
					<b>DEDUCTIONS</b>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<?php foreach ($GLOBALS['deduction'] as $deduction): ?>
						<tr>
							<td width="50%"><?php echo $deduction['description'] ?></td>
							<td class="text-right" width="15%"><?php echo nf($deduction['multiplier']) ?></td>
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
	</table>
	</div>
</div>



				<?php else: ?>
						<tr>
							<td colspan="7">
								<span class="label label-danger">No record found!.</span>
							</td>
						</tr>
				<?php endif ?>
