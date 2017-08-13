<?php 
/**
* Name: Migration_add_column_rate_pbt
* Author: Brando Talaguit
* Office: Information Technology Center - Solution Section
* Date: 07/11/2015
*/
class Migration_add_3_column_projects extends MY_Jammas_migration
{
	
	protected $tablename = 'projects';
	protected $fields = array(
		'business_style VARCHAR(180) NOT NULL AFTER address',
		'po VARCHAR(100) NOT NULL AFTER business_style',
		'tin VARCHAR(50) NOT NULL AFTER po',
	);

	public function up()
	{
		parent::up();
		$this->db->query('UPDATE projects SET user_id = 1');
	}

	public function down()
	{


		$fields = array(
			'business_style',
			'po',
			'tin',
		);

		foreach ($fields as $field) 
		{
			if ($this->db->field_exists($field, $this->tablename))
			$this->dbforge->drop_column($this->tablename, $field);
		}

		$this->db->query('UPDATE projects SET user_id = 0 WHERE user_id = 1');
		
	}

}