<?php 
/**
* Name: Migration_create_pbt_night_diff_ot
* Author: Brando Talaguit
* Office: Information Technology Center - Solution Section
* Date: 07/11/2015
*/
class Migration_create_pbt_night_diff_ot extends MY_Jammas_migration
{
	
	protected $tablename = 'project_billing_trans';
	protected $fields = array(
		'no_hrs DECIMAL(8, 2) NOT NULL AFTER project_employee_id', 
		'nd_ot_day DECIMAL(8, 2) NOT NULL AFTER nd_day',
	);

}