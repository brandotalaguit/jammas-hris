<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Combine_billing extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'combine_billing';
		$this->data['page_title'] = anchor(base_url('combine_billing/new'), '<strong><i class="fa fa-plus"></i> New Combine Project Billing</strong>', array('class' => 'btn btn-danger'));
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-copy"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-danger' href='".base_url('combine_billing/new')."'><i class='fa fa-plus'></i> New Combine Billing</a>";
		
		$this->load->model(array('combine_billings','combine_project_billings', 'project_billings', 'projects'));
	}

	public function index()
	{
		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
			$filter_user = array('user_id' => $this->session->userdata('Id'));
			$this->db->where($filter_user);
		}

		// Set up pagination 
		$config['total_rows'] = $this->combine_billings->count();
		$config['per_page'] = 15;
		$this->pagination->initialize($config);

		// Create pagination links
		$this->data['pagination'] = $this->pagination->create_links();

		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		if ($this->input->post('btn_action') == 'Search') 
		{
			$this->form_validation->set_rules('search', 'Search', 'required|strtoupper');
			
			$q = $this->input->post('search');
			$by = $this->input->post('by');
			if ($by == "Title") 
			{
				$this->db->like('title', $q, 'after');
			}
			elseif ($by == "Description") 
			{
				$this->db->like('description', $q, 'after');
			}
			unset($this->data['pagination']);
		}

		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
			$this->db->where($filter_user);
		}

		// Fetch all combine_billing
		$this->data['combine_billings'] = $this->combine_billings->combine_project_billings();
		$this->data['proj_rate_arr'] = $this->projects->get_project_rates_array();

		// Load view 
		$this->load_view('combine_billing/index');

	}

	public function get_billing_period($project_id)
	{
		$this->data['billing_periods'] = $this->project_billings->get_billing_period($project_id);
		$this->load->view('combine_billing/select_option', $this->data);
	}

	public function update_cpb($id)
	{
		// Set up the form
		$rules = $this->combine_billings->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			$data = $this->combine_billings->array_from_post(array(
				'cb_title', 
				'cb_address', 
				));

			// store user id
			$data['user_id'] = $this->session->userdata('Id');

			$this->combine_billings->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> Combine_billing has been updated";
			$this->activity_m->write($message, $this->data['combine_billings'], $data);

			// redirect to combine_billing
			redirect(base_url('combine_billing/' .$id. '/edit'));
		}
		dump(validation_errors());
		$this->output->enable_profiler(TRUE);
	}

	public function edit($id = NULL)
	{
		
		if ($id === NULL) 
		{
			$data['user_id'] = $this->session->userdata('Id');
			$id = $this->combine_billings->save($data, NULL);
			redirect(base_url("combine_billing/{$id}/edit",'refresh'));
		}

		// Fetch a combine_billing or create a new combine_billing
		if ($id) 
		{
			$this->data['combine_billings'] = $this->combine_billings->get($id, TRUE);
			$this->data['combine_project_billings'] = $this->combine_project_billings->get_by(array('cb_id' => $id));
			count($this->data['combine_billings']) || $this->data['errors'][] = 'Combine Project Billing Id could not be found';
		}		
		
		$_POST['cb_id'] = $id;

		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			// Set up the form
			$rules = $this->combine_project_billings->rules;
			$this->form_validation->set_rules($rules);

			// Process the form
			if ($this->form_validation->run() == TRUE) 
			{
				$data = $this->combine_project_billings->array_from_post(array(
					'cb_id', 
					'project_id', 
					'project_bill_id'
					));

				// store user id
				$data['user_id'] = $this->session->userdata('Id');

				$this->combine_project_billings->save($data);

				// save log
				$message = "<i class='fa fa-pencil'></i> Combine_billing has been updated";
				$this->activity_m->write($message, $this->data['combine_billings'], $data);

				// redirect to combine_billing
				redirect(base_url('combine_billing/' .$id. '/edit'));
			}
			
		} // end post request


		// Set up view
		$this->data['page_title'] = 'Edit Combine Project Billing # ' . $id;
		$this->data['projects'] = $this->projects->get_projects();
		

		// Load the view
		$this->load_view('combine_billing/edit');
		// $this->output->enable_profiler(TRUE);
	}

	public function delete($id = NULL)
	{
		// fetch data
		$combine_billing = $this->combine_billings->get($id, TRUE);

		// process delete
		$this->combine_billings->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$combine_billing->title</strong> Combine_billing has been removed";
		$this->activity_m->write($message, $combine_billing);

		// redirect to combine_billing
		redirect(site_url('combine_billing'));
	}


	public function _unique_title($str)
	{
		// Do NOT validate if combine_billing already exists
		// UNLESS it's the name for the current combine_billing
		$id = $this->uri->segment(2);
		
		$this->db->where('title',$this->input->post('title'));
		!$id || $this->db->where('combine_billing_id !=', $id);

		$combine_billing = $this->combine_billings->get();

		if (count($combine_billing)) 
		{
			$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file combine_billing.php */
/* Location: ./application/controllers/combine_billing.php */