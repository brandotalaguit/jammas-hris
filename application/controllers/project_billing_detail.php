<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_billing_detail extends Admin_Controller
{
	function __construct() 
	{
		parent::__construct();
        $this->load->model('project_billings');
        $this->load->model('project_billing_trans');
        $this->data['controller'] = $this->router->fetch_class();

	}


	public function show($project_id, $project_bill_id)
	{
		$project = $this->projects->get($project_id, TRUE);

		// Set up pagination 
		// $this->db->where('project_bill_id', $project_bill_id);
		// $config['total_rows'] = $this->project_billing_trans->count();
		// $config['per_page'] = 15;
		// $this->pagination->initialize($config);

		// Create pagination links
		// $this->data['pagination'] = $this->pagination->create_links();

		if ($this->input->post('btn_action') == 'Search') 
		{
			$this->form_validation->set_rules('search', 'Search', 'required|strtoupper');
			
			$q = $this->input->post('search');
			$by = $this->input->post('by');
			if ($by == "Lastname") 
			{
				$this->db->like('lastname', $q, 'after');
			}
			elseif ($by == "Firstname") 
			{
				$this->db->like('firstname', $q, 'after');
			}
			unset($this->data['pagination']);
		}
		else
		{
			// Retrieve paginated results, using the dynamically determined offset
			// $this->db->limit($config['per_page'], $this->pagination->offset);
		}



		// Fetch data
		$this->db->order_by('w_adjustment, lastname, firstname, middlename, position_code');
		$this->data['project_billing_trans'] = $this->project_billing_trans->get_project_billing_trans($project_bill_id);


		$this->data['project'] = $project;
        
		// Set up the view
		$this->data['page_subtitle'] = $project->description;
		$this->data['counter'] = $this->uri->segment(6, 0);
		$this->data['search_form'] = $this->load->view('employee/search_form', $this->data, TRUE);

		$billing_info = $this->project_billings->get($project_bill_id, TRUE);

		if (empty($billing_info->fields)) 
		{
			$this->project_billings->delete($project_bill_id);
			parent::redirect_to(
					"Unable to display billing. Please make sure you have assigned a column for billing report.", 
					'projectBillingInfo/' . $project_id
				);
		}

		if (empty($this->data['project_billing_trans'])) 
		{
			$this->project_billings->delete($project_bill_id);
			parent::redirect_to(
					"Unable to display billing. Please make sure you have assigned a personnel for billing report.", 
					'projectBillingInfo/' . $project_id
				);
		}

		$this->data['billing_info'] = $billing_info;
		$this->data['columns'] = explode(',', $billing_info->fields);

		$this->data['billing_rates'] = $this->project_billing_trans->get_billing_rates_array();
		
        $this->data['page_title'] = $project->title . '<br><small class="label label-danger">Billing Period: <strong>'. date('M j, y', strtotime($billing_info->date_start)) . ' - ' . date('M j, y', strtotime($billing_info->date_end)) .'</strong></small>';
		
		// Load view 
		$this->load_view('admin/project_billing_detail/list_billing');

		$this->output->enable_profiler(FALSE);
	}


	/**
	 * Generate summary of billing, excel format
	 *
	 * @param $project_id int project id
	 * @param $project_bill_id project billing id
	 *
	 * @return excel
	 */
	public function download($project_id, $project_bill_id)
	{
		// turn off profiler
		$this->output->enable_profiler(FALSE);

		// initialize variable
		$this->data['counter'] = 0;

		// fetch data
		$this->data['project'] = $this->projects->get($project_id, TRUE);
		$this->data['project_billing_info'] = $this->project_billings->get($project_bill_id, TRUE);
		$this->db->order_by('w_adjustment, lastname, firstname, middlename,position_code');
		$this->data['project_billing_trans'] = $this->project_billing_trans->get_project_billing_trans($project_bill_id);

		// $this->data['columns'] = explode(',', $this->data['project']->fields);

		$billing_info = $this->project_billings->get($project_bill_id, TRUE);
		$this->data['billing_info'] = $billing_info;
		$this->data['columns'] = explode(',', $billing_info->fields);
		
		$this->data['billing_rates'] = $this->project_billing_trans->get_billing_rates_array();


		// setup download header
		header("Content-type: application/vnd.ms-excel; charset=utf-8;");
		header("Content-Disposition: attachment;Filename=" . str_replace(',', '.', str_replace('.', '', str_replace(' ', '_', $this->data['project']->title))) . "-BillingDetail-".date('m-d-Y-H-i-s').".xls");

		// load view 
		$this->load->view('admin/project_billing_detail/excelBillingSummary', $this->data);
	}

	/*
	public function invoice($project_id, $project_bill_id)
	{
		// turn off profiler
		$this->output->enable_profiler(FALSE);

		// initialize variable
		$this->data['counter'] = 0;

		// fetch data
		$this->data['project'] = $this->projects->get($project_id, TRUE);
		$this->data['project_billing_info'] = $this->project_billings->get($project_bill_id, TRUE);
		$this->db->order_by('w_adjustment ,position_code, lastname, firstname, middlename');
		$this->data['project_billing_trans'] = $this->project_billing_trans->get_project_billing_trans($project_bill_id);

		$this->data['columns'] = explode(',', $this->data['project']->fields);

		// setup download header
		header("Content-type: application/vnd.ms-excel; charset=utf-8;");
		header("Content-Disposition: attachment;Filename=" . str_replace(',', '.', str_replace('.', '', str_replace(' ', '_', $this->data['project']->title))) . "-BillingDetail-".date('m-d-Y-H-i-s').".xls");

		// load view 
		$this->load->view('admin/project_billing_detail/excelBillingInvoice2', $this->data);
	}
	*/

	/**
	 * Generate summary of billing, excel format
	 *
	 * @param $cb_id int combine project id
	 * @return excel
	 */
	public function invoice_by_position($cb_id)
	{
		$this->load->model(array('combine_billings', 'combine_project_billings'));
		
		$combine_billing = $this->combine_billings->get($cb_id, TRUE);

		$billing_period = $this->combine_project_billings->get_by(array('cb_id' => $cb_id));
		$billing_id = array();
		// $fields = '';
		foreach ($billing_period as $bill) 
		{
			$proj_bill_info = $this->project_billings->get($bill->project_bill_id, TRUE);

			$project_id[] = $bill->project_id;
			$billing_id[] = $bill->project_bill_id;
			$billing_field[] = explode(',', $proj_bill_info->fields);
			// $fields .= $billing_field;
		}

		// $fields = implode(',', $billing_field);
		// dump($fields);
		
		// turn off profiler
		$this->output->enable_profiler(FALSE);

		$this->load->helper('toWords');

		// initialize variable
		$this->data['counter'] = 0;
		$this->data['total_billing'] = 0.00;

		// fetch data
		// $this->db->where_in('project_id', $project_id);
		// $this->data['projects'] = $this->projects->get();
		// dump(implode(", ", $billing_id));
		$this->db->where_in('project_bill_id', $billing_id);
		$this->data['project_billings'] = $this->project_billings->get();
		
		foreach ($this->data['project_billings'] as $key => $pbi) 
		{
			$this->data['projects'][] = $pbi->project_id;
		}

		$condition = "project_billing_trans.project_bill_id IN(" . implode(", ", $billing_id) . ")";
		$this->data['billings'] = $this->project_billing_trans->get_project_summary_by($condition, '`project_billing_trans`.`project_bill_id`, D.ppr_id');
		$this->data['combine_billing'] = $combine_billing;

		// setup view header
		header("Content-type: application/vnd.ms-excel; charset=utf-8;");
		header("Content-Disposition: attachment;Filename=" . str_replace(',', '.', str_replace('.', '', str_replace(',', '_', str_replace(' ', '_', 'combine_billing_id_' . $cb_id)))) . "-invoice_by_position-".date('m-d-Y-H-i-s').".xls");

		// load view 
		$this->load->view('admin/project_billing_detail/excelBillingInvoice2_arr', $this->data);
	}



	public function invoice_by_rate($cb_id)
	{
		$this->load->model(array('combine_billings', 'combine_project_billings'));
		
		$combine_billing = $this->combine_billings->get($cb_id, TRUE);

		$this->db->order_by('project_bill_id');
		$billing_period = $this->combine_project_billings->get_by(array('cb_id' => $cb_id));
		$billing_id = array();
		// $fields = '';
		foreach ($billing_period as $bill) 
		{
			$proj_bill_info = $this->project_billings->get($bill->project_bill_id, TRUE);

			$project_id[] = $bill->project_id;
			$billing_id[] = $bill->project_bill_id;
			$billing_field[] = explode(',', $proj_bill_info->fields);
			// $fields .= $billing_field;
		}

		// turn off profiler
		$this->output->enable_profiler(FALSE);

		$this->load->helper('toWords');

		// initialize variable
		$this->data['counter'] = 0;
		$this->data['total_billing'] = 0.00;

		// fetch data
		// $this->db->where_in('project_id', $project_id);
		// $this->data['projects'] = $this->projects->get();

		$this->db->where_in('project_bill_id', $billing_id);
		$this->data['project_billings'] = $this->project_billings->get();

		foreach ($this->data['project_billings'] as $key => $pbi) 
		{
			$this->data['projects'][] = $pbi->project_id;
		}
		// dump($billing_id);
		$condition = "project_billing_trans.project_bill_id IN(" . implode(", ", $billing_id) . ")";
		$this->db->select('B.title, B.description, B.address, B.rate_hourly, B.rate_daily, B.rate_semi_monthly, B.rate_monthly');
		$this->data['billings'] = $this->project_billing_trans->get_project_summary_by($condition, '`project_billing_trans`.`project_bill_id`, D.ppr_id');
		$this->data['billing_ids'] = $billing_id;
		$this->data['combine_billing'] = $combine_billing;
		// echo $this->db->last_query();
		// setup view header
		header("Content-type: application/vnd.ms-excel; charset=utf-8;");
		header("Content-Disposition: attachment;Filename=combine_project_billings-invoice_by_rates-".date('m-d-Y-H-i-s').".xls");

		// load view 
		$this->load->view('admin/project_billing_detail/excelBillingInvoice_rates_arr', $this->data);
	}

	/**
	 * Generate summary of billing, excel format
	 *
	 * @param $project_id int project id
	 * @param $project_bill_id project billing id
	 *
	 * @return excel
	 */
	public function invoice2($project_id, $project_bill_id)
	{
		// turn off profiler
		$this->output->enable_profiler(FALSE);

		$this->load->helper('toWords');

		// initialize variable
		$this->data['counter'] = 0;
		$this->data['total_billing'] = 0.00;

		// fetch data
		$this->data['project'] = $this->projects->get($project_id, TRUE);
		$this->data['project_billing_info'] = $this->project_billings->get($project_bill_id, TRUE);
		$condition = ['A.project_id' => $project_id, 'project_billing_trans.project_bill_id' => $project_bill_id];
		$this->data['billings'] = $this->project_billing_trans->get_project_summary_by($condition, '`project_billing_trans`.`project_bill_id`, D.ppr_id');

		// setup view header
		header("Content-type: application/vnd.ms-excel; charset=utf-8;");
		header("Content-Disposition: attachment;Filename=" . str_replace(',', '.', str_replace('.', '', str_replace(',', '_', str_replace(' ', '_', $this->data['project']->title)))) . "-Invoice2-".date('m-d-Y-H-i-s').".xls");

		// load view 
		$this->load->view('admin/project_billing_detail/excelBillingInvoice2', $this->data);
	}

	public function invoice3($project_id, $project_bill_id)
	{
		// turn off profiler
		$this->output->enable_profiler(FALSE);

		$this->load->helper('toWords');

		// initialize variable
		$this->data['counter'] = 0;
		$this->data['total_billing'] = 0.00;

		// fetch data
		$this->data['project'] = $this->projects->get($project_id, TRUE);
		$this->data['project_billing_info'] = $this->project_billings->get($project_bill_id, TRUE);
		$condition = ['A.project_id' => $project_id, 'project_billing_trans.project_bill_id' => $project_bill_id];
		$this->data['billings'] = $this->project_billing_trans->get_project_summary_by($condition, '`project_billing_trans`.`project_bill_id`, D.ppr_id');

		// setup view header
		header("Content-type: application/vnd.ms-excel; charset=utf-8;");
		header("Content-Disposition: attachment;Filename=" . str_replace(',', '.', str_replace('.', '', str_replace(',', '_', str_replace(' ', '_', $this->data['project']->title)))) . "-Invoice3-".date('m-d-Y-H-i-s').".xls");

		// load view 
		$this->load->view('admin/project_billing_detail/excelBillingInvoice3', $this->data);
	}

	public function invoice($project_id, $project_bill_id)
	{
		// turn off profiler
		$this->output->enable_profiler(FALSE);

		$this->load->helper('toWords');

		// initialize variables
		$this->data['counter'] = 0;
		$this->data['total_billing'] = 0.00;

		// fetch data
		$this->data['project'] = $this->projects->get($project_id, TRUE);
		$this->data['project_billing_info'] = $this->project_billings->get($project_bill_id, TRUE);
		$condition = ['A.project_id' => $project_id, 'project_billing_trans.project_bill_id' => $project_bill_id];
		$this->data['billings'] = $this->project_billing_trans->get_project_summary_by($condition, '`project_billing_trans`.`project_bill_id`, D.ppr_id');

		// setup header
		header("Content-type: application/vnd.ms-excel; charset=utf-8;");
		header("Content-Disposition: attachment;Filename=" . str_replace(',', '.', str_replace('.', '', str_replace(',', '_', str_replace(' ', '_', $this->data['project']->title)))) . "-Invoice-".date('m-d-Y-H-i-s').".xls");

		// load view 
		$this->load->view('admin/project_billing_detail/excelBillingInvoice', $this->data);
	}

	/**
	 * 
	 * @param id int project billing transaction id 
	 * @return json response
	 */

	public function edit()
	{
		$this->output->enable_profiler(FALSE);
		$status = 'error';
		$value = $this->input->post('value');
		$name = $this->input->post('name');
		$id = $this->input->post('pk');

		// Set up the form validation
		$rules = $this->project_billing_trans->single_column_rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			$proj_employee = $this->project_billing_trans->get_project_billing_trans(NULL, $id, TRUE);
			$rate = array(
				'no_hrs' => 'hourly_rate',
				'rw_day' => 'daily_rate',
				'rw_ot_day' => 'regular_ot_day',

				'nd_day' => 'night_diff',
				'nd_ot_day' => 'night_ot_diff',
				'sd_day' => 'straight_duty',
				'sd_ot_day' => 'straight_ot_duty',

				'rd_day' => 'rest_day_rate',
				'rd_ot_day' => 'rest_day_ot_rate',
				'rd_sh_day' => 'rest_day_special_holiday',
				'rd_sh_ot_day' => 'rest_day_special_ot_holiday',
				'rd_lg_hl' => 'rest_day_legal_holiday',
				'rd_lg_ot_hl' => 'rest_day_legal_ot_holiday',

				'lg_day' => 'legal_holiday',
				'lg_ot_day' => 'legal_ot_holiday',
				'sp_day' => 'special_holiday',
				'sp_ot_day' => 'special_ot_holiday',

				'late_minutes' => 'late_amount',
				'no_absences_per_hr' => 'absent_rate',				// no of absent per hour
				'no_absences_per_day' => 'absent_rate_per_day',		// no of absent per day

			);

			// save data
			$this->project_billing_trans->save([$name => $value], $id);


			$pbt = $this->project_billing_trans->get($id, TRUE);
			
			// billing period
			$billing_info = $this->project_billings->get($pbt->project_bill_id, TRUE);
			// dump($billing_info->fields);

			// billing details and computation array
			$billing_rates = $this->project_billing_trans->get_billing_rates_array();

			// project billing
			$project = $this->projects->get($billing_info->project_id, TRUE);

			
			// summary per project billing period 
			$this->db->where('project_billing_trans.project_bill_id', $pbt->project_bill_id);
			$pbt_proj = $this->project_billing_trans->get_project_summary(NULL, TRUE);
			// dump($this->db->last_query());

			// summary per row of project billing period
			$pbt_row = $this->project_billing_trans->get_project_summary($id, TRUE);
			// dump($this->db->last_query());


			if ($project->rate_hourly == 1)
			{
				$billing_info->fields .= ',hourly_rate';
			}

			if ($project->rate_daily == 1)
			{
				$billing_info->fields .= ',daily_rate';
			}
			
			if ($project->rate_semi_monthly == 1)
			{
				$billing_info->fields .= ',semi_monthly_rate';
			}

			if ($project->rate_monthly == 1)
			{
				$billing_info->fields .= ',monthly_rate';
			}


			$grandtotal = $subtotal = $column1total = $column2total = 0.00;
			// dump($billing_info);

			// loops through selected columns/fields
			foreach (explode(',', $billing_info->fields) as $rating)
			{
				// dump($rating);
		        $rate_data = explode('|', $billing_rates[$rating]);
		        $rate_basis = $rate_data[0];
		        $rate_title = $rate_data[1];
		        $rate_abbr = $rate_data[2];
		        $fieldname = $rate_data[3];
		        $fieldcount = $rate_data[4];
		        
		        // dump($rate_data);
		        // dump($fieldname);

			    if (in_array($rating, array_keys($billing_rates)))
			    {
			        // dump($rate_data);
		            if (substr($rating, 0, 4) != 'cola')
		            {
		                $subtotal += floatval($pbt_row->$fieldname);
		                $grandtotal += floatval($pbt_proj->$fieldname);
				    	
				    	// dump('subtotal is ' . $pbt_row->$fieldname);
				    	// dump('grandtotal is ' . $pbt_proj->$fieldname);
		                
		                if ($rating == $rate[$name]) 
		                {
		                	// column sub-total
			                $column1total = floatval($pbt_proj->$fieldcount);
			                // row sub-total
			                $column2total = floatval($pbt_proj->$fieldname);
		                }
		            }
			    }
			}


		    return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode(
		        	[
		        	'success' =>  TRUE, 
		        	'newValue' => $pbt->$name, 
		        	'rate' => $proj_employee->$rate[$name], 
		        	'rate_name' => '#' . $rate[$name],
		        	'total_amt' => nf(floatval($pbt->$name) * floatval($proj_employee->$rate[$name])), 
		        	'subtotal' => nf(floatval($subtotal)), 
		        	'column1total' => $column1total,
		        	'column2total' => $column2total,
		        	'grandtotal' => nf(floatval($grandtotal)),
		        	]
	        	));
	        // ->set_output(json_encode(['success' =>  TRUE, 'newValue' => $this->input->post('value', TRUE), 'rate' => $proj_employee->$rate[$name]]));
			// registrar transaction log
			# code here ...
		}
		else
		{
		    $this->output->set_status_header('400');
		    return validation_errors('<p>','</p>');
		}

	}

	public function delete($id, $project_id)
	{
		// fetch data
		$project_billing_trans = $this->project_billing_trans->get($id, TRUE);

		if (count($project_billing_trans)) 
		{
			// process delete
			$this->project_billing_trans->delete($id);

			// save log
			
			// redirect to user
			redirect(site_url('projectBillingTrans/' . $project_id . '/' . $project_billing_trans->project_bill_id . '/summary'));
		}

		return FALSE;
	}


	public function _unique_project_billing_trans($str)
	{
		// Do NOT validate if project_billing_trans already exists
		// UNLESS it's the project_billing_trans for the current project_billing_trans
		$this->db->where(['project_billing_trans'=> $str]);
		$this->db->where('project_billing_trans_id !=', $this->uri->segment(2,0));
		$project_billing_trans = $this->project_billing_trans->get();

		if (count($project_billing_trans)) 
		{
			$this->form_validation->set_message('_unique_project_billing_trans', "$str is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}	


	public function _id_exists($pbt_id)
	{
		// Do NOT validate if pbt_id exists
		$project_billing_trans = $this->project_billing_trans->get($pbt_id);

		if ( ! count($project_billing_trans)) 
		{
			$this->form_validation->set_message('_id_exists', "$str could not be found in the database. Invalid request.");
			return FALSE;
		}

		return TRUE;
	}	

	public function popupAjax($ppr_id = NULL, $col)
	{
		// Fetch a member or create a new member
		$this->data['ppr'] = $this->project_position_rates->get(intval($ppr_id));
		$this->data['col'] = $col;
		if (count($this->data['ppr']))
		{
			$this->data['error'] = "";
		}
		else
		{
			$this->data['ppr'] = $this->project_position_rates->get_new();
			$this->data['error'] = 'Member could not be found. Please try to refresh this page.';
		}

		// Load view
		$this->load->view('include/popupAjax', $this->data);
	}

}

/**
 * Created by PhpStorm.
 * User: Brando
 * Date: 8/31/2014
 * Time: 9:58 AM
 */