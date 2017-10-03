<div id="msg" class="alert"></div>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog" style="width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Project Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php $this->load->view('manning_payroll/project'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $this->load->view('manning_payroll/setting'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header">
        <div class="row">
            <div class="col-sm-8">
                <?php echo form_open('manning_payroll/finalize/', NULL, ['payroll_id' => $this->uri->segment(3)]); ?>
                <h3 class="box-title">
                <?php echo anchor('manning_payroll', '<strong><i class="fa fa-home"></i> Payroll</strong>', ['class' => 'btn btn-default'])?>
                <a class="btn btn-info" data-toggle="modal" href='#modal-id'>Project Information</a>

                <?php echo form_submit([
                                            'name' => 'btn_action',
                                            'value' => 'Save as Final',
                                            'onclick' => "return confirm('Are you sure you want to finalized this data? This will enable you to print payroll and payslip')",
                                            'class' => 'btn btn-primary'
                                        ]); ?>
                </h3>
                <?php echo form_close(); ?>
            </div>
            <div class="col-sm-4">
                <div class="box-tools" style="padding: 10px 10px 10px 0px">
                    <?php echo $search_form ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box-body no-padding tbl-ovrflow">
        <table class="table table-hover table-bordered" id="billing">
            <thead>
            <tr>
                <th width='2%' rowspan="2">#</th>
                <th width='10%' rowspan="2">Employee Name</th>
                <th width='2%' rowspan="2">Position</th>

                <?php
                    // if ($project->rate_daily == 1)
                    // {
                    //     $tmp = $payroll->fields;
                    //     $payroll->fields = 'daily_rate,' . $tmp;
                    // }


                    if (!in_array('hourly_rate', $distinct_rate) || strpos($payroll->fields, 'hourly_rate') === false)
                    {
                        $tmp = $payroll->fields;
                        $payroll->fields = 'hourly_rate,' . $tmp;
                    }

                ?>


                <?php if (in_array('semi_monthly_rate', $distinct_rate)): ?>
                <th width="3%">Semi-Monthly Rate</th>
                <?php endif ?>

                <?php if (in_array('monthly_rate', $distinct_rate)): ?>
                <th width="3%">Monthly Rate</th>
                <?php endif ?>

                <th width='2%' rowspan="2">COLA</th>
                <th width='2%'>Allowance</th>

                <?php $arr_subtotal = array(); ?>

                <?php foreach (explode(',', $payroll->fields) as $rate): ?>

                    <?php
                        $rate_data = explode('|', $billing_rates[$rate]);
                        $rate_basis = $rate_data[0];
                        $rate_title = $rate_data[1];
                        $rate_abbr = $rate_data[2];

                     ?>

                     <?php if (in_array($rate, array_keys($billing_rates))): ?>

                            <?php #if ($rate == 'cola'): ?>
                                <!-- <th width='2%' rowspan="2">COLA</th> -->
                            <?php #else: ?>
                                <th width='2%' rowspan="2"><?php echo $rate_title ?></th>
                                <th width='2%' rowspan="2">Amount</th>
                            <?php #endif ?>


                     <?php endif ?>

                <?php $arr_subtotal[$rate] = 0.00; ?>
                <?php $arr_subtotal[$rate.'_amount'] = 0.00; ?>

                <?php endforeach ?>

                <?php
                        // $arr_subtotal['semi_monthly_rate'] = 0.00;
                        // $arr_subtotal['semi_monthly_rate_amount'] = 0.00;
                        // $arr_subtotal['monthly_rate'] = 0.00;
                        // $arr_subtotal['monthly_rate_amount'] = 0.00;

                        // $arr_subtotal['cola'] = 0.00;
                        // $arr_subtotal['cola_amount'] = 0.00;
                        // $arr_subtotal['allowance'] = 0.00;
                        // $arr_subtotal['allowance_amount'] = 0.00;
                    ?>

                <th width='5%' rowspan="1">Total</th>

            </tr>
            </thead>
            <tbody>
            <?php
            $subtotal = $grandtotal = $total_semi_monthly = $total_monthly = $total_cola = $total_allowance = 0.000;
            // dump($earning[1]);
            ?>
            <?php if (count($earning)): ?>


                <?php foreach ($earning as $billing): ?>
                    <?php #die(dump($billing)); ?>
                    <tr <?php echo $this->session->flashdata('id') == $billing->manning_payroll_earning_id ? "class='success'" : '';  ?> >
                        <td class="text-center" >
                            <?php
                                if ($billing->w_adjustment == 1)
                                    echo 'Adj.';
                                elseif ($billing->employment_status_id == RELIEVER)
                                    echo 'R';
                                elseif ($billing->employment_status_id == EXTRA_RELIEVER)
                                    echo 'XR';
                                else
                                    echo ++$counter;
                            ?>
                        </td>
                        <td
                            <?php if ($billing->employment_status_id == RELIEVER) echo "class='bg-orange' "; ?>
                            <?php if ($billing->employment_status_id == EXTRA_RELIEVER) echo "class='bg-red' "; ?>
                            >
                            <?php
                                    echo $billing->lastname . ', ' . $billing->firstname . ' ' . $billing->middlename;
                                    if ($billing->employment_status_id == RELIEVER) echo " <p class = 'label label-danger'>RELIEVER</p>";
                                    if ($billing->employment_status_id == EXTRA_RELIEVER) echo " <p class = 'label label-danger'>EXTRA-RELIEVER</p>";
                                ?>

                        </td>
                            <?php
                                $position_rates = 0.00;
                                if (in_array('hourly_rate', $distinct_rate))
                                $position_rates = nf($billing->daily_rate);

                                if (in_array('semi_monthly_rate', $distinct_rate))
                                {
                                    $position_rates = nf($billing->semi_monthly_rate);
                                }

                                if (in_array('monthly_rate', $distinct_rate))
                                {
                                    $position_rates = nf($billing->monthly_rate);
                                }
                            ?>
                        <td title="<?php echo t($position_rates) ?>">
                            <?php
                                if ($billing->remarks)
                                    echo $billing->remarks;
                                else
                                    echo t($billing->position);
                            ?>
                        </td>

                        <?php if (in_array('semi_monthly_rate', $distinct_rate)): ?>
                        <td><span class="deci"><?php echo nf($billing->r_semi_monthly_rate);?></span></td>
                        <?php endif ?>

                        <?php if (in_array('monthly_rate', $distinct_rate)): ?>
                        <td><span class="deci"><?php echo nf($billing->r_monthly_rate);?></span></td>
                        <?php endif ?>

                        <td title="COLA" class="cola"><code class='deci cola'><?php echo nf($billing->r_cola) ?></code></td>

                        <td title="Allowance" class="allowance">
                            <code class='deci allowance'><?php echo nf($billing->r_allowance) ?></code>
                        </td>

            <?php
                // dump($payroll->fields);
                $subtotal = 0.000;

                $total_cola += $billing->r_cola;
                $total_allowance += $billing->r_allowance;

                $subtotal += $billing->r_cola;
                $subtotal += $billing->r_allowance;

                $subtotal += floatval($billing->r_semi_monthly_rate);
                $total_semi_monthly += floatval($billing->r_semi_monthly_rate);

                $subtotal += floatval($billing->r_monthly_rate);
                $total_monthly += floatval($billing->r_monthly_rate);
                ?>

            <?php foreach (explode(',', $payroll->fields) as $rate): ?>
                <?php

                    $rate_data = explode('|', $billing_rates[$rate]);
                    // dump($rate_data);
                    $rate_pbt = 'r_' . $rate;
                    $rate_basis = $rate_data[0];
                    $rate_title = $rate_data[1];
                    $rate_abbr = $rate_data[2];
                    $rate_amount = $rate_data[3];
                    // dump($rate_pbt);
                    // dump($rate_basis);
                    // dump($rate_title);
                    // dump($rate_abbr);
                    // dump($rate_amount);
                 ?>

                 <?php if (in_array($rate, array_keys($billing_rates))): ?>
                        <td>
                        <?php #if ($billing->rate > 1 && in_array($rate_basis, ['no_hrs']) && (in_array('monthly_rate', $distinct_rate) || in_array('semi_monthly_rate', $distinct_rate))): ?>
                        <?php #else: ?>
                            <a href="#" class="editable" data-url="<?php echo base_url("manning_payroll/$billing->manning_payroll_earning_id/edit_earning"); ?>" id="<?php echo $billing->manning_payroll_earning_id; ?>"
                                data-name="<?php echo $rate_basis ?>" data-type="text" data-title="<?php echo $rate_title?>" data-pk="<?php echo $billing->manning_payroll_earning_id; ?>" >
                                <!-- please clear the issue of decimal places to be used 2 OR 4 -->
                                <?php echo nf(floatval($billing->$rate_basis)) ?>

                            </a>
                        <?php #endif ?>
                        </td>
                        <td><?php echo nf(floatval($billing->$rate_pbt)); ?></td>

                 <?php endif ?>

            <?php
                // dump($rate_basis);
                $arr_subtotal[$rate] += floatval($billing->$rate_basis);
                $arr_subtotal[$rate.'_amount'] += floatval($billing->$rate_pbt);

                // if (substr($rate_abbr, 0, 4) != 'cola')
                // {
                  $subtotal += floatval($billing->$rate_pbt);
                // }
            ?>

            <?php endforeach ?>

            <?php

             ?>

            <th>
                <!-- sub-total -->
                <?php echo nf(floatval($subtotal)); ?>
            </th>
            </tr>

        <?php $grandtotal += floatval($subtotal); ?>
        <?php //exit(); ?>
        <?php endforeach ?>

        <?php else: ?>
                <tr>
                    <td colspan="11">
                        <p class="label label-danger">No record found!. Please try again.</p>
                    </td>
                </tr>
        <?php endif ?>
            </tbody>

            <tfoot>
            <tr>

                <th class="lead text-right" colspan="3"><strong>TOTAL</strong></th>

                <?php if (in_array('semi_monthly_rate', $distinct_rate)): ?>
                <th><?php echo nf(floatval($total_semi_monthly)) ?></th>
                <?php endif ?>

                <?php if (in_array('monthly_rate', $distinct_rate)): ?>
                <th><?php echo nf(floatval($total_monthly)) ?></th>
                <?php endif ?>

                <th id="total_cola"><?php echo nf($total_cola);  ?></th>
                <th id="total_allowance"><?php echo nf($total_allowance) ?></th>

                <?php #$grand_total = 0.00; ?>
                <?php #dump($arr_subtotal) ?>
                <?php foreach ($arr_subtotal as $key => $value): ?>
                        <th id="<?php echo $key ?>">
                            <?php if (substr($key, -7) == '_amount' && substr($key, 0, 4) != 'cola'): ?>
                            <?php echo nf(floatval($value)) ?>
                            <?php else: ?>
                            <?php echo nf(floatval($value)) ?>
                            <?php endif ?>
                        </th>
                <?php endforeach ?>
                <th style="font-weight: bold; font-size:15px;"><?php echo nf($grandtotal) ?></th>
            </tr>
            </tfoot>

        </table>
    </div>
    <div class="box-footer clearfix">
        <?php
        #if (isset($pagination))
        #    echo $pagination;
        ?>
        <div class="pull-right">


        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
 $('.left-side').addClass('collapse-left');
 $('.right-side').addClass('strech');

})



</script>


<?php
/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 9/1/14
 * Time: 2:17 PM
 */
