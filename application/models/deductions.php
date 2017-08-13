<?php 
/**
* Filename: deduction_categories.php
* Author: Junard De Leon (PHP Developer)
*/
class Deductions extends MY_Model
{
	protected $table_name = "deductions";
	protected $primary_key = "deduction_id";	
	protected $order_by = "date_filed DESC";
	protected $timestamps = TRUE;

	protected $_dropdown_field = 'lastname, firstname, middlename';

	public $rules = array(
		'employee_id' => ['field' => 'employee_id', 'label' => 'Employee', 'rules' => 'trim|intval|is_natural_no_zero|required|xss_clean'],
		'deduction_category_id' => ['field' => 'deduction_category_id', 'label' => 'Deduction Category', 'rules' => 'trim|intval|is_natural_no_zero|required|xss_clean'],
		'date_filed' => ['field' => 'date_filed', 'label' => 'Date Filed', 'rules' => 'trim|required|xss_clean'],
		'coverage_date_start' => ['field' => 'coverage_date_start', 'label' => 'Coverage Start', 'rules' => 'trim|required|xss_clean'],
		'coverage_date_end' => ['field' => 'coverage_date_end', 'label' => 'Coverage End', 'rules' => 'trim|required|xss_clean'],
		'payment_type' => ['field' => 'payment_type', 'label' => 'Category', 'rules' => 'trim|required|xss_clean'],
		'percentage' => ['field' => 'percentage', 'label' => 'Category', 'rules' => 'trim|to_decimal|xss_clean'],
		'fixed_amount' => ['field' => 'fixed_amount', 'label' => 'Category', 'rules' => 'trim|to_decimal|required|xss_clean'],
		'mode_of_payment' => ['field' => 'mode_of_payment', 'label' => 'Remarks', 'rules' => 'trim|required|xss_clean'],
		'is_closed' => ['field' => 'is_closed', 'label' => 'Is Closed', 'rules' => 'trim|xss_clean'],
		'date_closed' => ['field' => 'date_closed', 'label' => 'Date Closed', 'rules' => 'trim|xss_clean'],
		'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$deduction = new stdClass();
		$deduction->employee_id = 0;
		$deduction->deduction_category_id = 0;
		$deduction->date_filed = '';
		$deduction->coverage_date_start = '';
		$deduction->coverage_date_end = '';
		$deduction->payment_type = 0;
		$deduction->percentage = '0.00';
		$deduction->fixed_amount = '0.00';
		$deduction->mode_of_payment = 0;
		$deduction->is_closed = 0;
		$deduction->date_closed = '';
		$deduction->remarks = '';
		return $deduction;
	}

	public function get_deductions($id = NULL, $single = FALSE)
	{
		// select statements
		$this->db->select('deductions.*, b.lastname, b.firstname, e.position, d.title, b.middlename, c.deduction_category_code, c.deduction_category', FALSE);
		
		// join statements
		$this->db->join('deduction_categories as c', 'deductions.deduction_category_id = c.deduction_category_id', 'left');
		$this->db->join('manning as b', 'deductions.employee_id = b.manning_id', 'left');
		$this->db->join('projects as d', 'b.project_id = d.project_id', 'left');
		$this->db->join('positions as e', 'b.position_id = e.position_id', 'left');

		return parent::get($id, $single);
	}

	public function get_employees($id = NULL, $single = FALSE)
	{
		// select statements
		$this->db->select('manning_id, lastname, firstname, middlename',  FALSE);
		
		$employees = $this->db->order_by('lastname, firstname')->get('manning')->result();
		 
		// Return key -> value pair array
		$array = array('0' => 'Select employee');	
		if (count($employees)) 
		{
			foreach ($employees as $employee) 
			$array[$employee->manning_id] = $employee->lastname . ' , ' . $employee->firstname . ' ' . $employee->middlename;
		}
		

		return $array;
	}

	public function get_deduction_categories()
	{
		// Fetch employees
		$this->db->select('deduction_category_id, deduction_category_code, deduction_category');
		$deduction_categories = $this->db->order_by('deduction_category, deduction_category_code')->get('deduction_categories')->result();
		 
		// Return key -> value pair array
		$array = array('0' => 'Select category');
		if (count($deduction_categories)) 
		{
			foreach ($deduction_categories as $deduction_category) 
			$array[$deduction_category->deduction_category_id] =  $deduction_category->deduction_category;
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
		$array = array('0' => 'Select Deduction');
		$this->db->select($this->_dropdown_field)->order_by($this->_dropdown_field);
		$data = parent::get();
		foreach ($data as $row) 
		$array[$row->$this->primary_key] = $row->lastname . ', ' . $row->firstname . ' ' . $row->middlename;

		return $array;
	}
}

/*Location: ./application/models/projects.php*/
