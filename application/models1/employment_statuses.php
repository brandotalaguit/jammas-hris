<?php 
/**
* Filename: deduction_categories.php
* Author: Junard De Leon (PHP Developer)
*/
class Employment_statuses extends MY_Model
{
	protected $table_name = "employment_status";
	protected $primary_key = "employment_status_id";	
	protected $order_by = "employment_status.created_at DESC";
	protected $timestamps = TRUE;

	public $rules = array(
		'employment_status_code' => ['field' => 'employment_status_code', 'label' => 'Employment Status Code', 'rules' => 'trim|required|strtoupper|min_length[5]|max_length[200]|html_escape|xss_clean'],
		'employment_status' => ['field' => 'employment_status', 'label' => 'Employment Status', 'rules' => 'trim|required|xss_clean|callback__unique_title'],
		'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$employment_status = new stdClass();
		$employment_status->employment_status_code = '';
		$employment_status->employment_status = '';
		$employment_status->remarks = '';
		
		
		return $employment_status;
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