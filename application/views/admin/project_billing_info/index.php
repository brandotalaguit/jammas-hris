<div class="box">
<div class="box-header">
    <div class="row">
        <div class="col-sm-8">
            <h3 class="box-title">
                <?php echo btn_achor('project_employee/'.$project->project_id.'/detail', '<strong><i class="fa fa-home"></i> Project</strong>', array('class' => 'btn btn-default')) ?>
                <?php echo btn_new(site_url('projectBillingInfo/'.$project->project_id.'/new'), 'New Billing Period') ?>
            </h3>
            </div>
        <div class="col-sm-4"></div>
    </div>
</div>
<div class="box-body table-responsive no-padding">
<table class="table table-hover table-condensed">
    <thead>
    <tr>
        <th width='1%'>#</th>
        <th width='10%'>Date From</th>
        <th width='10%'>Date To</th>
        <th width='10%'>Remarks</th>
        <!-- <th width='5%'>Working Days</th> -->
        <th width='15%'>Columns</th>
        <th width='15%'>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($project_billings)): ?>
        <?php foreach ($project_billings as $billing): ?>
            <tr <?php echo $this->session->flashdata('id') == $billing->project_bill_id ? "class='success'" : ''; ?> >
                <td><?php echo ++$counter;?></td>
                <td><?php echo date('F j, Y', strtotime($billing->date_start));?></td>
                <td><?php echo date('F j, Y', strtotime($billing->date_end));?></td>
                <td><?php echo $billing->billing_remarks;?></td>
                <!-- <td><?php #echo $billing->working_days;?></td> -->
                <td>
                    <?php 
                        if (!empty($billing->fields)) 
                        {
                            // echo str_replace(',', ', ', );
                            $display_column = '';
                            foreach (explode(',', $billing->fields) as $key) 
                            {
                                $display_column .= $proj_rate_arr[$key] . ', ';
                            }
                            echo substr($display_column, 0, strlen($display_column) - 2);
                        }
                    ?>
                </td>
                <td>
                    <div class="btn-group btn-block">
                        <?php echo btn_edit('projectBillingInfo/'. $project->project_id . '/' . $billing->project_bill_id . '/edit');?>
                        <?php echo btn_achor('projectBillingTrans/'. $project->project_id . '/' . $billing->project_bill_id . '/summary', '<i class="fa fa-th"></i>', 'class="btn btn-info" title="Billing Summary"');?>
                        <?php echo anchor(site_url('projectBillingTrans/' . $project->project_id . '/'. $billing->project_bill_id . '/download'), '<i class="fa fa-paperclip"></i>', ['class' => 'btn btn-success', 'title' => 'Billing Attachment', 'target' => '_blank'])?>

                        <div class="btn-group" role="group" >
                             <!-- <i class="caret"></i> -->
                           <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Billing Invoice">
                             <i class="fa fa-print"></i>
                           </button>
                           <ul class="dropdown-menu pull-right">
                                <li><?php echo anchor(site_url('projectBillingTrans/' . $project->project_id . '/'. $billing->project_bill_id . '/invoice'), 'Invoice per Position', ['title' => 'Invoice per Position', 'target' => '_blank'])?></li>
                                <li><?php echo anchor(site_url('projectBillingTrans/' . $project->project_id . '/'. $billing->project_bill_id . '/invoice2'), 'Invoice Cost Summary', ['title' => 'Invoice Cost Summary', 'target' => '_blank'])?></li>
                                <li><?php echo anchor(site_url('projectBillingTrans/' . $project->project_id . '/'. $billing->project_bill_id . '/invoice3'), 'Invoice with EW-TAX', ['title' => 'Invoice with EW-TAX', 'target' => '_blank'])?></li>
                           </ul>
                        </div>


                        <?php echo btn_delete('projectBillingInfo/' . $billing->project_bill_id . '/delete');?>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="6">
                <p class="label label-danger">No record found!. Please try again.</p>
            </td>
        </tr>
    <?php endif ?>
    </tbody>

</table>
</div>
<div class="box-footer">
    <?php
    if (isset($pagination))
        echo $pagination;
    ?>
</div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 8/31/14
 * Time: 9:32 PM
 */