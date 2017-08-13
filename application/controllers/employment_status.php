<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employment_status extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'employment_status';
		$this->data['page_title'] = 'Deduction Categories';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-primary' href='".base_url('employment_status/new')."'><i class='fa fa-plus'></i> New Employment Status</a> <a class='btn btn-primary' href='".base_url('employment_status/print')."'><i class='fa fa-print'></i> Print</a>";
		
		$this->load->model('employment_statuses');
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
		$config['total_rows'] = $this->employment_statuses->count();
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
			if ($by == "employment_status_code") 
			{
				$this->db->like('employment_status_code', $q, 'after');
			}
			elseif ($by == "employment_status") 
			{
				$this->db->like('employment_status', $q, 'after');
			}
			unset($this->data['pagination']);
		}

		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
			$this->db->where($filter_user);
		}

		// Fecth all project
		$this->db->order_by('employment_status');
		$this->data['employment_statuses'] = $this->employment_statuses->get();
		
		// Load view 
		$this->load_view('employment_status/index');

	}	

	public function print_pdf($id = NULL)
	{
		
		$this->data['employment_statuses'] = $this->employment_statuses->get();

		// Set up view
		$this->data['page_title'] = 'Employment Statuses';
		

		// Load the view
		
		ini_set("memory_limit","256M");
		$this->load->library('pdf');
		$this->pdf->load_view('employment_status/print',$this->data);
		$this->pdf->render();
		$this->pdf->stream("employment_status.pdf");
		
	}

	public function edit($id = NULL)
	{
		// Fetch a project or create a new project
		if ($id) 
		{
			$this->data['employment_statuses'] = $this->employment_statuses->get($id);
			count($this->data['employment_statuses']) || $this->data['errors'][] = 'Employment Status could not be found';
		}
		else
		{
			$this->data['employment_statuses'] = $this->employment_statuses->get_new();
		}

		// Set up the form
		$rules = $this->employment_statuses->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->employment_statuses->array_from_post(array(
				'employment_status_code', 
				'employment_status',
				'remarks'
				)
			);

			
			

			$this->employment_statuses->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[title]</strong> Employment Status has been updated";
			$this->activity_m->write($message, $this->data['employment_statuses'], $data);

			// redirect to project
			redirect(site_url('employment_status/index'));
		}


		// Set up view
		$this->data['page_title'] = 'Editing Employment Status # ' . $id;
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);


		

		// Load the view
		$this->load_view('employment_status/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$employment_statuses = $this->employment_statuses->get($id, TRUE);

		// process delete
		$this->employment_statuses->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$employment_statuses->employment_status</strong> Employment Status has been removed";
		$this->activity_m->write($message, $project);

		// redirect to project
		redirect(site_url('employment_status'));
	}


	public function _unique_title($str)
	{
		// Do NOT validate if project already exists
		// UNLESS it's the name for the current project
		$id = $this->uri->segment(2);
		
		$this->db->where('employment_status',$this->input->post('employment_status'));
		!$id || $this->db->where('employment_status_id !=', $id);

		$employment_statuses = $this->employment_statuses->get();

		if (count($employment_statuses)) 
		{
			$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file deduction_category.php */
/* Location: ./application/controllers/deduction_category.php */