<div class="modal-body">


<?php echo $form_url; ?>

<div class="row">
	<div class="col-sm-7">
		<div class="form-group <?php echo form_error('account_no') ? 'has-error' : '' ?>">
		  <label class="col-sm-4 control-label" for="inputAccount">Account No.</label>
		  <div class="col-sm-8">
		    <input type="text" name="account_no" id="inputAccount" placeholder="Account No." class="form-control" value="<?php echo set_value('account_no', $member->account_no);?>">
		    <?php if (form_error('account_no')): ?>
		    	<span class="help-block"><?php echo form_error('account_no'); ?></span>
		    <?php endif ?>
		  </div>		  
		</div>
		<div class="form-group <?php echo form_error('firstname') ? 'has-error' : '' ?>">
		  <label class="col-sm-4 control-label" for="inputFirstName">First Name</label>
		  <div class="col-sm-8">
		    <input type="text" name="firstname" id="inputfirstname" placeholder="First Name" class="form-control" value="<?php echo set_value('firstname', $member->firstname);?>">
			  <?php if (form_error('firstname')): ?>
			  	<span class="help-block"><?php echo form_error('firstname'); ?></span>
			  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('middlename') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputMiddleName">Middle Name</label>
		  <div class="col-sm-8">
		    <input type="text" name="middlename" id="inputmiddlename" placeholder="Middle Name" class="form-control" value="<?php echo set_value('middlename', $member->middlename);?>">
		    <?php if (form_error('middlename')): ?>
		    	<span class="help-block"><?php echo form_error('middlename'); ?></span>
		    <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('lastname') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputLastName">Last Name</label>
		  <div class="col-sm-8">
		    <input type="text" name="lastname" id="inputlastname" placeholder="Last Name" class="form-control" value="<?php echo set_value('lastname', $member->lastname);?>">
		    <?php if (form_error('lastname')): ?>
		    	<span class="help-block"><?php echo form_error('lastname'); ?></span>
		    <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('civil_status') ? 'has-error' : ''; ?>">
			<label class="col-sm-4 control-label">Civil Status</label>
			<div class="col-sm-8">
				<label class="radio-inline">
				  <input type="radio" name="civil_status" id="inlineradio1" value="S" <?php $member->civil_status == 'S' ? $check = TRUE : $check = FALSE; echo set_radio('civil_status', 'S', $check);?> > Single
				</label>
				<label class="radio-inline">
				  <input type="radio" name="civil_status" id="inlineradio2" value="M" <?php $member->civil_status == 'M' ? $check = TRUE : $check = FALSE; echo set_radio('civil_status', 'M', $check);?> > Married
				</label>
				<label class="radio-inline">
				  <input type="radio" name="civil_status" id="inlineradio3" value="W" <?php $member->civil_status == 'W' ? $check = TRUE : $check = FALSE; echo set_radio('civil_status', 'W', $check);?> > Widowed
				</label>
				<label class="radio-inline">
				  <input type="radio" name="civil_status" id="inlineradio3" value="D" <?php $member->civil_status == 'D' ? $check = TRUE : $check = FALSE; echo set_radio('civil_status', 'D', $check);?> > Divorced
				</label>
				<?php if (form_error('civil_status')): ?>
					<span class="help-block"><?php echo form_error('civil_status'); ?></span>
				<?php endif ?>
			</div>
		</div>
		<div class="form-group <?php echo form_error('date_of_birth') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputdate_of_birth">Date of birth</label>
		  <div class="col-sm-8">
		    <input type="date" name="date_of_birth" id="inputdate_of_birth" placeholder="yyyy-mm-dd" class="form-control" value="<?php echo set_value('date_of_birth', $member->date_of_birth);?>">
		  </div>
		</div>
		<div class="form-group <?php echo form_error('birth_place') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputbirth_place">Place of birth</label>
		  <div class="col-sm-8">
		    <input type="text" name="birth_place" id="inputbirth_place" placeholder="Place of Birth" class="form-control" value="<?php echo set_value('birth_place', $member->birth_place);?>">
		  </div>
		</div>
		<div class="form-group <?php echo form_error('office_id') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputoffice">Office</label>
		  <div class="col-sm-8">
		    <?php echo form_dropdown('office_id', $offices, $this->input->post('office_id') ? $this->input->post('office_id') : $member->office_id, 'id="inputoffice" class="form-control"' ) ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('employment_status_id') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputemployment_status_id">Employment Status</label>
		  <div class="col-sm-8">
		    <?php echo form_dropdown('employment_status_id', $employment_status, $this->input->post('employment_status_id') ? $this->input->post('employment_status_id') : $member->employment_status_id, 'id="inputemployment_status_id" class="form-control"' ) ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('member_status_id') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputmember_status_id">Membership Status</label>
		  <div class="col-sm-8">
		    <?php echo form_dropdown('member_status_id', $member_status, $this->input->post('member_status_id') ? $this->input->post('member_status_id') : $member->member_status_id, 'id="inputmember_status_id" class="form-control"' ) ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('street') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputstreet">Street</label>
		  <div class="col-sm-8">
		    <input type="text" name="street" id="inputstreet" placeholder="Street" class="form-control" value="<?php echo set_value('street', $member->street);?>">
		  <?php if (form_error('street')): ?>
		  	<span class="help-block"><?php echo form_error('street'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('barangay') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputbarangay">Barangay</label>
		  <div class="col-sm-8">
		    <input type="text" name="barangay" id="inputbarangay" placeholder="Barangay" class="form-control" value="<?php echo set_value('barangay', $member->barangay);?>">
		  <?php if (form_error('barangay')): ?>
		  	<span class="help-block"><?php echo form_error('barangay'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('city') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputcity">City</label>
		  <div class="col-sm-8">
		    <input type="text" name="city" id="inputcity" placeholder="City" class="form-control" value="<?php echo set_value('city', $member->city);?>">
		  <?php if (form_error('city')): ?>
		  	<span class="help-block"><?php echo form_error('city'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('occupation') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputoccupation">Occupation</label>
		  <div class="col-sm-8">
		    <input type="text" name="occupation" id="inputoccupation" placeholder="Occupation" class="form-control" value="<?php echo set_value('occupation', $member->occupation);?>">
		  <?php if (form_error('occupation')): ?>
		  	<span class="help-block"><?php echo form_error('occupation'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('present_employer') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputpresent_employer">Present Employer</label>
		  <div class="col-sm-8">
		    <input type="text" name="present_employer" id="inputpresent_employer" placeholder="Present Employer" class="form-control" value="<?php echo set_value('present_employer', $member->present_employer);?>">
		  <?php if (form_error('present_employer')): ?>
		  	<span class="help-block"><?php echo form_error('present_employer'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('salary') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputsalary">Salary</label>
		  <div class="col-sm-8">
		    <input type="text" name="salary" id="inputsalary" placeholder="Salary" class="form-control" value="<?php echo set_value('salary', $member->salary);?>">
		  <?php if (form_error('salary')): ?>
		  	<span class="help-block"><?php echo form_error('salary'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('other_income') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputother_income">Other Income</label>
		  <div class="col-sm-8">
		    <input type="text" name="other_income" id="inputother_income" placeholder="Other Income" class="form-control" value="<?php echo set_value('other_income', $member->other_income);?>">
		  <?php if (form_error('other_income')): ?>
		  	<span class="help-block"><?php echo form_error('other_income'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('nearest_relative') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputnearest_relative">Nearest Relative</label>
		  <div class="col-sm-8">
		    <input type="text" name="nearest_relative" id="inputnearest_relative" placeholder="Nearest Relative" class="form-control" value="<?php echo set_value('nearest_relative', $member->nearest_relative);?>">
		  <?php if (form_error('nearest_relative')): ?>
		  	<span class="help-block"><?php echo form_error('nearest_relative'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('contact_nos') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputcontact_nos">Contact Nos.</label>
		  <div class="col-sm-8">
		    <input type="text" name="contact_nos" id="inputcontact_nos" placeholder="Contact Nos." class="form-control" value="<?php echo set_value('contact_nos', $member->contact_nos);?>">
		  <?php if (form_error('contact_nos')): ?>
		  	<span class="help-block"><?php echo form_error('contact_nos'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('dependent_nos') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputdependent_nos">No. of Dependent</label>
		  <div class="col-sm-8">
		    <input type="text" name="dependent_nos" id="inputdependent_nos" placeholder="Contact Nos." class="form-control" value="<?php echo set_value('dependent_nos', $member->dependent_nos);?>">
		  <?php if (form_error('dependent_nos')): ?>
		  	<span class="help-block"><?php echo form_error('dependent_nos'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('email') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputemail">Primary E-mail</label>
		  <div class="col-sm-8">
		    <input type="text" name="email" id="inputemail" placeholder="info@youremail.com" class="form-control" value="<?php echo set_value('email', $member->email);?>">
		  <?php if (form_error('email')): ?>
		  	<span class="help-block"><?php echo form_error('email'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group <?php echo form_error('email2') ? 'has-error' : ''; ?>">
		  <label class="col-sm-4 control-label" for="inputemail2">Secondary E-mail</label>
		  <div class="col-sm-8">
		    <input type="text" name="email2" id="inputemail2" placeholder="secondary@email.com" class="form-control" value="<?php echo set_value('email2', $member->email2);?>">
		  <?php if (form_error('email2')): ?>
		  	<span class="help-block"><?php echo form_error('email2'); ?></span>
		  <?php endif ?>
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-sm-offset-4 col-sm-8">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg">Save</button>
		  <a href="<?php echo site_url('member')?>" class="btn btn-default btn-lg">Cancel</a>
		  </div>
		</div>

	</div>

</div>

<?php echo form_close(); ?>

</div>