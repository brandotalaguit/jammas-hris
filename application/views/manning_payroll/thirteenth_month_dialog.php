<div class="modal-dialog">
    <div class="modal-content">


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">13<sup>th</sup> Month Benefits Report Options</h4>
</div>
<?php // echo $form_url; ?>
    <?php echo form_open('manning_payroll/thirteenth_month_report', ['class'=>'form-horizontal', 'role' => 'form', 'id'=>'form-thirteenth-month', 'target' => '_blank']); ?>
    <div class="modal-body">

        <label for="payroll_year" class="col-sm-3 control-label"><b>Payroll Period</b></label>
        <div class="form-group">

            <div class="col-sm-3">
                <input type="date" name="date_start" id="date_start" class="form-control" required="required" title="Date Start">
            </div>

            <div class="col-sm-1 control-label">
                <label>To</label>
            </div>

            <div class="col-sm-3">
                <input type="date" name="date_end" id="date_end" class="form-control" required="required" title="Date End">
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

        <!-- <div class="form-group">
            <label for="input" class="col-sm-3 control-label"><b>Scope</b></label>
            <div class="col-sm-8">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="coverage" id="proj_with_13th_only" value="1" required="">
                        Project with 13th ONLY
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="coverage" id="all_qualified_employees" value="2" required="">
                        Compute all qualified employees
                    </label>
                </div>
            </div>
        </div> -->

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

    $(document).on('click', 'input[type=radio][name=scope]', function (e) {
        $value = this.value;
        // Per employee
        if ($value == '1')
        {
            $('#manning_id').prop('disabled', false).val(0).select2({placeholder: "Select employee"});
            $('#project_id').prop('disabled', true).val(0).select2({placeholder: ""});
            $('#manning_id').attr('required', true);
            $('#project_id').prop('required', false);
        }
        // Per project
        else if ($value == '2')
        {
            $('#manning_id').prop('disabled', true).val(0).select2({placeholder: ""});
            $('#project_id').prop('disabled', false).val(0).select2({placeholder: "Select project"});
            $('#manning_id').attr('required', false);
            $('#project_id').prop('required', true);
        }
        else
        {
            $('#manning_id').prop('disabled', true).val(0).select2({placeholder: ""});;
            $('#project_id').prop('disabled', true).val(0).select2({placeholder: ""});;
            $('#manning_id').attr('required', false);
            $('#project_id').prop('required', false);
        }

    })

    $('#form-thirteenth-month').submit(function(e) {

    })






</script>

    </div>
</div>
