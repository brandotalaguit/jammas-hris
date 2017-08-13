// IIFE - Immediately Invoked Function Expression
 (function($, window, document) {

   // The $ is now locally scoped 

   // Generic function to make an AJAX call
   var fetchData = function(form_data, dataURL, dataTYPE = 'json', method = 'POST') {
       // Return the $.ajax promise
       return $.ajax({
           data: form_data,
           type: method,
           dataType: dataTYPE,
           url: dataURL,
           cache: false
       });
   }

   function failed_ajax_request(jqXHR, textStatus, errorThrown) {

     console.log(textStatus + ': ' + errorThrown);
       alert(textStatus + ': ' + errorThrown);
     // location.reload();

   }

	// Listen for the jQuery ready event on the document
	$(function() {

	// The DOM is ready!

	// The rest of the code goes here!
	$('.four_decimal').autoNumeric({'mDec': 4})
	$('.three_decimal').autoNumeric({'mDec': 3})
	$('.deci').autoNumeric({'mDec': 2})
	$('#spanValue').autoNumeric({'mDec': 2})

	$('input[type=date], .dtpicker').datepicker({
	  format: "yyyy-mm-dd",
	  startView: 0,
	  forceParse: true,
	  autoclose: true,
	  todayHighlight: true
	});

	$('input[type=date], .yearview').datepicker({
	  format: "yyyy-mm-dd",
	  startView: 2,
	  forceParse: false,
	  autoclose: true,
	  todayHighlight: true
	});

	$('select').select2();
	/*dataURL = $('#select2_project_id').attr('dataURL');

	var $element = $('#select2_project_id').select2({
	    ajax: {
	        type: "POST",
	        url: dataURL,
	        data: function (params) {
	         // Query paramters will be ?search=[term]&page=[page]
	         return {
	             search: params.term,
	             pageLimit: 15
	         }
	        },
	        processResults: function (data, page) { 
	            return {
	                results: $.map(data, function (item) {
	                    return {
	                       id: item.id,
	                       text: item.title + '-' + item.description,
	                       title: item.title,
	                       description: item.description,
	                    };
	                })
	            };
	            
	        },
	        dataType: 'json',
	        cache: true,
	        delay: 250,
	    },
	    id: function (item) { return { id: item.id }; },
	    escapeMarkup: function(m) { return m; },
	    templateResult: formatResult,
	    templateSelection: formatSelection,
	    dropdownParent: $('#payroll-modal'),
	});
	// $('#select2_project_id').val(<?php #$echo $payroll->project_id ?>).trigger('change.select2');
	function formatResult(data) 
	{
	    if (data.loading) return data.text;
	    return '<h5 style="margin-bottom: 0px;">' + data.title + '</h5>' + '<small>' + data.description + '</small>';
	}

	function formatSelection(data) 
	{
	    // console.log(data)
	    $('p.project_title').html(data.description)
	    return data.description
	}*/


	$(document).on('click', '#btn_payroll_action', function(e) {

	    e.preventDefault();
	    $input = $('#btn_payroll_action');
	    $input.attr('disabled', true);

	    $form = $('#form-manning-payroll')
	    form_data = $form.serializeArray()
	    form_data.push(
	        {name : 'project_id', value: $('[name=project_id]').val()}, 
	        {name: 'fields', value: $('[name="fields[]"]').val()},
	        {name: 'payroll_period', value: $('[name=payroll_period]:checked').val()}
	    )

	    form_data = $.param(form_data)
	    ajax_request = fetchData(form_data, $form.attr('action'))
	    // console.log(form_data);
	    ajax_request.done(function(data){
	      // console.log(data)
	      

	      if (data.status == 'success') 
	      {
	        // window.location.replace(data.url)
	        $input.css('display', 'none');
	        $input.css('visiblity', 'hidden');
	        $button = '<a href="' + data.url + '" class="btn btn-success btn-block">Proceed to payroll earning</a>';
	        $('#row-action1').prepend($button);
	      }
	      else
	      {
	          $.each(data.post_error, function(key, value){
	            $('p.'+key).removeClass('help-block').addClass('text-danger').html(value)
	          })
	          $input.removeAttr('disabled');
	      }
	    }).fail(function(jqXHR, textStatus, errorThrown){ 
	      return failed_ajax_request(jqXHR, textStatus, errorThrown); 
	    });
	})

	/*$('#select2_project_id').select2({
		ajax: {
			type: "POST",
			url: $(this).attr('dataURL'),
			// data: function (params) {
			// 	// Query paramters will be ?search=[term]&page=[page]
			// 	return {
			// 		search: params.term,
			// 		pageLimit: 25
			// 	}
			// },
			dataType: 'json',
			cache: true,
			// delay: 250,
			// templateResult: formatResult,
		}
	});
	$('#select2_project_id').val(null).trigger('change.select2');*/

	// function formatResult(data) 
	// {
	// 	if (!data.id) { return data.text; }
	// 	return $(
	// 	   '<b>' + data.title + '</b>' + ' - <em>' + data.description + '</em>'
	// 	);
	// }


	// $('input[name=daily_rate]').on('change', function (e) {
	$(document).on('change','input[name=daily_rate]', function(e) {
		console.log(this.value)
	})

	});

  
	// Clear cache modal
	$('body').on('hidden.bs.modal', '.modal', function () {
	$(this).removeData('bs.modal');
	});



  }(window.jQuery, window, document));
  // The global jQuery object is passed as a parameter



