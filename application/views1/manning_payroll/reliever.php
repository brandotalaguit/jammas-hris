<div class="modal-dialog">
    <div class="modal-content">


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Reliever</h4>
</div>

<?php // echo $form_url; ?>
    <?php echo form_open('manning_payroll/add_reliever', ['class'=>'form-horizontal', 'role' => 'form', 'id'=>'form-contribution']); ?>
    <div class="modal-body">


        <div class="form-group">
            <label for="input_status" class="col-sm-3 control-label"><b>Employment Status</b></label>
            <div class="col-sm-8">
                <div class="radio-inline margin">
                    <label>
                        <input type="radio" name="mr_employment_status_id" id="input_status" value="<?= RELIEVER ?>" required="">
                        Reliever
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="mr_employment_status_id" id="input_status" value="<?= EXTRA_RELIEVER ?>" required="">
                        Extra Reliever
                    </label>
                </div>
            </div>
        </div>

        <label for="manning_id" class="col-sm-3 control-label">Employee</label>
        <div class="form-group">
            <div class="col-sm-8">
                <!-- <select id="manning_id" class="form-control multiple-select2" multiple="multiple"  style="width:100%"></select> -->
                <?php echo form_dropdown(
                                            'mr_manning_id[]',
                                            array(),
                                            NULL,
                                            'id="manning_id" class="form-control multiple-select2" multiple="multiple"  style="width:100%"');
                    ?>

            </div>
        </div>

        <label for="mr_e_cola" class="col-sm-3 control-label">E-COLA</label>
        <div class="form-group">
            <div class="col-sm-8">

                <?php
                    echo form_input(array_merge($form_class, ['name' => 'mr_e_cola', 'id' => 'mr_e_cola', 'value' => set_value('mr_e_cola', 0.00)]));
                    ?>

            </div>
        </div>

        <label for="mr_daily_rate" class="col-sm-3 control-label">Daily Rate</label>
        <div class="form-group">
            <div class="col-sm-8">

                <?php
                    echo form_input(array_merge($form_class, ['name' => 'mr_daily_rate', 'id' => 'mr_daily_rate', 'value' => set_value('mr_daily_rate', 502.00)]));
                    ?>

            </div>
        </div>

        <label for="mr_allowance" class="col-sm-3 control-label">Allowance</label>
        <div class="form-group">
            <div class="col-sm-8">

                <?php
                    echo form_input(array_merge($form_class, ['name' => 'mr_allowance', 'id' => 'mr_allowance', 'value' => set_value('mr_allowance', 0.00)]));
                    ?>

            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-3 control-label">Allowance Mode of Payment</label>
            <div class="col-sm-8">
                <label class="radio-inline">
                  <input type="radio" name="mr_allowance_mode_of_payment" id="allowanceMode1" value="1" > Daily
                </label>
                <label class="radio-inline">
                  <input type="radio" name="mr_allowance_mode_of_payment" id="allowanceMode2" value="2" > Semi-Monthly
                </label>
            </div>
        </div>

    </div>
    <div class="modal-footer clearfix">

    <div class="row">
    <div class="col-md-6">
        <?= form_hidden($hidden); ?>
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
        $('.deci').autoNumeric({'mDec': 2})
        $(".select2, .multiple-select2").select2();
        $reliever_data = <?php echo json_encode($reliever); ?>;
        $extra_reliever_data = <?php echo json_encode($extra_reliever); ?>;
    })

    function refreshSelect($input, data) {
        // $input.html($('<option />')); # if a default blank is needed
        $input.empty();
        for (var key in data) {
            var $option = $('<option />')
                .prop('value', data[key]['id'])
                .text(data[key]['text'])
            ;
            $input.append($option)
        }
        $input.trigger('change');
    }

    $(document).on('click', 'input[type=radio][name=mr_employment_status_id]', function (e) {
        $value = this.value;
        var $input = $('#manning_id');
        // Reliever
        if ($value == '<?= RELIEVER ?>')
        {
            refreshSelect($input, $reliever_data)
        }
        // Extra Reliever
        else if ($value == '<?= EXTRA_RELIEVER ?>')
        {
            refreshSelect($input, $extra_reliever_data)
        }
        else
        {
            $input.empty();
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

    })

    $('#form-contribution').submit(function(e) {

    })

    $('#form-contribution').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });






</script>

    </div>
</div>
