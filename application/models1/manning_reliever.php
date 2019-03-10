<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Filename: manning_reliever.php
* Author: Brando Talaguit (PHP Developer)
*/
class Manning_reliever extends MY_Model
{
	protected $table_name = "manning_reliever";
	protected $primary_key = "manning_reliever_id";
	protected $order_by = "manning_reliever_id";

	public $rules = array(
		'mr_manning_id' => ['field' => 'mr_manning_id', 'label' => 'Employee', 'rules' => 'trim|required|intval|is_natural_no_zero|xss_clean'],
		// 'mr_project_id' => ['field' => 'mr_project_id', 'label' => 'Project', 'rules' => 'trim|required|intval|is_natural_no_zero|xss_clean'],
		'mr_payroll_id' => ['field' => 'mr_payroll_id', 'label' => 'Payroll', 'rules' => 'trim|required|intval|is_natural_no_zero|xss_clean'],
		'mr_rate' => ['field' => 'mr_rate', 'label' => 'Rate Type', 'rules' => 'intval|is_natural_no_zero|xss_clean'],
		'mr_employment_status_id' => ['field' => 'mr_employment_status_id', 'label' => 'Employment Status', 'rules' => 'intval|is_natural_no_zero|xss_clean'],
		'mr_daily_rate' => ['field' => 'mr_daily_rate', 'label' => 'Daily Rate', 'rules' => 'trim|required|to_decimal|greater_than[0]|xss_clean'],
		'mr_e_cola' => ['field' => 'mr_e_cola', 'label' => 'E-Cola', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'mr_allowance' => ['field' => 'mr_allowance', 'label' => 'Allowance', 'rules' => 'trim|to_decimal|xss_clean'],
		'mr_allowance_mode_of_payment' => ['field' => 'mr_allowance_mode_of_payment', 'label' => 'Allowance Mode of Payment', 'rules' => 'trim|intval|is_natural_no_zero|xss_clean'],
	);

	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$employee = new stdClass();
		$employee->mr_manning_id = '0';
		$employee->mr_employment_status_id = '0';
		$employee->mr_payroll_id = '0';
		$employee->mr_rate = '1';
		$employee->mr_daily_rate = '502.00';
		$employee->mr_e_cola = '10.00';
		$employee->mr_allowance = '0.00';
		$employee->mr_allowance_mode_of_payment = '0';

		return $employee;
	}




}

/*Location: ./application/models/manning_reliever.php*/
