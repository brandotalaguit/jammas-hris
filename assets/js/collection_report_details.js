$(function(){
	
	var DECIMAL_PLACES = $('input[name=DECIMAL_PLACES]').val();	

	$('.amortization15, .amortization30, #total_check_amount, #total_cash_amount, #total_amount, .numbers').autoNumeric('init', {'mDec':DECIMAL_PLACES});

	$('.amortization15').on('change', function (e) {
		if ($(this).data('initamount') != $(this).val().replace(",", "")) 
		{
			$(this).parent('td').parent('tr').addClass('warning');
		}
		else
		{
			$(this).parent('td').parent('tr').removeClass('warning');
		}
		
		var total_amount = 0.00;
		$('.amortization15').each(function() {
			
				var amount = $(this).val().replace(",", "");
				total_amount += parseInt(amount);
			
		})

		$('#th_amortization_15, #total_amount').autoNumeric('init');
		$('#th_amortization_15, #total_amount').autoNumeric('set',total_amount);
	})

	$('.amortization').on('blur', function () {
		
		var id = $(this).attr('data-id');
		var amortization = $(this).val().replace(",", "");
		var int_receivable = $(this).closest('tr').find('input.int_receivable').val();
		var sc_receivable = $(this).closest('tr').find('input.sc_receivable').val();
		var lpp_receivable = $(this).closest('tr').find('input.lpp_receivable').val();
		var loan_id = $(this).attr('data-loan-id');
		var base_url = $('input[name=base_url]').val();
		
		if (int_receivable == undefined) 
			int_receivable = 0.00;

				$.ajax({
					type: "POST",
					url: base_url + 'collection_report/overpayment',
					data: 
					{ 
						id: id,
						loan_id: loan_id, 
						amount: amortization,
						int_receivable: int_receivable
					},
					success: function (data) 
					{
						if (data.error != "0") 
						{
							alert('Over-payment is not allowed')
						}

					},
					dataType: 'json',
					cache: false
				});

	})

	$('.int_receivable').on('blur', function () {
		
		var id = $(this).attr('data-id');
		var int_receivable = $(this).closest('tr').find('input.int_receivable').val();
		var loan_id = $(this).attr('data-loan-id');
		var base_url = $('input[name=base_url]').val();
		
		if (int_receivable == undefined) 
			int_receivable = 0.00;
		else
		{
			$.ajax({
				type: "POST",
				url: base_url + 'collection_report/overpayment_int_receivable',
				data: 
				{ 
					id: id,
					loan_id: loan_id, 
					int_receivable: int_receivable
				},
				success: function (data) 
				{
					if (data.error != "0") 
					{
						alert('Over-payment is not allowed')
					}

				},
				dataType: 'json',
				cache: false
			});
		}

	})

	$('.amortization30').on('change', function (e) {
		
		if ($(this).data('initamount') != $(this).val().replace(",", "")) 
		{
			$(this).parent('td').parent('tr').addClass('warning');
		}
		else
		{
			$(this).parent('td').parent('tr').removeClass('warning');
		}
		


		var total_amount = 0.00;
		$('.amortization30').each(function() {
			
				var amount = $(this).val().replace(",", "");
				total_amount += parseInt(amount);
			
		})

		$('#th_amortization_15, #total_amount').autoNumeric('init');
		$('#th_amortization_15, #total_amount').autoNumeric('set',total_amount);

	})

	$('input[type=text]').on('click', function(e){
		$(this).select();
	});
	
	$('input[type=text]').keydown(function(e){
		//get the next index of text input element
		var next_idx = $('input[type=text]').index(this) + 1;
	 
		//get number of text input element in a html document
		var tot_idx = $('body').find('input[type=text]').length;
	 
		//enter button in ASCII code
		if(e.keyCode == 13){
			if(tot_idx == next_idx)
			{	//go to the first text element if focused in the last text input element
				$('input[type=text]:eq(0)').focus();
				$('input[type=text]:eq(0)').select();
			}
			else
			{
				//go to the next text input element
				$('input[type=text]:eq(' + next_idx + ')').focus();
				$('input[type=text]:eq(' + next_idx + ')').select();
			}
		}
	});

	




});