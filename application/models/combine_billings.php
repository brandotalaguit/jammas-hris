<?php 
/**
* Filename: combine_billings.php
* Author: Brando Talaguit (ITC Developer)
*/
class Combine_billings extends MY_Model
{
	protected $table_name = "combine_billings";
	protected $primary_key = "cb_id";	
	protected $order_by = "combine_billings.cb_id DESC";
	protected $timestamps = TRUE;

	public $rules = array(
		'user_id' => ['field' => 'user_id', 'label' => 'User Account Id', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
		'cb_title' => ['field' => 'cb_title', 'label' => 'Billing Title', 'rules' => 'trim|strtoupper|xss_clean'],
		'cb_address' => ['field' => 'cb_address', 'label' => 'Billing Address', 'rules' => 'trim|strtoupper|xss_clean'],
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$combine_billing = new stdClass();
		$combine_billing->user_id = $this->session->userdata('Id');
		
		return $combine_billing;
	}


	public function combine_project_billings($id = NULL)
	{
		$single = TRUE;

		if (is_array($id))
		$single = FALSE;

		if ($id === NULL) 
		$single = FALSE;
	
		$data = parent::get($id, $single);
		$combine_billings = array();
		
		if ($single) 
		{
			$combine_billing = new stdClass();
			$combine_billing->cb_id = $data->cb_id;
			$combine_billing->cb_title = $data->cb_title;
			$combine_billing->cb_address = $data->cb_address;
			$combine_billing->user_id = $data->user_id;
			$combine_billing->is_actived = $data->is_actived;
			$combine_billing->created_at = $data->created_at;
			$combine_billing->updated_at = $data->updated_at;
			$combine_billing->deleted_at = $data->deleted_at;
			$combine_billing->projects = $this->combine_project_billings->get_by(array('cb_id' => $data->cb_id));

			$combine_billings[] = $combine_billing;
		}
		else
		{
			foreach ($data as $key => $value)
			{
				$combine_billing = new stdClass();
				$combine_billing->cb_id = get_key($value, 'cb_id');
				$combine_billing->cb_title = get_key($value, 'cb_title');
				$combine_billing->cb_address = get_key($value, 'cb_address');
				$combine_billing->user_id = get_key($value, 'user_id');
				$combine_billing->is_actived = get_key($value, 'is_actived');
				$combine_billing->created_at = get_key($value, 'created_at');
				$combine_billing->updated_at = get_key($value, 'updated_at');
				$combine_billing->deleted_at = get_key($value, 'deleted_at');
				$combine_billing->projects = $this->combine_project_billings->get_by(array('cb_id' => get_key($value, 'cb_id')));

				$combine_billings[] = $combine_billing;
			}
		}

		return $combine_billings;
	}

	
}

/*Location: ./application/models/combine_billings.php*/
 ?>