<?php 
/**
* Filename: rates.php
* Author: Brando Talaguit (ITC Developer)
*/
class Rates extends MY_Model
{

	protected $table_name = "rates";
	protected $primary_key = "rate_id";	
	protected $order_by = "rates.created_at DESC";
	protected $timestamps = TRUE;
	public $rules = array(
			'rate_title' => array('field' => 'rate_title', 'label' => 'Rate', 'rules' => 'trim|required|callback__unique_rate|xss_clean'),
			'remarks' => array('field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean')
		);
	
	function __construct()
	{
		parent::__construct();
	}

	
	public function get_new()
	{
		$rate = new stdClass();
		$rate->rate_title = '';
		$rate->remarks = '';

		return $rate;
	}

	public function get_office()
	{
		// Fetch office
		$this->db->select('office_id, office_description, office_code')->where('is_actived', 1);
		$offices = $this->db->order_by('office_description')->get('offices')->result();

		// Return key -> value pair array
		$array = array();
		if (count($offices)) 
		{
			foreach ($offices as $office) 
			{
				// $array[$office->office_id] = array($office->office_id => $office->office_description);
				$array[$office->office_id] = $office->office_description;
			}
		}
		return $array;
	}

	public function get_employment_status()
	{
		// Fetch employment status
		$this->db->select('employment_status_id, employment_status')->where('is_actived', 1);
		$pages = $this->db->order_by('employment_status')->get('employment_status')->result();

		// Return key => value pair array
		$array = array();
		if (count($pages)) 
		{
			foreach ($pages as $page) 
			{
				$array[$page->employment_status_id] = $page->employment_status;
			}
		}
		return $array;
	}

}

/*Location: ./application/models/rates.php*/
 ?>