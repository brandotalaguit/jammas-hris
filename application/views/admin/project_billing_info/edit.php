

<?php echo $form_url; ?>
<div class="container">


    <div class="row">
        <div class="col-sm-10">

            <label for="title" class="col-sm-2 control-label">Project Title</label>
            <div class="form-group">
                <div class="col-sm-6">
                    <p class="form-control-static"><?php echo $project->title; ?></p>
                </div>
                <span class="help-block">Name of the project (e.g. <em>Cavitex International</em>) </span>
            </div>


                <label class="col-sm-2 control-label">Date from</label>
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="date" name="date_start" class="form-control" placeholder="Date From" value="<?php echo set_value('date_start', $project_billing->date_start) ?>" autofocus>
                    </div>
                    <span class="help-block">Start Date(<em>e.g. 01/01/2014</em>)</span>
                </div>

                <label class="col-sm-2 control-label">Date to</label>
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="date" name="date_end" class="form-control" placeholder="Date To" value="<?php echo set_value('date_end', $project_billing->date_end) ?>">
                    </div>
                    <span class="help-block">End Date(<em>e.g. 01/15/2014</em>)</span>
                </div>

                <label for="remarks" class="col-sm-2 control-label">Remarks</label>
                <div class="form-group">
                    <div class="col-sm-6">          
                        <textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $project_billing->remarks);?></textarea>
                    </div>
                    <span class="help-block">Additional Details</span>
                </div>


                <label class="col-sm-2 control-label">Columns</label>
                <div class="form-group">
                    <div class="col-sm-6">          
                        <!-- <select name="fields" class="multiple-select2" multiple="multiple"> -->
                        <!-- </select> -->
                        <?php echo form_dropdown('fields[]', $columns, $this->input->post('fields[]') ? $this->input->post('fields[]') : explode(',', $project_billing->fields), 'id="fields" class="form-control multiple-select2" multiple="multiple"' ) ?>
                    </div>
                    <span class="help-block">Column to display in the billing report</span>
                </div>

                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="form-group">
                    <div class="col-sm-7">
                        <label>
                            <input type="checkbox" name="is_vat" id="is_vat" value="1" <?php $project_billing->is_vat == '1' ? $check = TRUE : $check = FALSE; echo set_checkbox('is_vat', '1', $check);?> > &nbsp;Include Value Added Tax
                        </label>
                    </div>
                </div>

                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="form-group">
                    <div class="col-sm-7">
                        <label>
                            <input type="checkbox" name="is_wt_tax" id="is_wt_tax" value="1" <?php $project_billing->is_wt_tax == '1' ? $check = TRUE : $check = FALSE; echo set_checkbox('is_wt_tax', '1', $check);?> > &nbsp;Include EW Tax
                        </label>
                    </div>
                </div>
                
                <!-- <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="form-group">
                    <div class="col-sm-7">
                        <label>
                            <input type="checkbox" name="official_time" id="official_time" value="1" <?php $project_billing->official_time == '1' ? $check = TRUE : $check = FALSE; echo set_checkbox('official_time', '1', $check);?> > &nbsp;Display Employees Official Time to Billing Attachment
                        </label>
                    </div>
                </div> -->

        </div>

    </div>

    <div class="row">
        <div class="col-sm-10">

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <div class="btn-group">
                        <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
                        <a href="<?php echo site_url('projectBillingInfo/' . $project->project_id . '/')?>" class="btn btn-default btn-lg">CANCEL</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php echo form_close(); ?>

</div>

<?php
/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 8/31/14
 * Time: 10:55 PM
 */ 