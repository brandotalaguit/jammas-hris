<?php 
/**
* Filename: combine_project_billings.php
* Author: Brando Talaguit (ITC Developer)
*/
class Combine_project_billings extends MY_Model
{
	protected $table_name = "combine_project_billings";
	protected $primary_key = "cb_pb_id";	
	protected $order_by = "combine_project_billings.cb_id, combine_project_billings.cb_pb_id";
	protected $timestamps = TRUE;

	public $rules = array(
		'cb_id' => ['field' => 'cb_id', 'label' => 'Combine Billing Id', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
		'project_id' => ['field' => 'project_id', 'label' => 'Project Id', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
		'project_bill_id' => ['field' => 'project_bill_id', 'label' => 'Project Billing Period Id', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$cb_pb = new stdClass();
		$cb_pb->cb_id = 0;
		$cb_pb->project_id = 0;
		$cb_pb->project_bill_id = 0;
		
		return $cb_pb;
	}

	public function get($id = NULL, $single = FALSE)
	{
		$select_arr = array(
			'combine_project_billings.*',
			'a.title',
			'a.description',
			'b.date_start',
			'b.date_end',
			'b.remarks',
			'b.fields',
		);

		$this->db->select($select_arr, TRUE);
		$this->db->join('projects as a', 'combine_project_billings.project_id = a.project_id', 'LEFT');
		$this->db->join('project_billing_info as b', 'combine_project_billings.project_bill_id = b.project_bill_id', 'LEFT');

		return parent::get($id, $single);
	}

	
}

/*Location: ./application/models/combine_project_billings.php*/
