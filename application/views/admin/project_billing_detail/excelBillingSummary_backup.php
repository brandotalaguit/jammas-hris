<meta charset="utf-8" />
<?php $total_columns = (count($columns) * 2); ?>
<?php 
    if (in_array('cola', $columns))
    $total_columns-=2;
    // $total_columns++;
    if (in_array('daily_rate', $columns))
    $total_columns+=3;
    
?>
<script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.min.js" ></script>
<script src="<?php echo base_url()?>assets/js/jquery.number.js"></script>

<script>
    $(document).ready(function() {
        $('.deci').number(true, 2);
    });
</script>
        <table class="table table-hover table-bordered table-condensed" id="billing" border="1">
            <thead>
            <tr>
                <td style="border: none;" colspan="2">TO</td>
                <td style="border: none;" colspan="<?php echo $total_columns - 6 ?>"><strong>: <?php echo t($project->title); ?></strong></td>
                <td style="border: none;" colspan="3" rowspan="4">
                    <img src="<?php echo base_url('assets/img/jammas_summary_logo.jpg'); ?>" align="right">
                </td>
            </tr>
            </thead>
            <thead>                
            <tr>
                <td style="border: none;" colspan="2">FROM</td>
                <td style="border: none;" colspan="<?php echo $total_columns - 2 ?>"><strong>: JAMMAS INC.</strong></td>
            </tr>
            </thead>
            <thead>                
            <tr>
                <td style="border: none;" colspan="2">RE</td>
                <td style="border: none;" colspan="<?php echo $total_columns -2 ?>">: SUMMARY OF BILLING</td>
            </tr>
            </thead>
            <thead>
            <tr>
                <td style="border: none;" colspan="2">PERIOD</td>
                <td style="border: none;" colspan="<?php echo $total_columns -2 ?>">: <?php echo date('F j', strtotime($project_billing_info->date_start)) . ' - ' . date('j, Y', strtotime($project_billing_info->date_end))   ?></td>
            </tr>
            </thead>
            <thead>
            <tr>
                <th colspan="<?php echo $total_columns ?>">&nbsp;</th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th width='1%' rowspan="2">#</th>
                <th width='15%' rowspan="2" nowrap>Employee Name</th>
                <th width='5%' rowspan="2">Position</th>

                <?php if (in_array('cola', $columns)): ?>
                <th width="5%" rowspan="2">Basic<br>per day</th>
                <th width="5%" rowspan="2">COLA</th>    
                <?php endif ?>

                <?php if (in_array('daily_rate', $columns)): ?>
                <th width='5%' rowspan="2">Contract<br>Rate/day</th>
                <th width='2%' rowspan="2">Reg.<br>Days</th>
                <th width='2%' rowspan="2">Amount</th>
                <?php endif ?>
                
                <?php if (in_array('straight_duty', $columns)): ?>
                <th width='5%' rowspan="2">Straight<br>Duty</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>
                
                <?php if (in_array('night_diff', $columns)): ?>
                <th width='5%' rowspan="2">Night<br>Diff.</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>
                
                <?php if (in_array('regular_ot_day', $columns)): ?>
                <th width='5%' rowspan="2">Reg.<br>O.T.</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <?php if (in_array('special_holiday', $columns)): ?>
                <th width='5%' rowspan="2">Special<br>Holiday</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <?php if (in_array('special_ot_holiday', $columns)): ?>
                <th width='5%' rowspan="2">Special<br>O.T.</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <?php if (in_array('legal_holiday', $columns)): ?>
                <th width='5%' rowspan="2">Legal<br>Holiday</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <?php if (in_array('legal_ot_holiday', $columns)): ?>
                <th width='5%' rowspan="2">Legal<br>O.T.</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <?php if (in_array('rest_day_rate', $columns)): ?>
                <th width='5%' rowspan="2">Rest<br>Day</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <?php if (in_array('rest_day_special_holiday', $columns)): ?>
                <th width='5%' rowspan="2">RD<br>SH</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <?php if (in_array('rest_day_legal_holiday', $columns)): ?>
                <th width='5%' rowspan="2">RD<br>LG</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <?php if (in_array('late_amount', $columns)): ?>
                <th width='5%' rowspan="2">Less<br>Late</th>
                <th width='5%' rowspan="2">Amount</th>
                <?php endif ?>

                <th width='5%' rowspan="2">Total</th>
            </tr>

            </thead>
            </table>
            <table border="1">
            <tbody>
            <?php
                $rw_day = 0.00; 
                $daily_rate = 0.00;
                $t_daily_rate = 0.00;
                $sd_day = 0.00;
                $t_sd_day = 0.00;
                $nd_day = 0.00;
                $t_nd_day = 0.00;
                $rw_ot_day = 0.00;
                $t_rw_ot_day = 0.00;
                $nd_day = 0.00;
                $t_nd_day = 0.00;
                $sp_day = 0.00;
                $t_sp_day = 0.00;
                $sp_ot_day = 0.00;
                $t_sp_ot_day = 0.00;
                $lg_day = 0.00;
                $t_lg_day = 0.00;
                $lg_ot_day = 0.00;
                $t_lg_ot_day = 0.00;
                $rd_day = 0.00;
                $t_rd_day = 0.00;
                $rd_sh_day = 0.00;
                $t_rd_sh_day = 0.00;
                $rd_lg_hl = 0.00;
                $t_rd_lg_hl = 0.00;
                $rd_lg_ot_day = 0.00;
                $t_rd_lg_ot_day = 0.00;
                $rw_ot_day = 0.00;
                $late_minutes = 0.00;
                $t_late_minutes = 0.00;
                $regular_ot_day = 0.00;
                $t_rw_ot_day = 0.00;
                
                $total = 0.00;

                $cnt_rw_day = 0.00;
                $cnt_sd_day = 0.00;
                $cnt_nd_day = 0.00;
                $cnt_rw_ot_day = 0.00;
                $cnt_sp_day = 0.00;
                $cnt_sp_ot_day = 0.00;
                $cnt_lg_day = 0.00;
                $cnt_lg_ot_day = 0.00;
                $cnt_rd_day = 0.00;
                $cnt_rd_sh_day = 0.00;
                $cnt_rd_lg_hl = 0.00;
                $cnt_rd_lg_ot_day = 0.00;
                $cnt_regular_ot_day = 0.00;
                $cnt_late_minutes = 0.00;
             ?>
            <?php if (count($project_billing_trans)): ?>
                <?php foreach ($project_billing_trans as $billing): ?>
                    <tr>
                        <td>
                            <?php 
                                if ($billing->w_adjustment == 1) 
                                {
                                    echo 'Adj.';
                                }
                                else
                                {
                                    echo ++$counter;
                                }
                            ?>
                        </td>
                        <td><?php echo $billing->lastname . ', ' . $billing->firstname . ' ' . $billing->middlename;?></td>
                        <td>
                            <?php 
                                if ($billing->w_adjustment == 1) 
                                {
                                    echo $billing->remarks;
                                }
                                else
                                {
                                    echo $billing->position;
                                }
                            ?>
                        </td>

                        <?php if (in_array('cola', $columns)): ?>
                        <td><?php echo nf($billing->daily_rate - 15) ?></td>
                        <td><?php echo nf('15') ?></td>
                        <?php endif ?>

                        <?php if (in_array('daily_rate', $columns)): ?>
                        <td><?php echo nf($billing->daily_rate); ?></td>
                        <!-- regular days worked -->
                        <td class="deci">
                            <?php echo nf($billing->rw_day); $cnt_rw_day += $billing->rw_day; ?>
                        </td>
                        <td><?php echo nf($daily_rate = $billing->rw_day * $billing->daily_rate); $t_daily_rate += $daily_rate; ?></td>
                        <?php endif ?>

                        <?php if (in_array('straight_duty', $columns)): ?>
                        <!-- straight days worked -->
                        <td class="deci">
                            <?php echo nf($billing->sd_day); $cnt_sd_day += $billing->sd_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($sd_day = $billing->sd_day * $billing->straight_duty); $t_sd_day += $sd_day; ?></td>
                        <?php endif ?>
                        
                        
                        <?php if (in_array('night_diff', $columns)): ?>
                        <!-- Night Diff. worked -->
                        <td>
                            <?php echo nf($billing->nd_day); $cnt_nd_day += $billing->nd_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($nd_day = $billing->nd_day * $billing->night_diff); $t_nd_day += $nd_day; ?></td>
                        <?php endif ?>

                        <?php if (in_array('regular_ot_day', $columns)): ?>
                        <!-- Regular O.T. worked -->
                        <td>
                            <?php echo nf($billing->rw_ot_day); $cnt_rw_ot_day += $billing->rw_ot_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($rw_ot_day = $billing->rw_ot_day * $billing->regular_ot_day); $t_rw_ot_day += $rw_ot_day; ?></td>
                        <?php endif ?>

                        
                        <?php if (in_array('special_holiday', $columns)): ?>
                        <!-- Special holidays worked -->
                        <td>
                            <?php echo nf($billing->sp_day); $cnt_sp_day += $billing->sp_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($sp_day = $billing->sp_day * $billing->special_holiday); $t_sp_day += $sp_day; ?></td>
                        <?php endif ?>

                        
                        <?php if (in_array('special_ot_holiday', $columns)): ?>
                        <!-- Special holidays OT worked -->
                        <td>
                            <?php echo nf($billing->sp_ot_day); $cnt_sp_ot_day += $billing->sp_ot_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($sp_ot_day = $billing->sp_ot_day * $billing->special_ot_holiday); $t_sp_ot_day += $sp_ot_day; ?></td>
                        <?php endif ?>

                        
                        <?php if (in_array('legal_holiday', $columns)): ?>
                        <!-- Legal holidays worked -->
                        <td>
                            <?php echo nf($billing->lg_day); $cnt_lg_day += $billing->lg_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($lg_day = $billing->lg_day * $billing->legal_holiday); $t_lg_day += $lg_day; ?></td>
                        <?php endif ?>
                        
                        <?php if (in_array('legal_ot_holiday', $columns)): ?>
                        <!-- Legal holidays OT worked -->
                        <td>
                            <?php echo nf($billing->lg_ot_day); $cnt_lg_ot_day += $billing->lg_ot_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($lg_ot_day = $billing->lg_ot_day * $billing->legal_ot_holiday); $t_lg_ot_day += $lg_ot_day; ?></td>
                        <?php endif ?>
                        

                        <?php if (in_array('rest_day_rate', $columns)): ?>
                        <!-- Rest day Legal Holiday worked -->
                        <td>
                            <?php echo nf($billing->rd_day); $cnt_rd_day += $billing->rd_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($rd_day = $billing->rd_day * $billing->rest_day_rate); $t_rd_day += $rd_day; ?></td>
                        <?php endif ?>

                        <?php if (in_array('rest_day_special_holiday', $columns)): ?>
                        <!-- Rest day Legal Holiday worked -->
                        <td>
                            <?php echo nf($billing->rd_sh_day); $cnt_rd_sh_day += $billing->rd_sh_day; ?>
                        </td>
                        <td class="deci"><?php echo nf($rd_sh_day = $billing->rd_sh_day * $billing->rest_day_special_holiday); $t_rd_sh_day += $rd_sh_day; ?></td>
                        <?php endif ?>


                        <?php if (in_array('rest_day_legal_holiday', $columns)): ?>
                        <!-- Rest day Legal Holiday worked -->
                        <td>
                            <?php echo nf($billing->rd_lg_hl); $cnt_rd_lg_hl += $billing->rd_lg_hl; ?>
                        </td>
                        <td class="deci"><?php echo nf($rd_lg_hl = $billing->rd_lg_hl * $billing->rest_day_legal_holiday); $t_rd_lg_hl += $rd_lg_hl; ?></td>
                        <?php endif ?>
                        

                        <?php if (in_array('late_amount', $columns)): ?>
                        <!-- Less Late -->
                        <td style="color:red">
                            <?php echo nf($billing->late_minutes); $cnt_late_minutes += $billing->late_minutes; ?>
                        </td>
                        <td class="deci" style="color:red">(<?php echo nf($late_minutes = $billing->late_minutes * $billing->late_amount); $t_late_minutes += $late_minutes; ?>)</td>
                        <?php endif ?>

                        
                        <td><span class="subtotal">
                        <?php 
                            $subtotal = ($daily_rate + $sd_day + $nd_day + $rw_ot_day + $sp_day + $sp_ot_day + $lg_day + $lg_ot_day + $rd_lg_hl + $rd_sh_day + $rd_day) - $late_minutes;
                            echo nf($subtotal); $total += $subtotal;
                        ?></span></td>

                    </tr>
                <?php endforeach ?>
                <tr>
                    <tfoot>
                        <th colspan="<?php echo in_array('cola', $columns) ? 6 : 4; ?>">Grand Total</th>
                        
                        <?php if (in_array('daily_rate', $columns)): ?>
                        <th><?php echo $cnt_rw_day ?></th>
                        <th><?php echo nf($t_daily_rate) ?></th>
                        <?php endif ?>

                        <?php if (in_array('straight_duty', $columns)): ?>
                        <th><?php echo nf($cnt_sd_day) ?></th>
                        <th><?php echo nf($t_sd_day) ?></th>
                        <?php endif ?>
                        
                        <?php if (in_array('night_diff', $columns)): ?>
                        <th><?php echo nf($cnt_nd_day) ?></th>
                        <th><?php echo nf($t_nd_day) ?></th>
                        <?php endif ?>
                        
                        <?php if (in_array('regular_ot_day', $columns)): ?>
                        <th><?php echo nf($cnt_rw_ot_day) ?></th>
                        <th><?php echo nf($t_rw_ot_day) ?></th>
                        <?php endif ?>
                        
                        <?php if (in_array('special_holiday', $columns)): ?>
                        <th><?php echo nf($cnt_sp_day) ?></th>
                        <th><?php echo nf($t_sp_day) ?></th>
                        <?php endif ?>
                        
                        <?php if (in_array('special_ot_holiday', $columns)): ?>
                        <th><?php echo nf($cnt_sp_ot_day) ?></th>
                        <th><?php echo nf($t_sp_ot_day) ?></th>
                        <?php endif ?>
                        
                        <?php if (in_array('legal_holiday', $columns)): ?>
                        <th><?php echo nf($cnt_lg_day) ?></th>
                        <th><?php echo nf($t_lg_day) ?></th>
                        <?php endif ?>
                        
                        <?php if (in_array('legal_ot_holiday', $columns)): ?>
                        <th><?php echo nf($cnt_lg_ot_day) ?></th>
                        <th><?php echo nf($t_lg_ot_day) ?></th>
                        <?php endif ?>

                        <?php if (in_array('rest_day_rate', $columns)): ?>
                        <th><?php echo nf($cnt_rd_day) ?></th>
                        <th><?php echo nf($t_rd_day) ?></th>
                        <?php endif ?>
                        
                        <?php if (in_array('rest_day_special_holiday', $columns)): ?>
                        <th><?php echo nf($cnt_rd_sh_day) ?></th>
                        <th><?php echo nf($t_rd_sh_day) ?></th>
                        <?php endif ?>

                        <?php if (in_array('rest_day_legal_holiday', $columns)): ?>
                        <th><?php echo nf($cnt_rd_lg_hl) ?></th>
                        <th><?php echo nf($t_rd_lg_hl) ?></th>
                        <?php endif ?>
                        
                        <?php if (in_array('late_amount', $columns)): ?>
                        <th style="color:red"><?php echo nf($cnt_late_minutes) ?></th>
                        <th style="color:red">(<?php echo nf($t_late_minutes) ?>)</th>
                        <?php endif ?>

                        <th><?php echo nf($total) ?></th>
                    </tfoot>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="11">
                        <p class="label label-danger">No record found!. Please try again.</p>
                    </td>
                </tr>
            <?php endif ?>
            </tbody>
        
        <tfoot>
            <?php for ($i=0; $i < 4; $i++) : ?>
            <tr>
                <td style="border: none;" colspan="<?php echo $total_columns ?>">&nbsp;</td>
            </tr>
            <?php endfor ?>
            <tr>
                <td style="border: none;">&nbsp;</td>
                <td style="border: none;" colspan="2">Prepared by:</td>
                <td style="border: none;" colspan="2">&nbsp;</td>
                <td style="border: none;" colspan="5">Reviewed & Certified Correct by:</td>
            </tr>
            <?php for ($i=0; $i < 3; $i++) : ?>
            <tr>
                <td style="border: none;" colspan="<?php echo $total_columns ?>">&nbsp;</td>
            </tr>
            <?php endfor ?>            
            <tr>
                <td style="border: none;">&nbsp;</td>
                <td style="border: none;" colspan="2"><strong>Troy Henry G. Nardo</strong></td>
                <td style="border: none;" colspan="2">&nbsp;</td>
                <td style="border: none;" colspan="5"><strong>Mr. Kristofferson G. Pineda</strong></td>
            </tr>
            <?php for ($i=0; $i < 2; $i++) : ?>
            <tr>
                <td style="border: none;" colspan="<?php echo $total_columns ?>">&nbsp;</td>
            </tr>
            <?php endfor ?>
        </tfoot>

        </table>

<?php
/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 9/1/14
 * Time: 2:17 PM
 */ 