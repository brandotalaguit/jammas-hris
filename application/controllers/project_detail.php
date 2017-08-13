<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_detail extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'project_detail';
		$this->data['page_title'] = 'Project Details';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';

		$this->load->model('project_details');
	}

	public function index($project_id)
	{
		// $project_details = $this->db;

		// $this->db->select('title, description, employees.employee_id, lastname, firstname, middlename, position');
		// $this->projects->with_employees();
		// $this->projects->with_rates();
		// $project_details = $this->projects->get($project_id);
		// dump($project_details);

		if (!intval($project_id)) 
		{
			$this->session->set_userdata('error', 'Access denied, invalid project id detected');
			redirect(site_url('dashboard'));
		}

		$project = $this->projects->get($project_id);


		// Set up view
		$this->data['project_id'] = $project_id;
		$this->data['page_title'] = $project->title;
		$this->data['page_subtitle'] = $project->description;

		// $this->db->select('project_employees.*, position');
		$this->projects->with_employees();
		$this->projects->with_positions();
		$condition = ['project_employees.project_id' => $project_id];
		$this->data['project_personnels'] = $this->projects->get_by($condition);


		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('project_detail/index');
	}

	public function _display_message($msg, $redirect_to = 'dashboard')
	{
		$this->session->set_userdata('error', $msg);
		redirect(site_url($redirect_to));
	}

	public function edit($project_id, $id = NULL)
	{
		
		if (!intval($project_id))
		$this->_display_message('Access denied, invalid project id detected');

		$project = $this->projects->get($project_id);

		if (!count($project))
		$this->_display_message('Access denied, invalid project id detected');

		// Fetch project detail
		$this->data['project'] = $id == NULL ? $this->project_details->get_new($project_id) : $this->project_details->get_by($project_id, $id);

		$rules = $this->project_details->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// prep post data
			$_POST['project_id'] = $project_id;
			$_POST['user_id'] =$this->session->userdata('Id');

			$data = $this->project_details->array_from_post(
				[
					'project_id',
					'position_id',
					'employee_id',
					'regular_time_in',
					'regular_time_out',
					'user_id'
				]
			);
		
			$id = $this->project_details->save($data);
			$rate=[];
			foreach ($_POST['rate_id'] as $rate_id => $value) 
			{
				$rate[] = 
					[
						'project_id' => $project_id,
						'employee_id' => $_POST['employee_id'],
						'rate_id' => $rate_id, 
						'costs' => $value,
						'user_id' => $this->session->userdata('Id'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					];
			}

			$this->db->insert_batch('project_rates', $rate);			

			// $this->salary_input_m->save($salary_data);


			// // save log
			// $message = "<i class='fa fa-users'></i> <strong>$data[lastname] $data[firstname]</strong> is now a member of the coooperative";
			// $this->activity_m->write($message, NULL, $data);

			// // highligh row of the inserted data
			// $this->session->set_flashdata('id', $id);

			// // redirect to member
			redirect(base_url("project/$project_id/detail"));
		}

		// dropdown menu
		$this->data['employees'] = $this->projects->get_employees();
		$this->data['positions'] = $this->projects->get_positions();

		$this->data['rates'] = $this->rates->get();


		// Set up view
		$this->data['project_id'] = $project_id;
		$this->data['page_title'] = $project->title;
		$this->data['page_subtitle'] = $project->description;


		$attribute = ['role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('project_detail/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$project_detail = $this->project_details->get($id, TRUE);

		// process delete
		$this->project_details->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$project_detail->title</strong> Project has been removed";
		$this->activity_m->write($message, $project_detail);

		// redirect to project_detail
		redirect(site_url('project_detail'));
	}


	public function _unique_title($str)
	{
		// Do NOT validate if project_detail already exists
		// UNLESS it's the name for the current project_detail
		$id = $this->uri->segment(2);
		
		$this->db->where('title',$this->input->post('title'));
		!$id || $this->db->where('project_detail_id !=', $id);

		$project_detail = $this->project_details->get();

		if (count($project_detail)) 
		{
			$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

	public function billing_statement()
	{
		$this->load_view('sample_billing_statement');
	}

}

/* End of file project_detail.php */
/* Location: ./application/controllers/project_detail.php */