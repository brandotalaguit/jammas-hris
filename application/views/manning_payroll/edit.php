<div class="modal-dialog">
    <div class="modal-content">
    
    
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"> <?php echo $this->uri->segment(3) > 0 ? '<i class="fa fa-pencil"></i> Edit' : '<i class="fa fa-plus"></i> New' ?> Project Payroll</h4>
</div>
<?php // echo $form_url; ?>
    <?php echo form_open('manning_payroll/validate/' . $this->uri->segment(3), ['class'=>'form-horizontal', 'role' => 'form', 'id'=>'form-manning-payroll']); ?>
    <div class="modal-body">
        <style type="text/css">
            .dt {
                font-weight: bold;
                margin-bottom: 0px;
            }
            .dd, .dt {
                display: block;
                margin-top: 10px;
                margin-bottom: 10px;

            }
        </style>
        
        <label for="title" class="col-sm-3 control-label">Project</label>
        <div class="form-group">
            <div class="col-sm-8">

            <?php if (empty($payroll->project_id)): ?>

                <?php echo form_dropdown('project_id', $projects, $this->input->post('project_id') ? $this->input->post('project_id') : $payroll->project_id, 'id="select2_project_id" class="form-control" autofocus style="width:100%" dataURL="' . base_url('manning_payroll/select2project') . '"') ?>
                <p class="help-block project_id">Choose project</p>

            <?php else: ?>

                <p class="form-control-static"><b><?php echo $payroll->title ?></b></p>
                <p class="help-block project_id"><?php echo $payroll->description ?></p>
                <?php echo form_hidden($hidden); ?>
            <?php endif ?>

            </div>
        </div>

        <label for="payroll_month" class="col-sm-3 control-label">Payroll Month</label>
        <div class="form-group">
            <div class="col-sm-3">
            <?php 
                echo form_dropdown(
                        'payroll_month', 
                        $months, 
                        $this->input->post('payroll_month') ? $this->input->post('payroll_month') : $payroll->payroll_month, 
                        'id="select2_payroll_month" class="form-control" autofocus style="width:100%"'
                    ); 
                ?>
            <p class="help-block payroll_month"></p>
            </div>

            <label for="payroll_year" class="col-sm-1 control-label">Year</label>

            <div class="col-sm-3">
                <input type="numeric" name="payroll_year" id="payroll_year" class="form-control" value="<?php echo set_value('payroll_year', $payroll->payroll_year) ?>" required="required" title="Payroll Year">
                <p class="help-block payroll_year"></p>
            </div>
        </div>
        <?php echo form_hidden('payroll_date', $payroll->payroll_date); ?>

        <?php  ?>
        <label class="col-sm-3 control-label">Payroll Period</label>
        <div class="form-group">
            <div class="col-sm-8">
                <label class="radio-inline">
                  <input type="radio" name="payroll_period" id="payroll_period1" value="1st" <?php $payroll->payroll_period == '1st' ? $check = TRUE : $check = FALSE; echo set_radio('payroll_period', '1st', $check);?> > 1st
                </label>
                <label class="radio-inline">
                  <input type="radio" name="payroll_period" id="payroll_period2" value="2nd" <?php $payroll->payroll_period == '2nd' ? $check = TRUE : $check = FALSE; echo set_radio('payroll_period', '2nd', $check);?> > 2nd
                </label>
                
                <p class="help-block payroll_period"></p>
            </div>
        </div>

        <label for="date_start" class="col-sm-3 control-label">Period Covered</label>
        <div class="form-group">
            <div class="col-sm-3">
                <input type="date" name="date_start" id="date_start" class="form-control" placeholder="Date from" value="<?php echo set_value('date_start', $payroll->date_start);?>">
                <p class="help-block date_start"></p>
            </div>
            <div class="col-sm-1">
            <label for="date_end" class="control-label">To</label>
            </div>
            <div class="col-sm-3">
                <input type="date" name="date_end" id="date_end" class="form-control" placeholder="Date to" value="<?php echo set_value('date_end', $payroll->date_end);?>">
                <p class="help-block date_end"></p>
            </div>
        </div>

        <label class="col-sm-3 control-label">Wages</label>
        <div class="form-group">
            <div class="col-sm-8">          
                <?php echo form_dropdown('fields[]', $columns, $this->input->post('fields[]') ? $this->input->post('fields[]') : explode(',', $payroll->fields), 'id="fields" style="width:100%" class="form-control multiple-select2" multiple="multiple"' ) ?>
                <p class="help-block fields">Note: Hourly Rate, Semi-Monthly Rate, Monthly Rate, E-COLA and Allowance are automatically included.</p>
            </div>
        </div>

        <label for="remarks" class="col-sm-3 control-label">Remarks</label>
        <div class="form-group">
            <div class="col-sm-8">
                <textarea id="remarks" name="remarks" class="form-control" rows="2" placeholder="Remarks"><?php echo set_value('remarks', $payroll->remarks);?></textarea>
                <p class="help-block remarks"></p>
            </div>
        </div>

    </div>
    <div class="modal-footer clearfix">
        
    <div class="row">
    <div class="col-md-6" id="row-action1">
        <button type="button" id="btn_payroll_action" name="btn_action" class="btn btn-primary btn-block">
        <?php if ($this->uri->segment(3)): ?>
            <b>SAVE CHANGES</b>
        <?php else: ?>
            <b>CREATE PAYROLL</b>
        <?php endif ?>
        </button>
        
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
        
    </div>
    </div>
    </div>
<?php echo form_close(); ?>
<!-- <script type="text/javascript">
    $(function(){
        $('select').css('width', '100%').select2();
    })
</script> -->

<script type="text/javascript">
    $(function () {
        // jQuery.ajax({
        //       url: "<?php #echo base_url() ?>assets/js/scripts.js",
        //       dataType: "script",
        //       cache: true
        // }).done(function() {
                // console.log('js loaded')
                $('input[type=date], .dtpicker').datepicker({
                  format: "yyyy-mm-dd",
                  startView: 0,
                  forceParse: true,
                  autoclose: true,
                  todayHighlight: true
                });

                $('input[name=payroll_year]').datepicker({
                    autoclose: true,
                        format: "yyyy",
                        viewMode: "years", 
                        minViewMode: "years",
                        startDate: '2014',
                        endDate: new Date(),
                });
                
                // dataURL = $('#select2_project_id').attr('dataURL');

                var $element = $('#select2_project_id').select2({dropdownParent: $('#payroll-modal')});
                /*var $element = $('#select2_project_id').select2({
                    ajax: {
                        type: "POST",
                        url: dataURL,
                        data: function (params) {
                         // Query paramters will be ?search=[term]&page=[page]
                         return {
                             search: params.term,
                             pageLimit: 15
                         }
                        },
                        processResults: function (data, page) { 
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                       id: item.id,
                                       text: item.title + '-' + item.description,
                                       title: item.title,
                                       description: item.description,
                                    };
                                })
                            };
                            
                        },
                        dataType: 'json',
                        cache: true,
                        delay: 250,
                    },
                    id: function (item) { return { id: item.id }; },
                    escapeMarkup: function(m) { return m; },
                    templateResult: formatResult,
                    templateSelection: formatSelection,
                    dropdownParent: $('#payroll-modal'),
                });
                // $('#select2_project_id').val(<?php #$echo $payroll->project_id ?>).trigger('change.select2');
                function formatResult(data) 
                {
                    if (data.loading) return data.text;
                    return '<h5 style="margin-bottom: 0px;">' + data.title + '</h5>' + '<small>' + data.description + '</small>';
                }

                function formatSelection(data) 
                {
                    // console.log(data)
                    $('p.project_title').html(data.description)
                    return data.description
                }


                
                /*var fetchData = function(form_data, dataURL, dataTYPE = 'json', method = 'POST') {
                    // Return the $.ajax promise
                    return $.ajax({
                        data: form_data,
                        type: method,
                        dataType: dataTYPE,
                        url: dataURL,
                        cache: false
                    });
                }

                function failed_ajax_request(jqXHR, textStatus, errorThrown) {

                  console.log(textStatus + ': ' + errorThrown);
                    alert(textStatus + ': ' + errorThrown);
                  // location.reload();

                }*/


                /*$(document).on('click', '#btn_action', function(e) {

                    e.preventDefault();
                    $input = $('#btn_action');
                    $input.attr('disabled', true);

                    $form = $('#form-manning-payroll')
                    form_data = $form.serializeArray()
                    form_data.push(
                        {name : 'project_id', value: $('[name=project_id]').val()}, 
                        {name: 'fields', value: $('[name="fields[]"]').val()},
                        {name: 'payroll_period', value: $('[name=payroll_period]:checked').val()}
                    )

                    form_data = $.param(form_data)
                    ajax_request = fetchData(form_data, $form.attr('action'))
                    // console.log(form_data);
                    ajax_request.done(function(data){
                      // console.log(data)
                      

                      if (data.status == 'success') 
                      {
                        // window.location.replace(data.url)
                        $input.css('display', 'none');
                        $input.css('visiblity', 'hidden');
                        $button = '<a href="<?php echo base_url('manning_payroll') ?>" class="btn btn-success btn-block">Proceed to payroll earning</a>';
                        $('#row-action1').append($button);
                      }
                      else
                      {
                          $.each(data.post_error, function(key, value){
                            $('p.'+key).removeClass('help-block').addClass('text-danger').html(value)
                          })
                          $input.removeAttr('disabled');
                      }
                    }).fail(function(jqXHR, textStatus, errorThrown){ 
                      return failed_ajax_request(jqXHR, textStatus, errorThrown); 
                    });
                })*/
        // });



        // if ($('#select2_project_id').find('option:selected').text().trim() != "") 
        // {
        //     $('#select2_project_id').change();
        //     console.log('changes')
        // }
        $('#fields').select2();
        // $('#fields').empty();
        // $(document).on('change', '#select2_project_id', function() {
            // $project_id = $('select#select2_project_id.form-control').val();
            // console.log($project_id)
            // if ($project_id)
            // {
            // console.log(this.value)
            // console.log($element)
            //     var request = $.ajax({
            //             data: {project_id: $project_id},
            //             type: 'post',
            //             dataType: 'json',
            //             url: "<?php #echo base_url('manning_payroll/select2rates') ?>",                        
            //             cache: true
            //         });
            //     request.done(function(data){
            //         console.log('here')
            //         console.log(data)
            //         $('#fields').select2({data:data}).trigger("change");
            //         // $('#fields').select2("val", {data:data} ).trigger("change");
            //     })
            // }
            // else
            // {
            // }
        // })

    })
</script>

    </div>
</div>
<?php
/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 8/31/14
 * Time: 10:55 PM
 */ 