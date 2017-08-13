<?php

/**
 * Filename: manning_payroll_deduction_detail_detail_m.php
 * Author: Brando Talaguit (ITC Developer)
 */
class Manning_payroll_deduction_detail_m extends MY_Model
{
    protected $table_name = "manning_payroll_deduction_detail";
    protected $primary_key = "manning_payroll_deduction_detail_id";
    protected $order_by = "PayrollId, manning_payroll_deduction_detail_id";


    public $rules = array(
        'payroll_id' => ['field' => 'payroll_id', 'label' => 'Payroll Id', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
        'project_employee_id' => ['field' => 'project_employee_id', 'label' => 'Project Employee', 'rules' => 'required|intval|xss_clean'],
        'no_hrs' => ['field' => 'no_hrs', 'label' => 'No. of Hour', 'rules' => 'decimal|xss_clean'],
        'rw_day' => ['field' => 'rw_day', 'label' => 'No. of Regular Working Day', 'rules' => 'decimal|xss_clean'],
        'sd_day' => ['field' => 'sd_day', 'label' => 'No. of Straight Duty', 'rules' => 'decimal|xss_clean'],
        'nd_day' => ['field' => 'nd_day', 'label' => 'No. of Night Differential', 'rules' => 'decimal|xss_clean'],
        'nd_ot_day' => ['field' => 'nd_ot_day', 'label' => 'No. of Night Differential Over-Time', 'rules' => 'decimal|xss_clean'],
        'sp_day' => ['field' => 'sp_day', 'label' => 'No. of Special Holiday', 'rules' => 'decimal|xss_clean'],
        'sp_ot_day' => ['field' => 'sp_ot_day', 'label' => 'No. of Special Holiday Over-Time', 'rules' => 'decimal|xss_clean'],
        'lg_day' => ['field' => 'lg_day', 'label' => 'No. of Legal Holiday', 'rules' => 'decimal|xss_clean'],
        'lg_ot_day' => ['field' => 'lg_ot_day', 'label' => 'No. of Legal Holiday Over-Time', 'rules' => 'decimal|xss_clean'],
        'rd_lg_hl' => ['field' => 'rd_lg_hl', 'label' => 'No. of Rest Day Legal Holiday', 'rules' => 'decimal|xss_clean'],
        'rd_lg_ot_hl' => ['field' => 'rd_lg_ot_hl', 'label' => 'No. of Rest Day Legal Holiday Over-Time', 'rules' => 'decimal|xss_clean'],
        'od_day' => ['field' => 'od_day', 'label' => 'No. of Off-Duty', 'rules' => 'decimal|xss_clean'],
        'od_ot_day' => ['field' => 'od_ot_day', 'label' => 'No. of Off-Duty Over-Time', 'rules' => 'decimal|xss_clean'],
        'admin_cost' => ['field' => 'admin_cost', 'label' => 'Admin Cost', 'rules' => 'decimal|xss_clean'],
        'vat' => ['field' => 'vat', 'label' => 'VAT', 'rules' => 'decimal|xss_clean'],
        'rate_admin_fee_vat' => ['field' => 'rate_admin_fee_vat', 'label' => 'Admin Fee & VAT', 'rules' => 'decimal|xss_clean']
    );

    public $single_column_rules = array(
        'pk' => ['field' => 'pk', 'label' => 'Payroll', 'rules' => 'required|intval|is_natural_no_zero|callback__valid_id|xss_clean'],
        'name' => ['field' => 'name', 'label' => 'Column Name', 'rules' => 'required|xss_clean'],
        'value' => ['field' => 'value', 'label' => 'Values', 'rules' => 'required|is_numeric|to_decimal|nf|xss_clean']
    );

    function __construct()
    {
        parent::__construct();
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->PayrollId = 0;
        $data->DeductionId = 0;
        $data->amount = 0.00;

        return $data;
    }


    public function get_manning_payroll_deduction_detail()
    {
        $this->db->select('manning_payroll_deduction_detail.*, employee_no, lastname, firstname, middlename, position_code, position, payroll_date, deduction_category_code, deduction_category');
        $this->db->join('deductions as H', 'H.deduction_id = DeductionId', 'left');
        $this->db->join('deduction_categories as I', 'I.deduction_category_id = H.deduction_category_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = H.employee_id', 'left');
        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_deduction_detail.PayrollId', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');
        $this->db->join('projects as G', 'G.project_id = A.project_id', 'left');

        return parent::get(NULL, FALSE);
    }

}

/*Location: ./application/models/manning_payroll_deduction_detail_m.php*/