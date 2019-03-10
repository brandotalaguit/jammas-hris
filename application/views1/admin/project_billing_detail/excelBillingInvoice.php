<meta charset="utf-8" />
<?php $cnt_row = 0; ?>
<!-- data souce Project_billing_trans@get_project_summary -->
        <table class="table table-hover table-bordered table-condensed" id="billing" border="0">
            <thead>
            <?php for ($i=0; $i < 3; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>                
            </tr>
            <?php $cnt_row++ ?>
            <?php endfor ?>
            <tr>
                <td>&nbsp;</td>
                <!-- <td colspan="5" width="60%">&nbsp;</td> -->
                <!-- <td colspan="3">&nbsp;</td> -->
                <td colspan="4" align="right" style="text-align:right; padding-right:20px;"><font face="arial"><strong><?php echo date('d-M-y'); ?></strong></font></td>
                <!-- <td align="right" style="padding-right:50px;"><font face="arial"><strong><?php echo date('d-M-y'); ?></strong></font></td> -->
            <?php $cnt_row++ ?>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3" width="60%"><font size="3" face="arial"><strong><?php echo t($project->description); ?></strong></font></td>
            </tr>
            <?php $cnt_row++ ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="4"><?php echo t($project->address); ?></td>
                <td colspan="1">&nbsp;</td>
            <?php $cnt_row++ ?>
            </tr>
            <?php for ($i=0; $i < 9; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <?php $cnt_row++ ?>
            <?php endfor ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5"><font face="Arial" size="12pt"><strong>Billing for Manpower services rendered</strong></font></td>
            <?php $cnt_row++ ?>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5"><font face="Arial" size="12pt"><strong>for the period <?php echo date('F j, Y', strtotime($project_billing_info->date_start)) . ' - ' . date('F j, Y', strtotime($project_billing_info->date_end)) ?></strong></font></td>
            <?php $cnt_row++ ?>
            </tr>
            <tr>
                <th colspan="6">&nbsp;</th>
            <?php $cnt_row++ ?>
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



                <?php if (in_array('semi_monthly', $project_columns) && $bill->semi_monthly > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><strong><?php echo $bill->cnt_row . ' - ' . t($bill->position) . ' @ ' . nf($bill->semi_monthly_rate) . '/head'; ?></strong></td>
                    <td style="text-align:right; font-weight: bold">PHP</td>
                    <td style="text-align:right; font-weight: bold"><?php echo nf(floatval($bill->semi_monthly)) ?></td>
                    <td>&nbsp;</td>
                <?php $subtotal_billing += $bill->semi_monthly; ?>
                <?php $cnt_row++ ?>
                </tr>
                <?php endif ?>


                <?php if (in_array('monthly', $project_columns)  && $bill->monthly > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><strong><?php echo $bill->cnt_row . ' - ' . t($bill->position) . ' @ ' . nf($bill->monthly_rate) . '/head'; ?></strong></td>
                    <td style="text-align:right; font-weight: bold">PHP</td>
                    <td style="text-align:right; font-weight: bold"><?php echo nf(floatval($bill->monthly)) ?></td>
                    <td>&nbsp;</td>
                <?php $subtotal_billing += $bill->monthly; ?>
                <?php $cnt_row++ ?>
                </tr>
                <?php endif ?>
                
                <?php if (in_array('daily_rate', $project_columns) && $bill->daily > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><strong><?php echo $bill->cnt_row . ' - ' . t($bill->position) . ' @ ' . nf($bill->daily_rate) . '/day x ' . $bill->working_days . ' days '; ?></strong></td>
                    <td style="text-align:right; font-weight: bold">PHP</td>
                    <td style="text-align:right; font-weight: bold"><?php echo nf(floatval($bill->daily)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->daily; ?>
                <?php endif ?>
                
                
                <?php if (in_array('hourly_rate', $project_columns) && $bill->hourly > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><strong><?php echo $bill->cnt_row . ' - ' . t($bill->position) . ' @ ' . nf($bill->hourly_rate) . '/day x ' . $bill->working_hours . ' hours '; ?></strong></td>
                    <td style="text-align:right; font-weight: bold">PHP</td>
                    <td style="text-align:right; font-weight: bold"><?php echo nf(floatval($bill->hourly)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->hourly; ?>
                <?php endif ?>
                

                <?php if (in_array('straight_duty', $project_columns) && abs($bill->s_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->sd_day_cnt . ' hrs. straight duty @ ' . $bill->straight_duty; ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->s_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->s_duty; ?>
                <?php endif ?>

                <?php if (in_array('straight_ot_day', $project_columns) && abs($bill->s_ot_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->sd_ot_day_cnt . ' hrs. straight ot @ ' . nf($bill->straight_ot_day); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->s_ot_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->s_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('night_diff', $project_columns) && abs($bill->n_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->nd_day_cnt . ' hrs. night diff @ ' . nf($bill->night_diff); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->n_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->n_duty; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_rate', $project_columns) && abs($bill->rd_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->rd_day_cnt . ' hrs. rest day @ ' . nf($bill->rest_day_rate); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->rd_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->rd_duty; ?>
                <?php endif ?>
                
                <?php if (in_array('rest_day_ot_rate', $project_columns) && abs($bill->rd_ot_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->rd_ot_day_cnt . ' hrs. rest day @ ' . nf($bill->rest_day_ot_rate); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->rd_ot_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->rd_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_special_holiday', $project_columns) && abs($bill->rd_sh) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->rd_sh_day_cnt . ' hrs. rest day @ ' . nf($bill->rest_day_special_holiday); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->rd_sh)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->rd_sh; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_special_ot_holiday', $project_columns) && abs($bill->rd_ot_sh) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->rd_sh_ot_day_cnt . ' hrs. rest day @ ' . nf($bill->rest_day_special_ot_holiday); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->rd_ot_sh)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->rd_ot_sh; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_legal_holiday', $project_columns)  && abs($bill->rd_lghl) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->rd_lg_hl_cnt . ' hrs. rest day / legal hol. @ ' . nf($bill->rest_day_legal_holiday); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->rd_lghl)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->rd_lghl; ?>
                <?php endif ?>

                <?php if (in_array('rest_day_legal_ot_holiday', $project_columns) && abs($bill->rd_ot_lghl) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->rd_lg_ot_hl_cnt . ' hrs. rest day / legal o.t. hol. @ ' . nf($bill->rest_day_legal_ot_holiday); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->rd_ot_lghl)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->rd_ot_lghl; ?>
                <?php endif ?>



                <?php if (in_array('special_holiday', $project_columns) && abs($bill->sp_hl_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->h_day_cnt . ' hrs. spcl. hol. @ ' . nf($bill->special_holiday); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->sp_hl_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->sp_hl_duty; ?>
                <?php endif ?>
                
                <?php if (in_array('special_ot_holiday', $project_columns) && abs($bill->sp_hl_ot_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->h_ot_day_cnt . ' hrs. spcl. hol. o.t. @ ' . nf($bill->special_ot_holiday); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->sp_hl_ot_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->sp_hl_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('legal_holiday', $project_columns) && abs($bill->lg_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->lg_day_cnt . ' hrs. legal. hol. @ ' . nf($bill->legal_holiday); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->lg_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->lg_duty; ?>
                <?php endif ?>
                
                <?php if (in_array('legal_ot_holiday', $project_columns) && abs($bill->lg_ot_duty) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->lg_ot_day_cnt . ' hrs. legal. hol. o.t. @ ' . nf($bill->legal_ot_holiday); ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->lg_ot_duty)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->lg_ot_duty; ?>
                <?php endif ?>

                <?php if (in_array('regular_ot_day', $project_columns) && abs($bill->ot) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->rw_ot_day_cnt . ' hrs. reg. o.t. @ ' . $bill->regular_ot_day; ?></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;"><?php echo nf(floatval($bill->ot)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->ot; ?>
                <?php endif ?>
                

                
                <!-- lates and absences -->
                <?php if (in_array('late_amount', $project_columns) &&  abs($bill->late) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->late_minutes_cnt . ' mins. Lates @ ' . nf($bill->late_amount); ?></strong></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;">( <?php echo nf(floatval($bill->late)) ?> )</td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->late; ?>
                <?php endif ?>

                <?php if (in_array('absent_rate_per_day', $project_columns) && abs($bill->deduct_absent_per_day) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->no_absences_per_day_cnt . ' abs. / day @ ' . nf($bill->absent_rate_per_day); ?></strong></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal;">( <?php echo nf(floatval($bill->deduct_absent_per_day)) ?> )</td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->deduct_absent_per_day; ?>
                <?php endif ?>

                <?php if (in_array('absent_rate', $project_columns) && abs($bill->deduct_absent_per_hr) > 0): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><?php echo $bill->no_absences_per_hr_cnt . ' abs. / hrs. @ ' . nf($bill->absent_rate); ?></strong></td>
                    <td style="text-align:right; font-weight: normal;">&nbsp;</td>
                    <td style="text-align:right; font-weight: normal; border-bottom: 1px solid #000;">( <?php echo nf(floatval($bill->deduct_absent_per_hr)) ?> )</td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <?php $subtotal_billing += $bill->deduct_absent_per_hr; ?>
                <?php endif ?>

                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3" style="text-align:right; font-weight: bold; border-top: 1px solid #000;">Sub-total</td>
                    <td style="text-align:right; font-weight: bold; border-top: 1px solid #000;"><?php echo nf(floatval($subtotal_billing)) ?></td>
                    <td>&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                <?php $cnt_row++ ?>
                </tr>

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
                <td colspan="3" style="text-align:right; font-weight: normal;">12% VAT</td>
                <!-- <td style="text-align:right; font-weight: bold;">&nbsp;</td> -->
                <td style="text-align:right; font-weight: normal;"><?php echo nf($vat) ?></td>
                <td>&nbsp;</td>
            <?php $cnt_row++ ?>
            </tr>
        <?php endif ?>

        <?php if ($project_billing_info->is_wt_tax == 1): ?>
            <?php $total_billing -= floatval($ewt); ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align:right; font-weight: normal;">Less 2% EWT</td>
                <!-- <td style="text-align:right; font-weight: bold;">&nbsp;</td> -->
                <td style="text-align:right; font-weight: normal;"><?php echo nf($ewt) ?></td>
                <td>&nbsp;</td>
            <?php $cnt_row++ ?>
            </tr>
        <?php endif ?>
        
            <tr>
                <td colspan="5">&nbsp;</td>
            <?php $cnt_row++ ?>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2" style="text-align:left; font-weight: bold; font-size:15px;">GRAND TOTAL</td>
                <td style="text-align:right; font-weight: bold;">PHP</td>
                <td style="text-align:right; font-weight: bold; font-size:15px; border-bottom: 1px double #000;"><?php echo nf(floatval($total_billing)) ?></td>
                <td>&nbsp;</td>
            <?php $cnt_row++ ?>
            </tr>
            <?php for ($i=0; $i < 2; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            <?php $cnt_row++ ?>
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
            <?php $cnt_row++ ?>
            </tr>
            <?php for ($i=$cnt_row; $i < 39; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            <?php $cnt_row++ ?>
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