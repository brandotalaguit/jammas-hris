<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'project';
		$this->data['page_title'] = 'Projects';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-danger' href='".base_url('project/new')."'><i class='fa fa-plus'></i> New Project</a>";
		
		$this->load->model('projects');
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
		$config['total_rows'] = $this->projects->count();
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

		// Fecth all project
		$this->db->order_by('title');
		$this->data['projects'] = $this->projects->get();
		
		// Load view 
		$this->load_view('project/index');

	}	

	public function edit($id = NULL)
	{
		// Fetch a project or create a new project
		if ($id) 
		{
			$this->data['projects'] = $this->projects->get($id);
			count($this->data['projects']) || $this->data['errors'][] = 'Project could not be found';
		}
		else
		{
			$this->data['projects'] = $this->projects->get_new();
		}

		// Set up the form
		$rules = $this->projects->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->projects->array_from_post(array(
				'title', 
				'address', 
				'business_style', 
				'po', 
				'tin', 
				'description')
			);

			$data = array_merge($data, ['rate_daily' => 0, 'rate_monthly' => 0, 'rate_semi_monthly' => 0]);


			$rate = $this->input->post('rate', TRUE);
			if ($rate == 4)
				$data['rate_hourly'] = 1;
			if ($rate == 1)
				$data['rate_daily'] = 1;
			if ($rate == 2)
				$data['rate_monthly'] = 1;
			if ($rate == 3)
				$data['rate_semi_monthly'] = 1;
			
			$data['user_id'] = $this->session->userdata('Id');

			$this->projects->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[title]</strong> Project has been updated";
			$this->activity_m->write($message, $this->data['projects'], $data);

			// redirect to project
			redirect(site_url('project/index'));
		}


		// Set up view
		$this->data['page_title'] = 'Editing Project # ' . $id;
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);


		

		// Load the view
		$this->load_view('project/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$project = $this->projects->get($id, TRUE);

		// process delete
		$this->projects->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$project->title</strong> Project has been removed";
		$this->activity_m->write($message, $project);

		// redirect to project
		redirect(site_url('project'));
	}


	public function _unique_title($str)
	{
		// Do NOT validate if project already exists
		// UNLESS it's the name for the current project
		$id = $this->uri->segment(2);
		
		$this->db->where('title',$this->input->post('title'));
		!$id || $this->db->where('project_id !=', $id);

		$project = $this->projects->get();

		if (count($project)) 
		{
			$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}


	public function json_dropdown()
	{
	    return $this->output->set_content_type('application/json')->set_output(json_encode(
	    	$this->projects->dropdown($this->input->post('search', TRUE))
	    ));
	}

}

/* End of file project.php */
/* Location: ./application/controllers/project.php */