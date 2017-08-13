<?php echo validation_errors(); ?>
<?php echo $form_url; ?>

<div class="row">


	<!-- 1st column members info -->
	<div class="col-sm-7">

		<legend>Personal Information</legend>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputAccount">Account No.</label>
		  <div class="col-sm-8">
		    <input type="text" name="account_no" id="inputAccount" placeholder="Account No." class="form-control" value="<?php echo set_value('account_no', $member->account_no);?>">
		  </div>
		</div>		
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputLastName">Last Name</label>
		  <div class="col-sm-8">
		    <input type="text" name="lastname" id="inputlastname" placeholder="Last Name" class="form-control" value="<?php echo set_value('lastname', $member->lastname);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputFirstName">First Name</label>
		  <div class="col-sm-8">
		    <input type="text" name="firstname" id="inputfirstname" placeholder="First Name" class="form-control" value="<?php echo set_value('firstname', $member->firstname);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputMiddleName">Middle Name</label>
		  <div class="col-sm-8">
		    <input type="text" name="middlename" id="inputmiddlename" placeholder="Middle Name" class="form-control" value="<?php echo set_value('middlename', $member->middlename);?>">
		  </div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Civil Status</label>
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
			</div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputdate_of_birth">Date of birth</label>
		  <div class="col-sm-8">
		    <input type="date" name="date_of_birth" id="inputdate_of_birth" placeholder="yyyy-mm-dd" class="form-control" value="<?php echo set_value('date_of_birth', $member->date_of_birth);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputbirth_place">Place of birth</label>
		  <div class="col-sm-8">
		    <input type="text" name="birth_place" id="inputbirth_place" placeholder="Place of birth" class="form-control" value="<?php echo set_value('birth_place', $member->birth_place);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputdependent_nos">Dependent</label>
		  <div class="col-sm-8">
		    <input type="text" name="dependent_nos" id="inputdependent_nos" placeholder="Contact Nos." class="form-control" value="<?php echo set_value('dependent_nos', $member->dependent_nos);?>">
		  </div>
		</div>

		<legend>Address</legend>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputstreet">Street</label>
		  <div class="col-sm-8">
		    <input type="text" name="street" id="inputstreet" placeholder="Street" class="form-control" value="<?php echo set_value('street', $member->street);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputbarangay">Barangay</label>
		  <div class="col-sm-8">
		    <input type="text" name="barangay" id="inputbarangay" placeholder="Barangay" class="form-control" value="<?php echo set_value('barangay', $member->barangay);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputcity">City</label>
		  <div class="col-sm-8">
		    <input type="text" name="city" id="inputcity" placeholder="City" class="form-control" value="<?php echo set_value('city', $member->city);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputcontact_nos">Contact Nos.</label>
		  <div class="col-sm-8">
		    <input type="text" name="contact_nos" id="inputcontact_nos" placeholder="Contact Nos." class="form-control" value="<?php echo set_value('contact_nos', $member->contact_nos);?>">
		  </div>
		</div>


	</div>
	<!-- end of 1st column -->
	
	<!-- start of 2nd column -->
	<div class="col-sm-5">
		<legend>Employment Information</legend>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputoccupation">Occupation</label>
		  <div class="col-sm-8">
		    <input type="text" name="occupation" id="inputoccupation" placeholder="Occupation" class="form-control" value="<?php echo set_value('occupation', $member->occupation);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputpresent_employer">Present Employer</label>
		  <div class="col-sm-8">
		    <input type="text" name="present_employer" id="inputpresent_employer" placeholder="Present Employer" class="form-control" value="<?php echo set_value('present_employer', $member->present_employer);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputoffice">Office</label>
		  <div class="col-sm-8">
		    <?php echo form_dropdown('office_id', $offices, $this->input->post('office_id') ? $this->input->post('office_id') : $member->office_id, 'id="inputoffice" class="form-control"' ) ?>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputemployment_status_id">Employment Status</label>
		  <div class="col-sm-8">
		    <?php echo form_dropdown('employment_status_id', $employment_status, $this->input->post('employment_status_id') ? $this->input->post('employment_status_id') : $member->employment_status_id, 'id="inputemployment_status_id" class="form-control"' ) ?>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputmember_status_id">Membership Status</label>
		  <div class="col-sm-8">
		    <?php echo form_dropdown('member_status_id', $member_status, $this->input->post('member_status_id') ? $this->input->post('member_status_id') : $member->member_status_id, 'id="inputmember_status_id" class="form-control"' ) ?>
		  </div>
		</div>
		<legend>Net Salary</legend>		
		<div class="form-group">
			<label class="col-sm-4 control-label">15<sup>th</sup></label>
			<div class="col-sm-8">
				<input type="text" class="form-control number" name="salary_15" placeholder="15th" value="<?php echo set_value('salary_15', $salary->salary_15); ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label">30<sup>th</sup></label>
			<div class="col-sm-8">
				<input type="text" class="form-control number" name="salary_30" placeholder="30th" value="<?php echo set_value('salary_30', $salary->salary_30); ?>">
			</div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputother_income">Other Income</label>
		  <div class="col-sm-8">
		    <input type="text" name="other_income" id="inputother_income" placeholder="Other Income" class="form-control" value="<?php echo set_value('other_income', $member->other_income);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="inputnearest_relative">Nearest Relative</label>
		  <div class="col-sm-8">
		    <input type="text" name="nearest_relative" id="inputnearest_relative" placeholder="Nearest Relative" class="form-control" value="<?php echo set_value('nearest_relative', $member->nearest_relative);?>">
		  </div>
		</div>

		<legend>E-mails</legend>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputemail">Primary</label>
		  <div class="col-sm-8">
		    <input type="text" name="email" id="inputemail" placeholder="info@youremail.com" class="form-control" value="<?php echo set_value('email', $member->email);?>">
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="inputemail2">Secondary</label>
		  <div class="col-sm-8">
		    <input type="text" name="email2" id="inputemail2" placeholder="secondary@email.com" class="form-control" value="<?php echo set_value('email2', $member->email2);?>">
		  </div>
		</div>		


	</div>
	<!-- end of 2nd column -->



</div>

<br><br>
<div class="row">
	
	<div class="form-group">
	  <div class="col-sm-8">
	  <div class="btn-group">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
		  <a href="<?php echo site_url('member')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>
</div>

<?php echo form_close(); ?>

<script>
	$(function () {
		// $('.number').number(true, 2);
		$('.number').autoNumeric('init', {'mDec':<?php echo DECIMAL_PLACES ?>});
	})
</script>