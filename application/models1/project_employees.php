<?php 
/**
* Filename: projects.php
* Author: Brando Talaguit (ITC Developer)
*/
class Project_employees extends MY_Model
{
	protected $table_name = "project_employees";
	protected $primary_key = "project_employee_id";	
	protected $order_by = "project_employees.created_at DESC";
	protected $timestamps = TRUE;

	public $rules = 
		[
			'employee_id' => ['field' => 'employee_id', 'label' => 'Employee', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
			'ppr_id' => ['field' => 'ppr_id', 'label' => 'Position', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
			'regular_time_in' => ['field' => 'regular_time_in', 'label' => 'Regular Time In', 'rules' => 'trim|xss_clean'],
			'regular_time_out' => ['field' => 'regular_time_out', 'label' => 'Regular Time Out', 'rules' => 'trim|xss_clean'],
			'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean']
			// 'rate[]' => ['field' => 'rate[]', 'label' => 'Rate', 'rules' => 'trim|xss_clean']
		];

	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$project = new stdClass();
		$project->project_id = $this->uri->segment(2);
		$project->employee_id = '0';
		$project->ppr_id = '0';
		$project->regular_time_in = '08:00:00';
		$project->regular_time_out = '05:00:00';
		$project->remarks = '';

		return $project;
	}

	// public function ppr_dropdown($project_id)
	// {
	// 	$this->load->model('project_position_rates');

	// 	$this->db->select('postions.position_id, position');

	// 	if (is_array($project_id)) 
	// 		$this->db->where_in('project_id' , $project_id);
	// 	else
	// 		$this->db->where('project_id', $project_id);

	// 	$this->db->join('positions', 'project_position_rates.position_id = positions.position_id', 'left');
		
	// 	$ppr = $this->project_position_rates->get();
	// }



	// public function get_employee_position_rate($id = NULL, $single = FALSE)
	// {
	// 	$conditions = [
	// 		'project_employees.project_id' => $id,
	// 		'employees.is_actived' => 1,
	// 		'positions.is_actived' => 1,
	// 	];

	// 	$this->with_employees();
	// 	$this->with_positions();
	// 	// $this->with_rates();

	// 	return parent::get_by($conditions, $single);
	// }

	// public function with_employees()
	// {
	// 	$this->db->join('employees', 'employees.employee_id = project_employees.employee_id', 'LEFT');
	// 	return $this->db;
	// }

	// public function with_positions()
	// {
	// 	$this->db->join('positions', 'project_employees.position_id = positions.position_id', 'LEFT');
		
	// 	return $this->db;
	// }

	// public function with_rates()
	// {
	// 	$this->db->join('project_rates', 'project_rates.project_id = project_employees.project_id AND project_rates.employee_id = project_employees.employee_id', 'LEFT');
	// 	$this->db->join('rates', 'rates.rate_id = rates.rate_id', 'LEFT');
		
	// 	return $this->db;
	// }


}

/*Location: ./application/models/projects.php*/
 ?>