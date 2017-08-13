<style type="text/css">
    #payroll-register {
        /*font-family: Menlo,Monaco,Consolas,"Courier New",monospace;*/
    }
    .lblSearch {
        font-size: 16px;
        line-height: 20px;
        margin-top: 10px;
        font-weight: 600;
    }
</style>
<div class="modal fade" id="payroll-modal">
    
</div>
<div class="modal fade" id="contribution-modal">
    
</div>
<div class="row">
    
    <?= form_open(NULL, ['role' => 'form', 'target' => '_blank', 'id' => 'frmContribution']); ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header pad">
                <label>Payroll Date Filter</label>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-6">
                        <input type="date" class="form-control" name="date_start" placeholder="yyyy-mm-dd">
                    </div>
                    <div class="col-xs-6">
                        <input type="date" class="form-control" name="date_end" placeholder="yyyy-mm-dd">
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>


    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header pad">
                <label>Filter by field</label>
            </div>
            <div class="box-body">
                <div class="row">
                <div class="col-xs-6">
                <?= form_dropdown('by2', $filter_option, $this->input->post('by2'), "class='form-control col-sm-4' style='width:100%' id='by2'"); ?>
                </div>
                <div class="col-xs-6">
                <input type="text" class="form-control" name="search2" id="search2" placeholder="Search term..."  style="width: 100%" value="<?= set_value('search2') ?>">
                </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header pad">
                <label>Payroll Month Year</label>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-6">
                        <?php 
                            echo form_dropdown(
                                    'payroll_month', 
                                    $months, 
                                    $this->input->post('payroll_month'), 
                                    'id="payroll_month" class="form-control" autofocus style="width:100%"'
                                ); 
                            ?>
                    </div>
                    <div class="col-xs-6">
                        <input type="numeric" class="form-control payroll_year" name="payroll_year" placeholder="yyyy">
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
            

</div>
    <div class="box-footer no-padding">
    <p>
    <div class="row">
        <div class="col-md-3">
        <button type="button" data-url="<?= base_url('manning_payroll/pagibig_contribution') ?>" class="btn btn-info btn-block" name="btn_contribution_action" style="" value="pagibig">PAGIBIG Contribution</button>
        </div>
        <div class="col-md-3">
        <button type="button" data-url="<?= base_url('manning_payroll/philhealth_contribution') ?>" class="btn btn-info btn-block" name="btn_contribution_action" style="" value="philhealth">PHILHEALTH Contribution</button>
        </div>
        <div class="col-md-3">
        <button type="button" data-url="<?= base_url('manning_payroll/sss_contribution') ?>" class="btn btn-info btn-block" name="btn_contribution_action" style="" value="sss">SSS Contribution</button>
        </div>
        <div class="col-md-3">
        <!-- <button type="button" data-url="<?= base_url('manning_payroll/other_contribution') ?>" class="btn btn-info btn-block" name="btn_contribution_action" style="" value="other">OTHER Deduction</button> -->
        </div>
    </div>
    </p>
    <p>
        <?= anchor('manning_payroll/contribution'
                                                    , 'Contribution Report'
                                                    , [
                                                        'data-toggle'   => 'modal',
                                                        'data-target'   => '#payroll-modal',
                                                        'data-backdrop' => 'static',
                                                        'data-keyboard' => 'false',
                                                        'class'         => 'btn btn-primary',
                                                    ]); ?>
    </p>
    </div>
<?= form_close(); ?>
<hr>
<div class="box">
<div class="box-header">
    <?= form_open('manning_payroll', ['role' => 'form', 'id' => 'search_payroll']); ?>
    <div class="row pad">
        <div class="col-sm-7">
            <div class="row">
            <div class="col-sm-2">
                <h4>Project</h4>
            </div>
            <div class="col-sm-5">
            <div class="input-group">
            <?= form_dropdown('project_id', $projects, $this->input->post('project_id'), "class='form-control' style='width:99%' id='project_id' data-url='" . base_url('manning_payroll') ."'"); ?>
            <span class="input-group-btn">
            <button class="btn btn-default" name="btn_action" type="submit" value="Search" style="height: 34px;" ><span class="fa fa-search"></span></button>
            </span>
            </div>
            </div>
            </div>
            <code> <?= $this->input->post() ? 'Search Matched Found' : 'Total Record' ?>: <?= nf($total_result, 0) ?></code>
            
        </div>
        <div class="col-sm-5">
        <div class="row">
            <div class="col-xs-12">
                    <div class="col-sm-3"><label class="control-label lblSearch">Search</label></div>
                    <div class="input-group">
                    <?= form_dropdown('by', $search_option, $this->input->post('by'), "class='form-control col-sm-4' style='width:40%' id='by'"); ?>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search term..."  style="width: 60%" value="<?= set_value('search') ?>">
                    <span class="input-group-btn">
                    <button class="btn btn-default" name="btn_action" type="submit" value="Search" style="height: 34px;" ><span class="fa fa-search"></span></button>
                    <?= anchor('manning_payroll', '<span class="fa fa-refresh"></span>', ['style' => 'height: 34px;', 'class' => 'btn btn-default']); ?>
                    </span>
                    </div>
                    <p class="help-block inline">
                        <span class="help-block text-right">Date Format: <code><?= date('Y-m-d') ?></code> </span>
                    </p>
            </div>
        </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<div class="box-body table-responsive no-padding" id="main-content">

<table class="table table-hover table-condensed" id='payroll-register'>
    <thead>
    <tr>
        <th width='1%'>#</th>
        <th width='5%'>Date Encoded</th>
        <th width='20%'>Project Name</th>
        <th width='5%'>Pay Period</th>
        <th width='10%'>Month/Year</th>
        <!-- <th width='5%'>Period Covered</th> -->
        <!-- <th width='5%'>Working Days</th> -->
        <th width='25%'>Wages</th>
        <!-- <th width='5%'>Remarks</th> -->
        <!-- <th width='15%'>Action</th> -->
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
                    <?php if ($row->remarks) echo "<br><code>{$row->remarks}</code>";  ?>
                </td>
                <td><?php echo $row->payroll_period;?></td>
                <td>
                    <?php echo $row->payroll_month . ' ' . $row->payroll_year;?>
                    <p><?= proper_date($row->date_start, 'F j') ?> To: <?= proper_date($row->date_end, 'F j') ?></p>
                </td>
                <!-- <td><?php #echo $row->working_days;?></td> -->
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
                    <?php if ($row->IsFinal == 1): ?>
                    <?php 
                        echo anchor('manning_payroll/earning/' . $row->payroll_id, '<i class="fa fa-th"></i> Earning', ['class' => 'btn btn-primary', 'title' => 'Edit Earning']);
                        echo anchor('manning_payroll/print_payroll/' . $row->payroll_id, '<i class="fa fa-print"></i> Payroll', ['class' => 'btn btn-warning', 'target' => '_blank', 'title' => 'Print Payroll']);
                        echo anchor('manning_payroll/print_payslip/' . $row->payroll_id, '<i class="fa fa-print"></i> Payslip', ['class' => 'btn btn-success', 'target' => '_blank', 'title' => 'Print Payslip']);
                    ?>
                    <?php else: ?>
                        <?= anchor("manning_payroll/update_payroll_data/{$row->payroll_id}", '<i class="fa fa-refresh"></i> &nbsp;', ['class' => 'btn bg-olive', 'title' => 'Update Payroll Data']); ?>
                        <a class="btn btn-info" href="<?php echo base_url('manning_payroll/edit/' . $row->payroll_id) ?>" 
                                data-toggle="modal" data-target="#payroll-modal"
                                data-backdrop="static" 
                                data-keyboard="false"
                            ><i class="fa fa-pencil"></i> Edit</a>
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
</div>
</div>
<script type="text/javascript">
    $(function(){
        $('.payroll_year').datepicker({
          autoclose: true,
              format: "yyyy",
              viewMode: "years", 
              minViewMode: "years",
              startDate: '2014',
              endDate: new Date(),
        });
    })
    $('body').on('click', 'button[type=button][name=btn_contribution_action]', function(e){
        e.preventDefault();
        $('#frmContribution').attr('action', $(this).data('url')).submit();
        // alert($('#frmContribution').attr('action'))
        // $('#frmContribution').submit();
    })
</script>
<script>
    $("body").on("click", ".pagination a", function() {
        var url = $(this).attr('href');
        $("#main-content").fadeOut('slow').fadeIn('fast').load(url);
        return false;
    });

    // $(document).on('change', '#project_id', function(){
    //     // var url = $(this).data('url');
    //     // alert(url);

    //     $('#search_payroll').submit();
    // });

    // var limit = 15;
    // var start = 0;
    // var action = 'inactive';
    
    // function load_more(limit, start, page, targetElement) 
    // {
    //     var form_data = {start: start}
    //     var result = fetchData(form_data, page);
        
    //     result.done(function(data) {
    //         $(targetElement).append(data);
    //         if (data == '') 
    //         {
    //             button = '<button type="button" class="btn btn-info">No Data Found</button>';
    //             action = 'active';
    //         }
    //         else
    //         {
    //             button = '<button type="button" class="btn btn-warning">Please wait ... </button>';
    //             action = 'inactive';

    //         }
    //         $('#load_data_message').html(button);
    //     });

    // }
    
    // if (action == 'inactive')
    // {
    //     action = 'active';
    //     load_more(limit, start, page, targetElement);
    // }

    // $(window).scroll(function(){
    //     if ($(window).scrollTop() + $(window).height() > $('#load_data').height() && action == 'inactive') 
    //     {
    //         action = 'active';
    //         start = start + limit;
    //         setTimeout(function(){
    //             load_more(limit, start, page, targetElement);
    //         }, 1000);
    //     }
    // });

</script>

<?php
/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 8/31/14
 * Time: 9:32 PM
 */