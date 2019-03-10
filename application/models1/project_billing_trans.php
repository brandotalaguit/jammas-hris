<?php

/**
 * Filename: project_billing_trans.php
 * Author: Brando Talaguit (ITC Developer)
 */
class Project_billing_trans extends MY_Model
{
    protected $table_name = "project_billing_trans";
    protected $primary_key = "pbt_id";
    protected $order_by = "project_billing_trans.created_at";
    protected $timestamps = TRUE;

    public $rules = array(
        'project_bill_id' => ['field' => 'project_bill_id', 'label' => 'Project Billing Id', 'rules' => 'required|intval|is_natural_no_zero|xss_clean'],
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
        'pk' => ['field' => 'pk', 'label' => 'Project Billing Id', 'rules' => 'required|intval|is_natural_no_zero|callback__id_exists|xss_clean'],
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
        $data->project_bill_id = intval($this->uri->segment(3, 0));
        $data->project_employee_id = 0.00;
        $data->no_hrs = 0.00;
        $data->rw_day = 0.00;
        $data->sd_day = 0.00;
        $data->nd_day = 0.00;
        $data->nd_ot_day = 0.00;
        $data->sp_day = 0.00;
        $data->sp_ot_day = 0.00;
        $data->lg_day = 0.00;
        $data->lg_ot_day = 0.00;
        $data->rd_lg_hl = 0.00;
        $data->rd_lg_ot_hl = 0.00;
        $data->od_day = 0.00;
        $data->od_ot_day = 0.00;
        $data->admin_cost = 0.00;
        $data->vat = 0.00;
        $data->rate_admin_fee_vat = 0.00;

        return $data;
    }


    public function get_project_billing_trans($project_bill_id = NULL, $pbt_id = NULL, $single = FALSE)
    {
        $this->db->select('project_billing_trans.*, E.lastname, E.firstname, E.middlename, D.*, F.*, C.w_adjustment, C.remarks');
        $this->db->join('project_billing_info as A', 'A.project_bill_id = project_billing_trans.project_bill_id', 'left');
        $this->db->join('projects as B', 'B.project_id = A.project_id', 'left');
        $this->db->join('project_employees as C', 'C.project_employee_id = project_billing_trans.project_employee_id', 'left');
        $this->db->join('employees as E', 'E.employee_id = C.employee_id', 'left');
        $this->db->join('project_position_rates as D', 'D.ppr_id = C.ppr_id', 'left');
        $this->db->join('positions as F', 'F.position_id = D.position_id', 'left');

        return $pbt_id !== NULL ? parent::get($pbt_id, $single) : parent::get_by(['project_billing_trans.project_bill_id' => $project_bill_id]);
    }

    public function fill_billing($project_bill_id, $project_id, $ppr_id = NULL)
    {
        $pbt_column = '';
        $rate_column = '';
        $pbt_r_column_arr = array();
        $now = date('Y-m-d H:i:s');

        foreach ($this->get_billing_rates_array() as $key => $value) 
        {            
             $pbt_column .= 'r_' . $key . ', ';
             $rate_column .= $key . ', ';

             $pbt_r_column_arr = array_merge($pbt_r_column_arr, array('r_' . $key => $key));
        }

        if (parent::count(array('project_bill_id' => $project_bill_id))) 
        {
            $sql = "UPDATE `project_billing_trans` as C
                        LEFT JOIN project_employees as A ON C.project_employee_id = A.project_employee_id
                        LEFT JOIN project_position_rates as B ON A.ppr_id = B.ppr_id  
                    SET 
                        `r_cola` = cola,
                        `r_hourly_rate` = hourly_rate,
                        `r_daily_rate` = daily_rate,
                        `r_semi_monthly_rate` = semi_monthly_rate,
                        `r_monthly_rate` = monthly_rate,
                        `r_regular_ot_day` = regular_ot_day,
                        `r_straight_duty` = straight_duty,
                        `r_straight_ot_day` = straight_ot_day,
                        `r_night_diff` = night_diff,
                        `r_night_ot_diff` = night_ot_diff,
                        `r_legal_holiday` = legal_holiday,
                        `r_legal_ot_holiday` = legal_ot_holiday,
                        `r_rest_day_rate` = rest_day_rate,
                        `r_rest_day_ot_rate` = rest_day_ot_rate,
                        `r_rest_day_special_holiday` = rest_day_special_holiday,
                        `r_rest_day_special_ot_holiday` = rest_day_special_ot_holiday,
                        `r_rest_day_legal_holiday` = rest_day_legal_holiday,
                        `r_rest_day_legal_ot_holiday` = rest_day_legal_ot_holiday,
                        `r_special_holiday` = special_holiday,
                        `r_special_ot_holiday` = special_ot_holiday,
                        `r_late_amount` = late_amount,
                        `r_absent_rate_per_day` = absent_rate_per_day,
                        `r_absent_rate` = absent_rate,
                        `C`.`updated_at` = NOW() 
                    WHERE `A`.`project_id` =  ? AND `C`.`project_bill_id` =  ?";
            
            if ($ppr_id !== NULL)
            $sql .= " AND B.ppr_id = {$ppr_id}";

            $this->db->query($sql, [$project_id, $project_bill_id]);
        }
        else
        {
            $sql = "INSERT INTO project_billing_trans(project_bill_id, project_employee_id, $pbt_column created_at, updated_at)";
            $sql.= "SELECT ?, project_employee_id, $rate_column ?, ? 
                    -- LEFT JOIN project_employees as A ON C.project_employee_id = A.project_employee_id
                    FROM project_employees as A 
                    LEFT JOIN project_position_rates as B ON A.ppr_id = B.ppr_id                      
                    WHERE A.project_id = $project_id AND w_adjustment = 0 AND A.is_actived = 1 AND B.is_actived = 1";
            $now = date('Y-m-d H:i:s');
            $this->db->query($sql, [$project_bill_id, $now, $now]);
        }

        return $this->get_project_billing_trans($project_bill_id);
    }


    /**
     * Generate billing summary per period
     * 
     * @param   array   a key/value pair of fields
     * @return  object  data summary
     */
    public function get_project_summary_by($condition, $group_by = NULL)
    {
        $this->db->where($condition);

        if ($group_by === NULL) 
        $this->db->group_by('project_billing_trans.project_bill_id');
        else
        $this->db->group_by($group_by);

        return $this->get_project_summary();
    }


    /**
     * Generate project summary
     *
     * @param   int   
     * @param   int   
     * @param   bool  
     * @return  object
     */
    public function get_project_summary($pbt_id = NULL, $single = FALSE)
    {
        $this->db->select('project_billing_trans.project_bill_id, F.position, fields, A.remarks as billing_remarks, 
            SUM(IF(c.w_adjustment=0,1,0)) as cnt_emp, SUM(IF(c.w_adjustment=1,1,0)) as cnt_adj,
            COUNT(*) as cnt_row, date_start, date_end, 
            
            semi_monthly_rate, monthly_rate, hourly_rate,
            daily_rate, regular_ot_day, straight_duty, straight_ot_day, night_diff, night_ot_diff, legal_holiday, legal_ot_holiday, 
            rest_day_rate, rest_day_ot_rate, rest_day_special_holiday, rest_day_special_ot_holiday, rest_day_legal_holiday, rest_day_legal_ot_holiday, 
            special_holiday, special_ot_holiday, 
            late_amount, late_minutes, no_absences_per_day, no_absences_per_hr, absent_rate, absent_rate_per_day,
            
            SUM(no_hrs) as working_hours, 
            SUM(rw_day) as working_days, SUM(rw_ot_day) as rw_ot_day_cnt, 
            SUM(sd_day) as sd_day_cnt, SUM(sd_ot_day) as sd_ot_day_cnt, 
            SUM(nd_day) as nd_day_cnt, SUM(nd_ot_day) as nd_ot_day_cnt,
            SUM(lg_day) as lg_day_cnt, SUM(lg_ot_day) as lg_ot_day_cnt,  
            SUM(rd_day) as rd_day_cnt, SUM(rd_ot_day) as rd_ot_day_cnt, SUM(rd_sh_day) as rd_sh_day_cnt, SUM(rd_sh_ot_day) as rd_sh_ot_day_cnt, 
            SUM(rd_lg_hl) as rd_lg_hl_cnt, SUM(rd_lg_ot_hl) as rd_lg_ot_hl_cnt,
            SUM(sp_day) as h_day_cnt, SUM(sp_ot_day) as h_ot_day_cnt, 
            SUM(late_minutes) as late_minutes_cnt, 
            SUM(no_absences_per_day) as no_absences_per_day_cnt, 
            SUM(no_absences_per_hr) as no_absences_per_hr_cnt, 
            
            SUM(semi_monthly_rate) as semi_monthly, SUM(monthly_rate) as monthly, SUM(no_hrs * r_hourly_rate) as hourly, 
            SUM(rw_day * r_daily_rate) as daily, SUM(rw_ot_day * r_regular_ot_day) as ot, 
            SUM(sd_day * r_straight_duty) as s_duty, SUM(sd_ot_day * r_straight_ot_day) as s_ot_duty, 
            SUM(nd_day * r_night_diff) as n_duty, SUM(nd_ot_day * r_night_ot_diff) as n_ot_duty,
            SUM(lg_day * r_legal_holiday) as lg_duty, SUM(lg_ot_day * r_legal_ot_holiday) as lg_ot_duty, 
            SUM(rd_day * r_rest_day_rate) as rd_duty, SUM(rd_ot_day * r_rest_day_ot_rate) as rd_ot_duty,
            SUM(rd_sh_day * r_rest_day_special_holiday) as rd_sh, SUM(rd_sh_ot_day * r_rest_day_special_ot_holiday) as rd_ot_sh, 
            SUM(rd_lg_hl * r_rest_day_legal_holiday) as rd_lghl, SUM(rd_lg_ot_hl * r_rest_day_legal_ot_holiday) as rd_ot_lghl, 
            SUM(sp_day * r_special_holiday) as sp_hl_duty, SUM(sp_ot_day * r_special_ot_holiday) as sp_hl_ot_duty, 
            SUM(late_minutes * r_late_amount) as late, 
            SUM(no_absences_per_day * r_absent_rate_per_day) as deduct_absent_per_day, 
            SUM(no_absences_per_hr * r_absent_rate) as deduct_absent_per_hr
            ', 
            FALSE);

            // SUM(semi_monthly_rate) as semi_monthly, SUM(monthly_rate) as monthly, SUM(no_hrs * hourly_rate) as hourly, 
            // SUM(rw_day * daily_rate) as daily, SUM(rw_ot_day * regular_ot_day) as ot, 
            // SUM(sd_day * straight_duty) as s_duty, SUM(sd_ot_day * straight_ot_day) as s_ot_duty, 
            // SUM(nd_day * night_diff) as n_duty, SUM(nd_ot_day * night_ot_diff) as n_ot_duty,
            // SUM(lg_day * legal_holiday) as lg_duty, SUM(lg_ot_day * legal_ot_holiday) as lg_ot_duty, 
            // SUM(rd_day * rest_day_rate) as rd_duty, SUM(rd_ot_day * rest_day_ot_rate) as rd_ot_duty,
            // SUM(rd_sh_day * rest_day_special_holiday) as rd_sh, SUM(rd_sh_ot_day * rest_day_special_ot_holiday) as rd_ot_sh, 
            // SUM(rd_lg_hl * rest_day_legal_holiday) as rd_lghl, SUM(rd_lg_ot_hl * rest_day_legal_ot_holiday) as rd_ot_lghl, 
            // SUM(sp_day * special_holiday) as sp_hl_duty, SUM(sp_ot_day * special_ot_holiday) as sp_hl_ot_duty, 
            // SUM(late_minutes * late_amount) as late, 
            // SUM(no_absences_per_day * absent_rate_per_day) as deduct_absent_per_day, 
            // SUM(no_absences_per_hr * absent_rate) as deduct_absent_per_hr

         $this->_summay_join_statement();

        if ($pbt_id !== NULL) 
        {
            $this->db->group_by('project_billing_trans.pbt_id');
        }

        return parent::get($pbt_id, $single);
    }

    public function get_billing_rates_array()
    {
        /**
         * rates => 
         *          [rate*basis => total_rate_amount] | 
         *          [rate title] |
         *          [rate excel label] |
         *          [total per rate => grand total] |  <--(get_project_summary.[column_name])
         *          [total per column => column total] <--(get_project_summary.[column_name]_cnt)
         */

        $array = array(
            'cola' => 'cola|cola|cola|cola|cola',
            'hourly_rate' => "no_hrs|No. of hours worked|No.<br>Hours|hourly|working_hours",
            'daily_rate' => "rw_day|Regular days worked|Reg.<br>Days|daily|working_days",
            'semi_monthly_rate' => "0|0|0|semi_monthly|1",
            'monthly_rate' => "0|0|0|monthly|1",
            'regular_ot_day' => "rw_ot_day|Regular days O.T. worked|Reg.<br>O.T.|ot|rw_ot_day_cnt",
            'straight_duty' => "sd_day|Straight days worked|Straight<br>Duty|s_duty|sd_day_cnt",
            'straight_ot_day' => "sd_ot_day|Straight days O.T. worked|Straight<br>Duty O.T.|s_ot_duty|sd_ot_day_cnt",
            'night_diff' => "nd_day|Night Differential worked|Night<br>Diff.|n_duty|nd_day_cnt",
            'night_ot_diff' => "nd_ot_day|Night Differential O.T. worked|Night<br>Diff. O.T.|n_ot_duty|nd_ot_day_cnt",
            'legal_holiday' => "lg_day|Legal Holidays worked|Leg.<br>Hol.|lg_duty|lg_day_cnt",
            'legal_ot_holiday' => "lg_ot_day|Legal Holidays O.T. worked|Leg.<br>Hol. O.T.|lg_ot_duty|lg_ot_day_cnt",
            'rest_day_rate' => "rd_day|Rest Day worked|Rest<br>Day|rd_duty|rd_day_cnt",
            'rest_day_ot_rate' => "rd_ot_day|Rest Day O.T.|RD O.T.|rd_ot_duty|rd_ot_day_cnt",
            'rest_day_special_holiday' => "rd_sh_day|Rest Day Special Holidays worked|Rest Day<br>Spcl. Hol.|rd_sh|rd_sh_day_cnt",
            'rest_day_special_ot_holiday' => "rd_sh_ot_day|Rest Day Special Holidays O.T.|RD O.T.<br>Spcl. Hol.|rd_ot_sh|rd_sh_ot_day_cnt",
            'rest_day_legal_holiday' => "rd_lg_hl|Rest Day Legal Holidays worked|Rest Day<br>Leg. Hol.|rd_lghl|rd_lg_hl_cnt",
            'rest_day_legal_ot_holiday' => "rd_lg_ot_hl|Rest Day Legal Holidays O.T. worked|RD O.T.<br>Leg. Hol.|rd_ot_lghl|rd_lg_ot_hl_cnt",
            'special_holiday' => "sp_day|Special Holidays worked|Spcl.<br>Hol.|sp_hl_duty|h_day_cnt",
            'special_ot_holiday' => "sp_ot_day|Special Holidays O.T. worked|Spcl. Hol. <br>O.T.|sp_hl_ot_duty|h_ot_day_cnt",
            'late_amount' => "late_minutes|Minutes Lates|Lates|late|late_minutes_cnt",
            'absent_rate_per_day' => "no_absences_per_day|No. of Days Absent|No. of Days Absent|deduct_absent_per_day|no_absences_per_day_cnt",
            // 'absent_rate_per_hr' => "no_absences_per_hr|No. of Hours Absent|Absences Per Hrs|deduct_absent_per_hr|no_absences_per_hr_cnt",
            'absent_rate' => "no_absences_per_hr|No. of Hours Absent|Absences Per Hrs|deduct_absent_per_hr|no_absences_per_hr_cnt",
        );

        return $array;
    }


    private function _summay_join_statement()
    {
        $this->db->join('project_billing_info as A', 'A.project_bill_id = project_billing_trans.project_bill_id', 'left');
        $this->db->join('projects as B', 'B.project_id = A.project_id', 'left');
        $this->db->join('project_employees as C', 'C.project_employee_id = project_billing_trans.project_employee_id', 'left');
        $this->db->join('employees as E', 'E.employee_id = C.employee_id', 'left');
        $this->db->join('project_position_rates as D', 'D.ppr_id = C.ppr_id', 'left');
        $this->db->join('positions as F', 'F.position_id = D.position_id', 'left');
    }

}

/*Location: ./application/models/project_billing_trans.php*/
?>