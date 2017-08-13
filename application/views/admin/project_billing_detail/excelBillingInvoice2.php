<meta charset="utf-8" />
<!-- data souce Project_billing_trans@get_project_summary -->
        <table class="table table-hover table-bordered table-condensed" id="billing" border="0">
            <thead>
            <?php for ($i=0; $i < 4; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <?php endfor ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2"><font face="arial"><strong><?php echo t($project->description); ?></strong></font></td>
                <!-- <td>&nbsp;</td> -->
                <td colspan="3" align="right" style="text-align:right"><font face="arial"><strong><?php echo date('d-M-y'); ?></strong></font></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><strong><?php echo t($project->address); ?></strong></td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php for ($i=0; $i < 10; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <?php endfor ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5"><font face="Arial" size="12pt"><strong>Billing for Manpower services rendered</strong></font></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5"><font face="Arial" size="12pt"><strong>for the period <?php echo date('F j, Y', strtotime($project_billing_info->date_start)) . ' - ' . date('F j, Y', strtotime($project_billing_info->date_end)) ?></strong></font></td>
            </tr>
            <tr>
                <th colspan="6">&nbsp;</th>
            </tr>

            <?php 
                $subtotal_billing = 0.00; 
                $tmp = $project_billing_info->fields;
                
                if ($project->rate_hourly == 1)
                {
                    $project_billing_info->fields = 'hourly_rate,' . $tmp;
                }

                if ($project->rate_daily == 1)
                {
                    $project_billing_info->fields = 'daily_rate,' . $tmp;
                }

                if ($project->rate_semi_monthly == 1)
                {
                    $project_billing_info->fields = 'semi_monthly,' . $tmp;
                }

                if ($project->rate_monthly == 1)
                {
                    $project_billing_info->fields = 'monthly,' . $tmp;
                }

                $project_columns = explode(',', $project_billing_info->fields);
            ?>

            <?php foreach ($billings as $bill): ?>


                

                

                <?php if (in_array('straight_duty', $project_columns)): ?>
                <?php $subtotal_billing += $bill->s_duty; ?>
                <?php endif ?>

                <?php if (in_array('straight_ot_day', $project_columns)): ?>
                <?php $subtotal_billing += $bill->s_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('night_diff', $project_columns)): ?>
                <?php $subtotal_billing += $bill->n_duty; ?>
                <?php endif ?>

                <?php if (in_array('night_ot_diff', $project_columns)): ?>
                <?php $subtotal_billing += $bill->n_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_rate', $project_columns)): ?>
                <?php $subtotal_billing += $bill->rd_duty; ?>
                <?php endif ?>
                
                <?php if (in_array('rest_day_ot_rate', $project_columns)): ?>
                <?php $subtotal_billing += $bill->rd_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_special_holiday', $project_columns)): ?>
                <?php $subtotal_billing += $bill->rd_sh; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_special_ot_holiday', $project_columns)): ?>
                <?php $subtotal_billing += $bill->rd_ot_sh; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_legal_holiday', $project_columns)): ?>
                <?php $subtotal_billing += $bill->rd_lghl; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_legal_ot_holiday', $project_columns)): ?>
                <?php $subtotal_billing += $bill->rd_ot_lghl; ?>
                <?php endif ?>



                <?php if (in_array('special_holiday', $project_columns)): ?>
                <?php $subtotal_billing += $bill->sp_hl_duty; ?>
                <?php endif ?>
                
                <?php if (in_array('special_ot_holiday', $project_columns)): ?>
                <?php $subtotal_billing += $bill->sp_hl_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('legal_holiday', $project_columns)): ?>
                <?php $subtotal_billing += $bill->lg_duty; ?>
                <?php endif ?>
                
                <?php if (in_array('legal_ot_holiday', $project_columns)): ?>
                <?php $subtotal_billing += $bill->lg_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('regular_ot_day', $project_columns)): ?>
                <?php $subtotal_billing += $bill->ot; ?>
                <?php endif ?>
                

                
                <!-- lates and absences -->
                <?php if (in_array('late_amount', $project_columns)): ?>
                <?php $subtotal_billing += $bill->late; ?>
                <?php endif ?>

                <?php if (in_array('absent_rate_per_day', $project_columns)): ?>
                <?php $subtotal_billing += $bill->deduct_absent_per_day; ?>
                <?php endif ?>

                <?php if (in_array('absent_rate', $project_columns)): ?>
                <?php $subtotal_billing += $bill->deduct_absent_per_hr; ?>
                <?php endif ?>

                <?php if (in_array('semi_monthly', $project_columns) && $bill->semi_monthly > 0): ?>
                <?php $subtotal_billing += $bill->semi_monthly; ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><strong><?php echo $bill->cnt_row . ' - ' . $bill->position; ?></strong></td>
                    <td style="text-align:right; font-weight: bold">&nbsp;</td>
                    <td style="text-align:right; font-weight: bold"><?php echo nf(floatval($subtotal_billing)) ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php endif ?>


                <?php if (in_array('monthly', $project_columns)  && $bill->monthly > 0): ?>
                <?php $subtotal_billing += $bill->monthly; ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><strong><?php echo $bill->cnt_row . ' - ' . $bill->position; ?></strong></td>
                    <td style="text-align:right; font-weight: bold">&nbsp;</td>
                    <td style="text-align:right; font-weight: bold"><?php echo nf(floatval($subtotal_billing)) ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php endif ?>
                
                <?php if (in_array('daily_rate', $project_columns) && $bill->daily > 0): ?>
                <?php $subtotal_billing += $bill->daily; ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><strong><?php echo $bill->cnt_row . ' - ' . $bill->position; ?></strong></td>
                    <td style="text-align:right; font-weight: bold">&nbsp;</td>
                    <td style="text-align:right; font-weight: bold"><?php echo nf(floatval($subtotal_billing)) ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php endif ?>

                <?php if (in_array('hourly_rate', $project_columns) && $bill->hourly > 0): ?>
                <?php $subtotal_billing += $bill->hourly; ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><strong><?php echo $bill->cnt_row . ' - ' . $bill->position; ?></strong></td>
                    <td style="text-align:right; font-weight: bold">&nbsp;</td>
                    <td style="text-align:right; font-weight: bold"><?php echo nf(floatval($subtotal_billing)) ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php endif ?>

                <?php $total_billing += $subtotal_billing; ?>
                <?php $subtotal_billing = 0.00; ?>

            <?php endforeach ?>
            <?php $ewt = floatval($total_billing) * 0.02; ?>
            <?php $vat = floatval($total_billing) * 0.12; ?>
            </tbody>
        <tfoot>

            <?php if ($project_billing_info->is_vat == 1): ?>
            <?php $total_billing += floatval($vat); ?>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align:right; font-weight: normal;">12% VAT</td>
                <td style="text-align:right; font-weight: bold;">&nbsp;</td>
                <td style="text-align:right; font-weight: normal;"><?php echo nf($vat) ?></td>
                <td>&nbsp;</td>
            </tr>
            <?php endif ?>

            <?php if ($project_billing_info->is_wt_tax == 1): ?>
            <?php $total_billing -= floatval($ewt); ?>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align:right; font-weight: normal;">Less 2% EWT</td>
                <td style="text-align:right; font-weight: bold;">&nbsp;</td>
                <td style="text-align:right; font-weight: normal;"><?php echo nf($ewt) ?></td>
                <td>&nbsp;</td>
            </tr>
            <?php endif ?>
            
            <tr>
                <td>&nbsp;</td>
                <td style="text-align:left; font-weight: bold; font-size:15px;">GRAND TOTAL</td>
                <td style="text-align:right; font-weight: bold;">PHP</td>
                <td style="text-align:right; font-weight: bold; font-size:15px; border-bottom: 1px double #000;"><?php echo nf(floatval($total_billing)) ?></td>
                <td>&nbsp;</td>
            </tr>
            <?php for ($i=0; $i < 2; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <?php endfor ?>
            <tr>
                <td>&nbsp;</td>
                <?php $my_total = explode('.', $total_billing); ?>
                <td colspan="3">
                    ( 
                        <?php echo ucwords((convert_number_to_words($my_total[0]))); ?>
                        <?php 
                            // if ($my_total[1] > 0)
                            if ( ! empty($my_total[1]))
                            echo ' & ' . substr(nf( '.' . $my_total[1] ),2,10) . '/100';
                        ?>
                         Pesos Only 
                    )
                </td>
            </tr>
            <?php for ($i=0; $i < 11; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <?php endfor ?>            
            <tr>
                <td>&nbsp;</td>
                <td colspan="5"><strong>Mr. Troy Henry G. Nardo</strong></td>
            </tr>
        </tfoot>

        </table>

<?php
/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 9/1/14
 * Time: 2:17 PM
 */ 