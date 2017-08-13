<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='5%'>ID</th>
			<th width='15%'>PERIOD</th>
			<th width='10%'>EMPLOYEE TYPE</th>
			<th width='10%'>LOAN TYPE</th>
			<th width='12%'>DAY OF THE MONTH</th>
			<th width='12%' class="text-left">COLLECTION AMOUNT</th>
			<th width='10%'>EXPLANATIONS</th>
			<th width='3%'>ENCODER</th>
			<th width='5%'>STATUS</th>
			<th class='text-center' width='10%'>ACTION</th>
		</tr>
	</thead>
	<tbody>
		<?php $subtotal = 0.00; ?>
		<?php if (count($salary_period)): ?>
			<?php foreach ($salary_period as $period): ?>
				<?php $receipt_id = intval($period->cash_receipt_book_id); ?>
				<tr <?php echo $this->session->flashdata('id') == $period->salary_period_id ? "class='success'" : ''; ?> >
					<td><?php echo $period->salary_period_id;?></td>
					<td><?php echo date_convert_to_php($period->date_start, 'M d, y') . " - ". date_convert_to_php($period->date_end, 'M d, y');?></td>
					<td><?php echo $period->employment_status;?></td>
					<td><?php echo $period->loan_type;?></td>
					<td class="text-center">
						<?php 
							if ($period->amortization == 15) 
							{
								echo '15<sup>th</th>';
							}
							elseif ($period->amortization == 30)
							{
								echo '30<sup>th</th>';
							}
						?>
					</td>
					<td class='text-left'>
						<?php 
							$subtotal += $period->amount_receivable;
							echo nf($period->amount_receivable);
						?>
					</td>
					<td><?php echo $period->remarks;?></td>
					<td>
						<?php 
							echo substr($period->LastName, 0, 1) . substr($period->FirstName, 0, 1) . substr($period->MiddleName, 0, 1);
						?>
					</td>
					<td>
						<?php 
							if ($period->is_excel_generated == 1 && $receipt_id == 0) 
							{
								echo '<span class="label label-warning tooltipbox" data-toggle="tooltip" data-placement="top" title="Waiting for cash confirmation"><i class="fa fa-clock-o"></i> Pending</span>';
							}
							elseif ($receipt_id > 0) 
							{
								echo '<span class="label label-danger tooltipbox" data-toggle="tooltip" data-placement="top" title="Receipt has been issued"><i class="fa fa-lock"></i> Closed</span>';
							}
							else
							{
								echo '<span class="label label-success tooltipbox" data-toggle="tooltip" data-placement="top" title="Ready to generate excel report"><i class="fa fa-pencil"></i> Active</span>';
							}
						?>
					</td>
					<td>
						<div class="btn-group btn-blocked">
						  <?php $disabled = $period->amount_receivable == 0 ? 'disabled' : ''; ?>
						  <?php echo btn_achor('collection_report/'. $period->salary_period_id . '/details', '<i class="fa fa-table"></i> Details', "class='btn btn-primary' $disabled");?>

					    <?php if ($receipt_id == 0):  ?>
						  <div class="btn-group">
						    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						      <span class="caret"></span>
						    </button>

						    <ul class="dropdown-menu pull-right">
						      <li role="presentation"><?php echo btn_achor('collection_summary/'. $period->salary_period_id . '/edit', '<i class="fa fa-edit"></i> Edit Information', 'role="menuitem"');?></li>

							  <?php if ($period->amount_receivable != 0): ?>
						      <li role="presentation"><?php echo btn_achor('collection_summary/'. $period->salary_period_id . '/excel', '<i class="fa fa-download"></i> Download to excel');?></li>

						      <li role="presentation">
						      	<?php echo btn_achor('#', '<i class="fa fa-file"></i> Issue Receipt', 
								      	"class='btn_receipt' data-toggle='modal' data-target='#contact' data-original-title data-salary-period-id='$period->salary_period_id' data-total-amt='$period->amount_receivable'");?>
						      </li>
							  <?php endif; ?>

						      <li role="presentation" class="divider"></li>
						      <li role="presentation"><?php echo btn_achor('collection_summary/'. $period->salary_period_id . '/delete', '<i class="fa fa-trash-o"></i> Delete');?></li>
						    </ul>

						  </div>

						<?php endif; ?>

						</div>

						
					</td>
				</tr>
			<?php endforeach ?>

				</tbody>


				<tfoot>
					<tr>
						<th colspan='5' class='text-right'>
							Sub-Total
						</th>
						<th class='text-left'>
							Php <?php echo nf($subtotal); ?>
						</th>
						<th colspan='4'>&nbsp;</th>
					</tr>
				</tfoot>


		<?php else: ?>
				<tr>
					<td colspan="9">
						<span class="label label-danger">No record found!.</span>
					</td>
				</tr>
		<?php endif ?>
	
</table>

<!-- begin modal contact -->
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="panel-title" id="contactLabel"><span class="fa fa-info-circle"></span> Issuance of Receipt - Cash Salary Deduction Collection</h4>
            </div>
            <?php echo form_open(NULL, 'id="frmReceipt" onkeypress="return event.keyCode != 13;"') ?>
            <div class="modal-body">
            	<legend>Cash</legend>
					<div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            <input class="form-control" name="or_no" placeholder="Receipt" type="text" required />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            <input class="form-control" name="booklet_no" placeholder="Booklet" type="text" required />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            <input class="form-control dtpicker" name="date" placeholder="YYYY-MM-DD" type="text" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            <input class="form-control" name="remarks" placeholder="Remarks" type="text" />
                        </div>
                    </div>

                    <div class="row">
                    	<div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                    		<label for="total_cash_amount">Total Cash Amount</label>
                    		<input type="text" name="total_cash_amount" id="total_cash_amount" placeholder="Cash Amount" class="form-control text-right" value="0.00">
                    	</div>
                    </div>


                    <h4>
                      Payment 
						<span class="form-inline">
	                      	<label for="is_check" class="checkbox">
	                    		<input type="checkbox" name="is_check" id="is_check" class="checkbox"> <small>Check</small>
	                		</label>
	                	</span>
                    </h4>
					<hr>


                    <div class="row">
	                    	                    	
	                    	<div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
		                    	<label for="bank_id">Bank</label>
							    <?php echo form_dropdown('bank_id', $banks, NULL, 'class="form-control" disabled') ?>
	                    	</div>
	                    	<div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
		                    	<label for="check_no">Check No.</label>
	                    		<input type="text" name="check_no" id="check_no" class="form-control" placeholder="Check No." disabled>
	                    	</div>
                    </div>
										
                    <div class="row">
                    	<div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                    		<label for="total_check_amount">Total Check Amount</label>
                    		<input type="text" name="total_check_amount" id="total_check_amount" placeholder="Check Amount" class="form-control text-right" value="0.00" disabled>
                    	</div>
                    </div>
            </div>  <!-- modal body -->

            <div class="panel-footer" style="margin-bottom:-14px;">
            	<div class="row-fluid">
        			<p class="lead">Total Php. 
        				<strong>
	        				<span id="total_amount"></span>
	        			</strong>
	        		</p>
            	</div>
            	<div class="row">
            		<div class="col-lg-9 col-md-9 col-sm-9">
            			<input type="hidden" name="salary_period_id" id="hidden_salary_period_id">
            			<input type="hidden" name="user_id" id="hidden_user_id" value="<?php echo $this->session->userdata('Id') ?>">
            			<button type="button" class="btn btn-labeled btn-primary" id="btn-save-receipt">
                            <span class="btn-label"><i class="fa fa-save"></i></span>Save Transaction
                        </button>
                        <button type="reset" class="btn btn-labeled btn-danger" id="btn-reset-receipt">
                            <span class="btn-label"><i class="fa fa-times"></i></span>Clear Transaction
                        </button>
            		</div>
            		<div class="col-lg-3 col-md-3 col-sm-3">
	                    <button style="float: right;" type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
            		</div>
            	</div>
            </div> <!-- modal footer -->

        </div> <!-- panel -->
    </div> <!-- modal dialog -->
</div> <!-- modal -->
<!-- end modal contact -->

<script>
	$(function(){

		var amount_receivable;

		$('#total_check_amount, #total_cash_amount, span#total_amount').autoNumeric('init', {'mDec':3});

		$('.btn_receipt').on('click', function () {
			amount_receivable = $(this).attr('data-total-amt');
			var salary_period_id = $(this).attr('data-salary-period-id');

			$('span#total_amount').autoNumeric('init');
			$('span#total_amount').autoNumeric('set',amount_receivable);
			$('input#hidden_salary_period_id').val(salary_period_id);
		})

		$('input[type=text]').on('click', function(e){
			$(this).select();
		});

		$('#total_cash_amount,#total_check_amount').on('blur', function () {
			if ($(this).val() == '' || $(this).val() == '0')
			{
				$(this).val('0.00');
			}
		})

		

		$('#contact').on('hidden.bs.modal', function () {
		    $('#btn-save-receipt').removeAttr('disabled')
		})

		$('#btn-save-receipt').on('click', function () {

			// prevent double submit
			$(this).attr('disabled');

			var or_no = $('input[name=or_no]').val(),
			booklet_no = $('input[name=booklet_no]').val(),
			mydate = $('input[name=date]').val(),
			remarks = $('input[name=remarks]').val(),
			total_cash_amount = $('input[name=total_cash_amount]').val().replace(",", ""),
			total_check_amount = $('input[name=total_check_amount]').val().replace(",", ""),
			bank_id = $('select[name=bank_id]').val(),
			check_no = $('input[name=check_no]').val(),
			salary_period_id = $('input#hidden_salary_period_id').val(),
			user_id = $('#hidden_user_id').val(),
			base_url = "<?php echo site_url('collection_summary/new_receipt'); ?>"

			if(or_no.length == 0 || booklet_no.length == 0 || mydate.length == 0)
			{
				alert("You forgot to fill-up the following field\n RECEIPT, BOOKLET and DATE fields.")
			}
			else if( (parseInt(total_check_amount) + parseInt(total_cash_amount)) != parseInt(amount_receivable) )
			{
				alert("Total amount receivable did not match to \nTOTAL CASH AMOUNT / TOTAL CHECK AMOUNT!")
			}
			else if ($('#is_check').is(':checked'))
			{
				if ($('select[name=bank_id]').val() == "0") 
				{
					alert("Please select a bank from the dropdown-menu")
				}
				else if(check_no.length == 0)
				{
					alert("You forgot to fill-up the Check No field.")
				}
				else
				{
					// begin ajax call
					ajax_call();
				}
			}
			else
			{
				// begin ajax call
				ajax_call();
				
			}


			function ajax_call () 
			{
				$.ajax({
					type: "POST",
					url: base_url,
					data: 
					{ 
						or_no: or_no, 
						booklet_no: booklet_no, 
						date: mydate, 
						remarks: remarks, 
						total_cash_amount: total_cash_amount, 
						total_check_amount: total_check_amount,
						bank_id: bank_id,
						check_no: check_no,
						salary_period_id: salary_period_id,
						user_id: user_id
					},
					success: function (data) 
					{
						alert(data.message)

						if (data.error != "1") 
						{
							$('#contact').modal('hide');
						}

					},
					dataType: 'json',
					cache: false
				});
			}
		})

		$("#is_check").change(function() {
		    if(this.checked) {
		        $('#total_check_amount, #check_no, select[name=bank_id]').removeAttr('disabled');
		        $('#total_check_amount, #check_no, select[name=bank_id]').prop('disabled', false);
		    }
		    else
		    {
		        $('#total_check_amount, #check_no, select[name=bank_id]').attr('disabled','disabled');
		        $('#total_check_amount, #check_no, select[name=bank_id]').prop('disabled', true);
		    }
		});

		$('#contact').on('hidden.bs.modal', function () {
		    location.reload();
		})

		$('.tooltipbox').tooltip();
	});
</script>