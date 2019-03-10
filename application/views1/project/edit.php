

<?php echo $form_url; ?>
<div class="container">
	

<div class="row">
	<div class="col-sm-10">
		
		<label for="title" class="col-sm-2 control-label">Project Title</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="title" id="title" class="form-control" placeholder="Project Title" value="<?php echo set_value('title', $projects->title);?>" autofocus>
			</div>
			<span class="help-block">Name of the project (e.g. <em>Cavitex International</em>) </span>
		</div>

		<label for="address" class="col-sm-2 control-label">Project Address</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="address" id="address" class="form-control" placeholder="Project Address" value="<?php echo set_value('address', $projects->address);?>" autofocus>
			</div>
			<span class="help-block">Project Address (e.g. <em>Brgy. BF Homes, Paranaque</em>) </span>
		</div>

		<label for="business_style" class="col-sm-2 control-label">Business Style</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="business_style" id="business_style" class="form-control" placeholder="Project Address" value="<?php echo set_value('business_style', $projects->business_style);?>">
			</div>
			<span class="help-block">Business Style</span>
		</div>

		<label for="po" class="col-sm-2 control-label">P.O. #</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="po" id="po" class="form-control" placeholder="P.O. #" value="<?php echo set_value('po', $projects->po);?>">
			</div>
			<span class="help-block">P.O. #</span>
		</div>

		<label for="tin" class="col-sm-2 control-label">Tax Identification No.</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="tin" id="tin" class="form-control" placeholder="T.I.N." value="<?php echo set_value('tin', $projects->tin);?>">
			</div>
			<span class="help-block">Tax Identification Number</span>
		</div>
		
		<label for="description" class="col-sm-2 control-label">Description</label>
		<div class="form-group">
			<div class="col-sm-6">			
				<textarea id="description" name="description" class="form-control" rows="3" placeholder="Project Description"><?php echo set_value('description', $projects->description);?></textarea>
			</div>
			<span class="help-block">Nature of the project (<em>e.g. Counter Teller Service</em>)</span>
		</div>


		<div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-10">
			    <div class="radio">
			        <label class="radio-inline">
			            <input type="radio" name="rate" id="optionsRadios4" value="4"
			            <?php $projects->rate_hourly == '1' ? $check = TRUE : $check = FALSE; echo set_radio('rate', '4', $check);?> >
			             Hourly Rate
			        </label>
			        <label class="radio-inline">
			            <input type="radio" name="rate" id="optionsRadios1" value="1"
			            <?php $projects->rate_daily == '1' ? $check = TRUE : $check = FALSE; echo set_radio('rate', '1', $check);?> >
			             Daily Rate
			        </label>
			        <label class="radio-inline">
			            <input type="radio" name="rate" id="optionsRadios2" value="2"
			            <?php $projects->rate_monthly == '1' ? $check = TRUE : $check = FALSE; echo set_radio('rate', '2', $check);?> >
			             Monthly Rate
			        </label>
			        <label class="radio-inline">
			            <input type="radio" name="rate" id="optionsRadios3" value="3"
			            <?php $projects->rate_semi_monthly == '1' ? $check = TRUE : $check = FALSE; echo set_radio('rate', '3', $check);?> >
			             Semi-monthly Rate
			        </label>
			    </div>
			</div>
		</div>




	</div>

</div>

<div class="row">
	<div class="col-sm-10">
	
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-6">
	  <div class="btn-group">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
		  <a href="<?php echo site_url('project')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

</div>