<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rate extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'rate';
		$this->data['page_title'] = 'Rates';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="ion ion-android-star"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-danger' href='".base_url('rate/new')."'><i class='fa fa-plus'></i> New Rate</a>";
		
		$this->load->model('rates');
	}

	public function index()
	{
		// Set up pagination 
		$config['total_rows'] = $this->rates->count();
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
			if ($by == "Rate") 
			{
				$this->db->like('rate', $q, 'after');
			}
			elseif ($by == "Remarks") 
			{
				$this->db->like('remarks', $q, 'after');
			}
			unset($this->data['pagination']);
		}

		// Fecth all rate
		$this->data['rates'] = $this->rates->get();
		
		// Load view 
		$this->load_view('rate/index');

	}	

	public function add_new()
	{
		// Fetch a rate 
		$this->data['rate'] = $this->rates->get_new();

		// Set up the form 
		$rules = $this->rates->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			
			$data = $this->rates->array_from_post(['rate_title', 'remarks', 'created_at']);

			$this->rates->save($data);

			// save log
			$message = "<i class='fa fa-plus'></i> Rate <strong>$data[rate]</strong> has been added";
			$this->activity_m->write($message, NULL, $data);

			// redirect to rate
			redirect(site_url('rate/index'));
		}

		// Set up view
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('rate/edit');
		
	}

	public function edit($id = NULL)
	{
		// Fetch a rate or create a new rate
		if ($id) 
		{
			$this->data['rate'] = $this->rates->get($id);
			count($this->data['rate']) || $this->data['errors'][] = 'Rate could not be found';
		}
		else
		{
			$this->data['rate'] = $this->rates->get_new();
		}

		// Set up the form
		$rules = $this->rates->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			$data = $this->rates->array_from_post(['rate_title', 'remarks', 'updated_at']);

			$this->rates->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[rate]</strong> Rate has been updated";
			$this->activity_m->write($message, $this->data['rate'], $data);

			// redirect to rate
			redirect(site_url('rate/index'));
		}


		// Set up view
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('rate/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$rate = $this->rates->get($id, TRUE);

		// process delete
		$this->rates->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$rate->rate</strong> Rate has been removed";
		$this->activity_m->write($message, $rate);

		// redirect to rate
		redirect(site_url('rate'));
	}


	public function _unique_rate($str)
	{
		// Do NOT validate if rate already exists
		// UNLESS it's the name for the current rate
		$id = $this->uri->segment(2);
		
		$this->db->where('rate_title',$this->input->post('rate_title'));
		!$id || $this->db->where('rate_id !=', $id);

		$rate = $this->rates->get();

		if (count($rate)) 
		{
			$this->form_validation->set_message('_unique_rate', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}	

}

/* End of file rate.php */
/* Location: ./application/controllers/rate.php */