<?php 
/**
* Filename: philhealth_p_c_m.php
* Author: Junard De Leon (PHP Developer)
*/
class Philhealth_p_c_m extends MY_Model
{
	protected $table_name = "philhealth_premium_contribution_matrix";
	protected $primary_key = "ppc_id";	
	protected $order_by = "salary_base ASC";
	protected $timestamps = TRUE;

	public $rules = array(
		'salary_range_start' => ['field' => 'salary_range_start', 'label' => 'Salary Range Start', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'salary_range_end' => ['field' => 'salary_range_end', 'label' => 'Salary Range End', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'salary_base' => ['field' => 'salary_base', 'label' => 'Salary Base', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'employee_share' => ['field' => 'employee_share', 'label' => 'Employee Share', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'employer_share' => ['field' => 'employer_share', 'label' => 'Employer Share', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'total_monthly_premium' => ['field' => 'total_monthly_premium', 'label' => 'Total Monthly Premium', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$philhealth_matrix = new stdClass();
		$philhealth_matrix->salary_range_start = '0.00';
		$philhealth_matrix->salary_range_end = '0.00';
		$philhealth_matrix->salary_base = '0.00';
		$philhealth_matrix->employee_share = '0.00';
		$philhealth_matrix->employer_share = '0.00';
		$philhealth_matrix->total_monthly_premium = '0.00';
		$philhealth_matrix->remarks = '';
		return $philhealth_matrix;
	}

	


	public function delete($id)
	{
		// Delete a status
		parent::delete($id);

		// Reset employment_status ID for its members table
		// $this->db->set(array('project_id' => 0))->where('project_id', $id)->update('members');
	}

	
}

/*Location: ./application/models/philhealth_p_c_m.php*/
 ?>