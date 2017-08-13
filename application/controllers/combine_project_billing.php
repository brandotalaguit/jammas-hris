<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class combine_project_billing extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'combine_project_billing';
		$this->data['page_title'] = anchor(base_url('combine_project_billing/new'), '<i class="fa fa-plus"></i> New Combine Project Billing', array('class' => 'btn btn-danger btn-lg'));
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-copy"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-danger' href='".base_url('combine_project_billing/new')."'><i class='fa fa-plus'></i> New Combine Billing</a>";
		
		$this->load->model(array('combine_project_billings','combine_project_billings', 'project_billings', 'projects'));
	}

	
	public function delete($id = NULL)
	{
		// fetch data
		$combine_project_billing = $this->combine_project_billings->get($id, TRUE);

		// process delete
		$this->combine_project_billings->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$combine_project_billing->title</strong> Combine_billing has been removed";
		$this->activity_m->write($message, $combine_project_billing);

		// redirect to combine_project_billing
		redirect(base_url('combine_billing/'.$combine_project_billing->cb_id.'/edit'));
	}



}

/* End of file combine_project_billing.php */
/* Location: ./application/controllers/combine_project_billing.php */