<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_position_rate extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'project_position';
		$this->data['page_title'] = 'Project Position Rate';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="ion ion-android-star"></i>';

		$this->load->model('project_position_rates');
		$this->load->model('project_billing_trans');
		$this->load->model('project_billings');
		$this->load->model('positions');
	}

	public function index($project_id)
	{

		if (!intval($project_id)) 
		{
			$this->session->set_userdata('error', 'Access denied, invalid project id detected');
			redirect(site_url('dashboard'));
		}

		$this->output->enable_profiler(TRUE);

		$project = $this->projects->get($project_id);

		// Set up view
		$this->data['project_id'] = $project_id;
		$this->data['page_title'] = $project->title;
		$this->data['page_subtitle'] = $project->project_id;

		// $this->db->select('project_employees.*, position');
		$this->projects->with_employees();
		$this->projects->with_positions();
		$condition = ['project_employees.project_id' => $project_id, 'project_employees.is_actived' => 1];
		$this->data['project_personnels'] = $this->projects->get_by($condition);


		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('project_employee/index');
	}

	public function _display_message($msg, $redirect_to = 'dashboard')
	{
		$this->session->set_userdata('error', $msg);
		redirect(site_url($redirect_to));
	}

	public function edit($project_id, $id = NULL)
	{

		// operator (||) left operand must be false to execute right operand.

		$this->data['project'] = $this->projects->get($project_id, TRUE);
		count($this->data['project']) || parent::redirect_to('Access denied, can not detect project id');
		
		if ($id == NULL)
		{
			// new
			$this->data['ppr'] = $this->project_position_rates->get_new();
		}
		else
		{
			// edit
			$this->data['ppr'] = $this->project_position_rates->get($id);
			$this->data['job'] = $this->positions->get($this->data['ppr']->position_id, TRUE);
		}


		// Validation rules
		$rules = $this->project_position_rates->rules;
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message('is_natural_no_zero', 'Plese select a %s');

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// prep post data
			$_POST['user_id'] = $this->session->userdata('Id');
			$_POST['project_id'] = $project_id;

			$data = $this->project_position_rates->array_from_post([
					'project_id',
					'position_id',

					// 'rates',
					'hourly_rate',
					'daily_rate',
					'semi_monthly_rate',
					'monthly_rate',

					'straight_duty',
					'night_diff',
					'night_ot_diff',
					'regular_ot_day',

					'rest_day_rate',
					'rest_day_ot_rate',
					'rest_day_special_holiday',
					'rest_day_special_ot_holiday',
					'rest_day_legal_holiday',
					'rest_day_legal_ot_holiday',
					
					'legal_holiday',
					'legal_ot_holiday',
					'special_holiday',
					'special_ot_holiday',

					// lates and absent
					'late_amount',
					'absent_rate',
					'absent_rate_per_day',
					'user_id'
				]);

			

			$id = $this->project_position_rates->save($data, $id);

			// // save log
			// $message = "<i class='fa fa-users'></i> <strong>$data[lastname] $data[firstname]</strong> is now a member of the coooperative";
			// $this->activity_m->write($message, NULL, $data);

			// // highligh row of the inserted data
			$this->session->set_flashdata('id', $id);

			if (!empty($_POST['project_bill_id'])) 
			{
				$project_billings = $this->project_billing_trans->fill_billing($_POST['project_bill_id'], $project_id, $id);
				// $this->output->enable_profiler(TRUE);
			}


			// redirect to member
			redirect(base_url("project_employee/$project_id/detail"));
		}

		// dropdown menu
		$this->data['billing_periods'] = $this->project_billings->get_billing_period($project_id);
		$this->data['positions'] = $this->projects->get_positions();
		$this->data['rates'] = $this->rates->get();


		// Set up view
		$this->data['project_id'] = $project_id;
		$this->data['page_title'] = $this->data['project']->title;
		$this->data['page_subtitle'] = $this->data['project']->description;
		

		// $attribute = ['role' => 'form'];
		// $this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('project_position_rate/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$ppr = $this->project_position_rates->get($id, TRUE);

		if ($ppr) 
		{
			$pos = $this->positions->get($ppr->position_id, TRUE);
			$proj = $this->projects->get($ppr->project_id, TRUE);
			
			// process deletion
			$this->project_position_rates->delete($id);

			// save log
			$message = "<i class='fa fa-trash'></i> The position <strong><span style='border-bottom:1px dotted #000'>{$pos->position}</span> of {$proj->title}</strong> has been removed successfully";
			$this->activity_m->write($message, $ppr);
			$message = '<h4>SUCCESS.</h4>' . $message;
			// redirect
			parent::redirect_to($message, "project_employee/{$ppr->project_id}/detail", FALSE);
		}
		
		parent::redirect_to("<h4>TRANSACTION FAILED.</h4>Record could not be deleted. PPR ID {$id} not found.<br>Please check project position rate id used.");

	}


	public function _unique_title($str)
	{
		// Do NOT validate if project_employee already exists
		// UNLESS it's the name for the current project_employee
		$id = $this->uri->segment(2);
		
		$this->db->where('title',$this->input->post('title'));
		!$id || $this->db->where('project_employee_id !=', $id);

		$project_employee = $this->project_employees->get();

		if (count($project_employee)) 
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

/* End of file project_employee.php */
/* Location: ./application/controllers/project_employee.php */