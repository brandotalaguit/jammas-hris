<?php 
/**
* Name: Migration_add_column_rate_pbt
* Author: Brando Talaguit
* Office: Information Technology Center - Solution Section
* Date: 07/11/2015
*/
class Migration_add_column_rate_pbt extends MY_Jammas_migration
{
	
	protected $tablename = 'project_billing_trans';
	protected $fields = array(
		'r_cola DECIMAL(8, 4) NOT NULL AFTER project_employee_id',
		'r_monthly_rate DECIMAL(8, 4) NOT NULL AFTER r_cola',
		'r_semi_monthly_rate DECIMAL(8, 4) NOT NULL AFTER r_monthly_rate',
		'r_daily_rate DECIMAL(8, 4) NOT NULL AFTER rw_day',
		'r_hourly_rate DECIMAL(8, 4) NOT NULL AFTER no_hrs', 
		'r_straight_duty DECIMAL(8, 4) NOT NULL AFTER sd_day',
		'r_straight_ot_day DECIMAL(8, 4) NOT NULL AFTER sd_ot_day',
		'r_night_diff DECIMAL(8, 4) NOT NULL AFTER nd_day',
		'r_night_ot_diff DECIMAL(8, 4) NOT NULL AFTER nd_ot_day',
		'r_rest_day_rate DECIMAL(8, 4) NOT NULL AFTER rd_day',
		'r_rest_day_ot_rate DECIMAL(8, 4) NOT NULL AFTER rd_ot_day',
		'r_rest_day_special_holiday DECIMAL(8, 4) NOT NULL AFTER rd_sh_day',
		'r_rest_day_special_ot_holiday DECIMAL(8, 4) NOT NULL AFTER rd_sh_ot_day',
		'r_rest_day_legal_holiday DECIMAL(8, 4) NOT NULL AFTER rd_lg_hl',
		'r_rest_day_legal_ot_holiday DECIMAL(8, 4) NOT NULL AFTER rd_lg_ot_hl',
		'r_legal_holiday DECIMAL(8, 4) NOT NULL AFTER lg_day',
		'r_legal_ot_holiday DECIMAL(8, 4) NOT NULL AFTER lg_ot_day',
		'r_special_holiday DECIMAL(8, 4) NOT NULL AFTER sp_day',
		'r_special_ot_holiday DECIMAL(8, 4) NOT NULL AFTER sp_ot_day',
		'r_regular_ot_day DECIMAL(8, 4) NOT NULL AFTER rw_ot_day',
		'r_late_amount DECIMAL(8, 4) NOT NULL AFTER late_minutes',
		'r_absent_rate_per_day DECIMAL(8, 4) NOT NULL AFTER no_absences_per_day',
		'r_absent_rate DECIMAL(8, 4) NOT NULL AFTER no_absences_per_hr',
	);

	public function down()
	{


		$fields = array(
			'r_cola',
			'r_monthly_rate',
			'r_semi_monthly_rate',
			'r_daily_rate',
			'r_hourly_rate',
			'r_straight_duty',
			'r_straight_ot_day',
			'r_night_diff',
			'r_night_ot_diff',
			'r_rest_day_rate',
			'r_rest_day_ot_rate',
			'r_rest_day_special_holiday',
			'r_rest_day_special_ot_holiday',
			'r_rest_day_legal_holiday',
			'r_rest_day_legal_ot_holiday',
			'r_legal_holiday',
			'r_legal_ot_holiday',
			'r_special_holiday',
			'r_special_ot_holiday',
			'r_regular_ot_day',
			'r_late_amount',
			'r_absent_rate_per_day',
			'r_absent_rate',
		);

		foreach ($fields as $field) 
		{
			if ($this->db->field_exists($field, $this->tablename))
			$this->dbforge->drop_column($this->tablename, $field);
		}

		
	}

}