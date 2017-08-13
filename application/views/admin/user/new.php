<div class="modal-body">

<?php echo validation_errors(); ?>
<?php echo form_open(site_url('user/new'), array('class' =>'form-horizontal', 'role' => 'form')); ?>

<div class="row">
	<div class="col-sm-7">
		
		<div class="form-group">
			<label for="LastName" class="col-sm-2 control-label">Lastname</label>
			<div class="col-sm-9">
				<input type="text" name="LastName" id="LastName" class="form-control" placeholder="Lastname" value="<?php echo set_value('LastName');?>">
			</div>
		</div>

		<div class="form-group">
			<label for="FirstName" class="col-sm-2 control-label">Firstname</label>
			<div class="col-sm-9">
				<input type="text" name="FirstName" id="FirstName" class="form-control" placeholder="Firstname" value="<?php echo set_value('FirstName');?>">
			</div>
		</div>

		<div class="form-group">
			<label for="MiddleName" class="col-sm-2 control-label">Middlename</label>
			<div class="col-sm-9">
				<input type="text" name="MiddleName" id="MiddleName" class="form-control" placeholder="Middlename" value="<?php echo set_value('MiddleName');?>">
			</div>
		</div>

		<div class="form-group">
			<label for="Email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-9">
				<input type="text" name="EmailAddress" id="Email" class="form-control" placeholder="info@yourmail.com" value="<?php echo set_value('EmailAddress');?>">
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Birthday</label>
			<div class="col-sm-9">
				<input type="date" name="Birthday" id="password" class="form-control" value="<?php echo set_value('Birthday');?>">
			</div>
		</div>

		<div class="form-group">
			<label for="Username" class="col-sm-2 control-label">Username</label>
			<div class="col-sm-9">
				<input type="text" name="Username" id="Username" class="form-control" placeholder="Username" value="<?php echo set_value('Username');?>">
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-9">
				<input type="password" name="Password" id="password" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Confirm</label>
			<div class="col-sm-9">
				<input type="password" name="ConfirmPassword" id="ConfirmPassword" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">User Role</label>
			<div class="col-sm-9">
				<label class="radio-inline">
				  <input type="radio" name="AccountType" id="inlineradio1" value="S" <?php echo set_radio('AccountType','S');?> > Super Admin
				</label>
				<label class="radio-inline">
				  <input type="radio" name="AccountType" id="inlineradio2" value="A" <?php echo set_radio('AccountType','A');?> > Admin
				</label>
				<label class="radio-inline">
				  <input type="radio" name="AccountType" id="inlineradio3" value="R" <?php echo set_radio('AccountType','R');?> > Registrar's Officer
				</label>
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2"></label>
			<div class="col-sm-9">
				<button type="submit" class="btn btn-primary btn-lg">
					Save
				</button>
				<a href="<?php echo site_url('user')?>" class="btn btn-default btn-lg">Cancel</a>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

</div>