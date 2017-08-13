<?php 
/**
* Name: Migration_create_vat
* Author: Brando Talaguit
* Office: Information Technology Center - Solution Section
* Date: 07/16/2015
*/
class Migration_create_is_wt_tax extends MY_Jammas_migration
{
	
	protected $tablename = 'project_billing_info';
	protected $fields = array('is_wt_tax BOOLEAN NOT NULL AFTER is_vat');

/*
	public function up()
	{
		// $fields = ['is_vat' => ['type' => 'BOOLEAN', 'AFTER' => 'fields']];	
		$fields = array(
			'is_vat BOOLEAN NOT NULL AFTER fields'
		);

		$this->dbforge->add_column('project_billing_info', $fields);
	}

*/
	public function down()
	{
		$this->dbforge->drop_column('project_billing_info', 'is_wt_tax');
	}

}
 ?>