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


    protected $earning_employment_status_ids = [REGULAR, PROBITIONAL, CO_TERMINOUS, PROJECT_BASED, RELIEVER, EXTRA_RELIEVER];
    protected $payroll_employment_status_ids = [REGULAR, PROBITIONAL, CO_TERMINOUS, PROJECT_BASED];
    protected $reliever_employment_status_ids = [RELIEVER, EXTRA_RELIEVER];

    public $reliever_payroll = FALSE;

    protected $payroll_fields = [
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
                                    'r_daily_rate',
                                    'r_hourly_rate',
                                    'r_semi_monthly_rate',
                                    'r_monthly_rate',
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
    protected $thirteenth_month_field = [
                                            'lastname',
                                            'firstname',
                                            'middlename',
                                            'employee_no',
                                            'position_code',
                                            'position',
                                            'manning_payroll_earning.employee_id',
                                            'r_13thmonth',
                                        ];
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

    public function get_payroll($payroll_id, $manning_id = NULL, $single = FALSE)
    {
        $this->load->model(['manning_payroll_m', 'projects']);
        // $this->output->enable_profiler(TRUE);

        $sum_income = $sum_deduction = $sum_basic = "";
        $deduction_field = ['late_amount', 'absent_rate', 'absent_rate_per_day'];

        $payroll = $this->manning_payroll_m->get($payroll_id);
        $wage = explode(',', $payroll->fields);

        $project = $this->projects->get($payroll->project_id);

        $wage[] = 'hourly_rate';
        $wage[] = 'semi_monthly_rate';
        $wage[] = 'monthly_rate';

        $income_field = $this->projects->get_field();
        // trigger the 13th month benefits
        if ($project->with_13th_month != 1)
        unset($income_field['13thmonth']);

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

        $select = $this->payroll_fields;

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
            $select = array_merge($select_earning, $select, [
                                                                'mr_daily_rate',
                                                                'mr_e_cola',
                                                                'manning_reliever_id',
                                                            ]);
        }

        $sum_income .=  "+ `r_cola` + `r_allowance` + `r_adjustment`";
        $select_income = "sum(" . $sum_income . ") as earning";
        $sum_basic = "sum( r_hourly_rate + r_semi_monthly_rate + r_monthly_rate) as sum_basic";

        $tardiness = "`r_late_amount` + `r_absent_rate` + `r_absent_rate_per_day`";
        $select_tardiness = "sum({$tardiness}) as tardiness";

        $deduction_sql = "(
                            SELECT GROUP_CONCAT(concat(deduction_category,'#',amount) SEPARATOR '|') as deductions, employee_id
                                FROM deductions a
                                LEFT JOIN manning_payroll_deduction_detail b on deduction_id = DeductionId and b.is_actived = 1
                                LEFT JOIN deduction_categories c on c.deduction_category_id = a.deduction_category_id
                                WHERE a.is_actived AND PayrollId = {$payroll_id}
                                GROUP BY employee_id
                          )";

        $select[] = $select_income;
        $select[] = $select_tardiness;
        $select[] = $sum_basic;
        $select[] = 'H.deductions';
        $this->db->select($select);

        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_earning.payroll_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = manning_payroll_earning.employee_id', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');
        $this->db->join('manning_payroll_deduction as G', 'manningPayrollEarningId = manning_payroll_earning_id AND G.is_actived', 'left');
        $this->db->join($deduction_sql . ' as H', 'H.employee_id = E.manning_id', 'left');
        $this->db->join('manning_reliever as I',
                        'mr_manning_id = manning_payroll_earning.employee_id AND mr_payroll_id = manning_payroll_earning.payroll_id AND I.is_actived', 'left');

        $this->db->group_by($group_by);

        $employment_status = $this->payroll_employment_status_ids;

        if ($this->reliever_payroll == TRUE)
        $employment_status = $this->reliever_employment_status_ids;
        else
        $this->db->where("ISNULL(mr_employment_status_id) = 1", NULL, FALSE);

        $this->db->where_in('r_employment_status_id', $employment_status);


        // INCLUDE ONLY employee with earning
        $this->db->having('earning >', 0);

        if ($manning_id !== NULL)
        $this->db->where('E.manning_id', $manning_id);

        if (in_array('lastname', $select))
        $this->db->order_by('lastname, firstname, middlename');

        return parent::get_by(['manning_payroll_earning.payroll_id'=>$payroll_id], $single);
    }

    public function get_manning_payroll_earning($payroll_id = NULL, $manning_payroll_earning_id = NULL, $single = FALSE)
    {
        $this->db->select('manning_payroll_earning.*, lastname, firstname, middlename, position_code, position, rate, daily_rate, semi_monthly_rate, monthly_rate, employment_status_id, mr_daily_rate, mr_e_cola, manning_reliever_id, mr_employment_status_id, r_employment_status_id');
        $this->db->join('manning_payroll as A', 'A.payroll_id = manning_payroll_earning.payroll_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = manning_payroll_earning.employee_id', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');
        $this->db->join('manning_reliever as G', 'mr_manning_id = E.manning_id AND mr_payroll_id = A.payroll_id AND G.is_actived', 'left');

        return $manning_payroll_earning_id !== NULL ? parent::get($manning_payroll_earning_id, $single) : parent::get_by(['manning_payroll_earning.payroll_id' => $payroll_id]);
    }

    public function update_payroll_reliever($payroll_id)
    {
        $this->load->model(array('manning_payroll_m', 'manning_reliever', 'manning_payroll_deduction_m'));

        // set gov't dues for reliever and extra-reliever to zero
        $sql = "UPDATE manning_payroll_deduction a
                    INNER JOIN manning_reliever b
                    ON employee_id = mr_manning_id AND payroll_id = mr_payroll_id AND b.is_actived = 1
                    SET
                        employee_share_sss = 0.00,
                        employer_share_sss = 0.00,
                        employee_compensation_program_sss = 0.00,
                        total_monthly_premium_sss = 0.00,
                        employee_share_philhealth = 0.00,
                        employer_share_philhealth = 0.00,
                        total_monthly_premium_philhealth = 0.00,
                        employee_share_pagibig = 0.00,
                        employer_share_pagibig = 0.00,
                        total_monthly_premium_pagibig = 0.00,
                        a.updated_at = NOW()
                    WHERE payroll_id = ? AND a.is_actived = 1
                ";

        $this->db->query($sql, array($payroll_id));
        $affected = $this->db->affected_rows();

        // set gov't dues for reliever and extra-reliever to zero DATA FROM MANNING
        $sql = "UPDATE manning_payroll_deduction a
                    INNER JOIN manning b
                    ON employee_id = manning_id AND b.is_actived = 1
                    SET
                        employee_share_sss = 0.00,
                        employer_share_sss = 0.00,
                        employee_compensation_program_sss = 0.00,
                        total_monthly_premium_sss = 0.00,
                        employee_share_philhealth = 0.00,
                        employer_share_philhealth = 0.00,
                        total_monthly_premium_philhealth = 0.00,
                        employee_share_pagibig = 0.00,
                        employer_share_pagibig = 0.00,
                        total_monthly_premium_pagibig = 0.00,
                        a.updated_at = NOW()
                    WHERE payroll_id = ? AND a.is_actived = 1 AND employment_status_id IN (?, ?)
                ";

        $this->db->query($sql, array($payroll_id, RELIEVER, EXTRA_RELIEVER));
        $affected = $this->db->affected_rows();

        // update manning payroll set w_reliever to 0 / 1
        $data['w_reliever'] = (bool) count($affected);
        $this->manning_payroll_m->save($data, $payroll_id);
    }

    public function update_payroll_data($payroll_id)
    {
        #TODO:
        // add missing employee,
        // update payroll entries
        $this->load->model(array('manning_payroll_m', 'projects'));

        $payroll = $this->manning_payroll_m->get($payroll_id);

        if ($payroll->IsFinal == 1)
        {
            // $this->session->set_flashdata('message', '<strong>Access Denied.</strong> <p class="lead">This payroll is already finalized.</p>');
            // return redirect("manning_payroll");

            // remove all deduction to recompute previous payroll deduction and force user to finalize again this payroll
            self::remove_payroll_deductions($payroll_id);
        }

        $project_id = $payroll->project_id;
        $project = $this->projects->get($project_id);
        if (!empty($project))
        {
            $data['with_13th_month']            = $project->with_13th_month;
            $data['mode_of_payment_sss']        = $project->mode_of_payment_sss;
            $data['mode_of_payment_pagibig']    = $project->mode_of_payment_pagibig;
            $data['mode_of_payment_philhealth'] = $project->mode_of_payment_philhealth;
            $data['mode_of_payment_allowance']  = $project->mode_of_payment_allowance;
            // save post data
            $this->manning_payroll_m->save($data, $project_id);
        }

        // regular, project-based, probitionary & co-terminous, reliever status
        // --------------------------------------------------------------------
        // DO NOT forget to UPDATE save earning METHOD
        // --------------------------------------------------------------------
        $status_ids = $this->earning_employment_status_ids;
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
                                'r_allowance' => 0.00,
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
                                WHERE manning_id = employee_id AND
                                ((employment_status_id NOT IN({$implode_ids}) AND is_actived) OR is_actived = 0)
                               )";

        $excess_employee_qry = $this->db->query($sql, [$now, $payroll_id]);
        $excess_affected = $this->db->affected_rows();


        $join_proj_qry = "(SELECT with_13th_month, projects.project_id as proj_id
                            FROM projects WHERE projects.project_id = {$payroll->project_id}) as D";

        // update payroll entries for regular project employee
        $sql = "UPDATE `manning_payroll_earning` as C
                    LEFT JOIN manning as A ON C.employee_id = A.manning_id
                    LEFT JOIN manning_payroll as B ON C.payroll_id = B.payroll_id
                    /*LEFT JOIN $join_proj_qry ON proj_id = B.project_id*/
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
                    `r_night_diff` = round(((daily_rate/8) * 0.10) * nd_day,2),
                    `r_night_ot_diff` = round((((daily_rate/8) * 1.25) * 0.10) * nd_ot_day,2),
                    `r_legal_holiday` = round(((daily_rate+if(e_cola > 0, 10, 0))/8) * lg_day,2),
                    `r_legal_ot_holiday` = round((((daily_rate/8) * 2.60)) * lg_ot_day,2),
                    `r_rest_day_rate` = round(((daily_rate/8) * 1.30) * rd_day,2),
                    `r_rest_day_ot_rate` = round(((((daily_rate/8) * 1.30) * 0.30) + (((daily_rate/8) * 1.30))) * rd_ot_day,2),
                    `r_rest_day_special_holiday` = round(((daily_rate/8) * 1.50) * rd_sh_day,2),
                    `r_rest_day_special_ot_holiday` = round(((daily_rate/8) * 1.95) * rd_sh_ot_day,2),
                    `r_rest_day_legal_holiday` = round((((daily_rate/8) * 1.30) * 2) * rd_lg_hl,2),
                    `r_rest_day_legal_ot_holiday` = round(((daily_rate/8) * 3.38) * rd_lg_ot_hl,2),
                    `r_special_holiday` = round((((daily_rate+if(e_cola > 0, 10, 0))/8) * 0.30) * sp_day,2),
                    `r_special_ot_holiday` = round(((daily_rate/8) * 1.69) * sp_ot_day,2),
                    `r_late_amount` = round(((daily_rate/8)/60) * late_minutes * -1,2),
                    `r_absent_rate_per_day` = round(((daily_rate/8) * no_absences_per_day) * -1,2),
                    `r_absent_rate` = round(((daily_rate/8) * no_absences_per_hr) * -1,2),
                    `r_incentive` = 0,
                    `r_13thmonth` = IF(with_13th_month=1, IF(rate = 2, round(semi_monthly_rate/12,2),
                                        IF(rate = 3, round((monthly_rate * 0.50)/12,2),
                                                round(((daily_rate/8) * no_hrs)/12,2))), 0.00),
                    `r_employment_status_id` = A.employment_status_id,
                    `C`.`updated_at` = ?
                WHERE `C`.`payroll_id` =  ? AND C.is_actived = 1";
        $this->db->query($sql, [$now, $payroll_id]);
        // $update_affected = $this->db->affected_rows();

        // update payroll entries for reliever and extra-reliever
        $sql2 = "UPDATE `manning_payroll_earning` as C
                    LEFT JOIN manning as A ON C.employee_id = A.manning_id
                    LEFT JOIN manning_payroll as B ON C.payroll_id = B.payroll_id
                    /*LEFT JOIN $join_proj_qry ON proj_id = B.project_id*/
                    INNER JOIN manning_reliever F ON mr_manning_id = C.employee_id AND mr_payroll_id = {$payroll_id} AND F.is_actived
                SET
                    r_allowance = if(mr_allowance_mode_of_payment=1, round((mr_allowance * no_hrs)/8,2),
                                    if(mr_allowance_mode_of_payment=2, mr_allowance,
                                    if(mr_allowance_mode_of_payment=3 AND payroll_period='2nd', mr_allowance,
                                            0.00))),
                    `r_cola` = if(mr_e_cola > 0 AND no_hrs > 0, round((mr_e_cola/8) * (no_hrs),2), 0.00),
                    `r_hourly_rate` = IF(rate= 1, round((mr_daily_rate/8) * no_hrs,2), 0),
                    `r_daily_rate` = round(mr_daily_rate * rw_day,2),
                    `r_semi_monthly_rate` = IF(rate=2, round(semi_monthly_rate,2), 0),
                    `r_monthly_rate` = IF(rate=3, round(monthly_rate,2), 0),
                    `r_regular_ot_day` = round(((mr_daily_rate/8) * 1.25) * rw_ot_day,2),
                    `r_straight_duty` = round((mr_daily_rate/8) * sd_day,2),
                    `r_night_diff` = round(((mr_daily_rate/8) * 0.10) * nd_day,2),
                    `r_night_ot_diff` = round((((mr_daily_rate/8) * 1.25) * 0.10) * nd_ot_day,2),
                    `r_legal_holiday` = round(((mr_daily_rate+if(mr_e_cola > 0, 10, 0))/8) * lg_day,2),
                    `r_legal_ot_holiday` = round((((mr_daily_rate/8) * 2.60)) * lg_ot_day,2),
                    `r_rest_day_rate` = round(((mr_daily_rate/8) * 1.30) * rd_day,2),
                    `r_rest_day_ot_rate` = round(((((mr_daily_rate/8) * 1.30) * 0.30) + (((mr_daily_rate/8) * 1.30))) * rd_ot_day,2),
                    `r_rest_day_special_holiday` = round(((mr_daily_rate/8) * 1.50) * rd_sh_day,2),
                    `r_rest_day_special_ot_holiday` = round(((mr_daily_rate/8) * 1.95) * rd_sh_ot_day,2),
                    `r_rest_day_legal_holiday` = round((((mr_daily_rate/8) * 1.30) * 2) * rd_lg_hl,2),
                    `r_rest_day_legal_ot_holiday` = round(((mr_daily_rate/8) * 3.38) * rd_lg_ot_hl,2),
                    `r_special_holiday` = round((((mr_daily_rate+if(mr_e_cola > 0, 10, 0))/8) * 0.30) * sp_day,2),
                    `r_special_ot_holiday` = round(((mr_daily_rate/8) * 1.69) * sp_ot_day,2),
                    `r_late_amount` = round(((mr_daily_rate/8)/60) * late_minutes * -1,2),
                    `r_absent_rate_per_day` = round(((mr_daily_rate/8) * no_absences_per_day) * -1,2),
                    `r_absent_rate` = round(((mr_daily_rate/8) * no_absences_per_hr) * -1,2),
                    `r_incentive` = 0,
                    `r_13thmonth` = 0.00,
                    `C`.`updated_at` = ?
                WHERE `C`.`payroll_id` =  ? AND C.is_actived = 1";
        $this->db->query($sql2, [$now, $payroll_id]);
        // dd($this->db->last_query());
        self::update_payroll_reliever($payroll_id);

        $this->session->set_flashdata('message', '<strong>Success.</strong> <p class="lead">This payroll entries has been successfully updated.</p>');
        return redirect("manning_payroll/earning/{$payroll_id}");
    }

    public function remove_payroll_deductions($payroll_id)
    {
        $this->load->model([
                            'manning_payroll_deduction_detail_m',
                            'manning_payroll_deduction_m',
                            'manning_payroll_m'
                           ]);

        $this->manning_payroll_deduction_detail_m->delete_by(['PayrollId' => $payroll_id]);
        $this->manning_payroll_deduction_m->delete_by(['payroll_id' => $payroll_id]);
        $this->manning_payroll_m->save(['IsFinal' => 0], $payroll_id);
    }

    public function save_earning($payroll_id, $employee_id = NULL, $post = NULL, $manning_payroll_earning_id = NULL)
    {
        $this->load->model(['manning_payroll_m', 'manning', 'manning_reliever']);

        $e_cola = 0.00;
        $daily_rate = 0.00;

        $now = date('Y-m-d H:i:s');
        $param = ['payroll_id' => $payroll_id];
        ! $employee_id || $param['employee_id'] = $employee_id;

        $payroll = $this->manning_payroll_m->get($payroll_id, TRUE);

        $join_proj_qry = "(SELECT with_13th_month, projects.project_id as proj_id
                            FROM projects WHERE projects.project_id = {$payroll->project_id}) as D";

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

            $e_cola = 'e_cola';
            $daily_rate = 'daily_rate';
            $allowance = 'allowance';
            $allowance_mode_of_payment = 'allowance_mode_of_payment';

            if ( ! empty($employee_id))
            {
                $reliever = $this->manning_reliever->get_by(['mr_manning_id' => $employee_id, 'mr_payroll_id' => $payroll_id], TRUE);
                if ( ! empty($reliever))
                {
                    $e_cola = get_key($reliever, 'mr_e_cola', 0.00);
                    $daily_rate = get_key($reliever, 'mr_daily_rate', 0.00);
                    $allowance = get_key($reliever, 'mr_allowance', 0.00);
                    $allowance_mode_of_payment = get_key($reliever, 'mr_allowance_mode_of_payment', 0);
                }
                else
                {
                    $employee = $this->manning->get($employee_id);

                    $e_cola = get_key($employee, 'e_cola', 0.00);
                    $daily_rate = get_key($employee, 'daily_rate', 0.00);
                    $allowance = get_key($employee, 'allowance', 0.00);
                    $allowance_mode_of_payment = get_key($employee, 'allowance_mode_of_payment', 0);
                }
            }

            $sql = "UPDATE `manning_payroll_earning` as C
                        LEFT JOIN manning as A ON C.employee_id = A.manning_id
                        LEFT JOIN manning_payroll as B ON C.payroll_id = B.payroll_id
                        /*LEFT JOIN $join_proj_qry ON proj_id = B.project_id*/
                        LEFT JOIN manning_reliever as E ON A.manning_id = mr_manning_id AND B.payroll_id = mr_payroll_id AND E.is_actived
                    SET
                        $set
                        r_allowance = if({$allowance_mode_of_payment}=1, round(({$allowance} * no_hrs)/8,2),
                            if({$allowance_mode_of_payment}=2, {$allowance},
                            if({$allowance_mode_of_payment}=3 AND payroll_period='2nd', {$allowance},
                                    0.00))),
                        `r_cola` = if({$e_cola} > 0 AND no_hrs > 0, round(({$e_cola}/8) * (no_hrs),2), 0.00),
                        `r_hourly_rate` = IF(rate= 1, round(({$daily_rate}/8) * no_hrs,2), 0),
                        `r_daily_rate` = round({$daily_rate} * rw_day,2),
                        `r_semi_monthly_rate` = IF(rate=2, round(semi_monthly_rate,2), 0),
                        `r_monthly_rate` = IF(rate=3, round(monthly_rate,2), 0),
                        `r_regular_ot_day` = round((({$daily_rate}/8) * 1.25) * rw_ot_day,2),
                        `r_straight_duty` = round(({$daily_rate}/8) * sd_day,2),
                        `r_night_diff` = round((({$daily_rate}/8) * 0.10) * nd_day,2),
                        `r_night_ot_diff` = round(((({$daily_rate}/8) * 1.25) * 0.10) * nd_ot_day,2),
                        `r_legal_holiday` = round((({$daily_rate}+if({$e_cola} > 0, 10, 0))/8) * lg_day,2),
                        `r_legal_ot_holiday` = round(((({$daily_rate}/8) * 2.60)) * lg_ot_day,2),
                        `r_rest_day_rate` = round((({$daily_rate}/8) * 1.30) * rd_day,2),
                        `r_rest_day_ot_rate` = round((((({$daily_rate}/8) * 1.30) * 0.30) + ((({$daily_rate}/8) * 1.30))) * rd_ot_day,2),
                        `r_rest_day_special_holiday` = round((({$daily_rate}/8) * 1.50) * rd_sh_day,2),
                        `r_rest_day_special_ot_holiday` = round((({$daily_rate}/8) * 1.95) * rd_sh_ot_day,2),
                        `r_rest_day_legal_holiday` = round(((({$daily_rate}/8) * 1.30) * 2) * rd_lg_hl,2),
                        `r_rest_day_legal_ot_holiday` = round((({$daily_rate}/8) * 3.38) * rd_lg_ot_hl,2),
                        `r_special_holiday` = round(((({$daily_rate}+if({$e_cola} > 0, 10, 0))/8) * 0.30) * sp_day,2),
                        `r_special_ot_holiday` = round((({$daily_rate}/8) * 1.69) * sp_ot_day,2),
                        `r_late_amount` = round((({$daily_rate}/8)/60) * late_minutes * -1,2),
                        `r_absent_rate_per_day` = round((({$daily_rate}/8) * no_absences_per_day) * -1,2),
                        `r_absent_rate` = round((({$daily_rate}/8) * no_absences_per_hr) * -1,2),
                        `r_incentive` = 0,
                        `r_13thmonth` = IF(r_employment_status_id IN(?,?), 0.00, IF(with_13th_month = 1, IF(rate = 2, round(semi_monthly_rate/12,2),
                                            IF(rate = 3, round((monthly_rate * 0.50)/12,2),
                                                    round((({$daily_rate}/8) * no_hrs)/12,2))), 0.00)),
                        `C`.`updated_at` = ?
                    WHERE `C`.`payroll_id` =  ? AND C.is_actived = 1";

                    /*`r_13thmonth` = IF(with_13th_month = 1, IF(rate = 2, round(semi_monthly_rate/12,2),
                                        IF(rate = 3, round((monthly_rate * 0.50)/12,2),
                                                round((({$daily_rate}/8) * no_hrs)/12,2))),
                                                0.00),*/

            if ($employee_id !== NULL)
            $sql .= " AND C.employee_id = {$employee_id}";

            if ($manning_payroll_earning_id !== NULL)
            {
                $sql .= " AND manning_payroll_earning_id = ?";
                $this->db->query($sql, [RELIEVER, EXTRA_RELIEVER, $now, $payroll_id, $manning_payroll_earning_id]);
                // dd($this->db->last_query());
                // stop processing and return affected row
                return $this->db->affected_rows();
            }

            $this->db->query($sql, [RELIEVER, EXTRA_RELIEVER, $now, $payroll_id]);
        }
        else
        {
            $project_id = $payroll->project_id;
            // regular, project-based, probitionary & co-terminous, reliever status
            // --------------------------------------------------------------------
            // DO NOT forget to UPDATE update payroll data METHOD
            // --------------------------------------------------------------------
            $status_ids = $this->earning_employment_status_ids;
            $post = [];
            $manning = $this->db
                            ->where([
                                     'project_id' => $project_id,
                                     'is_resigned' => 0,
                                     'is_actived' => 1
                                    ])
                            ->where_in('employment_status_id', $status_ids)
                            ->join($join_proj_qry, 'proj_id = project_id', 'left')
                            ->get('manning')
                            ->result();

            if (count($manning))
            {
                foreach ($manning as $employee)
                {
                    $arr = [
                                'payroll_id' => $payroll->payroll_id,
                                'employee_id' => $employee->manning_id,
                                'r_daily_rate' => 0.00,
                                'r_semi_monthly_rate' => 0.00,
                                'r_monthly_rate' => 0.00,
                                'r_employment_status_id' => $employee->employment_status_id,
                                'r_allowance' => 0.00,
                                'r_13thmonth' => 0.00,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];

                    if ($employee->rate == 2)
                    {
                        $arr['r_semi_monthly_rate'] = $employee->semi_monthly_rate;
                        if ($employee->with_13th_month == 1 && ! in_array($employee->employment_status_id, [RELIEVER, EXTRA_RELIEVER]))
                        $arr['r_13thmonth'] = round($employee->semi_monthly_rate/12, 2);
                    }

                    if ($employee->rate == 3)
                    {
                        $arr['r_monthly_rate'] = $employee->monthly_rate;
                        if ($employee->with_13th_month == 1 && ! in_array($employee->employment_status_id, [RELIEVER, EXTRA_RELIEVER]))
                        $arr['r_13thmonth'] = round(($employee->monthly_rate * 0.50)/12, 2);
                    }

                    $post[] = $arr;
                }
                // dd($post);
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
        // regular, project-based , probitional, co-terminous, reliever
        $status = implode(',', $this->earning_employment_status_ids);

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


    public function get_thirteenth_month()
    {
        // $this->output->enable_profiler(TRUE);
        // select fields
        $field = $this->thirteenth_month_field;

        /*if ($this->input->post('coverage', TRUE) == '1')
        {
            if (isset($_POST['employee_id']))
            {
                $field = array_merge($field, ['payroll_date, A.payroll_id, G.title, payroll_period, r_hourly_rate, r_daily_rate, r_semi_monthly_rate, r_monthly_rate']);
                $this->db->order_by('payroll_date');
                $this->db->order_by('payroll_period', 'asc');
            }
            else
            {
                // to summarized and
                // GROUP BY
                $field = array_diff($field, ['r_13thmonth', 'A.payroll_id', 'payroll_date']);
                $field = array_merge($field, ['SUM(r_13thmonth) r_13thmonth', 'count(*) cnt_r13thmonth']);

                $this->db->group_by('manning_id');
                $this->db->order_by('lastname, firstname, middlename');
            }
            // for project with 13th month only
            $this->db->where('r_13thmonth >', 0);
        }
        else
        {*/
            // 07/18/2018
            // TODO: re-compute employees 13th month benefits here
            if (isset($_POST['employee_id']))
            {
                $thirteenth_month_arr = [
                        'payroll_date',
                        'A.payroll_id',
                        'G.title',
                        'payroll_period',
                        'date_start',
                        'date_end',
                        'r_employment_status_id',
                        'r_hourly_rate as r_hourly_rate1',
                        'r_semi_monthly_rate as r_semi_monthly_rate1',
                        'r_monthly_rate as r_monthly_rate1',
                        'r_daily_rate as r_daily_rate1',
                        'round(r_semi_monthly_rate/12,2) as r_semi_monthly_rate',
                        'round((r_monthly_rate * 0.50)/12,2) as r_monthly_rate',
                        'round(((r_daily_rate/8) * no_hrs)/12,2) as r_daily_rate',
                        'round(r_hourly_rate/12,2) as r_hourly_rate',
                    ];

                $field = array_merge($field, $thirteenth_month_arr);
                $this->db->order_by('payroll_date');
                $this->db->order_by('payroll_period', 'asc');
            }
            else
            {
                // to summarized and
                // GROUP BY
                $field = array_diff($field, ['r_13thmonth', 'A.payroll_id', 'payroll_date']);
                $thirteenth_month_arr = [
                        // 'payroll_date',
                        // 'A.payroll_id',
                        // 'G.title',
                        // 'payroll_period',
                        'SUM(r_hourly_rate) as r_hourly_rate1',
                        'SUM(r_semi_monthly_rate) as r_semi_monthly_rate1',
                        'SUM(r_monthly_rate) as r_monthly_rate1',
                        'SUM(r_daily_rate) as r_daily_rate1',
                        'SUM(round(r_semi_monthly_rate/12,2)) as r_semi_monthly_rate',
                        'SUM(round((r_monthly_rate * 0.50)/12,2)) as r_monthly_rate',
                        'SUM(round(((r_daily_rate/8) * no_hrs)/12,2)) as r_daily_rate',
                        'SUM(round(r_hourly_rate/12,2)) as r_hourly_rate',
                    ];
                $field = array_merge($field, $thirteenth_month_arr);

                $this->db->group_by('manning_id');
                $this->db->order_by('lastname, firstname, middlename');
            }
        // }



        // payroll period
        if ($this->input->post('pay_period'))
        $this->db->where_in('payroll_period', $this->input->post('pay_period'));

        //  month
        if ($this->input->post('payroll_month'))
        $this->db->where('payroll_month', $this->input->post('payroll_month'));

        // year
        if ($this->input->post('payroll_year'))
        $this->db->where('payroll_year', $this->input->post('payroll_year'));

        if ($this->input->post('date_start') && $this->input->post('date_end'))
        {
            $date_start = $this->input->post('date_start');
            $date_end = $this->input->post('date_end');

            $this->db->where("payroll_date BETWEEN '{$date_start}' AND '{$date_end}'");
        }

        if ($this->input->post('scope') == 1)
        {
            // scope employee
            $manning_id = $this->input->post('manning_id');
            if (in_array(-1, $manning_id))
            {
                // $this->db->where('manning_id', NULL);
            }
            else
            {
                $this->db->where('manning_id IN (' . implode(',', $manning_id) . ')');
            }
        }
        /*else
        {
            // scope project
            $project_id = $this->input->post('project_id');
            if (in_array(-1, $project_id))
            $this->db->where('A.project_id', NULL);
            else
            {
                $this->db->where('A.project_id IN (' . implode(',', $project_id) . ')');
            }
        }*/



        $this->db->where_not_in('r_employment_status_id', [RELIEVER, EXTRA_RELIEVER]);
        $this->db->where('IsPayrollPrinted != ', 0);
        $this->db->where('DateFinalized >', 0);

        $this->db->select($field, FALSE);

        $this->db->join('manning_payroll as A', 'A.payroll_id = '.$this->table_name.'.payroll_id', 'left');
        $this->db->join('manning as E', 'E.manning_id = '.$this->table_name.'.employee_id', 'left');
        $this->db->join('positions as F', 'F.position_id = E.position_id', 'left');
        $this->db->join('projects as G', 'G.project_id = A.project_id', 'left');



        return parent::get();
    }

    /*public function filter_by_project($value='')
    {
        // limit to project
        if (expr)
        {
            // all project
        }
        else
        {
            // selected projects
        }

        return $result;
    }

    public function filter_by_employee($value='')
    {
        // limit to employee
        if (expr)
        {
            // all employee
        }
        else
        {
            // selected employees
        }

        return $result;
    }*/





}

/*Location: ./application/models/manning_payroll_earning_m.php*/
