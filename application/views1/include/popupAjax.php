<?php if ( ! isset($error)): ?>

<?php echo form_open(site_url('project_billing_trans/'. $ppr->ppr_id . '/edit'), ['role' => 'form', 'class' => 'form-inline']); ?>

	<div class="form-group">
	    <label for="input"><?php echo $col ?></label>
	    <input type="text" class="form-control" name="data_value" placeholder="<?php echo get_key($ppr, $col) ?>">
	</div>

	<div class="btn-group">
	  <button type="button" class="btn btn-default"><i class="fa fa-times"></i></button>
	  <button type="button" class="btn btn-default"><i class="fa fa-save"></i></button>
	</div>
	
<?php echo form_close(); ?>

<?php else: ?>
	<?php echo $error; ?>
<?php endif ?>