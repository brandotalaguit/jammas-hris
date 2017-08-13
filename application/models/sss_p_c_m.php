<?php 
/**
* Filename: sss_p_c_m.php
* Author: Junard De Leon (PHP Developer)
*/
class Sss_p_c_m extends MY_Model
{
	protected $table_name = "sss_premium_contribution_matrix";
	protected $primary_key = "ssspc_id";	
	protected $order_by = "monthly_salary_credit ASC";
	protected $timestamps = TRUE;

	public $rules = array(
		'salary_range_start' => ['field' => 'salary_range_start', 'label' => 'Salary Range Start', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'salary_range_end' => ['field' => 'salary_range_end', 'label' => 'Salary Range End', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'monthly_salary_credit' => ['field' => 'monthly_salary_credit', 'label' => 'Monthly Salary Credit', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'employee_share' => ['field' => 'employee_share', 'label' => 'Employee Share', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'employer_share' => ['field' => 'employer_share', 'label' => 'Employer Share', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'employee_compensation_program' => ['field' => 'employee_compensation_program', 'label' => 'Employee Compensation Program', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'total_monthly_premium' => ['field' => 'total_monthly_premium', 'label' => 'Total Monthly Premium', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$sss_matrix = new stdClass();
		$sss_matrix->salary_range_start = '0.00';
		$sss_matrix->salary_range_end = '0.00';
		$sss_matrix->monthly_salary_credit = '0.00';
		$sss_matrix->employee_share = '0.00';
		$sss_matrix->employer_share = '0.00';
		$sss_matrix->employee_compensation_program = '0.00';
		$sss_matrix->total_monthly_premium = '0.00';
		$sss_matrix->remarks = '';
		return $sss_matrix;
	}

	


	public function delete($id)
	{
		// Delete a status
		parent::delete($id);

		// Reset employment_status ID for its members table
		// $this->db->set(array('project_id' => 0))->where('project_id', $id)->update('members');
	}

	
}

/*Location: ./application/models/sss_p_c_m.php*/
 ?>