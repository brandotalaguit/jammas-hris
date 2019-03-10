<?php 
/**
* Filename: employee_m.php
* Author: Brando Talaguit (ITC Developer)
*/
class Employees extends MY_Model
{

	protected $table_name = "employees";
	protected $primary_key = "employee_id";	
	protected $order_by = "lastname, firstname, middlename";
	protected $timestamps = TRUE;
	public $rules = array(
			'lastname' => array('field' => 'lastname', 'label' => 'Lastname', 'rules' => 'strtoupper|trim|required|callback__unique_name|xss_clean'),
			'firstname' => array('field' => 'firstname', 'label' => 'Firstname', 'rules' => 'strtoupper|trim|required|xss_clean'),
			'middlename' => array('field' => 'middlename', 'label' => 'Middlename', 'rules' => 'strtoupper|trim|xss_clean'),
			'civil_status' => array('field' => 'civil_status', 'label' => 'Civil Status', 'rules' => 'strtoupper|trim|xss_clean'),
			'date_of_birth' => array('field' => 'date_of_birth', 'label' => 'Date of Birth', 'rules' => 'trim|date|xss_clean'),
			'birth_place' => array('field' => 'birth_place', 'label' => 'Place of Birth', 'rules' => 'trim|xss_clean'),
			'street' => array('field' => 'street', 'label' => 'Street', 'rules' => 'strtoupper|trim|xss_clean'),
			'barangay' => array('field' => 'barangay', 'label' => 'Barangay', 'rules' => 'strtoupper|trim|xss_clean'),
			'city' => array('field' => 'city', 'label' => 'City', 'rules' => 'strtoupper|trim|xss_clean'),
			'contact_nos' => array('field' => 'contact_nos', 'label' => 'Contact Number', 'rules' => 'trim|xss_clean'),
			'email' => array('field' => 'email', 'label' => 'Primary E-mail', 'rules' => 'trim|valid_email'),
			'email2' => array('field' => 'email2', 'label' => 'Secondary E-mail', 'rules' => 'trim|valid_email')
		);
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_new()
	{
		$employee = new stdClass();
		$employee->account_no = '';
		$employee->lastname = '';
		$employee->firstname = '';
		$employee->middlename = '';
		$employee->civil_status = '';
		$employee->date_of_birth = '';
		$employee->birth_place = '';
		$employee->office_id = 0;
		$employee->employment_status_id = 0;
		$employee->street = '';
		$employee->barangay = '';
		$employee->city = '';
		$employee->occupation = '';
		$employee->present_employer = '';
		$employee->other_income = 0;
		$employee->nearest_relative = '';
		$employee->dependent_nos = 0;
		$employee->date_of_employeeship = '';
		$employee->contact_nos = '';
		$employee->email = '';
		$employee->email2 = '';
		$employee->is_approved = 0;
		$employee->secretary = '';
		$employee->noted_by = '';

		return $employee;
	}


	public function get_loan_balance_with_monthly_amortization($employee_id, $single = TRUE)
	{
		$this->db->select("
			employees.*, salary_15, salary_30, 			
			(
				SELECT SUM(amortization_15) FROM loans 
				WHERE 
					loans.employee_id = $employee_id AND 
					loans.is_actived = 1 AND
					loans.is_approved = 1 AND 
					loans.is_closed = 0
				GROUP BY loans.employee_id
			) as total_amortization_15, 
			(
				SELECT SUM(amortization_30) FROM loans 
				WHERE 
					loans.employee_id = $employee_id AND 
					loans.is_actived = 1 AND
					loans.is_approved = 1 AND 
					loans.is_closed = 0
				GROUP BY loans.employee_id
			) as total_amortization_30, 
			(
				SELECT SUM(loan_amount) FROM loans 
				WHERE 
					loans.employee_id = $employee_id AND 
					loans.is_actived = 1 AND
					loans.is_approved = 1 AND 
					loans.is_closed = 0
				GROUP BY loans.employee_id
			) as total_loans, 
			(
				SELECT SUM(amount) FROM cash_receipt_particulars 
				LEFT JOIN loans 
					ON cash_receipt_particulars.loan_id = loans.loan_id
				WHERE 
					loans.employee_id = $employee_id AND 
					loans.is_actived = 1 AND 
					cash_receipt_particulars.is_actived = 1 AND
					loans.is_closed = 0 
				GROUP BY loans.employee_id
			) as total_loan_payments"
			, FALSE
		);
		
		// join statements
		$this->db->join('loans', 'loans.employee_id = employees.employee_id', 'left');
		$this->db->join('employee_salary', 'employee_salary.employee_id = employees.employee_id', 'left');

		// condition(s)
		$this->db->where('employee_salary.is_actived', 1);

		return parent::get($employee_id, $single);
	}

	public function get_with_complete_info($id = NULL, $single = FALSE)
	{
		// select statements
		$this->db->select('employees.*, b.employment_status', FALSE);
		
		// join statements
		$this->db->join('employment_status as b', 'employees.employment_status_id = b.employment_status_id', 'left');

		return parent::get($id, $single);
	}

	public function get_office()
	{
		// Fetch office
		$this->db->select('office_id, office_description, office_code')->where('is_actived', 1);
		$offices = $this->db->order_by('office_description')->get('offices')->result();

		// Return key -> value pair array
		$array = array();
		if (count($offices)) 
		{
			foreach ($offices as $office) 
			{
				// $array[$office->office_id] = array($office->office_id => $office->office_description);
				$array[$office->office_id] = $office->office_description;
			}
		}
		return $array;
	}

	public function get_employment_status()
	{
		// Fetch employment status
		$this->db->select('employment_status_id, employment_status')->where('is_actived', 1);
		$pages = $this->db->order_by('employment_status')->get('employment_status')->result();

		// Return key => value pair array
		$array = array();
		if (count($pages)) 
		{
			foreach ($pages as $page) 
			{
				$array[$page->employment_status_id] = $page->employment_status;
			}
		}
		return $array;
	}	


	public function get_employee_status()
	{
		// Fetch office
		$this->db->select('employee_status_id, employee_status')->where('is_actived', 1);
		$employee_status = $this->db->order_by('employee_status')->get('employees_status')->result();

		// Return key -> value pair array
		$array = array();
		if (count($employee_status)) 
		{
			foreach ($employee_status as $status) 
			{
				$array[$status->employee_status_id] = $status->employee_status;
			}
		}
		return $array;
	}

}

/*Location: ./application/models/employee_m.php*/
 ?>