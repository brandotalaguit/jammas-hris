<div id="msg" class="alert"></div>

<div class="box box-primary">
    <div class="box-header">
        <div class="row">
            <div class="col-sm-8">
                <h3 class="box-title">
                <?php echo anchor(site_url('project_employee/' . $this->uri->segment(2, 0)) . '/detail', '<strong><i class="fa fa-home"></i> Project</strong>', ['class' => 'btn btn-default'])?>
                <?php echo anchor(site_url('projectBillingInfo/' . $this->uri->segment(2, 0)), '<strong><i class="fa fa-th"></i> Show Billings</strong>', ['class' => 'btn btn-info'])?>
                
                <?php #if (count($project_billing_trans)): ?>
                <?php #echo anchor(site_url('projectBillingTrans/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/download'), '<i class="fa fa-paperclip"></i> Billing Attachment', ['class' => 'btn btn-primary', 'target' => '_blank', 'title' => 'Download Excel Billing Attachment'])?>
                <?php #echo anchor(site_url('projectBillingTrans/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/invoice'), '<i class="fa fa-money"></i> Billing Invoice', ['class' => 'btn btn-primary', 'target' => '_blank', 'title' => 'Download Excel Billing Invoice'])?>
                <?php #echo anchor(site_url('projectBillingTrans/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/invoice2'), '<i class="fa fa-money"></i> Billing Invoice 2', ['class' => 'btn btn-primary', 'target' => '_blank', 'title' => 'Download Excel Billing Invoice2'])?>
                <?php #endif ?>

                <?php echo anchor(site_url('project_employee/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/special_addjustment_personnel'), '<i class="fa fa-plus"></i> Adjustment', ['class' => 'btn btn-success', 'title' => 'Add Adjustment'])?>
                <?php echo anchor(site_url('project_employee/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/add_personnel'), '<i class="ion ion-person-add"></i> Personnel', ['class' => 'btn btn-danger', 'title' => 'Add Personnel to Project'])?>
                </h3>
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
                    if ($project->rate_daily == 1)
                    {
                        $tmp = $billing_info->fields;
                        $billing_info->fields = 'daily_rate,' . $tmp;
                    }

                    if ($project->rate_hourly == 1)
                    {
                        $tmp = $billing_info->fields;
                        $billing_info->fields = 'hourly_rate,' . $tmp;
                    }
                ?>



                <?php if ($project->rate_semi_monthly == 1): ?>
                <th width="3%">Semi-Monthly<br>Rate</th>
                <?php endif ?>

                <?php if ($project->rate_monthly == 1): ?>
                <th>Monthly<br>Rate</th>
                <?php endif ?>

                <?php $arr_subtotal = array(); ?>
                <?php foreach (explode(',', $billing_info->fields) as $rate): ?>

                    <?php 
                        $rate_data = explode('|', $billing_rates[$rate]);
                        $rate_basis = $rate_data[0];
                        $rate_title = $rate_data[1];
                        $rate_abbr = $rate_data[2];
                        
                     ?>

                     <?php if (in_array($rate, array_keys($billing_rates))): ?>

                            <?php if ($rate == 'cola'): ?>
                                <th width='2%' rowspan="2">COLA</th>
                            <?php else: ?>
                                <th width='2%' rowspan="2"><?php echo $rate_title ?></th>
                                <th width='2%' rowspan="2">Amount</th>
                            <?php endif ?>

                         
                     <?php endif ?>

                <?php $arr_subtotal[$rate] = 0.00; ?>
                <?php $arr_subtotal[$rate.'_amount'] = 0.00; ?>                
                    
                <?php endforeach ?>
                <th width='5%' rowspan="1">Total</th>
       
            </tr>
            </thead>
            <tbody>
            <?php if (count($project_billing_trans)): ?>

                <?php $subtotal = $grandtotal = $total_semi_monthly = $total_monthly = $total_cola = 0.000; ?>

                <?php foreach ($project_billing_trans as $billing): ?>
                    <tr <?php echo $this->session->flashdata('id') == $billing->pbt_id ? "class='success'" : ''; ?> >
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
                            <?php echo delete_link('projectBillingTrans/' . $billing->pbt_id . '/' . $this->uri->segment(2, 0) . '/delete'); ?>
                        </td>
                        <td><?php echo $billing->lastname . ', ' . $billing->firstname . ' ' . $billing->middlename;?></td>
                        <?php 
                            if ($project->rate_hourly == 1) 
                            {
                                $position_rates = $billing->hourly_rate;
                            }
                            if ($project->rate_daily == 1) 
                            {
                                $position_rates = $billing->daily_rate;
                            }
                            if ($project->rate_semi_monthly == 1) 
                            {
                                $position_rates = $billing->semi_monthly_rate;
                            }
                            if ($project->rate_monthly == 1) 
                            {
                                $position_rates = $billing->monthly_rate;
                            }
                        ?>
                        <td title="<?php echo t($position_rates) ?>">
                            <?php 
                                // if ($billing->w_adjustment == 1) 
                                if ($billing->remarks) 
                                {
                                    echo $billing->remarks;
                                }
                                else
                                {
                                    echo t($billing->position);
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
                    $total_cola += $billing->cola;
                    $rate_data = explode('|', $billing_rates[$rate]);
                    $rate_pbt = 'r_' . $rate;
                    $rate_basis = $rate_data[0];
                    $rate_title = $rate_data[1];
                    $rate_abbr = $rate_data[2];
                    $rate_amount = $rate_data[3];
                 ?>

                 <?php if (in_array($rate, array_keys($billing_rates))): ?>

                        <?php if ($rate == 'cola'): ?>
                            <td title="COLA"><code class='deci'><?php echo nf($billing->cola) ?></code></td>
                        <?php else: ?>
                            <td>
                                <a href="#" class="editable" data-url="<?php echo base_url("projectBillingTrans/$billing->pbt_id/edit"); ?>" id="<?php echo $billing->pbt_id; ?>" 
                                    data-name="<?php echo $rate_basis ?>" data-type="text" data-title="<?php echo '(' . $rate_title . ' ) x (' . nf(floatval($billing->$rate_pbt)) . ')'; ?>" data-pk="<?php echo $billing->pbt_id; ?>" >
                                    <!-- please clear the issue of decimal places to be used 2 OR 4 -->
                                    <?php echo nf(floatval($billing->$rate_basis)) ?>

                                </a>
                            </td>
                            <td><?php echo nf(floatval($billing->$rate_basis) * floatval($billing->$rate)); ?></td>
                        <?php endif ?>
                     
                 <?php endif ?>

            <?php 
                $arr_subtotal[$rate] += floatval($billing->$rate_basis);
                $arr_subtotal[$rate.'_amount'] += floatval($billing->$rate_basis) * floatval($billing->$rate);

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
             
            <th>
                <!-- sub-total -->
                <?php echo nf(floatval($subtotal)); ?>
            </th>
            </tr>

                <?php $grandtotal += floatval($subtotal); ?>
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
                
                <th class="lead text-right" 
                    colspan="<?php echo (in_array('cola', $arr_subtotal) ? 3 : ($project->rate_daily == 1 ? 3 : 3)); ?>"
                    ><strong>TOTAL</strong></th>

                <?php if ($project->rate_semi_monthly == 1): ?>
                <th><?php echo nf(floatval($total_semi_monthly)) ?></th>
                <?php endif ?>

                <?php if ($project->rate_monthly == 1): ?>
                <th><?php echo nf(floatval($total_monthly)) ?></th>
                <?php endif ?>
                

                <?php #$grand_total = 0.00; ?>
                
                <?php foreach ($arr_subtotal as $key => $value): ?>
                    <?php if (substr($key, 0, 4) != 'cola'): ?>
                        <th id="<?php echo $key ?>">
                            <?php if (substr($key, -7) == '_amount' && substr($key, 0, 4) != 'cola'): ?>
                            <?php echo nf(floatval($value)) ?>
                            <?php else: ?>
                            <?php echo nf(floatval($value)) ?>
                            <?php endif ?>

                        </th>
                    <?php else: ?>
                        
                                <?php if ($key == 'cola') { ?>
                                    <th>
                                        <?php echo nf($total_cola) ?>
                                    </th>
                                <?php } ?>

                    <?php endif ?>

                <?php #if (substr($key, -7) == '_amount' && substr($key, 0, 4) != 'cola'): ?>
                <?php #$grand_total += $value; ?>
                <?php #endif ?>

                <?php #$arr_subtotal[$rate_abbr.'_amount']+= $billing->$rate_basis * $billing->$rate; ?>
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
            
        <?php /*if (count($project_billing_trans)): ?>
        <?php echo anchor(site_url('projectBillingTrans/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/download'), '<i class="fa fa-paperclip"></i> Billing Attachment', ['class' => 'btn btn-success', 'target' => '_blank', 'title' => 'Download Excel Billing Attachment'])?>
        <?php echo anchor(site_url('projectBillingTrans/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/invoice'), '<i class="fa fa-money"></i> Billing Invoice 1', ['class' => 'btn bg-blue', 'target' => '_blank', 'title' => 'Download Excel Billing Invoice 1'])?>
        <?php echo anchor(site_url('projectBillingTrans/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/invoice2'), '<i class="fa fa-money"></i> Billing Invoice 2', ['class' => 'btn bg-blue', 'target' => '_blank', 'title' => 'Download Excel Billing Invoice 2'])?>
        <?php echo anchor(site_url('projectBillingTrans/' . $this->uri->segment(2, 0) . '/'. $this->uri->segment(3, 0) . '/invoice3'), '<i class="fa fa-money"></i> Billing Invoice 3', ['class' => 'btn bg-blue', 'target' => '_blank', 'title' => 'Download Excel Billing Invoice 3'])?>
        <?php endif*/ ?>        
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