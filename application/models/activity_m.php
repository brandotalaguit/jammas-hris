<?php 
/**
* Filename: activity_m.php
* Author: Brando Talaguit (ITC Developer)
*/
class Activity_M extends MY_Model
{

	protected $table_name = "activity_logs";
	protected $primary_key = "activity_log_id";	
	protected $order_by = "created_at DESC";
	protected $timestamps = TRUE;
	public $rules = array(
			'user_id' => array('field' => 'user_id', 'label' => 'User Id', 'rules' => 'trim|required|intval|xss_clean'),
			'message' => array('field' => 'message', 'label' => 'Lastname', 'rules' => 'trim|required|xss_clean'),
			'data_before' => array('field' => 'data_before', 'label' => 'Firstname', 'rules' => 'trim|xss_clean'),
			'data_after' => array('field' => 'data_after', 'label' => 'Middlename', 'rules' => 'trim|required|xss_clean'),
			'client_ip' => array('field' => 'client_ip', 'label' => 'Civil Status', 'rules' => 'trim|required|xss_clean'),
			'request_uri' => array('field' => 'request_uri', 'label' => 'Date of Birth', 'rules' => 'trim|required|xss_clean'),
			'referer_page' => array('field' => 'referer_page', 'label' => 'Place of Birth', 'rules' => 'trim|required|xss_clean'),
			'created_at' => array('field' => 'created_at', 'label' => 'Datetime', 'rules' => 'trim|datetime|xss_clean')
		);
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
	}

	public function write($message, $old_data = NULL, $new_data = NULL, $table = NULL) 
	{
		
		$user_id = $this->session->userdata('Id');
	    if(intval($user_id) == 0) { // invalid user
	        return false;
	    }

	    $filter = $this->primary_filter;
	    $id = $filter($user_id);

	    if (!$id) 
	    {
	    	return FALSE;
	    }

	    if ($new_data !== NULL) 
	    {
	    	$data['data_after'] = print_r($new_data,TRUE);
	    }

	    if ($old_data !== NULL) 
	    {
	    	$data['data_before'] = print_r($old_data, TRUE);
	    }

	    $data['message'] = $message;
	    $data['user_id'] = intval($user_id);
	    $data['client_ip'] = $this->input->server('REMOTE_ADDR');
	    $data['request_uri'] = $this->input->server('REQUEST_URI');
	    $data['referer_page'] = $this->agent->referrer();
	    $data['created_at'] = date('Y-m-d H:i:s');

	    $this->db->set($data);
	    $table_name = $table == NULL ? $this->table_name : $table;
	    $this->db->insert($table_name, $data);

	    $this->session->set_flashdata('success', $message);
	} 

	public function get_new()
	{
		$activity = new stdClass();
		$activity->user_id = '';
		$activity->message = '';
		$activity->data_before = '';
		$activity->data_after = '';
		$activity->client_ip = '';
		$activity->request_uri = '';
		$activity->referer_page = '';		
		$activity->created_at = time();

		return $activity;
	}

}

/*Location: ./application/models/activity_m.php*/
 ?>