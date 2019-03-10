

<?php if (validation_errors()): ?>
	
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>The following errors have occurred.</strong>
		<ul>			
			<?php echo validation_errors(); ?>
		</ul>
	</div>

<?php endif ?>



<?php echo $form_url; ?>

<div class="row">
	<div class="col-sm-6">
		
		<div class="form-group">
			<label for="LastName" class="col-sm-2 control-label">Lastname</label>
			<div class="col-sm-9">
				<input type="text" name="LastName" id="LastName" class="form-control" placeholder="Lastname" value="<?php echo set_value('LastName', $user->LastName);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="FirstName" class="col-sm-2 control-label">Firstname</label>
			<div class="col-sm-9">
				<input type="text" name="FirstName" id="FirstName" class="form-control" placeholder="Firstname" value="<?php echo set_value('FirstName', $user->FirstName);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="MiddleName" class="col-sm-2 control-label">Middlename</label>
			<div class="col-sm-9">
				<input type="text" name="MiddleName" id="MiddleName" class="form-control" placeholder="Middlename" value="<?php echo set_value('MiddleName', $user->MiddleName);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="Email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-9">
				<input type="text" name="EmailAddress" id="Email" class="form-control" placeholder="info@yourmail.com" value="<?php echo set_value('Email', $user->EmailAddress);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Birthday</label>
			<div class="col-sm-9">
				<input type="date" name="Birthday" id="password" class="form-control" value="<?php echo set_value('Birthday', $user->Birthday);?>">
			</div>
		</div>

	</div>
	<!-- end of 1st column -->

	<div class="col-sm-6">
		<div class="form-group">
			<label for="Username" class="col-sm-2 control-label">Username</label>
			<div class="col-sm-9">
				<input type="text" name="Username" id="Username" class="form-control" placeholder="Username" value="<?php echo set_value('Username', $user->Username);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-9">
				<input type="password" name="Password" id="password" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label for="ConfirmPassword" class="col-sm-2 control-label">Confirm</label>
			<div class="col-sm-9">
				<input type="password" name="ConfirmPassword" id="ConfirmPassword" class="form-control">
			</div>
		</div>

		<?php if ($user->AccountType !== 'S'): ?>
			
				<?php if ($this->session->userdata('AccountType') === 'S') : ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">User Role</label>
					<div class="col-sm-9">
						<!-- <label class="radio-inline">
						  <input type="radio" name="AccountType" id="inlineradio1" value="S" <?php $user->AccountType == 'S' ? $check = TRUE : $check = FALSE; echo set_radio('AccountType', 'S', $check);?> > Super Admin
						</label> -->
						<label class="radio-inline">
						  <input type="radio" name="AccountType" id="inlineradio2" value="A" <?php $user->AccountType == 'A' ? $check = TRUE : $check = FALSE; echo set_radio('AccountType', 'A', $check);?> > Admin
						</label>
						<label class="radio-inline">
						  <input type="radio" name="AccountType" id="inlineradio3" value="U" <?php $user->AccountType == 'U' ? $check = TRUE : $check = FALSE; echo set_radio('AccountType', 'U', $check);?> > User
						</label>
					</div>
				</div>
				<?php endif ?>
		
		<?php endif ?>

	</div>
	<!-- end of 2nd column -->

</div>
<!-- end of row -->


<div class="row">
	<div class="col-sm-6">
	
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-6">
	  <div class="btn-group">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
		  <a href="<?php echo site_url('user')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

