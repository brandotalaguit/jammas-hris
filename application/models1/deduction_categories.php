<?php 
/**
* Filename: deduction_categories.php
* Author: Junard De Leon (PHP Developer)
*/
class Deduction_categories extends MY_Model
{
	protected $table_name = "deduction_categories";
	protected $primary_key = "deduction_category_id";	
	protected $order_by = "deduction_categories.created_at DESC";
	protected $timestamps = TRUE;

	protected $_dropdown_field = 'deduction_category_code, deduction_category';

	public $rules = array(
		'deduction_type' => ['field' => 'deduction_type', 'label' => 'Type', 'rules' => 'trim|required|xss_clean'],
		'deduction_category_code' => ['field' => 'deduction_category_code', 'label' => 'Category Code', 'rules' => 'trim|required|strtoupper|min_length[5]|max_length[200]|callback__unique_title|html_escape|xss_clean'],
		'deduction_category' => ['field' => 'deduction_category', 'label' => 'Category', 'rules' => 'trim|required|xss_clean'],
		'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$deduction_category = new stdClass();
		$deduction_category->deduction_type = 0;
		$deduction_category->deduction_category_code = '';
		$deduction_category->deduction_category = '';
		$deduction_category->remarks = '';
		
		
		return $deduction_category;
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
		$this->db->select($this->primary_key . ',' . $this->_dropdown_field)->order_by($this->_dropdown_field);
		$data = parent::get();
		foreach ($data as $row) 
		{
			// die(dump($row->{$this->primary_key}));
			$array[$row->{$this->primary_key}] = $row->deduction_category;
		}

		return $array;
	}

	
}

