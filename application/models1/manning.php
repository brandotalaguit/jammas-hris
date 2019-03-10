<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Filename: manning.php
* Author: Junard De Leon (PHP Developer)
*/
class Manning extends MY_Model
{
	protected $table_name = "manning";
	protected $primary_key = "manning_id";
	protected $order_by = "project_id DESC, lastname DESC";
	protected $timestamps = TRUE;

	protected $_dropdown_field = 'lastname, firstname, middlename';

	public $rules = array(
		'lastname' => ['field' => 'lastname', 'label' => 'Lastname', 'rules' => 'trim|required|callback__unique_name|xss_clean'],
		'firstname' => ['field' => 'firstname', 'label' => 'Firstname', 'rules' => 'trim|required|xss_clean'],
		'middlename' => ['field' => 'middlename', 'label' => 'Middlname', 'rules' => 'trim|xss_clean'],
		'mobile_no' => ['field' => 'mobile_no', 'label' => 'Mobile No.', 'rules' => 'trim|xss_clean'],
		'telephone_no' => ['field' => 'telephone_no', 'label' => 'Telephone No.', 'rules' => 'trim|xss_clean'],
		'email' => ['field' => 'email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'],
		'gender' => ['field' => 'gender', 'label' => 'Gender', 'rules' => 'trim|xss_clean'],
		'project_id' => ['field' => 'project_id', 'label' => 'Employee', 'rules' => 'trim|required|intval|is_natural_no_zero|xss_clean'],
		'position_id' => ['field' => 'position_id', 'label' => 'Employee', 'rules' => 'trim|required|intval|is_natural_no_zero|xss_clean'],
		'employment_status_id' => ['field' => 'employment_status_id', 'label' => 'Employment Status', 'rules' => 'trim|required|intval|is_natural_no_zero|xss_clean'],
		'length_of_service' => ['field' => 'length_of_service', 'label' => 'Length of Service', 'rules' => 'trim|intval|xss_clean'],
		'date_hired' => ['field' => 'date_hired', 'label' => 'Date Hired', 'rules' => 'trim|xss_clean'],
		'date_renew' => ['field' => 'date_renew', 'label' => 'Date Renew', 'rules' => 'trim|xss_clean'],
		'contract_expiry_date' => ['field' => 'contract_expiry_date', 'label' => 'Contract Expiry Date', 'rules' => 'trim|xss_clean'],
		'employee_no' => ['field' => 'employee_no', 'label' => 'Employee No.', 'rules' => 'trim|required|callback__is_unique|xss_clean'],
		'sss_no' => ['field' => 'sss_no', 'label' => 'SSS No.', 'rules' => 'trim|xss_clean'],
		'philhealth_no' => ['field' => 'philhealth_no', 'label' => 'Philhealth No.', 'rules' => 'trim|xss_clean'],
		'pagibig_no' => ['field' => 'pagibig_no', 'label' => 'PAGIBIG No.', 'rules' => 'trim|xss_clean'],
		'tin_no' => ['field' => 'tin_no', 'label' => 'TIN No.', 'rules' => 'trim|xss_clean'],
		'date_of_birth' => ['field' => 'date_of_birth', 'label' => 'Date of Birth', 'rules' => 'trim|xss_clean'],
		'age' => ['field' => 'age', 'label' => 'Age', 'rules' => 'trim|intval|is_natural_no_zero|xss_clean'],
		'address1' => ['field' => 'address1', 'label' => 'Address Line 1', 'rules' => 'trim|xss_clean'],
		'address2' => ['field' => 'address2', 'label' => 'Address Line 2', 'rules' => 'trim|xss_clean'],
		'contract_remarks' => ['field' => 'contract_remarks', 'label' => 'Contract Remarks', 'rules' => 'trim|xss_clean'],
		'rate' => ['field' => 'rate', 'label' => 'Rate Type', 'rules' => 'trim|required|to_decimal|xss_clean'],
		'daily_rate' => ['field' => 'daily_rate', 'label' => 'Daily Rate', 'rules' => 'trim|required|to_decimal|greater_than[0]|xss_clean'],
		'semi_monthly_rate' => ['field' => 'semi_monthly_rate', 'label' => 'Semi Monthly Rate', 'rules' => 'trim|to_decimal|xss_clean'],
		'monthly_rate' => ['field' => 'monthly_rate', 'label' => 'Monthly Rate', 'rules' => 'trim|to_decimal|xss_clean'],
		'e_cola' => ['field' => 'e_cola', 'label' => 'E-Cola', 'rules' => 'trim|required|to_decimal|xss_clean'],
		'allowance' => ['field' => 'allowance', 'label' => 'Allowance', 'rules' => 'trim|to_decimal|xss_clean'],
		'allowance_mode_of_payment' => ['field' => 'allowance_mode_of_payment', 'label' => 'Allowance Mode of Payment', 'rules' => 'trim|intval|is_natural_no_zero|xss_clean'],
		'allowance_remarks' => ['field' => 'allowance_remarks', 'label' => 'Allowance Remarks', 'rules' => 'trim|xss_clean'],
		'nbi_clearance_date_submitted' => ['field' => 'nbi_clearance_date_submitted', 'label' => 'NBI Clearance Date Submitted', 'rules' => 'trim|xss_clean'],
		'police_clearance_date_submitted' => ['field' => 'police_clearance_date_submitted', 'label' => 'Police Clearance Date Submitted', 'rules' => 'trim|xss_clean'],
		'brgy_clearance_date_submitted' => ['field' => 'brgy_clearance_date_submitted', 'label' => 'Barangay Clearance Date Submitted', 'rules' => 'trim|xss_clean'],
		'medical_clearance_date_submitted' => ['field' => 'medical_clearance_date_submitted', 'label' => 'Medical Clearance Date Submitted', 'rules' => 'trim|xss_clean'],
		'drugtest_clearance_date_submitted' => ['field' => 'drugtest_clearance_date_submitted', 'label' => 'Drug Test Clearance Date Submitted', 'rules' => 'trim|xss_clean'],
		'insurance_remarks' => ['field' => 'insurance_remarks', 'label' => 'Insurance Remarks', 'rules' => 'trim|xss_clean'],
		'date_filed_up' => ['field' => 'date_filed_up', 'label' => 'Date Filed Up', 'rules' => 'trim|xss_clean'],
		'mayors_permit_clerance_date_submitted' => ['field' => 'mayors_permit_clerance_date_submitted', 'label' => 'Mayor\'s Permit Clearance Date', 'rules' => 'trim|xss_clean'],
		'fit_to_work_date_submitted' => ['field' => 'fit_to_work_date_submitted', 'label' => 'Fit to work Clearance Date', 'rules' => 'trim|xss_clean'],
		'xray_date_submitted' => ['field' => 'xray_date_submitted', 'label' => 'X-Ray Clearance Date', 'rules' => 'trim|xss_clean'],
		'date_filed_up' => ['field' => 'date_filed_up', 'label' => 'Date Filed Up', 'rules' => 'trim|xss_clean'],
		'insurance_remarks' => ['field' => 'insurance_remarks', 'label' => 'Insurance Remarks', 'rules' => 'trim|xss_clean'],
		'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
	);

	function __construct()
	{
		parent::__construct();
	}

	public function max_proj_id($project_id)
	{
		$this->db->select('CAST(max(right(employee_no, 4))+1 AS UNSIGNED INT) max_id', FALSE);
		$this->db->group_by('project_id')->order_by('project_id', 'asc');
		$result = parent::get_by(['project_id' => $project_id], TRUE);
		// dump($this->db->last_query());
		// dump($result);
		$this->db->close();

		return $result->max_id;

	}

	public function get_new()
	{
		$employee = new stdClass();
		$employee->employee_no = '';
		$employee->lastname = '';
		$employee->firstname = '';
		$employee->middlename = '';
		$employee->mobile_no = '';
		$employee->telephone_no = '';
		$employee->email = '';
		$employee->gender = '';
		$employee->project_id = '0';
		$employee->position_id = '0';
		$employee->employment_status_id = '0';
		$employee->length_of_service = '';
		$employee->date_hired = '';
		$employee->date_renew = '';
		$employee->contract_expiry_date = '';
		$employee->sss_no = '';
		$employee->philhealth_no = '';
		$employee->pagibig_no = '';
		$employee->tin_no = '';
		$employee->date_of_birth = '';
		$employee->age = '';
		$employee->address1 = '';
		$employee->address2 = '';
		$employee->contract_remarks = '';
		$employee->rate = '0';
		$employee->daily_rate = '502.00';
		$employee->semi_monthly_rate = '0.00';
		$employee->monthly_rate = '0.00';
		$employee->e_cola = '10.00';
		$employee->allowance = '0.00';
		$employee->allowance_mode_of_payment = '0';
		$employee->allowance_remarks = '';
		$employee->nbi_clearance_date_submitted = '';
		$employee->police_clearance_date_submitted = '';
		$employee->brgy_clearance_date_submitted = '';
		$employee->medical_clearance_date_submitted = '';
		$employee->drugtest_clearance_date_submitted = '';
		$employee->mayors_permit_clerance_date_submitted = '';
		$employee->fit_to_work_date_submitted = '';
		$employee->xray_date_submitted = '';
		$employee->date_resigned = '';
		$employee->insurance_remarks = '';
		$employee->date_filed_up = '';
		$employee->remarks = '';


		return $employee;
	}

	public function get_employees($id = NULL, $single = FALSE, $fields = NULL)
	{

		// select statements
		$this->db->select('manning.*, f.employment_status as employment_status,  e.position as position, d.title as title', FALSE);

		// join statements
		$this->db->join('projects as d', 'manning.project_id = d.project_id', 'left');
		$this->db->join('positions as e', 'manning.position_id = e.position_id', 'left');
		$this->db->join('employment_status as f', 'manning.employment_status_id = f.employment_status_id', 'left');
		$this->db->order_by('project_id, lastname');
		return parent::get($id, $single);
	}

	public function get_cases($id = NULL, $single = FALSE)
	{
		// select statements
		$this->db->select('cases.*, b.lastname, b.firstname, e.position, d.title, b.middlename, c.case_category_code, c.case_category', FALSE);

		// join statements
		$this->db->join('case_categories as c', 'cases.case_category_id = c.case_category_id', 'left');
		$this->db->join('manning as b', 'cases.employee_id = b.manning_id', 'left');
		$this->db->join('projects as d', 'b.project_id = d.project_id', 'left');
		$this->db->join('positions as e', 'b.position_id = e.position_id', 'left');

		return parent::get($id, $single);
	}

	public function get_projects($id = NULL, $single = FALSE)
	{
		// select statements
		$this->db->select('project_id, title',  FALSE);

		$projects = $this->db->order_by('title')->get('projects')->result();

		// Return key -> value pair array
		$array = array('0' => 'Select Project');
		if (count($projects))
		{
			foreach ($projects as $project)
			$array[$project->project_id] = $project->title;
		}


		return $array;
	}

	public function get_positions($id = NULL, $single = FALSE)
	{
		// select statements
		$this->db->select('position_id, position',  FALSE);

		$positions = $this->db->order_by('position')->get('positions')->result();

		// Return key -> value pair array
		$array = array('0' => 'Select Position');
		if (count($positions))
		{
			foreach ($positions as $position)
			$array[$position->position_id] = $position->position;
		}


		return $array;
	}

	public function get_employment_statuses($id = NULL, $single = FALSE)
	{
		// select statements
		$this->db->select('employment_status_id, employment_status',  FALSE);
		$this->db->where('is_actived', 1);
		$employment_statuses = $this->db->order_by('employment_status')->get('employment_status')->result();

		// Return key -> value pair array
		$array = array('0' => 'Select Employment Status');
		if (count($employment_statuses))
		{
			foreach ($employment_statuses as $employment_status)
			$array[$employment_status->employment_status_id] = $employment_status->employment_status;
		}


		return $array;
	}


	public function delete($id)
	{
		// Delete a status
		parent::delete($id);

		// Reset employment_status ID for its members table
		// $this->db->set(array('project_id' => 0))->where('project_id', $id)->update('members');
	}

	public function as_dropdown()
	{
		$array = array('0' => 'Select Employee');
		$this->db->select($this->primary_key . ',' . $this->_dropdown_field)->order_by($this->_dropdown_field);
		$data = parent::get();
		// die(dump($data));
		foreach ($data as $row)
		$array[$row->{$this->primary_key}] = $row->lastname . ', ' . $row->firstname . ' ' . $row->middlename;

		return $array;
	}


}

/*Location: ./application/models/manning.php*/
