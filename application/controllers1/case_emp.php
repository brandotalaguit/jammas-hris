<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Case_Emp extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'case_emp';
		$this->data['page_title'] = 'Cases';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-primary' href='".base_url('case/new')."'><i class='fa fa-plus'></i> New Case</a> <button class='btn btn-primary' name='btn_print' type='submit' value='Search'>Print <span class='fa fa-print'></span></button>";
		
		$this->load->model('cases');
	}

	public function index()
	{
		$search = FALSE;
		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
			$filter_user = array('user_id' => $this->session->userdata('Id'));
			$this->db->where($filter_user);
		}
		$this->data['employees'] = $this->cases->get_employees();
		$this->data['case_categories'] = $this->cases->get_case_categories();
		$this->data['projects'] = $this->cases->get_projects();
		
		// Set up pagination 
		$config['total_rows'] = $this->cases->count();
		$config['per_page'] = 15;
		$this->pagination->initialize($config);

		// Create pagination links
		$this->data['pagination'] = $this->pagination->create_links();

		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		if ($this->input->post('btn_search') == 'Search') 
		{

			if ($this->input->post('project_id') != 0) 
			{
				$this->form_validation->set_rules('project_id', 'Project Id', 'required|strtoupper');
				$project_id = $this->input->post('project_id');
				$this->db->where('cases.project_id', $project_id);
				
			}	
		
			if ($this->input->post('employee_id') != 0) 
			{
				$this->form_validation->set_rules('employee_id', 'Employee', 'required|strtoupper');
				$employee_id = $this->input->post('employee_id');
				$this->db->where('cases.employee_id', $employee_id);
				
			}

			if ($this->input->post('case_category_id') != 0) 
			{
				$this->form_validation->set_rules('case_category_id', 'Case Category', 'required|strtoupper');
				$case_category_id = $this->input->post('case_category_id');
				$this->db->where('cases.case_category_id', $case_category_id);
				
			}


			unset($this->data['pagination']);
			$search = TRUE;
		}

		

		! $search || $this->db->ar_limit = FALSE;	

		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
			$this->db->where($filter_user);
		}

		// Fecth all project
		$this->db->order_by('date_filed DESC');
		$this->data['cases'] = $this->cases->get_cases();
		
		$this->data['last_query'] = $this->db->last_query();
		
		// Load view 
		$this->load_view('case_emp/index');

	}	

	public function print_pdf($id = NULL)
	{
		$limit = 'LIMIT';
		$last_query = explode($limit,$this->input->post('last_query'));
		$this->data['query'] = $this->db->query($last_query[0]);

		$this->data['cases'] = $this->data['query']->result();

		// Set up view
		$this->data['page_title'] = 'Cases';
		
		
		//Load the view
		
		ini_set("memory_limit","256M");
		$this->load->library('pdf');
		$this->pdf->set_paper("A4", "landscape");
		$this->pdf->load_view('case_emp/print',$this->data);
		$this->pdf->render();
		$this->pdf->stream("case.pdf");
		
	}

	public function edit($id = NULL)
	{
		// Fetch a project or create a new project
		if ($id) 
		{
			$this->data['cases'] = $this->cases->get($id);
			count($this->data['cases']) || $this->data['errors'][] = 'Case could not be found';
		}
		else
		{
			$this->data['cases'] = $this->cases->get_new();
		}

		// Set up the form
		$rules = $this->cases->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->cases->array_from_post(array(
				'employee_id', 
				'project_id', 
				'case_category_id',
				'date_filed',
				'remarks',
				)
			);

			
			$this->cases->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[title]</strong> Case has been updated";
			$this->activity_m->write($message, $this->data['cases'], $data);

			// redirect to project
			redirect(site_url('case_emp/index'));
		}

		$this->data['employees'] = $this->cases->get_employees();
		$this->data['case_categories'] = $this->cases->get_case_categories();
		$this->data['projects'] = $this->cases->get_projects();
		// Set up view
		$this->data['page_title'] = 'Editing Case # ' . $id;
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);


		

		// Load the view
		$this->load_view('case_emp/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$cases = $this->cases->get($id, TRUE);

		// process delete
		$this->cases->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$cases->case_category</strong> Case has been removed";
		$this->activity_m->write($message, $project);

		// redirect to project
		redirect(site_url('case_emp'));
	}


	public function _unique_title($str)
	{
		// Do NOT validate if project already exists
		// UNLESS it's the name for the current project
		$id = $this->uri->segment(2);
		
		$this->db->where('case_category',$this->input->post('case_category'));
		!$id || $this->db->where('case_category_id !=', $id);

		$cases = $this->cases->get();

		if (count($cases)) 
		{
			$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file case.php */
/* Location: ./application/controllers/case.php */