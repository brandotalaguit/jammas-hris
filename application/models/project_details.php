<?php 
/**
* Filename: projects.php
* Author: Brando Talaguit (ITC Developer)
*/
class Project_details extends MY_Model
{
	protected $table_name = "project_employees";
	protected $primary_key = "project_employee_id";	
	protected $order_by = "project_employees.created_at DESC";
	protected $timestamps = TRUE;

	public $rules = 
		[
			'employee_id' => ['field' => 'employee_id', 'label' => 'Employee', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
			'position_id' => ['field' => 'position_id', 'label' => 'Position', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
			'regular_time_in' => ['field' => 'regular_time_in', 'label' => 'Regular Time In', 'rules' => 'trim|required|xss_clean'],
			'regular_time_out' => ['field' => 'regular_time_out', 'label' => 'Regular Time Out', 'rules' => 'trim|required|xss_clean'],
			'rate[]' => ['field' => 'rate[]', 'label' => 'Rate', 'rules' => 'trim|xss_clean']
		];
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new($project_id)
	{
		$project = new stdClass();
		$project->project_id = $project_id;
		$project->employee_id = '0';
		$project->position_id = '0';
		$project->regular_time_in = '07:00:00';
		$project->regular_time_out = '04:00:00';

		return $project;
	}

	public function delete($id)
	{
		// Delete a status
		parent::delete($id);

		// Reset employment_status ID for its members table
		// $this->db->set(array('project_id' => 0))->where('project_id', $id)->update('members');
	}


	public function with_positions()
	{
		$this->db->join('positions', 'project_employees.position_id = positions.position_id', 'LEFT');
		
		return $this->db;
	}

	public function with_rates()
	{
		$this->db->join('project_rates', 'project_rates.project_id = projects.project_id', 'LEFT');
		$this->db->join('rates', 'rates.rate_id = rates.rate_id', 'LEFT');
		
		return $this->db;
	}

	
}

/*Location: ./application/models/projects.php*/
 ?>