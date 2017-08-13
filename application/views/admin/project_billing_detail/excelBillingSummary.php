<meta charset="utf-8" />
<style type="text/css">
    table { font-family: arial, verdana, calibri; font-size: 12px;}
    td { mso-number-format:"\@";  }
    /*td { mso-number-format:General; }*/
</style>
<?php $total_columns = (count($columns) * 3); ?>
<?php 
    if (in_array('cola', $columns))
    $total_columns-=1;

    // if ($project->rate_daily == 1)
    // $total_columns+=3;

    if ($project->rate_semi_monthly == 1)
    $total_columns-=1;

    if ($project->rate_monthly == 1)
    $total_columns-=1;

    // $total_columns+=6;
    $total_columns+=7;
    

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
                <td style="border: none;" colspan="<?php echo $total_columns - 5 ?>"><strong>: <?php echo t($project->title); ?></strong></td>
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
                
                <?php 
                    $tmp = $billing_info->fields;
                    if ($project->rate_daily == 1)
                    {
                        $billing_info->fields = 'daily_rate,' . $tmp;
                    }

                    if ($project->rate_hourly == 1)
                    {
                        $billing_info->fields = 'hourly_rate,' . $tmp;
                    }
                ?>

                <?php if ($project->rate_semi_monthly == 1): ?>
                <th rowspan="2">Semi-monthly<br>Rate</th>
                <?php endif ?>

                <?php if ($project->rate_monthly == 1): ?>
                <th rowspan="2">Monthly<br>Rate</th>
                <?php endif ?>

                <?php $arr_subtotal = array(); ?>
                <?php foreach (explode(',', $billing_info->fields) as $rate): ?>

                    <?php 
                        $rate_data = explode('|', $billing_rates[$rate]);
                        $rate_basis = $rate_data[0];
                        $rate_title = $rate_data[1];
                        $rate_abbr = $rate_data[2];
                        $rate_legend[] = $rate_data;

                     ?>

                     <?php if (in_array($rate, array_keys($billing_rates))): ?>

                            <?php if ($rate == 'cola'): ?>
                                <th width='2%' rowspan="2">COLA</th>
                            <?php else: ?>
                                <th width='50px' rowspan="2"><?php echo $rate_abbr ?></th>
                                <th width='50px' rowspan="2">x</th>
                                <th width='2%' rowspan="2">Amount</th>
                            <?php endif ?>

                         
                     <?php endif ?>

                

                <?php $arr_subtotal[$rate_abbr] = 0.00; ?>
                <?php $arr_subtotal[$rate_abbr.'_amount'] = 0.00; ?>
                <?php endforeach ?>
                <?php #dump($arr_subtotal) ?>
                <th width='5%' rowspan="2">Total</th>

            </tr>

            </thead>
            </table>
            <table border="1">
            <tbody>
            
            <?php if (count($project_billing_trans)): ?>
                    
                    <?php $subtotal = $grandtotal = $total_semi_monthly = $total_monthly = 0.000; ?>

                    <?php foreach ($project_billing_trans as $billing): ?>
                        <tr>
                            <td class="text-center">
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
                                    if ($billing->remarks) 
                                    {
                                        echo $billing->remarks;
                                    }
                                    else
                                    {
                                        echo $billing->position;
                                    }
                                ?>
                            </td>


                            <?php if ($project->rate_semi_monthly == 1): ?>
                            <td><span class="deci"><?php echo nf($billing->semi_monthly_rate);?></span></td>
                            <?php endif ?>

                            <?php if ($project->rate_monthly == 1): ?>
                            <td><span class="deci"><?php echo nf($billing->monthly_rate);?></span></td>
                            <?php endif ?>


                <?php $subtotal = 0.000; ?>
                <?php foreach (explode(',', $billing_info->fields) as $rate): ?>

                    <?php 
                        $rate_data = explode('|', $billing_rates[$rate]);
                        $rate_basis = $rate_data[0];
                        $rate_title = $rate_data[1];
                        $rate_abbr = $rate_data[2];
                     ?>

                     <?php if (in_array($rate, array_keys($billing_rates))): ?>

                            <?php if ($rate == 'cola'): ?>
                                <td title="COLA"><code class='deci'><?php echo nf($billing->cola) ?></code></td>
                            <?php else: ?>
                                <td>

                                <?php if ($billing->$rate_basis > 0): ?>
                                    <?php echo nf(floatval($billing->$rate_basis)) ?>
                                <?php else: ?>
                                    <span class="text-center">-</span>
                                <?php endif ?>

                                </td>
                                <td>
                                    <?php if ($billing->$rate_basis > 0): ?>
                                    <?php echo floatval($billing->$rate); ?>
                                    <?php else: ?>
                                        <span class="text-center">-</span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if ($billing->$rate_basis > 0): ?>                                    
                                    <?php echo nf(floatval($billing->$rate_basis) * floatval($billing->$rate)); ?>
                                    <?php else: ?>
                                        <span class="text-center">-</span>
                                    <?php endif ?>
                                </td>
                            <?php endif ?>
                         
                     <?php endif ?>

                <?php 
                    $arr_subtotal[$rate_abbr] += floatval($billing->$rate_basis); 
                    $arr_subtotal[$rate_abbr.'_amount'] += floatval($billing->$rate_basis) * floatval($billing->$rate);

                    if (substr($rate_abbr, 0, 4) != 'cola')
                    {
                        $subtotal += (floatval($billing->$rate_basis) * floatval($billing->$rate));
                    }
                ?>

                <?php endforeach ?>

                <?php 
                    if ($project->rate_semi_monthly == 1)
                    {
                        $subtotal += floatval($billing->semi_monthly_rate);
                        $total_semi_monthly += floatval($billing->semi_monthly_rate);
                    }

                    if ($project->rate_monthly == 1)
                    {
                        $subtotal += floatval($billing->monthly_rate);
                        $total_monthly += floatval($billing->monthly_rate);
                    }
                 ?>

                <td>
                    <!-- sub-total -->
                    <?php if ($subtotal > 0): ?>
                    <?php echo nf($subtotal) ?>
                    <?php else: ?>
                    <span class="text-center">-</span>
                    <?php endif ?>
                </td>

            </tr>


                <?php $grandtotal += floatval($subtotal); ?>
                <?php #$subtotal = 0.000; ?>

    <?php endforeach ?>


    <?php #var_dump($arr_subtotal) ?>

               

                <tfoot>
                <tr>
                        <th style="text-align:right" colspan="<?php echo (in_array('cola', $arr_subtotal) ? 3 : 3); ?>">TOTAL</th>
                        
                        <?php if ($project->rate_semi_monthly == 1): ?>
                        <th><?php echo nf(floatval($total_semi_monthly)) ?></th>
                        <?php endif ?>

                        <?php if ($project->rate_monthly == 1): ?>
                        <th><?php echo nf(floatval($total_monthly)) ?></th>
                        <?php endif ?>

                        <?php #$grand_total = 0.00; ?>
                        <?php foreach ($arr_subtotal as $key => $value): ?>
                            <?php if (substr($key, 0, 4) != 'cola'): ?>
                                    <?php #if (substr($key, -7) == '_amount' && substr($key, 0, 4) != 'cola'): ?>
                                    <?php if (substr($key, -7) != '_amount'): ?>
                                    <th>
                                    <?php echo nf(floatval($value)) ?>
                                    </th>
                                    <th>-</th>
                                    <?php else: ?>
                                    <th>
                                    <?php echo nf(floatval($value)) ?>
                                    </th>
                                    <?php endif ?>

                            <?php endif ?>

                        <?php #if (substr($key, -7) == '_amount' && substr($key, 0, 4) != 'cola'): ?>
                        <?php #$grand_total += $value; ?>
                        <?php #endif ?>

                        <?php #$arr_subtotal[$rate_abbr.'_amount']+= $billing->$rate_basis * $billing->$rate; ?>
                        <?php endforeach ?>

                        
                        <th style="font-weight: bold; font-size:15px;"><?php echo nf($grandtotal) ?></th>
                </tr>
                </tfoot>
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
                <td style="border: none;" colspan="<?php echo $total_columns - 5?>">&nbsp;</td>
                <td style="border: none;" colspan="2"></td>
            </tr>
            <?php for ($i=0; $i < 3; $i++) : ?>
            <tr>
                <td style="border: none;" colspan="<?php echo $total_columns ?>">&nbsp;</td>
            </tr>
            <?php endfor ?>            
            <tr>
                <td style="border: none;">&nbsp;</td>
                <td style="border: none;" colspan="2"><strong>Troy Henry G. Nardo</strong></td>
                <td style="border: none;" colspan="<?php echo $total_columns - 5?>">&nbsp;</td>
                <td style="border: none;" colspan="2"></td>
            </tr>
            <?php for ($i=0; $i < 2; $i++) : ?>
            <tr>
                <td style="border: none;" colspan="<?php echo $total_columns ?>">&nbsp;</td>
            </tr>
            <?php endfor ?>
           
                <tr>
                    <td align="right" style="border: none; font-size:8pt; padding-right: 100px" colspan="<?php echo $total_columns?>"><span style="font-weight:bold">LEGENDS</span> : 
            <?php foreach ($rate_legend as $legend): ?>
                    <span style="font-weight:bold"><?php echo strip_tags($legend['2']) ?></span> ( <?php echo strip_tags($legend['1']) ?> )  
            <?php endforeach ?>
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