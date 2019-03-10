<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title"><?php echo $title ?></h4>
</div>

<div class="modal-body">

<?php if ($this->session->flashdata('error')): ?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $this->session->flashdata('error'); ?>
	</div>		

<?php endif ?>



<?php echo form_open(NULL, ['class' => 'form-horizontal', 'role' => 'form']); ?>

  <div class="form-group">
    <!-- Username -->
    <label class="col-sm-2 control-label" for="Username">Username</label>
    <div class="col-sm-10">
      <input type="text" id="Username" name="Username" placeholder="Username" class="form-control input-xlarge" autofocus>
    </div>
  </div>

  <div class="form-group">
    <!-- Password-->
    <label class="col-sm-2 control-label" for="Password">Password</label>
    <div class="col-sm-10">
      <input type="password" id="Password" name="Password" placeholder="Password" class="form-control input-xlarge">
    </div>
  </div>
  
  <div class="form-group">
    <!-- Button -->
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
    </div>
  </div>



<?php echo form_close(); ?>

</div>