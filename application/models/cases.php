<?php 
/**
* Filename: case_categories.php
* Author: Junard De Leon (PHP Developer)
*/
class Cases extends MY_Model
{
	protected $table_name = "cases";
	protected $primary_key = "case_id";	
	protected $order_by = "date_filed DESC";
	protected $timestamps = TRUE;

	public $rules = array(
		'employee_id' => ['field' => 'employee_id', 'label' => 'Employee', 'rules' => 'trim|intval|is_natural_no_zero|required|xss_clean'],
		'project_id' => ['field' => 'project_id', 'label' => 'Project', 'rules' => 'trim|intval|is_natural_no_zero|required|xss_clean'],
		'case_category_id' => ['field' => 'case_category_id', 'label' => 'Deduction Category', 'rules' => 'trim|intval|is_natural_no_zero|required|xss_clean'],
		'date_filed' => ['field' => 'date_filed', 'label' => 'Date Filed', 'rules' => 'trim|required|xss_clean'],
		'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$case = new stdClass();
		$case->employee_id = 0;
		$case->project_id = 0;
		$case->case_category_id = 0;
		$case->date_filed = '';
		$case->remarks = '';
		return $case;
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

	public function get_case_categories()
	{
		// Fetch employees
		$this->db->select('case_category_id, case_category_code, case_category');
		$case_categories = $this->db->order_by('case_category, case_category_code')->get('case_categories')->result();
		 
		// Return key -> value pair array
		$array = array('0' => 'Select category');
		if (count($case_categories)) 
		{
			foreach ($case_categories as $case_category) 
			$array[$case_category->case_category_id] =  $case_category->case_category;
		}

		return $array;
	}

	public function get_projects($id = NULL, $single = FALSE)
	{
		// select statements
		$this->db->select('project_id, title',  FALSE);
		
		$projects = $this->db->order_by('title')->get('projects')->result();
		 
		// Return key -> value pair array
		$array = array('0' => 'Select project');
		if (count($projects)) 
		{
			foreach ($projects as $project) 
			$array[$project->project_id] = $project->title;
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

	
}

/*Location: ./application/models/projects.php*/
 ?>