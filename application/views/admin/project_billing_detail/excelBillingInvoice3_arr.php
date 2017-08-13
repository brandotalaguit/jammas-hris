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
                <td colspan="3"><strong><?php echo t($project->description); ?></strong></td>
                <td>&nbsp;</td>
                <td align="right"><strong><?php echo date('d-M-y'); ?></strong></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><strong><?php echo t($project->address); ?></strong></td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <?php for ($i=0; $i < 5; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <?php endfor ?>


            <?php $title_flag = FALSE; ?>
            <?php foreach ($projects as $key => $project): ?>
            <?php endforeach ?>
                        <?php 
                            $subtotal_billing = 0.00; 
                            $cnt_emp = 0.00; 
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



                            <?php $cnt_emp += $bill->cnt_emp ?>



                            <?php if (in_array('semi_monthly', $project_columns) && $bill->semi_monthly > 0): ?>
                            <?php $subtotal_billing += $bill->semi_monthly; ?>
                            <?php endif ?>


                            <?php if (in_array('monthly', $project_columns)  && $bill->monthly > 0): ?>
                            <?php $subtotal_billing += $bill->monthly; ?>                            
                            <?php endif ?>
                            
                            <?php if (in_array('daily_rate', $project_columns) && $bill->daily > 0): ?>
                            <?php $subtotal_billing += $bill->daily; ?>
                            <?php endif ?>

                            <?php if (in_array('hourly_rate', $project_columns) && $bill->hourly > 0): ?>
                            <?php $subtotal_billing += $bill->hourly; ?>
                            <?php endif ?>

                            <?php $total_billing += $subtotal_billing; ?>
                            <?php $subtotal_billing = 0.00; ?>

                        <?php endforeach ?>

                        
                        <?php $admin_margin = floatval($total_billing) * 0.08; ?>
                        <?php $vat = (floatval($total_billing) + floatval($admin_margin))* 0.12; ?>
                        <?php $ew_tax = (floatval($total_billing) + floatval($admin_margin)) * 0.02; ?>

            <tr>
                <td>&nbsp;</td>
                <td colspan="5"><font face="Arial" size="12pt"><strong>Billing for Services rendered for the period of </strong></font></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5"><font face="Arial" size="12pt"><strong><?php echo date('F j, Y', strtotime($project_billing_info->date_start)) . ' - ' . date('F j, Y', strtotime($project_billing_info->date_end)) ?> of <?php echo $cnt_emp ?> personnels assigned at</strong></font></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="5"><font face="Arial" size="12pt"><strong><?php echo ucwords(strtolower($project->description)); ?></strong> details as follow</font></td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            

            <tbody>

            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><font face="Arial" size="12pt"><strong>I. Employees Salaries</strong></font></td>
                <td style="text-align:right; font-weight: bold;">&nbsp;</td>
                <td style="text-align:right; font-weight: normal;"><?php echo nf($total_billing); ?></td>
            </tr>

            <tr>
                <?php 
                    $total_billing += $admin_margin; 
                ?>
                <td>&nbsp;</td>
                <td colspan="3"><font face="Arial" size="12pt"><strong>II. Administrative Margin ( 8% )</strong></font></td>
                <td style="text-align:right; font-weight: bold;">&nbsp;</td>
                <td style="text-align:right; font-weight: normal;"><?php echo nf($admin_margin); ?></td>
            </tr>
            
            <?php if ($project_billing_info->is_vat == 1): ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><font face="Arial" size="12pt"><strong>III. Value Added Tax ( 12% )</strong></font></td>
                <td style="text-align:right; font-weight: bold; color: red"><?php // echo nf($total_billing) ?></td>
                <td style="text-align:right; font-weight: normal;"><?php echo nf($vat); ?></td>
                <?php $total_billing += floatval($vat); ?>
            </tr>
            <?php endif ?>

            <tr>
                <td>&nbsp;</td>
                <td colspan="3" style="text-align:left; font-weight: bold; font-size:12px;">Total</td>
                <td style="text-align:right; font-weight: bold;">PHP</td>
                <td style="text-align:right; font-weight: bold; font-size:15px; border-bottom: 1px solid #000;"><?php echo nf(floatval($total_billing)) ?></td>
                <td>&nbsp;</td>
            </tr>
            

            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><font face="Arial" size="12pt"><strong>IV. Less: EW Tax ( 2% )</strong></font></td>
                <td style="text-align:right; font-weight: bold; color: red">&nbsp;</td>
            <?php if ($project_billing_info->is_wt_tax == 1): ?>
                <td style="text-align:right; font-weight: normal;">( <?php echo nf($ew_tax); ?> )</td>
                <?php $total_billing -= floatval($ew_tax); ?>
            <?php else: ?>
                <td style="text-align:right; font-weight: normal;">-</td>
            <?php endif ?>
            </tr>

            <?php #if ($project_billing_info->is_vat == 1): ?>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><font face="Arial" size="12pt"><strong>V. Cash Advance</strong></font></td>
                <td style="text-align:right; font-weight: bold; color: red">&nbsp;</td>
                <td style="text-align:right; font-weight: bold; font-size:15px; border-bottom: 1px solid #000;"> - </td>
            </tr>
            <?php #endif ?>
            
            <tr>
                <td colspan="5">&nbsp;</td>
                <td style="text-align:right; font-weight: bold; font-size:15px; border-bottom: 1px solid #000;">&nbsp;</td>
            </tr>



            <tr>
                <td>&nbsp;</td>
                <td colspan="3"><font face="Arial" size="12pt"><strong>Total Amount Due</strong></font></td>
                <td style="text-align:right; font-weight: bold; color: red">&nbsp;</td>
                <td style="text-align:right; font-weight: bold; font-size:15px; border-bottom: 1px double #000;"><?php echo nf($total_billing); ?></td>
            </tr>




            </tbody>
        <tfoot>

            <?php for ($i=0; $i < 2; $i++) : ?>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <?php endfor ?>
            <tr>
                <td>&nbsp;</td>
                <?php $my_total = explode('.', $total_billing); ?>
                <td colspan="5">
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
            
            
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>               
                <td colspan="5">
                    pls. see attached summary..
                </td>
            </tr>


            <?php for ($i=0; $i < 5; $i++) : ?>
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
 * Date: 7/16/15
 * Time: 11:45 AM
 */ 