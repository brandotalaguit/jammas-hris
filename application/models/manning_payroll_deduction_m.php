<?php

/**
 * Filename: manning_payroll_deduction_m.php
 * Author: Brando Talaguit (ITC Developer)
 */

class Manning_payroll_deduction_m extends MY_Model
{
    protected $table_name = "manning_payroll_deduction";
    protected $primary_key = "manning_payroll_deduction_id";
    protected $order_by = "manning_payroll_deduction_id DESC, manning_payroll_deduction.payroll_id ASC";

    private $deductions = array();

    private $_select = "title, tin, rate_hourly, rate_daily, rate_monthly, rate_semi_monthly,
                            lastname, firstname, middlename, position_code, position, 
                            pagibig_no, philhealth_no, tin_no, sss_no, employee_no, date_printed, date_start, date_end, 
                            manning_payroll_deduction.*";

    private $search_contribution_rules = array(
        'payroll_month' => ['field' => 'payroll_month', 'label' => 'Payroll Month', 'rules' => 'trim|xss_clean'],
        'payroll_year' => ['field' => 'payroll_year', 'label' => 'Payroll Year', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'deduction_and_govtdue' => ['field' => 'deduction_and_govtdue', 'label' => 'Type of Report', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'scope' => ['field' => 'scope', 'label' => 'Scope of Report', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'report_format' => ['field' => 'report_format', 'label' => 'Report Format', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'contribution' => ['field' => 'contribution', 'label' => 'Contribution', 'rules' => 'trim|xss_clean'],
        'deduction' => ['field' => 'deduction', 'label' => 'Deduction', 'rules' => 'trim|xss_clean'],
        'manning_id' => ['field' => 'manning_id[]', 'label' => 'Employee Id', 'rules' => 'trim|xss_clean'],
        'project_id' => ['field' => 'project_id[]', 'label' => 'Project Id', 'rules' => 'trim|xss_clean'],

    );
    
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

    public static function deduction_field()
    {
        return array(
            'employee_share_sss' => ['label' => 'SSS', 'abbr' => 'SSS', 'payroll' => 'employee_share_sss', 'multiplier' => ''], 
            'employee_share_philhealth' => ['label' => 'PhilHealth', 'abbr' => 'PhilHealth', 'payroll' => 'employee_share_philhealth', 'multiplier' => ''], 
            'employee_share_pagibig' => ['label' => 'PAG-IBIG', 'abbr' => 'PAG-IBIG', 'payroll' => 'employee_share_pagibig', 'multiplier' => ''], 

            'late_amount' => ['label' => 'Tardiness', 'abbr' => 'Tardiness', 'payroll' => 'r_late_amount', 'multiplier' => 'late_minutes'], 
            'absent_rate' => ['label' => 'Absent per Hours', 'abbr' => 'Absent/Hrs', 'payroll' => 'r_absent_rate', 'multiplier' => 'no_absences_per_hr'], 
            'absent_rate_per_day' => ['label' => 'Absent', 'abbr' => 'Absent', 'payroll' => 'r_absent_rate_per_day', 'multiplier' => 'no_absences_per_day'], 
        );
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

    public function get_employee_deduction($deduction, $manning_id = NULL, $date_start, $date_end)
    {
        if (is_array($manning_id)) {
            $this->db->where('manning_id IN (' . implode(', ', $manning_id) . ')');
        }
    }

    public function get_project_monthly_deduction($deduction, $project_id = NULL, $month, $year)
    {
        
    }

    public function get_project_yearly_deduction($deduction, $proect_id = NULL, $year)
    {
        
    }

    public function get_deduction_join_stmt($category)
    {
        if ( ! in_array($category, $this->deductions)) {
            $this->session->set_flashdata('error', 'Deduction category is invalid.');
            return FALSE;
        }

        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_deduction.payroll_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = manning_payroll_deduction.employee_id', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');
        $this->db->join('projects as G', 'G.project_id = A.project_id', 'left');

        return $this;
    }

    public function validate_search_form()
    {
        $data = array('success' => FALSE, 'message' => '', 'form' => array());
        $rules = $this->search_contribution_rules;

        $type_of_report = $this->input->post('type_of_report');
        $scope = $this->input->post('scope');

        if ($type_of_report == 1) 
        $rules['contribution']['rules'] .= '|required';
        
        if ($type_of_report == 2) 
        $rules['deduction']['rules'] .= '|is_natural_no_zero|required';

        if ($scope == 1) 
        $rules['manning_id']['rules'] .= '|required';

        if ($scope == 2) 
        $rules['project_id']['rules'] .= '|required';

        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        ! $this->form_validation->run() || $data['success'] = TRUE;
        validation_errors() || $data['messages'] = validation_errors();

        foreach ($this->search_contribution_rules as $key => $value) {
            $data['form'][$key] = form_error($key);
        }

        return $data;
    }

    public function get_by_employee_contribution($field_arr, $payroll_year, $manning_id = NULL, $payroll_month = NULL)
    {
        ! $manning_id || $this->db->where('manning_id IN (' . implode(',', $manning_id) . ')');
        ! $payroll_month || $this->db->where('payroll_month', $payroll_month);

        $this->db->where('payroll_year', $payroll_year);
        return $this->fields($field_arr)->group_by('manning_id')
                    ->get_manning_payroll_deduction();
    }

    public function get_by_project_contribution($field_arr, $payroll_year, $project_id, $payroll_month = NULL)
    {
         // Fecth all row
         // $this->db->having('employee_share_philhealth >', 0);
         // project ids
         //      23 --> Bent International
         //      146 -> The Henry Hotel
         //      153 -> University of Perpertual Help (NCB/BLDG 2-3)

         $project = array();
         $proj = $this->db->where_in('project_id', $project_id)->get('projects')->result();
         // die(dump($this->db->last_query()));
         foreach ($proj as $row) 
         {
             ! $payroll_month || $this->db->where('payroll_month', $payroll_month);
             $this->db->where('payroll_year', $payroll_year);
             $this->db->where('G.project_id', $row->project_id);
             $result = $this->fields($field_arr)
                            ->group_by('G.project_id, manning_id')
                            ->get_manning_payroll_deduction();

             $project[] = array(
                                 'project_id'    => $row->project_id,
                                 'project_title' => $row->title,
                                 'project_data'  => $result,
                               );
         }

         return $project;
    }

    public function get_deduction()
    {
        $this->form_validation->set_rules('search2', 'Search', 'strtoupper');
                
        $q = $this->input->post('search2');
        $by = $this->input->post('by2');
            

        if ($q > '') 
        {
            if (in_array($by, ['lastname', 'firstname', 'position', 'title'])) 
            {
                $this->db->like($by, $q, 'after');
            }
            elseif ($by == "address") 
            {
                $this->db->like('address1', $q, 'after');
                $this->db->or_like('address2', $q, 'after');
            }
        }

        if ($this->input->post('btn_order_by') == 'Search') 
        {
            $oby = $this->input->post('orderby');
            $ascdesc = $this->input->post('orderbyascdesc');
            $this->db->order_by($oby, $ascdesc);
        }   

        $ds = $this->input->post('date_start');
        $de = $this->input->post('date_end');

        if (!(empty($ds) || empty($de))) 
        {
            $this->form_validation->set_rules('date_start', 'Date Start', 'strtoupper|required');
            $this->form_validation->set_rules('date_end', 'Date End', 'strtoupper|required');
        }

        if (!(empty($ds) && empty($de))) 
        {
            $this->db->where('payroll_date >=', $ds);
            $this->db->where('payroll_date <=', $de);
        }


            $this->form_validation->set_rules('payroll_month', 'Payroll Month', 'trim|strtoupper');
            $this->form_validation->set_rules('payroll_year', 'Payroll Year', 'intval|trim');

            $payroll_month = $this->input->post('payroll_month');
            $payroll_year = $this->input->post('payroll_year');

            if ($payroll_month > '')
            $this->db->like('payroll_month', $payroll_month, 'after');

            if (intval($payroll_year)>0)
            $this->db->where('payroll_year', $payroll_year);
        
        return $this->form_validation->run();
    }

    public function fields($fields = NULL)
    {
        if(isset($fields))
        {
            $this->_select = array();
            $fields = (!is_array($fields)) ? explode(',', $fields) : $fields;
            $this->_select = $fields;
        }

        return $this;
    }


    public function get_manning_payroll_deduction($payroll_id = NULL, $manning_payroll_earning_id = NULL, $single = FALSE)
    {
        $this->db->select($this->_select);
        /*$this->db->select('title, tin, rate_hourly, rate_daily, rate_monthly, rate_semi_monthly,
                            lastname, firstname, middlename, position_code, position, 
                            pagibig_no, philhealth_no, tin_no, sss_no, employee_no, date_printed, date_start, date_end, 
                            manning_payroll_deduction.*');*/

        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_deduction.payroll_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = manning_payroll_deduction.employee_id', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');
        $this->db->join('projects as G', 'G.project_id = A.project_id', 'left');

        $this->db->order_by('title, lastname, firstname, middlename, date_printed ASC');


        if ($payroll_id == NULL && $manning_payroll_earning_id == NULL) 
        return parent::get(NULL, $single);    

        return $manning_payroll_earning_id !== NULL ? parent::get($manning_payroll_earning_id, $single) : parent::get_by(['manning_payroll_earning.payroll_id' => $payroll_id]);
    }

    public function generate_deduction($payroll_id, $employee_id = NULL, $post = NULL)
    {
        $this->load->model(['projects', 'manning_payroll_deduction_detail_m']);
        
        $payroll = $this->manning_payroll_m->get($payroll_id);
        $wages = explode(',', $payroll->fields);
        
        $wage = FALSE;
        $now = date('Y-m-d H:i:s');
        $deduction_field = ['late_amount', 'absent_rate', 'absent_rate_per_day'];
        $payroll_period = substr($payroll->payroll_period, 0, 1);
        $payroll_date_end = $payroll->date_end;
        
        $project = $this->projects->get($payroll->project_id);

        $mode_allowance = $project->mode_of_payment_allowance;
        $mode_pagibig = $project->mode_of_payment_pagibig;
        $mode_philhealth = $project->mode_of_payment_philhealth;
        $mode_sss = $project->mode_of_payment_sss;

        $wages[] = 'hourly_rate';
        $wages[] = 'semi_monthly_rate';
        $wages[] = 'monthly_rate';

        foreach ($wages as $field) 
        {
            // DO NOT include DEDUCTION field to income
            if ( ! in_array($field, $deduction_field)) 
            {
                $optr = $wage ? "+" : "";
                $wage .=  $optr . "`r_{$field}`"; 
            }
        }
        
        $this->manning_payroll_deduction_detail_m->delete_by(['PayrollId'=>$payroll_id]);
        $sql = "INSERT INTO manning_payroll_deduction_detail(PayrollId, DeductionId, amount, created_at, updated_at)
                SELECT ?, deduction_id, fixed_amount, NOW(), NOW() FROM deductions 
                WHERE coverage_date_end >= ? AND mode_of_payment IN(2,{$payroll_period}) AND is_actived AND 
                    EXISTS(
                        SELECT 1 FROM manning_payroll_earning MPE 
                        WHERE payroll_id = ? AND deductions.employee_id = MPE.employee_id AND is_actived
                    )";
        $this->db->query($sql, [$payroll_id, $payroll_date_end, $payroll_id]);

        parent::delete_by(['payroll_id'=>$payroll_id]);
        $sql = "INSERT INTO manning_payroll_deduction(
                    manningPayrollEarningId, payroll_id, employee_id, gross_income, sum_basic, 
                    employee_share_sss, employer_share_sss, employee_compensation_program_sss, total_monthly_premium_sss,
                    employee_share_philhealth, employer_share_philhealth, total_monthly_premium_philhealth,
                    employee_share_pagibig, employer_share_pagibig, total_monthly_premium_pagibig, 
                    other_deduction, created_at, updated_at
                )
                SELECT  a.manning_payroll_earning_id, payroll_id, a.employee_id, gross_income, monthly_basic, 
                    IF({$mode_sss} = 3, b.employee_share, IF({$mode_sss} = 1, b.employee_share, 0)), 
                    IF({$mode_sss} = 3, b.employer_share, IF({$mode_sss} = 1, b.employer_share, 0)), 
                    IF({$mode_sss} = 3, b.employee_compensation_program, IF({$mode_sss} = 1, b.employee_compensation_program, 0)), 
                    IF({$mode_sss} = 3, b.total_monthly_premium, IF({$mode_sss} = 1, b.total_monthly_premium, 0)),

                    IF({$mode_philhealth} = {$payroll_period}, d.employee_share, abs(sum_employee_philhealth - d.employee_share)), 
                    IF({$mode_philhealth} = {$payroll_period}, d.employer_share, abs(sum_employer_philhealth - d.employer_share)), 
                    IF({$mode_philhealth} = {$payroll_period}, d.total_monthly_premium, abs(sum_monthly_philhealth - d.total_monthly_premium)),

                    IF({$mode_pagibig} = {$payroll_period}, c.employee_share, abs(sum_employee_pagibig - c.employee_share)), 
                    IF({$mode_pagibig} = {$payroll_period}, c.employer_share, abs(sum_employer_pagibig - c.employer_share)), 
                    IF({$mode_pagibig} = {$payroll_period}, c.total_monthly_premium, abs(sum_monthly_pagibig - c.total_monthly_premium)),

                    sum_other_deduction_amount, '{$now}', '{$now}'  
                FROM (   
                        SELECT manning_payroll_earning_id, payroll_id, employee_id, 
                            COALESCE(sum($wage), 0) as gross_income, 
                            COALESCE(sum(r_hourly_rate + r_semi_monthly_rate + r_monthly_rate), 0) pay_basic 
                        FROM manning_payroll_earning MPE          
                        WHERE MPE.payroll_id = ? and is_actived        
                        GROUP BY manning_payroll_earning_id  
                    ) as a
                LEFT JOIN (
                        SELECT employee_id, COALESCE(sum($wage), 0) monthly_gross_income, COALESCE(sum(r_hourly_rate + r_semi_monthly_rate + r_monthly_rate), 0) monthly_basic 
                        FROM manning_payroll_earning MPE
                        LEFT JOIN manning_payroll ON manning_payroll.payroll_id = MPE.payroll_id AND manning_payroll.is_actived
                        WHERE payroll_month = ? and payroll_year = ? and IsFinal = 1  and MPE.is_actived
                        GROUP BY manning_payroll.project_id, employee_id
                ) as employee_salary ON employee_salary.employee_id = a.employee_id 
                LEFT JOIN (
                    SELECT employee_id, 
                            COALESCE(SUM(employee_share_philhealth), 0) sum_employee_philhealth, 
                            COALESCE(SUM(employer_share_philhealth), 0) sum_employer_philhealth, 
                            COALESCE(SUM(total_monthly_premium_philhealth), 0) sum_monthly_philhealth,
                            COALESCE(SUM(employee_share_pagibig), 0) sum_employee_pagibig, 
                            COALESCE(SUM(employer_share_pagibig), 0) sum_employer_pagibig, 
                            COALESCE(SUM(total_monthly_premium_pagibig), 0) sum_monthly_pagibig
                    FROM manning_payroll_deduction MPD
                    LEFT JOIN manning_payroll ON manning_payroll.payroll_id = MPD.payroll_id and manning_payroll.is_actived 
                    WHERE payroll_month = ? and payroll_year = ? and IsFinal = 1 and MPD.is_actived 
                    GROUP BY manning_payroll.project_id, employee_id
                ) as employee_deduction ON employee_deduction.employee_id = a.employee_id
                LEFT JOIN sss_premium_contribution_matrix as b on pay_basic >= b.salary_range_start AND pay_basic <= b.salary_range_end     
                
                LEFT JOIN pagibig_premium_contribution_matrix as c 
                    on monthly_basic >= c.salary_range_start AND monthly_basic <= c.salary_range_end AND monthly_basic > 0  
                
                LEFT JOIN philhealth_premium_contribution_matrix as d 
                    on monthly_basic >= d.salary_range_start AND monthly_basic <= d.salary_range_end AND monthly_basic > 0 

                LEFT JOIN (
                    SELECT COUNT(*) cnt, COALESCE(SUM(fixed_amount), 0) sum_other_deduction_amount, employee_id FROM deductions 
                    WHERE coverage_date_end >= ? AND mode_of_payment IN(2,{$payroll_period}) AND is_actived AND is_closed != 1
                    GROUP BY employee_id
                ) as other ON a.employee_id = other.employee_id AND b.is_actived AND c.is_actived AND d.is_actived
                HAVING monthly_basic > 0
        ";
        $this->db->query($sql, [$payroll_id, $payroll->payroll_month, $payroll->payroll_year, $payroll->payroll_month, $payroll->payroll_year, $payroll_date_end]);
        // die(dump($this->db->last_query()));
        return $this->db->affected_rows();
    }

    public function save_earning($payroll_id, $employee_id = NULL, $post = NULL, $manning_payroll_earning_id = NULL)
    {
        $now = date('Y-m-d H:i:s');
        $param = ['payroll_id' => $payroll_id];
        ! $employee_id || $param['employee_id'] = $employee_id;

        $count = parent::count($param);
        if ($count) 
        {
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
                        r_allowance = if(allowance_mode_of_payment=1 AND payroll_period='1st', allowance,
                                            if(allowance_mode_of_payment=2 AND payroll_period='2nd', allowance,
                                                if(allowance_mode_of_payment=3, allowance, 0.00))), 
                        `r_cola` = if(find_in_set('cola', fields), round((10/8) * (rw_day*8),2), 0.00),
                        `r_hourly_rate` = round((daily_rate/8) * no_hrs,2),
                        `r_daily_rate` = round(daily_rate * rw_day,2),
                        `r_semi_monthly_rate` = round(monthly_rate * 0.50,2),
                        `r_monthly_rate` = round(monthly_rate,2),
                        `r_regular_ot_day` = round(((daily_rate/8) * 1.25) * rw_ot_day,2),
                        `r_straight_duty` = round((daily_rate/8) * sd_day,2),
                        -- `r_straight_ot_day` =round( straight_ot_day,2),
                        `r_night_diff` = round(((daily_rate/8) * 0.10) * nd_day,2),
                        `r_night_ot_diff` = round((((daily_rate/8) * 1.25) * 0.10) * nd_ot_day,2),
                        `r_legal_holiday` = round(((daily_rate+10)/8) * lg_day,2),
                        `r_legal_ot_holiday` = round((((daily_rate/8) * 1.25) * 2) * lg_ot_day,2),
                        `r_rest_day_rate` = round(((daily_rate/8) * 1.30) * rd_day,2),
                        `r_rest_day_ot_rate` = round((((daily_rate/8) * 1.30) * 0.30) * rd_ot_day,2),
                        `r_rest_day_special_holiday` = round(117.24 * rd_sh_day/*((daily_rate/8) * 0.50) * rd_sh_day*/,2),
                        `r_rest_day_special_ot_holiday` = round(((daily_rate/8) * 1.95) * rd_sh_ot_day,2),
                        `r_rest_day_legal_holiday` = round((((daily_rate/8) * 1.30) * 2) * rd_lg_hl,2),
                        `r_rest_day_legal_ot_holiday` = round(((daily_rate/8) * 3.38) * rd_lg_ot_hl,2),
                        `r_special_holiday` = round((((daily_rate+10)/8) * 0.30) * sp_day,2),
                        `r_special_ot_holiday` = round(98.44 *  sp_ot_day/*(((daily_rate/8) * 0.30) * 1.30) * sp_ot_day*/,2),
                        `r_late_amount` = round(((daily_rate/8)/60) * late_minutes * -1,2),
                        `r_absent_rate_per_day` = round(((daily_rate/8) * no_absences_per_day) * -1,2),
                        `r_absent_rate` = round(((daily_rate/8) * no_absences_per_hr) * -1,2),
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
            $this->load->model('manning_payroll_m', 'manning');
            $payroll = $this->manning_payroll_m->get($payroll_id, TRUE);
            $project_id = $payroll->project_id;

            $post = [];
            $manning = $this->db
                            ->where([
                                     'project_id' => $project_id, 
                                     'is_actived' => 1
                                    ])
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
            SUM(r_absent_rate ) as deduct_absent_per_hr
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
            // 'absent_rate_per_hr' => "no_absences_per_hr|No. of Hours Absent|Absences Per Hrs|deduct_absent_per_hr|no_absences_per_hr_cnt",
            'absent_rate' => "no_absences_per_hr|No. of Hours Absent|Absences Per Hrs|deduct_absent_per_hr|no_absences_per_hr_cnt",
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

}

/*Location: ./application/models/manning_payroll_earning_m.php*/