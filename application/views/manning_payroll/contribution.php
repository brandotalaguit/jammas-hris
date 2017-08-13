<div class="modal-dialog">
    <div class="modal-content">
    
    
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Contribution and Deduction Report Options</h4>
</div>
<?php // echo $form_url; ?>
    <?php echo form_open('manning_payroll/philhealth_contribution', ['class'=>'form-horizontal', 'role' => 'form', 'id'=>'form-contribution', 'target' => '_blank']); ?>
    <div class="modal-body">

        <div class="form-group">
            <label for="report_format" class="col-sm-3 control-label"><b>Report Format</b></label>
            <div class="col-sm-8">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="report_format" id="report_summary" value="1" required="">
                        Summary
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="report_format" id="report_detail" value="2" required="">
                        Details
                    </label>
                </div>
            </div>
        </div>

        <label for="payroll_year" class="col-sm-3 control-label">Payroll Year</label>
        <div class="form-group">

            <div class="col-sm-3">
                <input type="numeric" name="payroll_year" id="payroll_year" class="form-control" required="required" title="Payroll Year">
            </div>

            <label for="payroll_month" class="col-sm-1 control-label">Month</label>
            <div class="col-sm-4">
            <?php 
                echo form_dropdown(
                        'payroll_month', 
                        $months, 
                        NULL, 
                        'id="select2_payroll_month" class="form-control" autofocus style="width:100%"'
                    ); 
                ?>
            </div>

        </div>

        <div class="form-group">
            <label for="input" class="col-sm-3 control-label"><b>Filter</b></label>
            <div class="col-sm-8">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="scope" id="input_emp" value="1" required="">
                        Per Employee
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="scope" id="input_prj" value="2" required="">
                        Per Project
                    </label>
                </div>
            </div>
        </div>

        <label for="manning_id" class="col-sm-3 control-label">Employee</label>
        <div class="form-group">
            <div class="col-sm-8">

                <?php echo form_dropdown(
                                            'manning_id[]', 
                                            $employees, 
                                            NULL, 
                                            'id="manning_id" class="form-control multiple-select2" multiple="multiple"  style="width:100%"'); 
                    ?>

            </div>
        </div>

        <label for="project_id" class="col-sm-3 control-label">Project</label>
        <div class="form-group">
            <div class="col-sm-8">

                <?php echo form_dropdown(
                                            'project_id[]', 
                                            $projects, 
                                            NULL, 
                                            'id="project_id" class="form-control multiple-select2" multiple="multiple"  style="width:100%"'); 
                    ?>

            </div>
        </div>        

        <div class="form-group">
            <label for="input" class="col-sm-3 control-label"><b>Type of Report</b></label>
            <div class="col-sm-8">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="deduction_and_govtdue" id="input1" value="1" required="">
                        Government Due
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="deduction_and_govtdue" id="input2" value="2" required="">
                        Deduction
                    </label>
                </div>
            </div>
        </div>

        <label for="type_of_report" class="col-sm-3 control-label">Contribution</label>
        <div class="form-group">
            <div class="col-sm-8">

                <?php echo form_dropdown(
                                            'contribution', 
                                            $govt_dues, 
                                            NULL, 
                                            'id="contribution" class="form-control" style="width:100%"'
                                        ); 
                    ?>

            </div>
        </div>

        <label for="type_of_report" class="col-sm-3 control-label">Deduction</label>
        <div class="form-group">
            <div class="col-sm-8">

                <?php echo form_dropdown(
                                            'deduction', 
                                            $deductions, 
                                            NULL, 
                                            'id="deduction" class="form-control" style="width:100%"'
                                        ); 
                    ?>

            </div>
        </div>

        

        

    </div>
    <div class="modal-footer clearfix">
        
    <div class="row">
    <div class="col-md-6">
        <button type="submit" id="btn_action" name="btn_action" class="btn btn-primary btn-block">
        SUBMIT
        </button>
        
    </div>
    <div class="col-md-6">
        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
    </div>
    </div>
    </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(function () {
                $('select').val('0');
                $('select').prop('disabled', true)
                $('select[name=payroll_month]').prop('disabled', false)
                $('select[name=payroll_month]').val('')

                console.log('js loaded')
                $(".select2, .multiple-select2").select2();
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
                
        $('#fields').select2();
       
        $("#manning_id").select2({
            minimumInputLength: 0,
            ajax: {
                url: "<?php echo base_url('manning_list/get_employee') ?>",
                dataType: 'json',
                delay: 250,
                type: 'POST',
                data: function (params) {
                    return {
                      search: params.term, // search term              
                    };
                },
                processResults: function (data, params) {   
                    return {                                    
                      results: $.map(data, function (item) {
                            return {
                                text: item.text,                          
                                id: item.id,                                                
                            }                  
                        })                            
                    };
                },          
            },        
        }); 
    })

    $(document).on('click', 'input[type=radio][name=deduction_and_govtdue]', function (e) {
        $value = this.value;
        // Gov't Due's 
        if ($value == '1') 
        {
            $('#contribution').prop('disabled', false).val(1);
            $('#deduction').prop('disabled', true).val(0);
        }
        // Deduction 
        else if ($value == '2') 
        {
            $('#contribution').prop('disabled', true).val(0);
            $('#deduction').prop('disabled', false).val('00001');
        }
        else
        {
            $('#contribution').prop('disabled', true).val(0);
            $('#deduction').prop('disabled', true).val(0);
        }

    })

    $(document).on('click', 'input[type=radio][name=scope]', function (e) {
        $value = this.value;
        // Per employee
        if ($value == '1') 
        {
            $('#manning_id').prop('disabled', false).val(0).select2({placeholder: "Select employee"});
            $('#project_id').prop('disabled', true).val(0).select2({placeholder: ""});
        }
        // Per project 
        else if ($value == '2') 
        {
            $('#manning_id').prop('disabled', true).val(0).select2({placeholder: ""});
            $('#project_id').prop('disabled', false).val(0).select2({placeholder: "Select project"});
        }
        else
        {
            $('#manning_id').prop('disabled', true).val(0).select2({placeholder: ""});;
            $('#project_id').prop('disabled', true).val(0).select2({placeholder: ""});;
        }

    })

    

    $(document).on('click', '#btn_action', function (e) {
        // var form = $(this);
        // form[0].reset();
        // $('#contribution-modal').modal('hide');

        // e.preventDefault();
        // alert('button submit clicked')
        // var type_of_report = $('input[type=radio][name=deduction_and_govtdue]').val()
        // var scope = $('input[type=radio][name=scope]').val()

        // console.log(type_of_report, scope)


        // return false;
    })

    $('#form-contribution').submit(function(e) {



        /*e.preventDefault();
        var form = $(this);

        var $request = $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    $('#message').append('<div class="alert alert-success">' +
                                         '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' + 
                                         ' Data has been saved successfully' + 
                                         '</div>');
                    $('.form-group').removeClass('has-error');
                    $('.text-danger').remove();

                    // reset form
                    form[0].reset();

                    // close messages after seconds
                    $('.alert-success').delay(500).show(10, function(){
                        $(this).delay(3000).hide(10, function(){
                            $(this).remove();
                        })
                    })
                }
                else {
                    $.each(response.messages, function (key, value) {
                        var element = $('#' + key);
                        element.closest('div.form-group')
                               .removeClass('has-error')
                               .addClass(value.length > 0 ? 'has-error' : '')
                               .find('.text-danger')
                               .remove();
                        element.after(value)
                    })
                }
            }
        });*/

    })


    



</script>

    </div>
</div>
