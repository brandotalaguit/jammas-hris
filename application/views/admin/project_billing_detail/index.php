<div class="box box-success">
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-bordered table-condensed">
            <thead>
            <tr>
                <th width='1%' rowspan="2">#</th>
                <th width='15%' rowspan="2">Employee Name</th>
                <th width='5%' rowspan="2">Position</th>
                <th width='5%' rowspan="1">Contract</th>
                <th width='5%' rowspan="1">Reg.</th>
                <th width='5%' rowspan="1">Straight</th>
                <th width='5%' rowspan="1">Night</th>
                <th width='5%' rowspan="1">Reg. OT</th>
                <th width='5%' rowspan="1">Less</th>
                <th width='5%' rowspan="1">Total</th>
                <th width='5%' rowspan="2">Action</th>
            </tr>
            <tr>
                <th>Rate/Day</th>
                <th>Days</th>
                <th>Duty</th>
                <th>Diff.</th>
                <th>RFID</th>
                <th>Late</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($project_billing_trans)): ?>
                <?php foreach ($project_billing_trans as $billing): ?>
                    <tr <?php echo $this->session->flashdata('id') == $billing->pbt_id ? "class='success'" : ''; ?> >
                        <td><?php echo ++$counter;?></td>
                        <td><?php echo $billing->lastname . ', ' . $billing->firstname . ' ' . $billing->middlename;?></td>
                        <td><?php echo $billing->position;?></td>
                        <td><?php echo $billing->contract_rate;?></td>
                        <td><input type="text" name="rw_day" value="<?php echo nf($billing->rw_day);?>"/></td>
                        <td><input type="text" name="sd_day" value="<?php echo nf($billing->sd_day);?>"/></td>
                        <td><input type="text" name="sd_ot_day" value="<?php echo nf($billing->sd_ot_day);?>"/></td>
                        <td><input type="text" name="nd_day" value="<?php echo nf($billing->nd_day);?>"/></td>
                        <td><input type="text" name="reg_ot_day" value="<?php echo nf($billing->reg_ot_day);?>"/></td>
                        <td><input type="text" name="late_minutes" value="<?php echo nf($billing->late_minutes);?>"/></td>
                        <td><span class="subtotal"><?php echo nf($subtotal) ?></span></td>
                        <td>
                            <div class="btn-group btn-block">
                                <?php echo btn_edit('projectBillingInfo/'. $project->project_id . '/' . $billing->Id . '/edit');?>
                                <?php echo btn_achor('projectBillingTrans/'. $billing->project_bill_id . '/summary', '<i class="fa fa-th"></i>', 'class="btn btn-info"');?>
                                <?php echo btn_delete('projectBillingInfo/'. $project->project_id . '/' . $billing->Id . '/delete');?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">
                        <p class="label label-danger">No record found!. Please try again.</p>
                    </td>
                </tr>
            <?php endif ?>
            </tbody>

        </table>
        <div class="box-header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">
                        <?php echo anchor(site_url('project'), '<b>Back to projects</b>', ['class' => 'btn btn-default btn-sm'])?>
                    </h3>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        </div>
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
 * Date: 9/1/14
 * Time: 2:17 PM
 */ 