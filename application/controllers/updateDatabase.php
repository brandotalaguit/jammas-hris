<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class updateDatabase extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
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

				redirect('manning_payroll', 'refresh');

	}

}

/* End of file  */
/* Location: ./application/controllers/ */
