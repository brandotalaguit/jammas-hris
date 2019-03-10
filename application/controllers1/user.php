<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();

		$this->load->library('pagination');

		$this->data['controller'] = 'Users';
		$this->data['page_title'] = 'User Account';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="glyphicon glyphicon-user"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-danger' href='".base_url('user/new')."'><i class='glyphicon glyphicon-user'></i> New User Account</a>";

		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
		    parent::redirect_to("You are not authorized to access this page.");
		}
	}

	public function index()
	{
		// Set up pagination 
		$config['total_rows'] = $this->user_m->count();
		$config['per_page'] = 5;
		$this->pagination->initialize($config);

		// Create pagination links
		$this->data['pagination'] = $this->pagination->create_links();


		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		// Fecth all user
		$this->data['users'] = $this->user_m->get();

		// Load view 
		$this->load_view('user/index');

	}	

	public function add_new()
	{
		// Fetch a user 
		$this->data['user'] = $this->user_m->get_new();	

		// Set up the form 
		$rules = $this->user_m->rules_admin;
		$rules['Password']['rules'] .= '|required';
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			$data = $this->user_m->array_from_post(
				[
					'LastName', 
					'FirstName', 
					'MiddleName', 
					'Birthday',
					'Username',
					'Password',
					'AccountType',
					'EmailAddress'
				]
			);

			if (!empty($data['Password'])) 
			{
				// encrypt Password 
				$data['Password'] = $this->user_m->hash($data['Password']);
			}
			else
			{
				// We don't save an empty password
				unset($data['Password']);
			}

			$this->user_m->save($data);

			// save log
			$message = "<i class='fa fa-user'></i> A new user <strong>$data[LastName] $data[FirstName]</strong> has been added";
			$this->activity_m->write($message, NULL, $data);

			// redirect to user			
			redirect(site_url('user/index'));
		}

		// Set up view
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('user/edit');
		
	}

	public function edit($id = NULL)
	{
		// Fetch a user or create a new user
		if ($id) 
		{
			$this->data['user'] = $this->user_m->get($id);
			count($this->data['user']) || $this->data['errors'][] = 'User could not be found';
		}
		else
		{
			$this->data['user'] = $this->user_m->get_new();
		}

		// Set up the form
		$rules = $this->user_m->rules_admin;
		$id || $rules['Password']['rules'] .= '|required';
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			$data = $this->user_m->array_from_post(
				[
					'LastName', 
					'FirstName', 
					'MiddleName', 
					'Birthday',
					'Username',
					'AccountType',
					'Password',
					'EmailAddress'
				]
			);

			if (!empty($data['Password'])) 
			{
				// encrypt Password 
				$data['Password'] = $this->user_m->hash($data['Password']);
			}
			else
			{
				// We don't save an empty password
				unset($data['Password']);
			}

			$this->user_m->save($data, $id);

			// save log
			$message = "<i class='fa fa-user'></i> <strong>$data[LastName] $data[FirstName]</strong> updated his/her account profile";
			$this->activity_m->write($message, $this->data['user'], $data);

			// redirect to user
			redirect(site_url('user/index'));
		}

		// Set up the view 
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('user/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$user = $this->user_m->get($id, TRUE);

		// process delete
		$this->user_m->delete($id);

		// save log
		$message = "<i class='fa fa-user'></i> User account with username <strong>$user->Username </strong> has been removed";
		$this->activity_m->write($message, $user);

		// redirect to user
		redirect(site_url('user'));
	}


	public function _unique_name($str)
	{
		// Do NOT validate if user already exists
		// UNLESS it's the name for the current user

		$lastname = $this->input->post('LastName');
		$firstname = $this->input->post('FirstName');
		$middlename = $this->input->post('MiddleName');
		
		$this->db->where(array('LastName'=>$lastname, 'FirstName' => $firstname, 'MiddleName' => $middlename));
		$this->db->where('Id !=', $this->uri->segment(2,0));
		$user = $this->user_m->get();

		if (count($user)) 
		{
			$this->form_validation->set_message('_unique_name', "$lastname $firstname $middlename is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}	

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */