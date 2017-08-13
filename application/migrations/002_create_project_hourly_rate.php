<?php 
/**
* Name: Migration_create_proj_hourly_rate
* Author: Brando Talaguit
* Office: Information Technology Center - Solution Section
* Date: 07/08/2015
*/
class Migration_create_project_hourly_rate extends MY_Jammas_migration
{
	
	protected $tablename = 'projects';
	protected $fields = array('rate_hourly BOOLEAN NOT NULL AFTER address');

}