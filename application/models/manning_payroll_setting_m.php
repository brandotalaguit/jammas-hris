<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manning_payroll_setting_m extends MY_Model {

	public $data;

	protected $table_name = "manning_payroll_setting";
	protected $primary_key = "manning_payroll_setting_id";
	protected $order_by = "manning_payroll_setting_id";

	public $rules = array(
	    'mode_of_payment_pagibig' => ['field' => 'mode_of_payment_pagibig', 'label' => 'PAGIBIG mode of payment', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
	    'mode_of_payment_philhealth' => ['field' => 'mode_of_payment_philhealth', 'label' => 'PHILHEALTH mode of payment', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
	    'mode_of_payment_sss' => ['field' => 'mode_of_payment_sss', 'label' => 'SSS mode of payment', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
	    'save_option' => ['field' => 'save_option', 'label' => 'Save option', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
	    'projects[]' => ['field' => 'projects', 'label' => 'Project', 'rules' => 'xss_clean|callback__check_projects'],
	);

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_new()
	{
		$payroll = new stdClass();

		$payroll->rate = 0;
		$payroll->mode_of_payment_pagibig = 0;
		$payroll->mode_of_payment_philhealth = 0;
		$payroll->mode_of_payment_sss = 0;
		$payroll->save_option = 0;
		$payroll->projects = array();

		return $payroll;
	}

}

/* End of file manning_payroll_setting_m.php */
/* Location: ./application/models/manning_payroll_setting_m.php */