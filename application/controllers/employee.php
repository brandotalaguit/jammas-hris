<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('employees');
		
		$this->data['icon'] = '<i class="fa fa-users"></i>';
		$this->data['controller'] = 'employee';
		$this->data['page_title'] = 'Employees';
		$this->data['page_subtitle'] = '';
		$this->data['page_btn_add'] = " <a class='btn btn-danger' href='".base_url()."employee/new'><i class='ion ion-person-add'></i> New employee</a>";

	}

	public function index()
	{
		// Set up pagination 
		$config['total_rows'] = $this->employees->count();
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
			if ($by == "Lastname") 
			{
				$this->db->like('employees.lastname', $q, 'after');
			}
			elseif ($by == "Firstname") 
			{
				$this->db->like('employees.firstname', $q, 'after');
			}
			elseif ($by == "Middlename") 
			{
				$this->db->like('employees.middlename', $q, 'after');
			}
			elseif ($by == "AccountNo") 
			{
				$this->db->where('employees.account_no', $q);
			}
			unset($this->data['pagination']);
		}

		// Fecth all employees
		$this->data['employees'] = $this->employees->get_with_complete_info();

		// Set up the view
		$this->data['search_form'] = $this->load->view('employee/search_form', $this->data, TRUE);
		
		// Load view 
		$this->load_view('employee/index');

	}


	public function edit($id = NULL)
	{
		// Fetch a employees or create a new partcipant
		if ($id) 
		{
			$this->data['member'] = $this->employees->get($id, TRUE);
			// $qry = $this->db->last_query();
			// $salary = $this->salary_input_m->get_by("employees_id = $id", TRUE);
			// $this->data['salary'] = count($salary) ? $salary : $this->salary_input_m->get_new();
			if (count($this->data['member']) == 0) 
			{
				// Error message
				$this->session->set_flashdata('id', 'x');
				// $this->session->set_flashdata('error', $qry);
				$this->session->set_flashdata('error', 'employees Id could not be found');

				// redirect
				redirect(site_url('employee'));
			}
		}
		else
		{
			$this->data['member'] = $this->employees->get_new();
		}

		// Employment status for dropdown
		// $this->data['employment_status'] = $this->employees->get_employment_status();

		// employees status for dropdown
		// $this->data['employees_status'] = $this->employees->get_employees_status();

		// Offices for dropdown
		// $this->data['offices'] = $this->employees->get_office();

		// Set up form
		$rules = $this->employees->rules;
		$this->form_validation->set_rules($rules);

		// Process form
		if ($this->form_validation->run() == TRUE) 
		{
			$data = $this->employees->array_from_post(array(
				'lastname',
				'firstname',
				'middlename',
				'civil_status',
				'date_of_birth',
				'birth_place',
				'street',
				'barangay',
				'city',
				'contact_nos'
				)
			);
			
			$employees_id = $this->employees->save($data, $id);

			// save log
			$this->session->set_flashdata('id', $id);
			$message = "<i class='fa fa-users'></i> <strong>$data[lastname] $data[firstname]</strong> updated his/her employeeship profile";
			$this->activity_m->write($message, $this->data['employees'], $data);

			// redirect to employees
			redirect(site_url('employee'));
		}

		// Set up view 
		$this->data['page'] = 'employees';

		// Load view
		$this->load_view('employee/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$employees = $this->employees->get($id, TRUE);
		$this->db->close();

		// process delete
		$this->employees->delete($id);
		
		// save log
		$message = "<i class='fa fa-users'></i> <strong>$employees->lastname $employees->firstname</strong> had widthdraw his employeeship.";
		$this->activity_m->write($message, $employees);

		// redirect to employees
		redirect(site_url('employee'));
	}


	public function _unique_name($str)
	{
		// Do NOT validate if user already exists
		// UNLESS it's the name for the current user
		
		$lastname = $this->input->post('lastname');
		$firstname = $this->input->post('firstname');
		$middlename = $this->input->post('middlename');

		$id = $this->uri->segment(2, 0);
		
		$this->db->where(array('lastname'=>$lastname, 'firstname' => $firstname, 'middlename' => $middlename));
		!$id || $this->db->where("employee_id !=", $this->uri->segment(2));
		$employees = $this->employees->get();

		if (count($employees)) 
		{
			$this->form_validation->set_message('_unique_name', "$lastname, $firstname $middlename is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

	public function _unique_account_no($str)
	{
		// Do NOT validate if user already exists
		// UNLESS it's the name for the current user
		$id = $this->uri->segment(2);		
		$this->db->where("account_no", $this->input->post('account_no'));
		!$id || $this->db->where('employees_id !=', $id);

		$employees = $this->employees->get();

		if (count($employees)) 
		{
			$this->form_validation->set_message('_unique_account_no', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

	public function info($id = NULL)
	{
		// Fetch a employees or create a new employees
		if ($id) 
		{
			// $this->data['employees'] = $this->employees->get($id);
			$this->data['employees'] = $this->employees->get_loan_balance_with_monthly_amortization($id);
			count($this->data['employees']) || $this->data['errors'] = 'employees could not be found';
		}
		else
		{
			$this->data['employees'] = $this->employees->get_new();
		}

		// Load view
		$this->load->view('default_popup', $this->data);

	}

	

}

/* End of file employees.php */
/* Location: ./application/controllers/employees.php */