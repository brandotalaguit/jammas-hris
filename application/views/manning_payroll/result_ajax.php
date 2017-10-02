<table class="table table-hover table-condensed" id='payroll-register'>
    <thead>
    <tr>
        <th width='1%'>#</th>
        <th width='8%'>Date Encoded</th>
        <th width='15%'>Project Name</th>
        <!-- <th width='5%'>Pay Period</th> -->
        <th width='15%'>Month/Year</th>
        <th width='25%'>Wages</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($collection)): ?>
        <?php $offset = $counter + 1; ?>
        <?php foreach ($collection as $row): ?>
            <tr >
                <td><?php echo $offset++;?></td>
                <td><?php echo proper_date($row->payroll_date);?></td>
                <td>
                    <?php echo $row->title;?>
                    <?php if ($row->remarks) echo "<code>{$row->remarks}</code>";  ?>
                </td>
                <!-- <td><?php echo $row->payroll_period;?></td> -->
                <td>
                    <p>
                        <?php echo $row->payroll_month . ' ' . $row->payroll_year;?>
                        (<?= proper_date($row->date_start, 'm/j') ?> To: <?= proper_date($row->date_end, 'm/j') ?>)
                        <br><b><?php echo $row->payroll_period ?></b> Pay Period
                    </p>
                </td>
                <td>
                    <p>
                        <?php
                            if (!empty($row->fields))
                            {
                                $display_column = '';
                                foreach (explode(',', $row->fields) as $key)
                                {
                                    $display_column .= $proj_rate_arr[$key] . ', ';
                                }
                                echo substr($display_column, 0, strlen($display_column) - 2);
                            }
                        ?>
                    </p>

                    <h5>ACTION</h5>
                    <div class="btn-group">
                    <?php
                        echo anchor('manning_payroll/edit/' . $row->payroll_id,
                                    '<i class="fa fa-pencil"></i> Edit',
                                    [
                                        'class' => 'btn btn-info',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#payroll-modal',
                                        'data-backdrop' => 'static',
                                        'data-keyboard' => 'false',
                                    ]);
                        echo anchor("manning_payroll/update_payroll_data/{$row->payroll_id}", '<i class="fa fa-refresh"></i> &nbsp;', ['class' => 'btn bg-olive', 'title' => 'Update Payroll Data']);
                        echo anchor('manning_payroll/earning/' . $row->payroll_id, '<i class="fa fa-th"></i> Earning', ['class' => 'btn btn-primary', 'title' => 'Edit Earning']);
                     ?>
                    <?php if ($row->IsFinal == 1): ?>
                    <?php
                        echo anchor('manning_payroll/print_payroll/' . $row->payroll_id, '<i class="fa fa-print"></i> Payroll', ['class' => 'btn btn-warning', 'target' => '_blank', 'title' => 'Print Payroll']);
                        if ($row->w_reliever)
                        echo anchor('manning_payroll/print_reliever_payroll/' . $row->payroll_id, '<i class="fa fa-print"></i> Reliever', ['class' => 'btn btn-warning', 'target' => '_blank', 'title' => 'Print Reliever Payroll']);
                        echo anchor('manning_payroll/print_payslip/' . $row->payroll_id, '<i class="fa fa-print"></i> Payslip', ['class' => 'btn btn-success', 'target' => '_blank', 'title' => 'Print Payslip']);
                        if ($row->w_reliever)
                        echo anchor('manning_payroll/print_reliever_payslip/' . $row->payroll_id, '<i class="fa fa-print"></i> Reliever', ['class' => 'btn btn-success', 'target' => '_blank', 'title' => 'Print Reliever Payslip']);
                    ?>
                    <?php else: ?>
                        <a href="<?php echo base_url("manning_payroll/earning/{$row->payroll_id}") ?>"
                            class="btn btn-primary"><i class="fa fa-th"></i> Earning</a>
                        <?php echo btn_delete("manning_payroll/{$row->payroll_id}/delete", '&nbsp;') ?>
                    <?php endif ?>
                    </div>
                </td>

            </tr>

        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="6" align="center">
                <p class="label label-danger">NO RECORD FOUND.</p>
            </td>
        </tr>
    <?php endif ?>
    </tbody>

</table>

<div class="box-footer clearfix" id="box-pagination">
    <?php
    if (isset($pagination))
        echo $pagination;
    ?>
</div>

