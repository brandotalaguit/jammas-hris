<?php 
/**
* Name: Migration_create_combine_billings
* Author: Brando Talaguit
* Office: Information Technology Center - Solution Section
* Date: 10/20/2015
*/
class Migration_create_combine_billings extends MY_Jammas_migration
{
	
	protected $tablename = 'combine_billings';
	protected $fields = array(
		'cb_id INT(11) NOT NULL AUTO_INCREMENT',
		'user_id INT(5) NOT NULL',
		'is_actived TINYINT(1) NOT NULL DEFAULT "1"',
		'created_at DATETIME NOT NULL',
		'updated_at DATETIME NOT NULL',
		'deleted_at DATETIME NOT NULL',
	);

	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('cb_id', TRUE);
		$this->dbforge->add_key('user_id');
		$this->dbforge->create_table($this->tablename);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->tablename);
	}

}