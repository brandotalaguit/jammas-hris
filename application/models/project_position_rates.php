<?php 
/**
* Filename: projects.php
* Author: Brando Talaguit (ITC Developer)
*/
class Project_position_rates extends MY_Model
{
	protected $table_name = "project_position_rates";
	protected $primary_key = "ppr_id";	
	protected $order_by = "project_position_rates.project_id, project_position_rates.ppr_id";
	protected $timestamps = TRUE;

	protected $protected_attribute = array('ppr_id');

	public $rules = 
	[
		'position_id' => ['field' => 'position_id', 'label' => 'Position', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
		
		'hourly_rate' => ['field' => 'hourly_rate', 'label' => 'Hourly Rate', 'rules' => 'to_decimal|xss_clean'],
		'daily_rate' => ['field' => 'daily_rate', 'label' => 'Daily Rate', 'rules' => 'to_decimal|xss_clean'],
		'semi_monthly_rate' => ['field' => 'semi_monthly_rate', 'label' => 'Semi-Monthly Rate', 'rules' => 'to_decimal|xss_clean'],
		'monthly_rate' => ['field' => 'monthly_rate', 'label' => 'Monthly Rate', 'rules' => 'to_decimal|xss_clean'],
		
		'straight_duty' => ['field' => 'straight_duty', 'label' => 'Straight Duty', 'rules' => 'required|to_decimal|xss_clean'],
		'night_diff' => ['field' => 'night_diff', 'label' => 'Night Differential', 'rules' => 'required|to_decimal|xss_clean'],
		'night_ot_diff' => ['field' => 'night_ot_diff', 'label' => 'Night Differential', 'rules' => 'required|to_decimal|xss_clean'],
		'rest_day_rate' => ['field' => 'rest_day_rate', 'label' => 'Rest-day', 'rules' => 'required|to_decimal|xss_clean'],
		'special_holiday' => ['field' => 'special_holiday', 'label' => 'Special Holiday', 'rules' => 'required|to_decimal|xss_clean'],
		'special_ot_holiday' => ['field' => 'special_ot_holiday', 'label' => 'Special Holiday O.T.', 'rules' => 'required|to_decimal|xss_clean'],
		'rest_day_special_holiday' => ['field' => 'rest_day_special_holiday', 'label' => 'Rest Day Special Holiday', 'rules' => 'required|to_decimal|xss_clean'],
		'rest_day_special_ot_holiday' => ['field' => 'rest_day_special_ot_holiday', 'label' => 'Rest Day Spcl. O.T. Hol.', 'rules' => 'required|to_decimal|xss_clean'],
		'legal_holiday' => ['field' => 'legal_holiday', 'label' => 'Legal Holiday', 'rules' => 'required|to_decimal|xss_clean'],
		'legal_ot_holiday' => ['field' => 'legal_ot_holiday', 'label' => 'Legal Holiday O.T.', 'rules' => 'required|to_decimal|xss_clean'],
		'rest_day_legal_holiday' => ['field' => 'rest_day_legal_holiday', 'label' => 'Rest Day Legal Holiday', 'rules' => 'required|to_decimal|xss_clean'],
		'rest_day_legal_ot_holiday' => ['field' => 'rest_day_legal_ot_holiday', 'label' => 'Rest Day Legal O.T. Hol.', 'rules' => 'required|to_decimal|xss_clean'],
		'regular_ot_day' => ['field' => 'regular_ot_day', 'label' => 'Regular O.T.', 'rules' => 'required|to_decimal|xss_clean'],

		// lates and absent 

		'late_amount' => ['field' => 'late_amount', 'label' => 'Less Amount', 'rules' => 'to_decimal|to_negative|xss_clean'],
		'absent_rate' => ['field' => 'absent_rate', 'label' => 'Absent Rate Per Hour', 'rules' => 'to_decimal|to_negative|xss_clean'],
		'absent_rate_per_day' => ['field' => 'absent_rate_per_day', 'label' => 'Absent Rate Per Day', 'rules' => 'to_decimal|to_negative|xss_clean'],
		
	];

	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$ppr = new stdClass();
		$ppr->position_id = 0;
		
		$ppr->hourly_rate = '0.00';
		$ppr->daily_rate = '0.00';
		$ppr->semi_monthly_rate = '0.00';
		$ppr->monthly_rate = '0.00';

		$ppr->straight_duty = '0.00';
		$ppr->night_diff = '0.00';
		$ppr->night_ot_diff = '0.00';
		$ppr->rest_day_rate = '0.00';
		$ppr->rest_day_ot_rate = '0.00';
		$ppr->special_holiday = '0.00';
		$ppr->special_ot_holiday = '0.00';
		$ppr->rest_day_special_holiday = '0.00';
		$ppr->rest_day_special_ot_holiday = '0.00';
		$ppr->legal_holiday = '0.00';
		$ppr->legal_ot_holiday = '0.00';
		$ppr->rest_day_legal_holiday = '0.00';
		$ppr->rest_day_legal_ot_holiday = '0.00';
		$ppr->regular_ot_day = '0.00';
		
		$ppr->late_amount = '0.00';
		$ppr->absent_rate = '0.00';
		$ppr->absent_rate_per_day = '0.00';

		return $ppr;
	}


	public function get_employee_position_rate($id = NULL, $single = FALSE)
	{
		$conditions = [
			'project_employees.project_id' => $id,
			'employees.is_actived' => 1,
			'positions.is_actived' => 1,
		];

		$this->with_employees();
		$this->with_positions();
		// $this->with_rates();

		return parent::get_by($conditions, $single);
	}

	public function get_positions($project_id)
	{

		if (is_array($project_id)) 
			$this->db->where_in('project_id' , $project_id);
		else
			$this->db->where('project_id', $project_id);

		$this->db->select('ppr_id, position, daily_rate');
		$this->db->join('positions', 'project_position_rates.position_id = positions.position_id', 'left');
		
		return $this->get();
	}

	public function dropdown_select($project_id)
	{
		$ppr = $this->get_positions($project_id);

		// Return key -> value pair array
		$array = array('0' => 'Select position');
		if (count($ppr)) 
		{
			foreach ($ppr as $position) 
			{
				$array[$position->ppr_id] = $position->position . " (" . $position->daily_rate . ")";
			}
		}
		return $array;
	}

	// public function with_employees()
	// {
	// 	$this->db->join('employees', 'employees.employee_id = project_employees.employee_id', 'LEFT');
	// 	return $this->db;
	// }

	// public function with_positions()
	// {
	// 	$this->db->join('positions', 'project_employees.position_id = positions.position_id', 'LEFT');
		
	// 	return $this->db;
	// }

	// public function with_rates()
	// {
	// 	$this->db->join('project_rates', 'project_rates.project_id = project_employees.project_id AND project_rates.employee_id = project_employees.employee_id', 'LEFT');
	// 	$this->db->join('rates', 'rates.rate_id = rates.rate_id', 'LEFT');
		
	// 	return $this->db;
	// }


}

/*Location: ./application/models/projects.php*/
 ?>