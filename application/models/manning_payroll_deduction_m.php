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
                            UPPER(lastname) lastname, UPPER(firstname) firstname, UPPER(middlename) middlename, position_code, position,
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

    public $philhealth_deduction = array(
                                            'philhealth_no',
                                            'SUM(employee_share_philhealth) employee_share_philhealth',
                                            'SUM(employer_share_philhealth) employer_share_philhealth',
                                            'SUM(total_monthly_premium_philhealth) total_monthly_premium_philhealth',
                                        );

    public $pagibig_deduction = array(
                                            'pagibig_no',
                                            'SUM(employee_share_pagibig) employee_share_pagibig',
                                            'SUM(employer_share_pagibig) employer_share_pagibig',
                                            'SUM(total_monthly_premium_pagibig) total_monthly_premium_pagibig',
                                     );

    public $sss_deduction = array(
                                            'sss_no',
                                            'SUM(employee_share_sss) employee_share_sss',
                                            'SUM(employer_share_sss) employer_share_sss',
                                            'SUM(total_monthly_premium_sss) total_monthly_premium_sss',
                                            'SUM(employee_compensation_program_sss) employee_compensation_program_sss'
                                 );

    function __construct()
    {
        parent::__construct();
    }

    public static function deduction_field($reliever = FALSE)
    {
        if ($reliever)
            return array(
                'late_amount' => ['label' => 'Tardiness', 'abbr' => 'Tardiness', 'payroll' => 'r_late_amount', 'multiplier' => 'late_minutes'],
                'absent_rate' => ['label' => 'Absent per Hours', 'abbr' => 'Absent/Hrs', 'payroll' => 'r_absent_rate', 'multiplier' => 'no_absences_per_hr'],
                'absent_rate_per_day' => ['label' => 'Absent', 'abbr' => 'Absent', 'payroll' => 'r_absent_rate_per_day', 'multiplier' => 'no_absences_per_day'],
            );

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
        $REGULAR = REGULAR;
        $PROBITIONAL = PROBITIONAL;
        $CO_TERMINOUS = CO_TERMINOUS;
        $PROJECT_BASED = PROJECT_BASED;

        ! $manning_id || $this->db->where('manning_id IN (' . implode(',', $manning_id) . ')');
        ! $payroll_month || $this->db->where('payroll_month', $payroll_month);

        if ($this->input->post('report_format') == 1)
        {
            ! $payroll_month || $this->db->group_by('payroll_month');
        }
        else
        {
            $this->db->group_by('payroll_date, payroll_period');
        }

        if (count($this->input->post('pay_period')))
        {
            $this->db->where_in('payroll_period', $this->input->post('pay_period'));
        }

        $summary = TRUE;
        if ($this->input->post('report_format') == 2)
        {
          in_array('payroll_date', $field_arr) || array_push($field_arr, 'payroll_date');
          $summary = FALSE;
        }
        self::join_by_payroll_month($payroll_month, $payroll_year, NULL, $summary, $manning_id);

        $this->db->where('payroll_year', $payroll_year);
        return $this->fields($field_arr)
                    ->group_by('manning_id')
                    ->get_manning_payroll_deduction();
    }

    public function get_by_project_contribution($field_arr,$payroll_year,$project_id,$payroll_month=NULL)
    {
        $REGULAR = REGULAR;
        $PROBITIONAL = PROBITIONAL;
        $CO_TERMINOUS = CO_TERMINOUS;
        $PROJECT_BASED = PROJECT_BASED;

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

             if ($this->input->post('report_format') == 1)
             {
                 ! $payroll_month || $this->db->group_by('payroll_month');
                 // $this->db->group_by('payroll_date, manning_id');
             }
             else
             {
                if (!in_array('payroll_date', $field_arr))
                {
                    $field_arr = array_merge($field_arr, ['payroll_date']);
                }
                $this->db->group_by('payroll_date, payroll_period');
             }

             if (count($this->input->post('pay_period')))
             {
                 $this->db->where_in('payroll_period', $this->input->post('pay_period'));
             }

             $summary = TRUE;
             if ($this->input->post('report_format') == 2)
             {
               $summary = FALSE;
             }
             self::join_by_payroll_month($payroll_month, $payroll_year, $row->project_id, $summary);

             $result = $this->fields($field_arr)
                            // ->group_by('G.project_id, manning_id')
                            ->group_by('manning_id')
                            ->get_manning_payroll_deduction();

             $project[] = array(
                                 'project_id'    => $row->project_id,
                                 'project_title' => $row->title,
                                 'project_data'  => $result,
                               );
         }

         return $project;
    }

    public function join_by_payroll_month($month, $year, $project_id = NULL, $summary = FALSE, $manning_id = array())
    {
        $REGULAR = REGULAR;
        $PROBITIONAL = PROBITIONAL;
        $CO_TERMINOUS = CO_TERMINOUS;
        $PROJECT_BASED = PROJECT_BASED;

        $column = "employee_id, \nCOALESCE(sum(r_hourly_rate+r_semi_monthly_rate+r_monthly_rate), 0) monthly_basic \n";
        $join_on  = 'manning_payroll_deduction.employee_id=H.employee_id';
        if ($summary == TRUE)
        {
            $group_by = 'employee_id';
        }
        else
        {
            $column  .= ",\n MPE.payroll_id";
            $group_by = 'employee_id, MPE.payroll_id';
            $join_on .= ' AND manning_payroll_deduction.payroll_id = H.payroll_id';
        }

        $where = "";
        if ($project_id != NULL)
        {
        $where = "\n and project_id = $project_id";
        }
        if ($project_id == NULL)
        {
            ! $manning_id || $where = "\n and employee_id IN (". implode(',', $manning_id) .")";
        }

        $sql_statement = "SELECT $column FROM manning_payroll_earning MPE
                           LEFT JOIN manning_payroll
                            ON manning_payroll.payroll_id = MPE.payroll_id
                           WHERE payroll_month = '$month'
                            and payroll_year = '$year'
                            $where
                            and IsFinal = 1
                            and r_employment_status_id IN($REGULAR, $PROBITIONAL, $CO_TERMINOUS, $PROJECT_BASED)
                            and manning_payroll.is_actived
                            and MPE.is_actived
                           GROUP BY $group_by ";

        $this->db->join('(' . $sql_statement . ') as H', $join_on, 'left');

        return $this;
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


    public function get_manning_payroll_deduction($payroll_id=NULL, $manning_payroll_earning_id = NULL, $single = FALSE)
    {
        $this->db->select($this->_select);

        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_deduction.payroll_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = manning_payroll_deduction.employee_id', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');
        $this->db->join('projects as G', 'G.project_id = A.project_id', 'left');
        // $this->db->join('projects as G', 'G.project_id = A.project_id', 'left');
        $this->db->order_by('lastname, firstname, middlename, payroll_period ASC');


        if ($payroll_id == NULL && $manning_payroll_earning_id == NULL)
        return parent::get(NULL, $single);

        return $manning_payroll_earning_id !== NULL ? parent::get($manning_payroll_earning_id, $single) : parent::get_by(['manning_payroll_earning.payroll_id' => $payroll_id]);
    }

    public function generate_deduction($payroll_id, $employee_id = NULL, $post = NULL)
    {
        $this->load->model(['projects', 'manning_payroll_deduction_detail_m']);

        $now           = date('Y-m-d H:i:s');
        $REGULAR       = REGULAR;
        $PROBITIONAL   = PROBITIONAL;
        $CO_TERMINOUS  = CO_TERMINOUS;
        $PROJECT_BASED = PROJECT_BASED;

        $employee_status = "('{$REGULAR}', '{$PROBITIONAL}', '{$CO_TERMINOUS}', '{$PROJECT_BASED}')";

        $payroll         = $this->manning_payroll_m->get($payroll_id);
        $payroll_month   = $payroll->payroll_month;
        $payroll_year    = $payroll->payroll_year;
        $payroll_period  = substr($payroll->payroll_period, 0, 1);

        $where_in_payroll_period = "";
        $where_not_equal_payroll_period = "";
        if ($payroll_period == 1)
        {
            $where_in_payroll_period = " AND payroll_period = 1";
            $where_not_equal_payroll_period = "AND payroll_period != 1";
        }

        if ($payroll_period == 2)
        {
            $where_in_payroll_period = " AND payroll_period = 2";
            $where_not_equal_payroll_period = "AND payroll_period != 2";
        }

        $wages           = explode(',', $payroll->fields);
        $wage            = FALSE;

        $deduction_field    = ['late_amount', 'absent_rate', 'absent_rate_per_day'];
        $payroll_date_start = $payroll->date_start;
        $payroll_date_end   = $payroll->date_end;

        $project    = $this->projects->get($payroll->project_id);
        $project_id = $project->project_id;

        $mode_allowance  = $project->mode_of_payment_allowance;
        $mode_pagibig    = $project->mode_of_payment_pagibig;
        $mode_philhealth = $project->mode_of_payment_philhealth;
        $mode_sss        = $project->mode_of_payment_sss;

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

        $mode_of_payment = $payroll_period;
        if ($payroll_period == 2)
        $mode_of_payment = 3;

        // Other Deductions ---------------------------------------------------------------------------------------
        $other_deduction = self::generate_other_deductions($payroll_id, $mode_of_payment, $payroll_date_end);
        // End Other Deductions -----------------------------------------------------------------------------------


        $sql = "INSERT INTO manning_payroll_deduction(
                    manningPayrollEarningId, payroll_id, employee_id, sum_basic,
                    employee_share_sss, employer_share_sss, employee_compensation_program_sss, total_monthly_premium_sss,
                    employee_share_philhealth, employer_share_philhealth, total_monthly_premium_philhealth,
                    employee_share_pagibig, employer_share_pagibig, total_monthly_premium_pagibig,
                    other_deduction, created_at, updated_at
                )
                SELECT  a.manning_payroll_earning_id, payroll_id, a.employee_id, monthly_basic,

                    abs(if(payroll_period=1,0,IFNULL(sum_employee_sss,0)) - b.employee_share),
                    abs(if(payroll_period=1,0,IFNULL(sum_employer_sss,0)) - b.employer_share),
                    abs(if(payroll_period=1,0,IFNULL(sum_employee_compensation_program_sss,0)) - b.employee_compensation_program),
                    abs(if(payroll_period=1,0,IFNULL(sum_monthly_sss,0)) - b.total_monthly_premium),

                    IF(payroll_period = 1,
                        ROUND(biweekly_basic * 0.01375, 2),
                        IF(monthly_basic <= 10000,
                            137.50 - IFNULL(sum_employee_philhealth, 0),
                            ROUND(monthly_basic * 0.01375, 2) - IFNULL(sum_employee_philhealth, 0)
                        )
                    ),

                    IF(payroll_period = 1,
                        ROUND(biweekly_basic * 0.01375, 2),
                        IF(monthly_basic <= 10000,
                            137.50 - IFNULL(sum_employee_philhealth, 0),
                            ROUND(monthly_basic * 0.01375, 2) - IFNULL(sum_employee_philhealth, 0)
                        )
                    ),

                    IF(payroll_period = 1,
                        ROUND(biweekly_basic * 0.01375, 2) * 2,
                        IF(monthly_basic <= 10000,
                            (137.50 - IFNULL(sum_employee_philhealth, 0)) * 2,
                            (ROUND(monthly_basic * 0.01375, 2) - IFNULL(sum_employee_philhealth, 0)) * 2
                        )
                    ),

                    IF(mode_of_payment_pagibig = payroll_period,
                        c.employee_share,
                        if(mode_of_payment_pagibig != 3,
                            0,
                            abs(IFNULL(sum_employee_pagibig,0) - c.employee_share)
                        )
                    ),
                    IF(mode_of_payment_pagibig = payroll_period,
                        c.employer_share,
                        if(mode_of_payment_pagibig != 3,
                            0,
                            abs(IFNULL(sum_employer_pagibig,0) - c.employer_share)
                        )
                    ),
                    IF(mode_of_payment_pagibig = payroll_period,
                        c.total_monthly_premium,
                        if(mode_of_payment_pagibig != 3,
                            0,
                            abs(IFNULL(sum_monthly_pagibig,0) - c.total_monthly_premium)
                        )
                    ),

                    sum_other_deduction_amount, '{$now}', '{$now}'
                FROM (
                        SELECT manning_payroll_earning_id, MPE.payroll_id, employee_id,
                            P.project_id,
                            LEFT(payroll_period,1) payroll_period,
                            IF(MP.mode_of_payment_allowance=0, P.mode_of_payment_allowance, MP.mode_of_payment_allowance) mode_of_payment_allowance,
                            IF(MP.mode_of_payment_pagibig=0, P.mode_of_payment_pagibig, MP.mode_of_payment_pagibig) mode_of_payment_pagibig,
                            IF(MP.mode_of_payment_philhealth=0, P.mode_of_payment_philhealth, MP.mode_of_payment_philhealth) mode_of_payment_philhealth,
                            IF(MP.mode_of_payment_sss=0, P.mode_of_payment_sss, MP.mode_of_payment_sss) mode_of_payment_sss,
                            IF(MP.with_13th_month=0, P.with_13th_month, MP.with_13th_month) with_13th_month,
                            ( r_hourly_rate +  r_semi_monthly_rate + r_monthly_rate ) biweekly_basic
                        FROM manning_payroll_earning MPE
                        LEFT JOIN manning_payroll MP
                            ON MP.payroll_id = MPE.payroll_id
                        LEFT JOIN projects P ON MP.project_id = P.project_id
                        WHERE payroll_month = '{$payroll_month}' and payroll_year = '{$payroll_year}' and IsFinal = 1
                            {$where_in_payroll_period}
                            and MPE.is_actived
                            and r_employment_status_id IN $employee_status
                            and MP.payroll_id = {$payroll_id}
                        GROUP BY manning_payroll_earning_id
                        HAVING biweekly_basic > 0
                    ) as a
                LEFT JOIN (
                    SELECT employee_id,
                        sum(IFNULL(r_hourly_rate,0)+IFNULL(r_semi_monthly_rate,0)+IFNULL(r_monthly_rate,0)) monthly_basic,
                        count(*) pay_cnt
                    FROM manning_payroll_earning MPE
                    WHERE MPE.is_actived
                        AND r_employment_status_id IN $employee_status
                        AND EXISTS (
                            SELECT 1 FROM manning_payroll WHERE payroll_id = MPE.payroll_id
                            and payroll_month = '{$payroll_month}' and payroll_year = '{$payroll_year}' and IsFinal = 1
                            and is_actived
                            AND project_id = {$project_id}
                        )
                    GROUP BY employee_id
                ) as employee_salary ON employee_salary.employee_id = a.employee_id
                LEFT JOIN (
                    SELECT employee_id,
                            COALESCE(SUM(employee_share_philhealth), 0) sum_employee_philhealth,
                            COALESCE(SUM(employer_share_philhealth), 0) sum_employer_philhealth,
                            COALESCE(SUM(total_monthly_premium_philhealth), 0) sum_monthly_philhealth,
                            COALESCE(SUM(employee_share_pagibig), 0) sum_employee_pagibig,
                            COALESCE(SUM(employer_share_pagibig), 0) sum_employer_pagibig,
                            COALESCE(SUM(total_monthly_premium_pagibig), 0) sum_monthly_pagibig,
                            COALESCE(SUM(employee_share_sss), 0) sum_employee_sss,
                            COALESCE(SUM(employer_share_sss), 0) sum_employer_sss,
                            COALESCE(SUM(employee_compensation_program_sss), 0) sum_employee_compensation_program_sss,
                            COALESCE(SUM(total_monthly_premium_sss), 0) sum_monthly_sss
                    FROM manning_payroll_deduction MPD
                    LEFT JOIN manning_payroll ON manning_payroll.payroll_id = MPD.payroll_id
                    WHERE payroll_month = '{$payroll_month}' and payroll_year = '{$payroll_year}' and IsFinal = 1
                            {$where_not_equal_payroll_period}
                            and project_id = {$project_id}
                            and MPD.is_actived
                            and manning_payroll.is_actived
                    GROUP BY employee_id
                ) as employee_deduction ON employee_deduction.employee_id = a.employee_id

                LEFT JOIN sss_premium_contribution_matrix as b
                    on IF(payroll_period=1, biweekly_basic, monthly_basic) >= b.salary_range_start
                    AND IF(payroll_period=1, biweekly_basic, monthly_basic) <= b.salary_range_end

                LEFT JOIN pagibig_premium_contribution_matrix as c
                    on monthly_basic >= c.salary_range_start AND monthly_basic <= c.salary_range_end AND monthly_basic >0

                LEFT JOIN (
                    SELECT COUNT(*) cnt, COALESCE(SUM(fixed_amount), 0) sum_other_deduction_amount, employee_id FROM deductions
                    WHERE coverage_date_end >= '{$payroll_date_start}' AND mode_of_payment IN(2,{$payroll_period}) AND is_actived AND is_closed != 1
                    GROUP BY employee_id
                ) as other ON a.employee_id = other.employee_id AND b.is_actived AND c.is_actived
                HAVING monthly_basic > 0
        ";

        // Process Government Deductions
        parent::delete_by(['payroll_id'=>$payroll_id]);
        // dump($this->db->last_query());
        // $this->db->query($sql, [$payroll_id, $payroll->payroll_month, $payroll->payroll_year, $payroll->payroll_month, $payroll->payroll_year, $payroll_date_start]);
        $this->db->query($sql);
        // dd($this->db->last_query());

        return $this->db->affected_rows();
    }

    public function generate_other_deductions($payroll_id, $mode_of_payment, $payroll_date_end)
    {
        $this->load->model('manning_payroll_deduction_detail_m');
        // Other Deductions ---------------------------------------------------------------------------------------
        $this->manning_payroll_deduction_detail_m->delete_by(['PayrollId'=>$payroll_id]);
        $sql = "INSERT INTO manning_payroll_deduction_detail(PayrollId, DeductionId, amount, created_at, updated_at)
                SELECT ?, deduction_id, fixed_amount, NOW(), NOW() FROM deductions
                WHERE ? BETWEEN coverage_date_start AND coverage_date_end
                    AND mode_of_payment IN(2,{$mode_of_payment}) AND is_actived AND
                    EXISTS(
                        SELECT 1 FROM manning_payroll_earning MPE
                        WHERE payroll_id = ? AND deductions.employee_id = MPE.employee_id AND is_actived
                        HAVING COALESCE(sum(r_hourly_rate + r_semi_monthly_rate + r_monthly_rate), 0) > 0
                    )";
        $this->db->query($sql, [$payroll_id, $payroll_date_end, $payroll_id]);
        return $this->db->affected_rows();
        // End Other Deductions -----------------------------------------------------------------------------------
    }

    public function remove_employee_payroll_deduction($employee_id=NULL, $payroll_period, $payroll_month, $payroll_year)
    {
        /*$this->load->model('manning_payroll_deduction_detail_m');
        $exist_in = "EXISTS(SELECT 1 FROM manning_payroll_deduction WHERE  )"
        $this->db->where($exist_in, NULL, FALSE);
        $this->manning_payroll_deduction_detail_m->delete_by(['PayrollId'=>$payroll_id]);
        $sql = "INSERT INTO manning_payroll_deduction_detail(PayrollId, DeductionId, amount, created_at, updated_at)
                SELECT ?, deduction_id, fixed_amount, NOW(), NOW() FROM deductions
                WHERE ? BETWEEN coverage_date_start AND coverage_date_end
                    AND mode_of_payment IN(2,{$mode_of_payment}) AND is_actived AND
                    EXISTS(
                        SELECT 1 FROM manning_payroll_earning MPE
                        WHERE payroll_id = ? AND deductions.employee_id = MPE.employee_id AND is_actived and IsFinal = 1
                        HAVING COALESCE(sum(r_hourly_rate + r_semi_monthly_rate + r_monthly_rate), 0) > 0
                    )";
        $this->db->query($sql, [$payroll_id, $payroll_date_end, $payroll_id]);
        return $this->db->affected_rows();*/
    }

    public function employee_deduction($employee_id = NULL, $payroll_period, $payroll_month, $payroll_year)
    {
        $now = date('Y-m-d H:i:s');
        $this->load->model('projects');

        $REGULAR = REGULAR;
        $PROBITIONAL = PROBITIONAL;
        $CO_TERMINOUS = CO_TERMINOUS;
        $PROJECT_BASED = PROJECT_BASED;

        $employee_status = "('{$REGULAR}', '{$PROBITIONAL}', '{$CO_TERMINOUS}', '{$PROJECT_BASED}')";

        $where_in_employee = "";
        // is_null($employee_id) || $where_in_employee = " AND employee_id IN( " . implode(',', $employee_id) . " )";
        is_null($employee_id) || $where_in_employee = " AND employee_id IN ( $employee_id )";
        $where_in_deduction_employee = "";
        is_null($employee_id) || $where_in_deduction_employee = str_replace('employee_id', 'deductions.employee_id', $where_in_employee);

        $where_in_payroll_period = "";
        $where_not_equal_payroll_period = "";
        if ($payroll_period == 1)
        {
            $where_in_payroll_period = " AND payroll_period = 1";
            $where_not_equal_payroll_period = "AND payroll_period != 1";
        }

        if ($payroll_period == 2)
        {
            $where_in_payroll_period = " AND payroll_period = 2";
            $where_not_equal_payroll_period = "AND payroll_period != 2";
        }

        $sql = "INSERT INTO manning_payroll_deduction(
                    manningPayrollEarningId, payroll_id, employee_id, sum_basic,
                    employee_share_sss, employer_share_sss, employee_compensation_program_sss, total_monthly_premium_sss,
                    employee_share_philhealth, employer_share_philhealth, total_monthly_premium_philhealth,
                    employee_share_pagibig, employer_share_pagibig, total_monthly_premium_pagibig,
                    other_deduction, created_at, updated_at
                )
                SELECT  a.manning_payroll_earning_id, a.payroll_id, a.employee_id, monthly_basic,
                    abs(if(payroll_period=1,0,IFNULL(sum_employee_sss,0)) - b.employee_share),
                    abs(if(payroll_period=1,0,IFNULL(sum_employer_sss,0)) - b.employer_share),
                    abs(if(payroll_period=1,0,IFNULL(sum_employee_compensation_program_sss,0)) - b.employee_compensation_program),
                    abs(if(payroll_period=1,0,IFNULL(sum_monthly_sss,0)) - b.total_monthly_premium),

                    IF(payroll_period = 1,
                        ROUND(biweekly_basic * 0.01375, 2),
                        IF(monthly_basic <= 10000,
                            137.50 - IFNULL(sum_employee_philhealth, 0),
                            ROUND(monthly_basic * 0.01375, 2) - IFNULL(sum_employee_philhealth, 0)
                        )
                    ),

                    IF(payroll_period = 1,
                        ROUND(biweekly_basic * 0.01375, 2),
                        IF(monthly_basic <= 10000,
                            137.50 - IFNULL(sum_employee_philhealth, 0),
                            ROUND(monthly_basic * 0.01375, 2) - IFNULL(sum_employee_philhealth, 0)
                        )
                    ),

                    IF(payroll_period = 1,
                        ROUND(biweekly_basic * 0.01375, 2) * 2,
                        IF(monthly_basic <= 10000,
                            (137.50 - IFNULL(sum_employee_philhealth, 0)) * 2,
                            (ROUND(monthly_basic * 0.01375, 2) - IFNULL(sum_employee_philhealth, 0)) * 2
                        )
                    ),

                    IF(mode_of_payment_pagibig = payroll_period,
                        c.employee_share,
                        if(mode_of_payment_pagibig != 3,
                            0,
                            abs(IFNULL(sum_employee_pagibig,0) - c.employee_share)
                        )
                    ),
                    IF(mode_of_payment_pagibig = payroll_period,
                        c.employer_share,
                        if(mode_of_payment_pagibig != 3,
                            0,
                            abs(IFNULL(sum_employer_pagibig,0) - c.employer_share)
                        )
                    ),
                    IF(mode_of_payment_pagibig = payroll_period,
                        c.total_monthly_premium,
                        if(mode_of_payment_pagibig != 3,
                            0,
                            abs(IFNULL(sum_monthly_pagibig,0) - c.total_monthly_premium)
                        )
                    ),
                    sum_other_deduction_amount, '{$now}', '{$now}'
                FROM (
                        SELECT manning_payroll_earning_id, MPE.payroll_id, employee_id,
                                P.project_id,
                                LEFT(payroll_period,1) payroll_period,
                                IF(MP.mode_of_payment_allowance=0, P.mode_of_payment_allowance, MP.mode_of_payment_allowance) mode_of_payment_allowance,
                                IF(MP.mode_of_payment_pagibig=0, P.mode_of_payment_pagibig, MP.mode_of_payment_pagibig) mode_of_payment_pagibig,
                                IF(MP.mode_of_payment_philhealth=0, P.mode_of_payment_philhealth, MP.mode_of_payment_philhealth) mode_of_payment_philhealth,
                                IF(MP.mode_of_payment_sss=0, P.mode_of_payment_sss, MP.mode_of_payment_sss) mode_of_payment_sss,
                                IF(MP.with_13th_month=0, P.with_13th_month, MP.with_13th_month) with_13th_month,
                                ( r_hourly_rate +  r_semi_monthly_rate + r_monthly_rate ) biweekly_basic
                        FROM manning_payroll_earning MPE
                        LEFT JOIN manning_payroll MP
                            ON MP.payroll_id = MPE.payroll_id
                        LEFT JOIN projects P ON MP.project_id = P.project_id
                        WHERE payroll_month = '{$payroll_month}' and payroll_year = '{$payroll_year}' and IsFinal = 1
                            {$where_in_payroll_period}
                            and MPE.is_actived
                            and r_employment_status_id IN $employee_status
                            {$where_in_employee}
                        GROUP BY manning_payroll_earning_id
                        HAVING biweekly_basic > 0
                    ) as a
                LEFT JOIN (
                    SELECT employee_id,
                        sum(IFNULL(r_hourly_rate,0)+IFNULL(r_semi_monthly_rate,0)+IFNULL(r_monthly_rate,0)) monthly_basic,
                        count(*) pay_cnt
                    FROM manning_payroll_earning MPE
                    WHERE is_actived {$where_in_employee}
                        AND r_employment_status_id IN $employee_status
                        AND EXISTS (
                            SELECT 1 FROM manning_payroll WHERE payroll_id = MPE.payroll_id
                            and payroll_month = '{$payroll_month}' and payroll_year = '{$payroll_year}' and IsFinal = 1
                            and is_actived
                        )
                    GROUP BY employee_id
                ) as employee_salary ON employee_salary.employee_id = a.employee_id
                LEFT JOIN (
                    SELECT employee_id,
                        COALESCE(SUM(employee_share_philhealth), 0) sum_employee_philhealth,
                        COALESCE(SUM(employer_share_philhealth), 0) sum_employer_philhealth,
                        COALESCE(SUM(total_monthly_premium_philhealth), 0) sum_monthly_philhealth,
                        COALESCE(SUM(employee_share_pagibig), 0) sum_employee_pagibig,
                        COALESCE(SUM(employer_share_pagibig), 0) sum_employer_pagibig,
                        COALESCE(SUM(total_monthly_premium_pagibig), 0) sum_monthly_pagibig,
                        COALESCE(SUM(employee_share_sss), 0) sum_employee_sss,
                        COALESCE(SUM(employer_share_sss), 0) sum_employer_sss,
                        COALESCE(SUM(employee_compensation_program_sss), 0) sum_employee_compensation_program_sss,
                        COALESCE(SUM(total_monthly_premium_sss), 0) sum_monthly_sss
                    FROM manning_payroll_deduction MPD
                    LEFT JOIN manning_payroll ON manning_payroll.payroll_id = MPD.payroll_id
                    WHERE payroll_month = '{$payroll_month}' and payroll_year = '{$payroll_year}' and IsFinal = 1
                            {$where_not_equal_payroll_period}
                            and MPD.is_actived
                            and manning_payroll.is_actived
                            {$where_in_employee}
                    GROUP BY employee_id
                ) as employee_deduction ON employee_deduction.employee_id = a.employee_id

                LEFT JOIN sss_premium_contribution_matrix as b
                    on IF(payroll_period=1, biweekly_basic, monthly_basic) >= b.salary_range_start
                    AND IF(payroll_period=1, biweekly_basic, monthly_basic) <= b.salary_range_end

                LEFT JOIN pagibig_premium_contribution_matrix as c
                    on monthly_basic >= c.salary_range_start AND monthly_basic <= c.salary_range_end AND monthly_basic >0

                LEFT JOIN (
                    SELECT COUNT(*) cnt,COALESCE(SUM(fixed_amount), 0) sum_other_deduction_amount,deductions.employee_id
                    FROM deductions
                    LEFT JOIN manning_payroll_deduction_detail MPDD ON deduction_id = DeductionId
                    LEFT JOIN manning_payroll MP ON payroll_id = PayrollId
                    LEFT JOIN manning_payroll_earning MPE ON MP.payroll_id = MPE.payroll_id AND MPE.employee_id = deductions.employee_id
                    WHERE deductions.is_actived
                            AND MP.is_actived
                            AND MPDD.is_actived
                            AND MPE.is_actived
                            AND is_closed != 1
                            AND payroll_year = '{$payroll_year}' AND payroll_month = '{$payroll_month}' AND IsFinal = 1
                            {$where_in_payroll_period}
                            AND mode_of_payment IN(2, left(payroll_period,1))
                            {$where_in_deduction_employee}
                        GROUP BY deductions.employee_id
                ) as other ON a.employee_id = other.employee_id AND b.is_actived AND c.is_actived
                HAVING monthly_basic > 0
                ";

        // Process Government Deductions
        // parent::delete_by(['payroll_id'=>$payroll_id]);
        $qry = $this->db->query($sql);
        // dump($this->db->last_query());
        // dd($qry->result());

        return $this->db->affected_rows();
    }

}

/*Location: ./application/models/manning_payroll_deduction_m.php*/
