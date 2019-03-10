<?php 
/**
* Filename: Project_rates.php
* Author: Brando Talaguit (ITC Developer)
*/
class Project_rates extends MY_Model
{
	protected $table_name = "project_rates";
	protected $primary_key = "project_rate_id";	
	protected $order_by = "project_rates.created_at DESC";
	protected $timestamps = TRUE;

	public $rules = 
		[
			'project_id' => ['field' => 'project_id', 'label' => 'Project Id', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
			'position_id' => ['field' => 'position_id', 'label' => 'Position', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
			'rate_id[]' => ['field' => 'rate_id[]', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
			'cost' => ['field' => 'cost', 'label' => 'Cost', 'rules' => 'trim|xss_clean'],
		];
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new($project_id)
	{
		$project = new stdClass();
		$project->project_id = $project_id;
		$project->project_id = '0';
		$project->position_id = '0';
		$project->cost = '07:00:00';
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
		$this->db->join('positions', 'project_rates.position_id = positions.position_id', 'LEFT');
		
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