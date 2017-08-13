<?php

/**
 * Filename: manning_payroll_earning_m.php
 * Author: Brando Talaguit (ITC Developer)
 */
class Manning_payroll_earning_m extends MY_Model
{
    protected $table_name = "manning_payroll_earning";
    protected $primary_key = "manning_payroll_earning_id";
    protected $order_by = "manning_payroll_earning_id DESC, manning_payroll_earning.payroll_id ASC";


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
        $data->payroll_id = 0;
        $data->project_employee_id = 0;
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

    public function get_payroll($payroll_id, $single = FALSE)
    {
        $this->load->model(['manning_payroll_m', 'projects']);

        $sum_income = $sum_deduction = $sum_basic = "";
        $deduction_field = ['late_amount', 'absent_rate', 'absent_rate_per_day'];

        $payroll = $this->manning_payroll_m->get($payroll_id);
        $wage = explode(',', $payroll->fields);

        $project = $this->projects->get($payroll->project_id);

        $wage[] = 'hourly_rate';
        $wage[] = 'semi_monthly_rate';
        $wage[] = 'monthly_rate';
        
        $income_field = $this->projects->get_field();
        foreach ($wage as $earning) 
        {
            $select_earning[] = $income_field[$earning]['payroll'];
            $select_earning[] = $income_field[$earning]['multiplier'];
            
            // DO NOT include DEDUCTION field to income
            if ( ! in_array($earning, $deduction_field)) 
            {
                $optr = $sum_income ? "+" : "";
                $sum_income .=  $optr . "`{$income_field[$earning]['payroll']}`"; 
            }
        }

        $select = [
                    'lastname',
                    'firstname',
                    'middlename',
                    'employee_no',
                    'position_code',
                    'position',
                    'manning_payroll_earning_id',
                    'manning_payroll_earning.payroll_id',
                    'manning_payroll_earning.employee_id',
                    'daily_rate',
                    'semi_monthly_rate',
                    'monthly_rate',
                    'r_cola',
                    'r_allowance',
                    'r_13thmonth',
                    'r_adjustment',
                    'manning_payroll_earning.remarks as earning_remarks',

                    // deduction fields 
                    'manning_payroll_deduction_id',
                    'employee_share_sss', 
                    'employee_share_philhealth', 
                    'employee_share_pagibig', 
                    'other_deduction', 
                    'adjustment', 
                    'G.remarks as deduction_remarks',
                  ];

        $group_by = 'manning_payroll_earning_id';
        if ($single == TRUE) 
        {
            $select = [
                        'manning_payroll_earning_id',
                        'manning_payroll_earning.payroll_id',
                        'count(*) as cnt',
                      ];

            $sum_deduction = "sum(`employee_share_sss` + `employee_share_philhealth` + `employee_share_pagibig` + `other_deduction` + `adjustment` + {$tardiness}) as deduction";
            $select[] = $sum_deduction;
            
            $group_by = 'manning_payroll_earning_m.payroll_id';
        }
        else 
        {
            $select = array_merge($select_earning, $select);
        }
        
        if (in_array('lastname', $select)) 
        $this->db->order_by('lastname, firstname, middlename');

        $this->db->group_by($group_by);
        $sum_income .=  "+ `r_cola` + `r_allowance` + `r_adjustment`"; 
        $select_income = "sum(" . $sum_income . ") as earning";
        $sum_basic = "sum( r_hourly_rate + r_semi_monthly_rate + r_monthly_rate) as sum_basic";
        
        $tardiness = "`r_late_amount` + `r_absent_rate` + `r_absent_rate_per_day`";
        $select_tardiness = "sum({$tardiness}) as tardiness";

        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_earning.payroll_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = manning_payroll_earning.employee_id', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');
        $this->db->join('manning_payroll_deduction as G', 'manningPayrollEarningId = manning_payroll_earning_id', 'left');
        
        $deduction_sql = "(
                            SELECT GROUP_CONCAT(concat(deduction_category,'#',amount) SEPARATOR '|') as deductions, employee_id 
                                FROM deductions a
                                LEFT JOIN manning_payroll_deduction_detail b on deduction_id = DeductionId and b.is_actived = 1
                                LEFT JOIN deduction_categories c on c.deduction_category_id = a.deduction_category_id
                                WHERE a.is_actived AND PayrollId = {$payroll_id}
                                GROUP BY employee_id
                          )";

        $select[] = 'H.deductions';
        $this->db->join($deduction_sql . ' as H', 'H.employee_id = E.manning_id', 'left');
        

        $select[] = $select_income;
        $select[] = $select_tardiness;
        $select[] = $sum_basic;

        $this->db->select($select);

        // ONLY INCLUDE actived deduction
        $this->db->where('G.is_actived', 1);
        $this->db->having('earning >', 0);
        return parent::get_by(['manning_payroll_earning.payroll_id'=>$payroll_id], $single);
    }

    public function get_manning_payroll_earning($payroll_id = NULL, $manning_payroll_earning_id = NULL, $single = FALSE)
    {
        $this->db->select('manning_payroll_earning.*, lastname, firstname, middlename, position_code, position, rate, daily_rate, semi_monthly_rate, monthly_rate');
        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_earning.payroll_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = manning_payroll_earning.employee_id', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');

        return $manning_payroll_earning_id !== NULL ? parent::get($manning_payroll_earning_id, $single) : parent::get_by(['manning_payroll_earning.payroll_id' => $payroll_id]);
    }

    public function update_payroll_data($payroll_id)
    {
        #TODO: 
        // add missing employee,
        // update payroll entries
        $this->load->model('manning_payroll_m');

        $payroll = $this->manning_payroll_m->get($payroll_id);
        if ($payroll->IsFinal == 1) 
        {
            $this->session->set_flashdata('message', '<strong>Access Denied.</strong> <p class="lead">This payroll is already finalized.</p>');
            return redirect("manning_payroll");
        }

        $project_id = $payroll->project_id;
        // regular, project-based, probitionary & co-terminous
        $status_ids = [1,2,3,5];
        $implode_ids = implode(',', $status_ids);
        $now = date('Y-m-d H:i:s');
        $post = [];

        $sql = "SELECT manning_id, employment_status_id, {$payroll_id}, daily_rate, semi_monthly_rate, monthly_rate, allowance 
                FROM manning A 
                WHERE A.is_actived = 1 AND A.employment_status_id IN({$implode_ids}) AND A.project_id = ?
                    AND NOT EXISTS(SELECT 1 FROM manning_payroll_earning WHERE payroll_id = ? AND A.manning_id = employee_id AND is_actived)";

        $missing_employee_qry = $this->db->query($sql, [$project_id, $payroll_id]);
        if ($missing_employee_qry->num_rows()>0)
        {
            foreach ($missing_employee_qry->result() as $employee) {
                $post[] = [
                                'payroll_id' => $payroll_id,
                                'employee_id' => $employee->manning_id,
                                'r_daily_rate' => $employee->daily_rate,
                                'r_semi_monthly_rate' => $employee->semi_monthly_rate,
                                'r_monthly_rate' => $employee->monthly_rate,
                                'r_allowance' => $employee->allowance,
                                'created_at' => $now,
                                'updated_at' => $now,
                          ];
            }
            // die(dump($post));
            $affected = $this->db->insert_batch('manning_payroll_earning', $post);
        }

        // delete excess employees
        $sql = "UPDATE manning_payroll_earning 
                    SET is_actived = 0, updated_at = ? 
                    WHERE is_actived = 1 AND payroll_id = ?
                    AND EXISTS(SELECT 1 FROM manning 
                                WHERE manning_id = employee_id AND employment_status_id NOT IN({$implode_ids}) AND is_actived
                               )";

        $excess_employee_qry = $this->db->query($sql, [$now, $payroll_id]);
        $excess_affected = $this->db->affected_rows();


        // update payroll entries
        $sql = "UPDATE `manning_payroll_earning` as C
                    LEFT JOIN manning as A ON C.employee_id = A.manning_id
                    LEFT JOIN manning_payroll as B ON C.payroll_id = B.payroll_id
                SET 
                    r_allowance = if(allowance_mode_of_payment=1, round((allowance * no_hrs)/8,2),
                                    if(allowance_mode_of_payment=2, allowance,
                                    if(allowance_mode_of_payment=3 AND payroll_period='2nd', allowance,
                                            0.00))), 
                    `r_cola` = if(e_cola > 0 AND no_hrs > 0, round((e_cola/8) * (no_hrs),2), 0.00),
                    `r_hourly_rate` = IF(rate= 1, round((daily_rate/8) * no_hrs,2), 0),
                    `r_daily_rate` = round(daily_rate * rw_day,2),
                    `r_semi_monthly_rate` = IF(rate=2, round(semi_monthly_rate,2), 0),
                    `r_monthly_rate` = IF(rate=3, round(monthly_rate,2), 0),
                    `r_regular_ot_day` = round(((daily_rate/8) * 1.25) * rw_ot_day,2),
                    `r_straight_duty` = round((daily_rate/8) * sd_day,2),
                    -- `r_straight_ot_day` =round( straight_ot_day,2),
                    `r_night_diff` = round(((daily_rate/8) * 0.10) * nd_day,2),
                    `r_night_ot_diff` = round((((daily_rate/8) * 1.25) * 0.10) * nd_ot_day,2),
                    `r_legal_holiday` = round(((daily_rate+if(e_cola > 0, 10, 0))/8) * lg_day,2),
                    `r_legal_ot_holiday` = round((((daily_rate/8) * 2.60)) * lg_ot_day,2),
                    `r_rest_day_rate` = round(((daily_rate/8) * 1.30) * rd_day,2),
                    `r_rest_day_ot_rate` = round(((((daily_rate/8) * 1.30) * 0.30) + (((daily_rate/8) * 1.30))) * rd_ot_day,2),
                    `r_rest_day_special_holiday` = round(((daily_rate/8) * 1.50) * rd_sh_day/*((daily_rate/8) * 0.50) * rd_sh_day*/,2),
                    `r_rest_day_special_ot_holiday` = round(((daily_rate/8) * 1.95) * rd_sh_ot_day,2),
                    `r_rest_day_legal_holiday` = round((((daily_rate/8) * 1.30) * 2) * rd_lg_hl,2),
                    `r_rest_day_legal_ot_holiday` = round(((daily_rate/8) * 3.38) * rd_lg_ot_hl,2),
                    `r_special_holiday` = round((((daily_rate+if(e_cola > 0, 10, 0))/8) * 0.30) * sp_day,2),
                    `r_special_ot_holiday` = round(((daily_rate/8) * 1.95) * sp_ot_day/*(((daily_rate/8) * 0.30) * 1.30) * sp_ot_day*/,2),
                    `r_late_amount` = round(((daily_rate/8)/60) * late_minutes * -1,2),
                    `r_absent_rate_per_day` = round(((daily_rate/8) * no_absences_per_day) * -1,2),
                    `r_absent_rate` = round(((daily_rate/8) * no_absences_per_hr) * -1,2),
                    `r_incentive` = 0,
                    `r_13thmonth` = round(((daily_rate/8) * no_hrs)/12,2),
                    `C`.`updated_at` = ? 
                WHERE `C`.`payroll_id` =  ? AND C.is_actived = 1";
        $this->db->query($sql, [$now, $payroll_id]);
        $update_affected = $this->db->affected_rows();

        $this->session->set_flashdata('message', '<strong>Success.</strong> <p class="lead">This payroll entries has been successfully updated.</p>');
        return redirect("manning_payroll/earning/{$payroll_id}");
    }

    public function save_earning($payroll_id, $employee_id = NULL, $post = NULL, $manning_payroll_earning_id = NULL)
    {
        $this->load->model(['manning_payroll_m', 'manning']);

        $now = date('Y-m-d H:i:s');
        $param = ['payroll_id' => $payroll_id];
        ! $employee_id || $param['employee_id'] = $employee_id;

        $payroll = $this->manning_payroll_m->get($payroll_id, TRUE);

        $count = parent::count($param);

        if ($count) 
        {
            if ($manning_payroll_earning_id !== NULL) 
            {
                $sql = "UPDATE {$this->table_name} as A LEFT JOIN manning as B ON A.employee_id = B.manning_id
                            SET A.is_actived = 0, A.updated_at = NOW(), A.deleted_at = NOW()
                            WHERE is_resigned = 1 AND A.is_actived = 1 AND B.manning_id IS NOT NULL";
                $this->db->query($sql);
                $affected = $this->db->affected_rows();

                if ($affected) 
                $this->session->set_flashdata('message', "{$affected} employee(s) resigned and was removed to this payroll");
            }

            $set = '';
            if ($post !== NULL) 
            {
                if ($this->db->field_exists($post['field'], 'manning_payroll_earning')) 
                {
                    $set = "{$post['field']} =  {$post['value']}, ";
                }
            }


            $sql = "UPDATE `manning_payroll_earning` as C
                        LEFT JOIN manning as A ON C.employee_id = A.manning_id
                        LEFT JOIN manning_payroll as B ON C.payroll_id = B.payroll_id
                    SET 
                        $set
                        r_allowance = if(allowance_mode_of_payment=1, round((allowance * no_hrs)/8,2),
                            if(allowance_mode_of_payment=2, allowance,
                            if(allowance_mode_of_payment=3 AND payroll_period='2nd', allowance,
                                    0.00))), 
                        `r_cola` = if(e_cola > 0 AND no_hrs > 0, round((e_cola/8) * (no_hrs),2), 0.00),
                        `r_hourly_rate` = IF(rate= 1, round((daily_rate/8) * no_hrs,2), 0),
                        `r_daily_rate` = round(daily_rate * rw_day,2),
                        `r_semi_monthly_rate` = IF(rate=2, round(semi_monthly_rate,2), 0),
                        `r_monthly_rate` = IF(rate=3, round(monthly_rate,2), 0),
                        `r_regular_ot_day` = round(((daily_rate/8) * 1.25) * rw_ot_day,2),
                        `r_straight_duty` = round((daily_rate/8) * sd_day,2),
                        -- `r_straight_ot_day` =round( straight_ot_day,2),
                        `r_night_diff` = round(((daily_rate/8) * 0.10) * nd_day,2),
                        `r_night_ot_diff` = round((((daily_rate/8) * 1.25) * 0.10) * nd_ot_day,2),
                        `r_legal_holiday` = round(((daily_rate+if(e_cola > 0, 10, 0))/8) * lg_day,2),
                        `r_legal_ot_holiday` = round((((daily_rate/8) * 2.60)) * lg_ot_day,2),
                        `r_rest_day_rate` = round(((daily_rate/8) * 1.30) * rd_day,2),
                        `r_rest_day_ot_rate` = round(((((daily_rate/8) * 1.30) * 0.30) + (((daily_rate/8) * 1.30))) * rd_ot_day,2),
                        `r_rest_day_special_holiday` = round(((daily_rate/8) * 1.50) * rd_sh_day/*((daily_rate/8) * 0.50) * rd_sh_day*/,2),
                        `r_rest_day_special_ot_holiday` = round(((daily_rate/8) * 1.95) * rd_sh_ot_day,2),
                        `r_rest_day_legal_holiday` = round((((daily_rate/8) * 1.30) * 2) * rd_lg_hl,2),
                        `r_rest_day_legal_ot_holiday` = round(((daily_rate/8) * 3.38) * rd_lg_ot_hl,2),
                        `r_special_holiday` = round((((daily_rate+if(e_cola > 0, 10, 0))/8) * 0.30) * sp_day,2),
                        `r_special_ot_holiday` = round(((daily_rate/8) * 1.95) * sp_ot_day/*(((daily_rate/8) * 0.30) * 1.30) * sp_ot_day*/,2),
                        `r_late_amount` = round(((daily_rate/8)/60) * late_minutes * -1,2),
                        `r_absent_rate_per_day` = round(((daily_rate/8) * no_absences_per_day) * -1,2),
                        `r_absent_rate` = round(((daily_rate/8) * no_absences_per_hr) * -1,2),
                        `r_incentive` = 0,
                        `r_13thmonth` = round(((daily_rate/8) * no_hrs)/12,2),
                        `C`.`updated_at` = ? 
                    WHERE `C`.`payroll_id` =  ? AND C.is_actived = 1";
            
            if ($employee_id !== NULL)
            $sql .= " AND C.employee_id = {$employee_id}";
            
            if ($manning_payroll_earning_id !== NULL) 
            {
                $sql .= " AND manning_payroll_earning_id = ?";
                $this->db->query($sql, [$now, $payroll_id, $manning_payroll_earning_id]);
                // dump($this->db->last_query());
                // stop processing and return affected row
                return $this->db->affected_rows();
            }

            $this->db->query($sql, [$now, $payroll_id]);
        }
        else
        {
            $project_id = $payroll->project_id;
            // regular, project-based, probitionary & co-terminous
            $status_ids = [1,2,3,5];
            $post = [];
            $manning = $this->db
                            ->where([
                                     'project_id' => $project_id, 
                                     'is_resigned' => 0, 
                                     'is_actived' => 1
                                    ])
                            ->where_in('employment_status_id', $status_ids)
                            ->get('manning')
                            ->result();
            if (count($manning)) 
            {
                foreach ($manning as $employee) 
                {
                    $post[] = [
                                    'payroll_id' => $payroll->payroll_id,
                                    'employee_id' => $employee->manning_id,
                                    'r_daily_rate' => $employee->daily_rate,
                                    'r_semi_monthly_rate' => $employee->semi_monthly_rate,
                                    'r_monthly_rate' => $employee->monthly_rate,
                                    'r_allowance' => $employee->allowance,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                              ];
                }
                $affected = $this->db->insert_batch('manning_payroll_earning', $post);
            }
        }

        return self::get_manning_payroll_earning($payroll_id);
    }


    /**
     * Generate billing summary per period
     * 
     * @param   array   a key/value pair of fields
     * @return  object  data summary
     */
    public function get_project_summary_by($condition = NULL, $group_by = NULL)
    {
        if ($condition != NULL) 
        $this->db->where($condition);

        if ($group_by === NULL) 
        $group_by = 'manning_payroll_earning.payroll_id';

        $this->db->group_by($group_by);

        return self::get_project_summary();
    }


    /**
     * Generate project summary
     *
     * @param   int   
     * @param   int   
     * @param   bool  
     * @return  object
     */
    public function get_project_summary($manning_payroll_earning_id = NULL, $single = FALSE)
    {
        $this->db->select('manning_payroll_earning.payroll_id, 
            F.position, 
            fields, 
            A.remarks as billing_remarks, 
            SUM(IF(w_adjustment=0,1,0)) as cnt_emp, 
            SUM(IF(w_adjustment=1,1,0)) as cnt_adj,
            COUNT(*) as cnt_row, 
            /*date_start, date_end, */
            
            r_semi_monthly_rate as semi_monthly_rate, 
            r_monthly_rate as monthly_rate, 
            r_daily_rate as daily_rate, 
            r_hourly_rate as hourly_rate, 
            rate,
            
            r_allowance, 
            allowance, 
            allowance_mode_of_payment, 
            /*regular_ot_day, straight_duty, straight_ot_day, night_diff, night_ot_diff, legal_holiday, legal_ot_holiday, */
            /*rest_day_rate, rest_day_ot_rate, rest_day_special_holiday, rest_day_special_ot_holiday, rest_day_legal_holiday, rest_day_legal_ot_holiday, */
            /*special_holiday, special_ot_holiday, */
            /*late_amount, late_minutes, no_absences_per_day, no_absences_per_hr, absent_rate, absent_rate_per_day,*/
            
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
            
            SUM(r_cola) as cola, 
            SUM(r_hourly_rate ) as hourly, 
            SUM(r_daily_rate ) as daily, 
            SUM(r_semi_monthly_rate) as semi_monthly, 
            SUM(r_monthly_rate) as monthly, 
            SUM(r_regular_ot_day ) as ot, 
            SUM(r_straight_duty ) as s_duty, 
            SUM(r_straight_ot_day ) as s_ot_duty, 
            SUM(r_night_diff ) as n_duty, 
            SUM(r_night_ot_diff ) as n_ot_duty,
            SUM(r_legal_holiday ) as lg_duty, 
            SUM(r_legal_ot_holiday ) as lg_ot_duty, 
            SUM(r_rest_day_rate ) as rd_duty, 
            SUM(r_rest_day_ot_rate ) as rd_ot_duty,
            SUM(r_rest_day_special_holiday ) as rd_sh, 
            SUM(r_rest_day_special_ot_holiday ) as rd_ot_sh, 
            SUM(r_rest_day_legal_holiday ) as rd_lghl, 
            SUM(r_rest_day_legal_ot_holiday ) as rd_ot_lghl, 
            SUM(r_special_holiday ) as sp_hl_duty, 
            SUM(r_special_ot_holiday ) as sp_hl_ot_duty, 
            SUM(r_late_amount ) as late, 
            SUM(r_absent_rate_per_day ) as deduct_absent_per_day, 
            SUM(r_absent_rate ) as deduct_absent_per_hr,
            SUM(r_incentive ) as incentive,
            SUM(r_13thmonth ) as 13thmonth,
            ', 
            FALSE);

            // SUM(semi_monthly_rate) as semi_monthly, 
            // SUM(monthly_rate) as monthly, 
            // SUM(no_hrs * hourly_rate) as hourly, 
            // SUM(rw_day * daily_rate) as daily, 
            // SUM(rw_ot_day * regular_ot_day) as ot, 
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

        if ($manning_payroll_earning_id !== NULL) 
        $this->db->group_by('manning_payroll_earning.manning_payroll_earning_id');

        return parent::get($manning_payroll_earning_id, $single);
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
            'cola' => 'r_cola|cola|cola|cola|cola',
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
            'absent_rate_per_hr' => "no_absences_per_hr|No. of Hours Absent|Absences Per Hrs|deduct_absent_per_hr|no_absences_per_hr_cnt",
            'absent_rate' => "no_absences_per_hr|No. of Hours Absent|Absences Per Hrs|deduct_absent_per_hr|no_absences_per_hr_cnt",
            'incentive' => "no_hrs|Incentives|Incentive|incentive|1",
            '13thmonth' => "no_hrs|13th Month|13th Month|13thmonth|1",
        );

        return $array;
    }


    private function _summay_join_statement()
    {
        // $this->db->join('project_billing_info as A', 'A.payroll_id = manning_payroll_earning.payroll_id', 'left');
        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_earning.payroll_id', 'left');
        $this->db->join('projects as B', 'B.project_id = A.project_id', 'left');
        $this->db->join('manning as C', 'C.manning_id = manning_payroll_earning.employee_id', 'left');
        // $this->db->join('employees as E', 'E.employee_id = C.employee_id', 'left');
        // $this->db->join('project_position_rates as D', 'D.ppr_id = C.ppr_id', 'left');
        $this->db->join('positions as F', 'F.position_id = C.position_id', 'left');
    }

    public function distinct_rate($project_id)
    {
        // regular, project-based ,probitional & co-terminous
        $status = "1,2,3,5";

        $param = [$project_id];

        $sql = "SELECT DISTINCT rate FROM manning WHERE project_id = ? AND employment_status_id IN({$status}) AND is_actived";
        $result = $this->db->query($sql, $param);
        $this->db->close();

        $rates = [1 => 'hourly_rate', 2 => 'semi_monthly_rate', 3 => 'monthly_rate'];

        $rate = array();
        foreach ($result->result() as $row) 
        {
            if (array_key_exists($row->rate, $rates))
                $rate[] = $rates[$row->rate];
        }

        return $rate;
    }

}

/*Location: ./application/models/manning_payroll_earning_m.php*/