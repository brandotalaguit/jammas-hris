<?php 
/**
* Name: Migration_create_ppr_hourly_rate
* Author: Brando Talaguit
* Office: Information Technology Center - Solution Section
* Date: 07/08/2015
*/
class Migration_create_ppr_hourly_rate extends MY_Jammas_migration
{
	
	protected $tablename = 'project_position_rates';
	protected $fields = array(
		'hourly_rate DECIMAL(8, 4) NOT NULL AFTER cola',
		'night_ot_diff DECIMAL(8, 4) NOT NULL AFTER night_diff'
	);

}