<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	function __construct($foo = null) 
	{
		parent::__construct();
		$this->load->model('employees');
		$this->load->model('projects');
		$this->load->model('positions');
		$this->load->model('user_m');
	}

	public function index()
	{

		$this->data['content'] = "dashboard/index";
		$this->data['page_title'] = "J.A.M.M.A.S. Incorporated ";
		$this->data['page_subtitle'] = "(Janitorial Maintenance Manpower &amp; Allied Services)";
		$this->data['icon'] = '<i class="fa fa-dashboard"></i>';
		$this->data['controller'] = "Dashboard";
		$this->data['page'] = "";
		$this->data['members'] = $this->employees->get();
		
		$this->data['project_cnt'] = $this->projects->count();
		$this->data['position_cnt'] = $this->positions->count();
		$this->data['employee_cnt'] = $this->employees->count();
		$this->data['user_cnt'] = $this->user_m->count();
		
		$this->db->limit(8);
		$this->data['activities'] = $this->activity_m->get();

		$this->load->view('template/default', $this->data);


	}

	public function logout()
	{
		redirect('site');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */