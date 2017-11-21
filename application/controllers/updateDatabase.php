<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class updateDatabase extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$this->load->library('session');

		$sql1 = "ALTER TABLE `jammas-hris`.`manning_payroll_setting`
				ADD COLUMN `with_13th_month` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '' AFTER `is_actived`;";
		$sql2 = "ALTER TABLE `jammas-hris`.`projects`
				ADD COLUMN `with_13th_month` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '' AFTER `mode_of_payment_sss`;";

				if ( ! $this->db->field_exists('with_13th_month', 'jammas-hris`.`manning_payroll_setting'))
				$this->db->query($sql1);

				if ( ! $this->db->field_exists('with_13th_month', 'jammas-hris`.`projects'))
				{
					$this->db->query($sql2);
					$this->db->query("UPDATE projects SET with_13th_month = 1, updated_at = NOW() WHERE is_actived");
					$this->session->set_flashdata('success', 'Database has been successfully updated. You can now choose projects for 13th month benefits');
				}

				if ( ! $this->db->table_exists('manning_reliever') )
				{
					$create_table = "CREATE TABLE manning_reliever (
									  `manning_reliever_id` INT(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT '',
									  `mr_manning_id` INT(11) UNSIGNED ZEROFILL NOT NULL COMMENT '',
									  `mr_payroll_id` INT(5) UNSIGNED ZEROFILL NOT NULL COMMENT '',
									  `mr_rate` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
									  `mr_daily_rate` DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT '',
									  `mr_e_cola` DECIMAL(6,2) NOT NULL DEFAULT 0.00 COMMENT '',
									  `created_at` DATETIME NOT NULL COMMENT '',
									  `updated_at` DATETIME NOT NULL COMMENT '',
									  `deleted_at` DATETIME NOT NULL COMMENT '',
									  `is_actived` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '',
									  PRIMARY KEY (`manning_reliever_id`)  COMMENT '',
									  INDEX `man_payroll` (`mr_manning_id` ASC, `mr_payroll_id` ASC, `is_actived` ASC)  COMMENT '',
									  INDEX `manning` (`mr_manning_id` ASC, `is_actived` ASC)  COMMENT '');
									";
					$this->db->query($create_table);
				}

				if ( ! $this->db->field_exists('mr_allowance', 'jammas-hris`.`manning_reliever'))
				{
						$sql4 = "ALTER TABLE `manning_reliever`
								ADD COLUMN `mr_allowance` DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT '' AFTER `mr_e_cola`,
								ADD COLUMN `mr_allowance_mode_of_payment` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '' AFTER `mr_allowance`;
								";
						$this->db->query($sql4);
						$this->session->set_flashdata('message', 'Database has been successfully updated. You can now input allowance rate for reliever');
				}

				if ( ! $this->db->field_exists('mr_employment_status_id', 'jammas-hris`.`manning_reliever'))
				{
					$sql5 = "ALTER TABLE `jammas-hris`.`manning_reliever`
					CHARACTER SET = utf8 , COLLATE = utf8_general_ci ,
					ADD COLUMN `mr_employment_status_id` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '' AFTER `mr_allowance_mode_of_payment`;";
					$this->db->query($sql5);
					$this->session->set_flashdata('message', 'Database has been successfully updated. Manning mr_employment_status_id is now being record in the Database.');

				}

				if ( ! $this->db->field_exists('r_employment_status_id', 'jammas-hris`.`manning_payroll_earning'))
				{
					$sql6 = "ALTER TABLE `jammas-hris`.`manning_payroll_earning`
								ADD COLUMN `r_employment_status_id` INT(2) NULL COMMENT '' AFTER `r_13thmonth`,
								ADD INDEX `r_employment_status_id` (`r_employment_status_id` ASC)  COMMENT '';";
					$this->db->query($sql6);
					$this->session->set_flashdata('message', 'Database has been successfully updated. Manning r_employment_status_id is now being record in the Database.');

				}


				redirect('manning_payroll', 'refresh');

	}

}

/* End of file  */
/* Location: ./application/controllers/ */
