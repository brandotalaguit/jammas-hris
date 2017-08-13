<?php 
/**
* Filename: case_categories.php
* Author: Junard De Leon (PHP Developer)
*/
class Case_categories extends MY_Model
{
	protected $table_name = "case_categories";
	protected $primary_key = "case_category_id";	
	protected $order_by = "case_categories.created_at DESC";
	protected $timestamps = TRUE;

	public $rules = array(
		'case_category_code' => ['field' => 'case_category_code', 'label' => 'Category Code', 'rules' => 'trim|required|strtoupper|min_length[5]|max_length[200]|callback__unique_title|html_escape|xss_clean'],
		'case_category' => ['field' => 'case_category', 'label' => 'Category', 'rules' => 'trim|required|xss_clean'],
		'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$case_category = new stdClass();
		$case_category->case_category_code = '';
		$case_category->case_category = '';
		$case_category->remarks = '';
		
		
		return $case_category;
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