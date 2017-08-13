<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller 
{
	protected $limit = 15;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');

		$this->load->library('form_validation');
		$this->load->library('pagination');		
		$this->load->library('session');
		
		$this->load->model('user_m');
		$this->load->model('activity_m');

		
		$this->load->model('projects');
		$this->load->model('employees');
		$this->load->model('positions');
		$this->load->model('rates');

		$model = $this->router->class . '_m';
		if(file_exists(APPPATH."models/$model.php"))
		{
		   $this->load->model($model);
		}

		$this->form_validation->set_error_delimiters('<li>', '</li>');
		
		// Login Check 
		$exception_uris = array(
			'site/login',
			'site/logout'
		);

		if (in_array(uri_string(), $exception_uris) == FALSE) 
		{
			if ($this->user_m->loggedin() == FALSE) 
			{
				redirect(site_url('site/login'));
			}
		}

		$attribute = ['role' => 'form', 'class' => 'form-horizontal'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		$this->data['master_data'] = array_keys(config_item('master_data'));
		$this->data['counter'] = $this->uri->segment(3, 0);
	}

}

/* End of file Admin_Controller.php */
/* Location: ./application/controllers/Admin_Controller.php */