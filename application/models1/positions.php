<?php 
/**
* Filename: positions.php
* Author: Brando Talaguit (ITC Developer)
*/
class Positions extends MY_Model
{

	protected $table_name = "positions";
	protected $primary_key = "position_id";	
	protected $order_by = "positions.created_at DESC";
	protected $timestamps = TRUE;
	public $rules = array(
			'position_code' => array('field' => 'position_code', 'label' => 'Code', 'rules' => 'trim|strtoupper|required|callback__unique_position_code|xss_clean'),
			'position' => array('field' => 'position', 'label' => 'Position', 'rules' => 'trim|strtoupper|required|callback__unique_position|xss_clean'),
			'remarks' => array('field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|required|xss_clean')
		);
	
	function __construct()
	{
		parent::__construct();
	}

	
	public function get_new()
	{
		$position = new stdClass();
		$position->position_code = '';
		$position->position = '';
		$position->remarks = '';

		return $position;
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

	public function delete($id)
	{
		parent::delete($id);

		if ($id !== NULL) 
		{
			// assign 0 to position id
			$data['position_id'] = 0;
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$this->db->where('position_id', $id)->update('project_employees', $data);
			$this->db->where('position_id', $id)->update('project_rates', $data);
			$this->db->flush_cache();
		}
	}

}

/*Location: ./application/models/positions.php*/
 ?>