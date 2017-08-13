<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->model('user_m');
	}

	public function login()
	{
		// Redirect a user if he's already logged in
		$dashboard = 'dashboard';
		$this->user_m->loggedin() == FALSE || redirect($dashboard);

		// Set form
		$rules = $this->user_m->rules;
		$this->form_validation->set_rules($rules);

		// Process form
		if ($this->form_validation->run() == TRUE) 
		{
			# authenticated and can now be redirected
			if ($this->user_m->login() == TRUE) 
			{
				redirect(site_url($dashboard), 'refresh');
			}
			else
			{
				$this->session->set_flashdata('error', '<h5>The following errors have occurred</h5> <ul> <li>Username/Password combination does not exists</li></ul>');
				redirect('site/login', 'refresh');
			}
		}
		
		if(validation_errors())
		{
			$validation_msg = "<h5>The following errors have occurred</h5> <ul>" . validation_errors('<li>','</li>') . "</ul>";
			$this->session->set_flashdata('error', $validation_msg);
			redirect('site/login');
		}

		// Load view
		$this->data['content'] = 'login/form';
		$this->data['title'] = '<h3>User Login | <small>Please login using your credential</small></h3>';
		$this->load->view('login/template', $this->data);

	}

	public function logout()
	{
		$this->user_m->logout();
		redirect(site_url('site/login'));
	}

	public function hash()
	{
		
		echo hash('sha512', 'hgrunt85' . config_item('encryption_key'));
		
	}
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */