<?php 
/**
* Filename: projects.php
* Author: Brando Talaguit (ITC Developer)
*/
class Projects extends MY_Model
{
	protected $table_name = "projects";
	protected $primary_key = "project_id";	
	protected $order_by = "projects.created_at DESC";
	protected $timestamps = TRUE;

	public $rules = array(
		'title' => ['field' => 'title', 'label' => 'Project Title', 'rules' => 'trim|required|min_length[5]|max_length[200]|callback__unique_title|html_escape|xss_clean'],
		'address' => ['field' => 'address', 'label' => 'Project Address', 'rules' => 'trim|required|xss_clean'],
		'business_style' => ['field' => 'business_style', 'label' => 'Business Style', 'rules' => 'trim|strtoupper|required|xss_clean'],
		'po' => ['field' => 'po', 'label' => 'P.O. #', 'rules' => 'trim|strtoupper|required|xss_clean'],
		'tin' => ['field' => 'tin', 'label' => 'T.I.N.', 'rules' => 'trim|strtoupper|required|xss_clean'],
		'description' => ['field' => 'description', 'label' => 'Project Description', 'rules' => 'trim|required|xss_clean'],
		'rate' => ['field' => 'rate', 'label' => 'Project Rate', 'rules' => 'trim|required|is_natural|xss_clean'],
		// 'fields[]' => ['field' => 'fields', 'label' => 'Columns', 'rules' => 'required|xss_clean'],
		// 'rate_daily' => ['field' => 'rate_daily', 'label' => 'Daily Rate', 'rules' => 'is_natural|xss_clean'],
		// 'rate_monthly' => ['field' => 'rate_monthly', 'label' => 'Monthly Rate', 'rules' => 'is_natural|xss_clean'],
		// 'rate_semi_monthly' => ['field' => 'rate_semi_monthly', 'label' => 'Semi-Monthly Rate', 'rules' => 'is_natural|xss_clean']
	);
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$project = new stdClass();
		$project->title = '';
		$project->address = '';
		$project->business_style = '';
		$project->po = '';
		$project->tin = '';
		$project->description = '';
		$project->rate = 0;
		$project->rate_hourly = 0;
		$project->rate_daily = 0;
		$project->rate_monthly = 0;
		$project->rate_semi_monthly = 0;
		// $project->fields = '';
		
		return $project;
	}

	public function get_project_rates_array()
	{
		$array = array(
			// 'cola' => 'COLA',									--> this field is automatically included
			// 'hourly_rate' => 'Rate per Hour',					--> this field is automatically included 
			// 'daily_rate' => 'Rate per Day',						--> this field is automatically included
			// 'semi_monthly_rate' => 'Rate per Semi-Monthly',		--> this field is automatically included
			// 'monthly_rate' => 'Rate per Monthly',				--> this field is automatically included
			'straight_duty' => 'Straight Duty',
			'night_diff' => 'Night Differential',
			'night_ot_diff' => 'Night Differential Over-time',
			'rest_day_rate' => 'Rest Day',
			'rest_day_ot_rate' => 'Rest Day Over-time',
			'rest_day_special_holiday' => 'Rest Day Special Holiday',
			'rest_day_special_ot_holiday' => 'Rest Day Special Holiday Over-time',
			'rest_day_legal_holiday' => 'Rest Day Legal Holiday',
			'rest_day_legal_ot_holiday' => 'Rest Day Legal Holiday Over-time',
			'legal_holiday' => 'Legal Holiday',
			'legal_ot_holiday' => 'Legal Holiday Over-time',
			'special_holiday' => 'Special Holiday',
			'special_ot_holiday' => 'Special Holiday Over-time',
			'regular_ot_day' => 'Regular Over-time',
			'late_amount' => 'Late Rate per Minutes',
			'absent_rate' => 'Absent Rate per Hours',
			'absent_rate_per_day' => 'Absent Rate per Day',
			// 'incentive' => 'Incentives',
			// '13thmonth' => '13th Month',							--> this field is automatically computed to payroll
		);

		return $array;
	}

	public function get_field()
	{
		$array = array(
			'cola' => ['label' => 'COLA', 'abbr' => 'ECOLA', 'payroll' => 'r_cola', 'multiplier' => 'e_cola'], 
			'hourly_rate' => ['label' => 'Rate per Hour', 'abbr' => 'Basic/Hrs', 'payroll' => 'r_hourly_rate', 'multiplier' => 'no_hrs'], 
			'daily_rate' => ['label' => 'Rate per Day', 'abbr' => 'Basic/Day', 'payroll' => 'r_daily_rate', 'multiplier' => 'rw_day'], 
			'semi_monthly_rate' => ['label' => 'Rate per Semi-Monthly', 'abbr' => 'Basic/Semi-Month', 'payroll' => 'r_semi_monthly_rate', 'multiplier' => 'semi_monthly_rate'], 
			'monthly_rate' => ['label' => 'Rate per Monthly', 'abbr' => 'Basic/Month', 'payroll' => 'r_monthly_rate', 'multiplier' => 'monthly_rate'], 
			'straight_duty' => ['label' => 'Straight Duty', 'abbr' => 'Straight Duty', 'payroll' => 'r_straight_duty', 'multiplier' => 'sd_day'], 
			'night_diff' => ['label' => 'Night Differential', 'abbr' => 'Night Diff.', 'payroll' => 'r_night_diff', 'multiplier' => 'nd_day'], 
			'night_ot_diff' => ['label' => 'Night Differential Over-time', 'abbr' => 'Night Diff. OT', 'payroll' => 'r_night_ot_diff', 'multiplier' => 'nd_ot_day'], 
			'rest_day_rate' => ['label' => 'Rest Day', 'abbr' => 'Rest Day', 'payroll' => 'r_rest_day_rate', 'multiplier' => 'rd_day'], 
			'rest_day_ot_rate' => ['label' => 'Rest Day Over-time', 'abbr' => 'Rest Day OT', 'payroll' => 'r_rest_day_ot_rate', 'multiplier' => 'rd_ot_day'], 
			'rest_day_special_holiday' => ['label' => 'Rest Day Special Holiday', 'abbr' => 'Sp Hol/Rest Day', 'payroll' => 'r_rest_day_special_holiday', 'multiplier' => 'rd_sh_day'], 
			'rest_day_special_ot_holiday' => ['label' => 'Rest Day Special Holiday Over-time', 'abbr' => 'Sp Hol/Rest OT', 'payroll' => 'r_rest_day_special_ot_holiday', 'multiplier' => 'rd_sh_ot_day'], 
			'rest_day_legal_holiday' => ['label' => 'Rest Day Legal Holiday', 'abbr' => 'Lg Hol/Rest', 'payroll' => 'r_rest_day_legal_holiday', 'multiplier' => 'rd_lg_hl'], 
			'rest_day_legal_ot_holiday' => ['label' => 'Rest Day Legal Holiday Over-time', 'abbr' => 'LG Hol/Rest OT', 'payroll' => 'r_rest_day_legal_ot_holiday', 'multiplier' => 'rd_lg_ot_hl'], 
			'legal_holiday' => ['label' => 'Legal Holiday', 'abbr' => 'Lg Holiday', 'payroll' => 'r_legal_holiday', 'multiplier' => 'lg_day'], 
			'legal_ot_holiday' => ['label' => 'Legal Holiday Over-time', 'abbr' => 'Lg Holiday OT', 'payroll' => 'r_legal_ot_holiday', 'multiplier' => 'lg_ot_day'], 
			'special_holiday' => ['label' => 'Special Holiday', 'abbr' => 'Sp Holiday', 'payroll' => 'r_special_holiday', 'multiplier' => 'sp_day'], 
			'special_ot_holiday' => ['label' => 'Special Holiday Over-time', 'abbr' => 'Sp Holiday OT', 'payroll' => 'r_special_ot_holiday', 'multiplier' => 'sp_ot_day'], 
			'regular_ot_day' => ['label' => 'Regular Over-time', 'abbr' => 'Basic OT', 'payroll' => 'r_regular_ot_day', 'multiplier' => 'rw_ot_day'], 
			'late_amount' => ['label' => 'Tardiness', 'abbr' => 'Tardiness', 'payroll' => 'r_late_amount', 'multiplier' => 'late_minutes'], 
			'absent_rate' => ['label' => 'Absent per Hours', 'abbr' => 'Absent/Hrs', 'payroll' => 'r_absent_rate', 'multiplier' => 'no_absences_per_hr'], 
			'absent_rate_per_day' => ['label' => 'Absent', 'abbr' => 'Absent', 'payroll' => 'r_absent_rate_per_day', 'multiplier' => 'no_absences_per_day'], 
			// 'incentive' => ['label' => 'Incentives', 'abbr' => 'Incentives', 'payroll' => 'r_incentive', 'multiplier' => 'no_hrs'], 
			'13thmonth' => ['label' => '13th Month', 'abbr' => '13th Month', 'payroll' => 'r_13thmonth', 'multiplier' => 'no_hrs'], 
		);

		return $array;
	}

	public function get_columns()
	{
		// Return key -> value pair array
		// $array = array('0' => 'Select columns');

		$array = $this->get_project_rates_array();

		foreach ($array as $field => $value) 
		{
			$array[$field] = $value;
		}

		return $array;
	}

	public function get_config($project_id)
	{
		$proj = self::get($project_id, TRUE);
		$rates = self::get_project_rates_array();

		foreach ($rates as $field => $value) 
		{ 
			$rates[$field] = $value; 
			// $rates[] = ['id'=> $field, 'text' => $value];
		}

		if ($proj->rate_hourly == 1) 
		{
		    unset($rates['hourly_rate']);
		    unset($rates['semi_monthly_rate']);
		    unset($rates['monthly_rate']);
		}

		if ($proj->rate_daily == 1) 
		{
		    unset($rates['daily_rate']);
		    unset($rates['semi_monthly_rate']);
		    unset($rates['monthly_rate']);
		}

		if (($proj->rate_semi_monthly == 1) || ($proj->rate_monthly == 1)) 
		{
		    unset($rates['semi_monthly_rate']);
		    unset($rates['monthly_rate']);
		}

		return $rates;

	}

	public function get_projects($multiple = FALSE)
	{
		// Fetch employees
		$this->db->select('project_id, title, description');
		$this->db->order_by('title, description');
		$projects = parent::get();

		if ($multiple == FALSE) 
		$array = array(0 => 'Select projects');

		// Return key -> value pair array
		if (count($projects)) 
		{
			foreach ($projects as $project) 
			$array[$project->project_id] = $project->title;
		}

		return $array;
	}

	public function dropdown($search = NULL, $limit = 25)
	{
	    $data = array();

	    // if ( ! isset($_POST['search']))
        $this->db->limit($limit);
        
        if ($search !== NULL) 
	    $this->db->like('title', $search, 'after')->or_like('description', $search, 'both');

	    foreach (parent::get() as $key => $result) 
	    {
	      $data[] = 
	      				[
	                        "id" => $result->project_id, 
	                        'text' => "{$result->title} ({$result->description})",
	                        'title' => "{$result->title}",
	                        'description' => "{$result->description}",
	                    ];
	    }

	    return $data;
	}

	public function get_employees()
	{
		// Fetch employees
		$this->db->select('employee_id, lastname, firstname, middlename')->where('is_actived', 1);
		$employees = $this->db->order_by('lastname, firstname, middlename')->get('employees')->result();

		// Return key -> value pair array
		$array = array('0' => 'Select employees');
		if (count($employees)) 
		{
			foreach ($employees as $employee) 
			{
				$array[$employee->employee_id] = $employee->lastname . ', ' . $employee->firstname . ' ' . $employee->middlename;
				// $array[$employee->employee_id] = $employee->member_status;
			}
		}
		return $array;
	}

	public function get_positions($project_id = NULL)
	{
		// Fetch position
		$this->db->select('A.position_id, A.position')->where('A.is_actived', 1);
		$this->db->join('project_position_rates as B', 'A.position_id = B.position_id', 'left');

		$project_id == NULL || $this->db->where('project_id', $project_id);

		$positions = $this->db->order_by('position')->get('positions as A')->result();

		// Return key -> value pair array
		$array = array('0' => 'Select position');
		if (count($positions)) 
		{
			foreach ($positions as $position) 
			{
				$array[$position->position_id] = $position->position;
			}
		}
		return $array;
	}


	public function delete($id)
	{
		// Delete a status
		parent::delete($id);

		// Reset employment_status ID for its members table
		// $this->db->set(array('project_id' => 0))->where('project_id', $id)->update('members');
	}

	public function with_employees()
	{
		$this->db->join('project_employees', 'project_employees.project_id = projects.project_id', 'LEFT');
		$this->db->join('employees', 'employees.employee_id = project_employees.employee_id', 'LEFT');
		
		// return parent::get($employee_id, $single);
		return $this->db;
	}

	public function with_positions()
	{
		$this->db->join('positions', 'project_employees.position_id = positions.position_id', 'LEFT');
		
		return $this->db;
	}

	public function with_rates()
	{
		$this->db->join('project_rates', 'project_rates.project_id = projects.project_id', 'LEFT');
		$this->db->join('rates', 'rates.rate_id = rates.rate_id', 'LEFT');
		
		return $this->db;
	}
}

/*Location: ./application/models/projects.php*/
