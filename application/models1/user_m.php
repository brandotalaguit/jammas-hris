<?php 
/**
* Filename: user_m.php
* Author: Brando Talaguit (ITC Developer)
*/
class User_M extends MY_Model
{
	protected $table_name = "users";
	protected $primary_key = "Id";	
	protected $order_by = "LastName,FirstName,MiddleName";	
	public $rules = array(
		'Username' => array('field' => 'Username', 'label' => 'Username', 'rules' => 'trim|required|max_length[20]|xss_clean'),
		'Password' => array('field' => 'Password', 'label' => 'Password', 'rules' => 'trim|required')
	);

	public $rules_admin = array(
		'LastName' => array('field' => 'LastName', 'label' => 'LastName', 'rules' => 'trim|required|callback__unique_name|xss_clean'),
		'FirstName' => array('field' => 'FirstName', 'label' => 'FirstName', 'rules' => 'trim|required|xss_clean'),
		'MiddleName' => array('field' => 'MiddleName', 'label' => 'MiddleName', 'rules' => 'trim|required|xss_clean'),
		'Birthday' => array('field' => 'Birthday', 'label' => 'Birthday', 'rules' => 'trim|required|date|xss_clean'),
		'Username' => array('field' => 'Username', 'label' => 'Username', 'rules' => 'trim|required|max_length[20]|xss_clean'),
		'Password' => array('field' => 'Password', 'label' => 'Password', 'rules' => 'trim|matches[ConfirmPassword]'),
		'ConfirmPassword' => array('field' => 'ConfirmPassword', 'label' => 'ConfirmPassword', 'rules' => 'trim|matches[Password]'),
		'EmailAddress' => array('field' => 'EmailAddress', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
		'AccountType' => array('field' => 'AccountType', 'label' => 'Account Type', 'rules' => 'trim|strtoupper|required|xss_clean'),
	);
	
	function __construct()
	{
		parent::__construct();
	}

	
	public function login()
	{
		$user = $this->get_by(array(
			'Username' => $this->input->post('Username'),
			'Password' => $this->hash($this->input->post('Password'))
		), TRUE);

		if (count($user)) 
		{
			# Log in user
			$data = array(
				'LastName' => $user->LastName,
				'FirstName' => $user->FirstName,
				'MiddleName' => $user->MiddleName,
				'Username' => $user->Username,
				'Id' => $user->Id,
				'EmailAddress' => $user->EmailAddress,
				'Birthday' => $user->Birthday,
				'AccountType' => $user->AccountType,
				'loggedin' => TRUE
			);

			$this->session->set_userdata($data);
			return TRUE;
		}

		// If we get to here then login did not succeed
		return FALSE;
	}

	public function loggedin()
	{
		return (bool) $this->session->userdata('loggedin');
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
	}

	public function get_new()
	{
		$user = new stdClass();
		$user->LastName = '';
		$user->FirstName = '';
		$user->MiddleName = '';
		$user->Birthday = '';
		$user->Username = '';
		$user->Password = '';
		$user->AccountType = '';
		$user->EmailAddress = '';
		
		return $user;
	}
	
	public function hash($string)
	{
		return hash('sha512', $string . config_item('encryption_key'));
	}
}

/*Location: ./application/models/user_m.php*/
 ?>