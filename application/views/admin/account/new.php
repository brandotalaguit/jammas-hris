<div class="modal-body">

<?php echo validation_errors(); ?>
<?php echo form_open(site_url('account/new'), array('class' =>'form-horizontal', 'role' => 'form')); ?>

<div class="row">
	<div class="col-sm-7">
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputChargeCode">Charge Code</label>
		  <div class="col-sm-8">
		    <input type="text" name="charge_code" id="inputChargeCode" placeholder="Charge Code" class="form-control" value="<?php echo set_value('charge_code', $account->charge_code);?>">
		  </div>
		</div>		
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputDescription">Description</label>
		  <div class="col-sm-8">
		    <input type="text" name="charge_description" id="inputDescription" placeholder="Charge Description" class="form-control" value="<?php echo set_value('charge_description', $account->charge_description);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputcharge_type">Charge Type</label>
		  <div class="col-sm-8">
		    <?php echo form_dropdown('charge_type_id', $charge_type, $this->input->post('charge_type_id') ? $this->input->post('charge_type_id') : $account->charge_type_id, 'id="inputcharge_type" class="form-control"' ) ?>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputremarks">Remarks</label>
		  <div class="col-sm-8">
		    <input type="text" name="remarks" id="inputremarks" placeholder="Remarks" class="form-control" value="<?php echo set_value('remarks', $account->remarks);?>" >
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-sm-offset-4 col-sm-8">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg">Save</button>
		  <a href="<?php echo site_url('account')?>" class="btn btn-default btn-lg">Cancel</a>
		  </div>
		</div>

	</div>

</div>

<?php echo form_close(); ?>

</div>