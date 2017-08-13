<?php 
/**
* Name: Migration_create_combine_project_billings
* Author: Brando Talaguit
* Office: Information Technology Center - Solution Section
* Date: 10/21/2015
*/
class Migration_create_combine_project_billings extends MY_Jammas_migration
{
	
	protected $tablename = 'combine_project_billings';
	protected $fields = array(
		'cb_pb_id INT(11) NOT NULL AUTO_INCREMENT',
		'cb_id INT(11) NOT NULL',
		'project_id INT(11) NOT NULL',
		'project_bill_id INT(11) NOT NULL',
		'user_id INT(5) NOT NULL',
		'is_actived TINYINT(1) NOT NULL DEFAULT "1"',
		'created_at DATETIME NOT NULL',
		'updated_at DATETIME NOT NULL',
		'deleted_at DATETIME NOT NULL',
	);


	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('cb_pb_id', TRUE);
		$this->dbforge->add_key('cb_id');
		$this->dbforge->create_table($this->tablename);
		
	}

	public function down()
	{
		$this->dbforge->drop_table($this->tablename);
	}

}