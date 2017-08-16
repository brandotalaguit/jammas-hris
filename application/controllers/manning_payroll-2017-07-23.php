<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manning_payroll extends Admin_Controller
{
    protected $limit = 5;
    public $payroll_data = array();

    function __construct()
    {
        parent::__construct();
        $this->data['controller'] = 'manning_payroll';
        $this->data['page_title'] = 'PAYROLL REGISTER ';
        $this->data['page_subtitle'] = '';
        $this->data['icon'] = '<i class="fa fa-file"></i>';

        $this->load->model('projects');
        $this->load->model('manning_payroll_m');
        $this->load->model('manning_payroll_earning_m');
    }

    public function index()
    {
        // $this->output->enable_profiler(TRUE);
        $search = FALSE;
        $user_account = $this->session->userdata('AccountType');

        // Filter user account per user
        // $user_account == 'S' || $this->db->where('A.user_id', $this->session->userdata('Id'));

        // Retrieve paginated results, using the dynamically determined offset
        $this->db->limit($this->limit, $this->pagination->offset);

        $rules = $this->manning_payroll_m->search_rules;
        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run() == TRUE) 
        {
            $by = $this->input->post('by');
            $search = $this->input->post('search');
            if (!empty($by) && !empty($search)) 
            $this->db->like($by, $search, 'after');

            $project_id = $this->input->post('project_id');
            if ($project_id) 
            {
                if (empty($by) || empty($search)) 
                $this->db->ar_like = array();
                $this->db->where('manning_payroll.project_id', $project_id);
            }

            $search = TRUE;
        }

        ! $search || $this->db->ar_limit = FALSE;
        $this->data['collection'] = $collection = $this->manning_payroll_m->get_index();
        $db_result = $this->manning_payroll_m->_db;
        // dump($db_result);
        $this->data['total_result'] = $total_rows = $search ? $db_result->num_rows : $this->manning_payroll_m->count();
        
        // Set up view
        $search || $this->data['pagination'] = pagination($total_rows, $this->limit, 'manning_payroll/Page');
        $this->data['search_option'] = $this->manning_payroll_m->search_option;
        $this->data['filter_option'] = $this->manning_payroll_m->filter_option;
        $this->data['proj_rate_arr'] = $this->projects->get_project_rates_array();
        $this->data['projects'] = $this->projects->get_projects();
        // die(dump($this->data['projects']));
        $this->data['months'] = $this->manning_payroll_m->get_month();
        $this->data['page_title'] .= anchor('manning_payroll/edit'
                                            , '<i class="fa fa-plus"></i> New Payroll'
                                            , [
                                                'data-toggle'   => 'modal',
                                                'data-target'   => '#payroll-modal',
                                                'data-backdrop' => 'static',
                                                'data-keyboard' => 'false',
                                                'class'         => 'btn btn-primary',
                                            ]);
        
        
        // Load view
        return $this->input->is_ajax_request() ? 
                    $this->load->view('manning_payroll/result_ajax', $this->data) : 
                    $this->load_view('manning_payroll/index');
    }

    private function load_index($load_view)
    {
        // $this->output->enable_profiler(TRUE);
        $search = FALSE;
        
        // Filter user account per user
        $this->session->userdata('AccountType') == 'S' || $this->db->where('A.user_id', $this->session->userdata('Id'));


        // Retrieve paginated results, using the dynamically determined offset
        $this->db->limit($this->limit, $this->pagination->offset);

        $rules = $this->manning_payroll_m->search_rules;
        $this->form_validation->set_rules($rules);

        // search filter 
        if ($this->form_validation->run() == TRUE) 
        {
            $by = $this->input->post('by');
            $search = $this->input->post('search');
            $this->db->like($by, $search, 'after');

            $project_id = $this->input->post('project_id');
            if ($project_id) 
            {
                $this->db->ar_like = array();
                $this->db->where('project_id', $project_id);
            }

            $search = TRUE;
        }

        ! $search || $this->db->ar_limit = FALSE;
        $this->data['collection'] = $collection = $this->manning_payroll_m->get_index();

        $db_result = $this->manning_payroll_m->_db;
        // dump($db_result);

        $total_rows = $search ? $db_result->num_rows : $this->manning_payroll_m->count();
        
        // Set up view
        $search || $this->data['pagination'] = pagination($total_rows, $this->limit, 'manning_payroll/Page');

        $this->data['search_option']     = $this->manning_payroll_m->search_option;
        $this->data['filter_option']     = $this->manning_payroll_m->filter_option;
        $this->data['total_result']      = $total_rows;
        $this->data['proj_rate_arr']     = $this->projects->get_project_rates_array();
        $this->data['projects']          = $this->projects->get_projects();
        $this->data['months']            = $this->manning_payroll_m->get_month();

        // die(dump($this->data));
        // Load view
        return $load_view;
    }

    public function project($project_id = NULL)
    {
        $search = FALSE;

        // Retrieve paginated results, using the dynamically determined offset
        $this->db->limit($this->limit, $this->pagination->offset);

        $rules = $this->manning_payroll_m->search_rules;
        $this->form_validation->set_rules($rules);

        // search filter 
        if ($this->form_validation->run() == TRUE) 
        {
            $by = $this->input->post('by');
            $search = $this->input->post('search');
            $this->db->like($by, $search, 'after');
            $search = TRUE;
        }
        ! $search || $this->db->ar_limit = FALSE;
        $this->data['collection'] = $collection = $this->manning_payroll_m->get_index();

        $db_result = $this->manning_payroll_m->_db;
        // dump($db_result);
        $this->data['total_result'] = $total_rows = $search ? $db_result->num_rows : $this->manning_payroll_m->count();
        
        // Set up view
        $search || $this->data['pagination'] = pagination($total_rows, $this->limit, 'manning_payroll/Page');
        $this->data['search_option'] = $this->manning_payroll_m->search_option;
        $this->data['filter_option'] = $this->manning_payroll_m->filter_option;
        $this->data['proj_rate_arr'] = $this->projects->get_project_rates_array();
        $this->data['projects'] = $this->projects->get_projects();
        $this->data['months'] = $this->manning_payroll_m->get_month();
        // Load view
        return $this->input->is_ajax_request() ? 
                    $this->load->view('manning_payroll/result_ajax', $this->data) : 
                    $this->load_view('manning_payroll/index');
    }

    public function update_payroll_data($payroll_id)
    {
        $this->manning_payroll_earning_m->update_payroll_data($payroll_id);
    }

    public function modal($payroll_id = NULL)
    {
        $this->load->model('manning_payroll_m');

        dump(1231);
        $payroll = FALSE;

        if ($payroll_id != NULL) 
        {
            $payroll = $this->manning_payroll_m->get($payroll_id);
            dump(substr($payroll->payroll_period, 0, 1));
        }

        dump($payroll);
    }

    /**
     * get payroll setting
     *
     * @return array of payroll setting
     * @author 
     */
    public function get_config()
    {
        return $this->payroll_data;
    }

    public function validate($id = NULL)
    {
        $rules = $this->manning_payroll_m->rules;
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_message('is_natural_no_zero', 'Please select %s');

        // prep post data
        $post = $this->manning_payroll_m->array_from_post2();
        // Process the form
        if ($this->form_validation->run() == TRUE)
        {
            $post['payroll_date'] != '0000-00-00' || $post['payroll_date'] = date('Y-m-d');
            
            // save post data
            $data['id'] = $this->manning_payroll_m->save($post, $id);
            $earning = $this->manning_payroll_earning_m->save_earning($id);
            $post['user_id'] = $this->session->userdata('Id');
            $data['post'] = $post;
            $data['status'] = 'success';

            $data['message'] = $data['flash_message'] = 'All rates has been successfully re-computed and applied.';
            if ($id == NULL) 
            {
                $data['flash_message'] = '<h4>Success.</h4><p>New Payroll has been successfully created.</p>';
                $data['message'] = strip_tags($data['flash_message']);
            }

            $this->session->set_flashdata('success', $data['flash_message']);
            $data['url'] = base_url('manning_payroll/earning/' . $data['id']);
            return $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }

        $data['postRaw'] = print_r($_POST, TRUE);
        $data['post_error'] = self::return_form_validation_error($post);
        return $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    private function return_form_validation_error($input)
    {
        $output = array();
        foreach ($input as $key => $value)
        {
            $output[$key] = form_error($key);
        }
        return $output;
    }

    public function edit($id = NULL)
    {
        // $this->output->enable_profiler(TRUE);

        if ($id === NULL)
        {
            // setup payroll object
            $this->data['payroll'] = $this->manning_payroll_m->get_new();
        }
        else
        {
            $this->data['payroll'] = self::_check_payroll_id($id);
            $this->data['hidden']['project_id'] = $this->data['payroll']->project_id;
        }

        $rules = $this->manning_payroll_m->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE)
        {
            // prep post data
            $_POST['user_id'] = $this->session->userdata('Id');
            $data = $this->manning_payroll_m->array_from_post([
                    'project_id', 
                    'payroll_period', 
                    'payroll_date', 
                    'payroll_month', 
                    'payroll_year', 
                    'date_start', 
                    'date_end', 
                    'date_printed', 
                    'remarks', 
                    'user_id',
                ]);
            ! empty($data['payroll_date']) || $data['payroll_date'] = date('Y-m-d');
            $data['fields'] = implode(",", $_POST['fields']);

            // save post data
            $id = $this->manning_payroll_m->save($data, $id);
            $earning = $this->manning_payroll_earning_m->save_earning($id);

            return parent::redirect_to('<h4>Success</h4><p>New Payroll has been successfully created</p>.', FALSE);
        }

        // Set up view
        $this->data['projects'] = $this->projects->get_projects();
        $this->data['months'] = $this->manning_payroll_m->get_month();
        
        // $this->data['project_id'] = $project_id;
        // $this->data['page_title'] = $project->title;
        // $this->data['page_subtitle'] = $project->description;

        $this->data['columns'] = $this->projects->get_columns();

        // Load the view
        return $this->load->view('manning_payroll/edit', $this->data);
    }

    public function delete($id = NULL)
    {
        // $old = $this->manning_payroll_m->get($id, TRUE);

        // process delete
        $billing_id = $this->manning_payroll_m->delete($id);

        // save log
        $this->session->set_userdata('success', "Success. Payroll id {$id} has been successfully deleted");
        return redirect('manning_payroll');
    }

    public function finalize()
    {
        $this->form_validation->set_rules('payroll_id', 'Payroll Id', 'intval|is_natural_no_zero|required');
        $this->form_validation->set_message('is_natural_no_zero', 'Please select %s to finalize');    
        if ($this->form_validation->run() == TRUE) 
        {
            if ($this->input->post('btn_action') == 'Save as Final') 
            {
                $now = date('Y-m-d H:i:s');
                $id = $this->input->post('payroll_id');
                $post = [
                            'IsFinal' => 1,
                            'DateFinalized' => $now,
                            'user_id' => $this->session->userdata('Id'),
                        ];

                $this->manning_payroll_m->save($post, $id);

                $this->db->order_by('payroll_id'); 
                $data['payroll'] = $this->manning_payroll_m->get_manning_payroll($id);
                $html = $this->load->view('manning_payroll/finalize', $data, TRUE);
                $this->session->set_flashdata('dialog_box', $html);
            }
        }

        return redirect('manning_payroll');
    }

    private function _isProjectExists($project_id)
    {
        $project = $this->projects->get(intval($project_id), TRUE);
        count($project) || parent::redirect_to('Access denied, Project Id does not exists');

        return $project;
    }

    private function _check_payroll_id($payroll_id)
    {
        $payroll_id = intval($payroll_id);

        if ($payroll_id > 0) 
        {
            $this->db->order_by('payroll_id', 'desc');
            $this->db->select('manning_payroll.*, title, description, rate_hourly, rate_daily, rate_monthly, rate_semi_monthly');
            $billing = $this->manning_payroll_m->get_manning_payroll($payroll_id);

            count($billing) || parent::redirect_to('Record not found, Manning Payroll Id does not exists');

            return $billing;
        }

        return parent::redirect_to('Record not found, Manning Payroll Id does not exists');
    }

    public function _unique_period($str)
    {
        // Do NOT validate if manning_payroll already exists
        // UNLESS it's the name for the current manning_payroll
        $id = $this->uri->segment(3);
        $project_id = $this->input->post('project_id');
        $payroll_period = $this->input->post('payroll_period');
        $payroll_month = $this->input->post('payroll_month');
        $payroll_year = $this->input->post('payroll_year');

        $this->db->where([
                'project_id' => $project_id,
                'payroll_period' => $payroll_period,
                'payroll_month' => $payroll_month,
                'payroll_year' => $payroll_year,
            ]);

        !$id || $this->db->where('payroll_id !=', $id);
        $payroll = $this->manning_payroll_m->get();
        $qry = $this->db->last_query();

        if (count($payroll))
        {
            $this->form_validation->set_message('_unique_period', "This payroll period is already created. Duplicate entry is not allowed. $id ."/* . $qry*/);

            return FALSE;
        }

        return TRUE;
    }

    public function billing_statement()
    {
        $this->load_view('sample_billing_statement');
    }

    public function select2project()
    {
        $term = $this->input->post('search', TRUE);
        $pageLimit = intval($this->input->post('pageLimit', TRUE));
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(
                        json_encode(
                            $this->projects->dropdown($term, $pageLimit)
                        )
                    );
    }

    public function select2rates()
    {
        $term = $this->input->post('project_id', TRUE);
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(
                        json_encode(
                            $this->projects->get_config($term)
                        )
                    );
    }

    public function search($id)
    {
        if ($id === NULL) 
        return [];
        
        $this->db->where('project_id', $id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($this->projects->dropdown()));
    }


    public function earning($payroll_id)
    {
        // $this->output->enable_profiler(TRUE);

        $payroll = $this->manning_payroll_m->get($payroll_id, TRUE);
        count($payroll) || parent::redirect_to('Unable to display payroll register. Record does not exists.', 'manning_payroll');

        if (empty($payroll->fields)) 
        {
            $this->manning_payroll_m->delete($payroll_id);
            parent::redirect_to("Unable to display payroll register. Please make sure you have fill-up wages field.", 
                    'manning_payroll');
        }

        // ! $payroll->IsFinal || parent::redirect_to('Access Denied. Payroll you trying to access is already finalize.', 'manning_payroll');


        // Set up pagination 
        // $this->db->where('manning_payroll_earning_id', $payroll_id);
        // $config['total_rows'] = $this->project_billing_trans->count();
        // $config['per_page'] = 15;
        // $this->pagination->initialize($config);

        // Create pagination links
        // $this->data['pagination'] = $this->pagination->create_links();

        if ($this->input->post('btn_action') == 'Search') 
        {
            $this->form_validation->set_rules('search', 'Search', 'required|strtoupper');
            
            $q = $this->input->post('search');
            $by = $this->input->post('by');
            if ($by == "Lastname") 
            {
                $this->db->like('lastname', $q, 'after');
            }
            elseif ($by == "Firstname") 
            {
                $this->db->like('firstname', $q, 'after');
            }
            unset($this->data['pagination']);
        }
        else
        {
            // Retrieve paginated results, using the dynamically determined offset
            // $this->db->limit($config['per_page'], $this->pagination->offset);
        }


        // Fetch data
        $this->db->order_by('w_adjustment, lastname, firstname, middlename, position_code');
        $this->data['earning'] =  $this->manning_payroll_earning_m->get_manning_payroll_earning($payroll_id);

        $project = $this->projects->get($payroll->project_id, TRUE);
        $this->data['project'] = $project;
        
        // Set up the view
        $this->data['page_subtitle'] = $project->description;
        $this->data['counter'] = $this->uri->segment(6, 0);
        $this->data['search_form'] = $this->load->view('employee/search_form', $this->data, TRUE);
        
        $this->data['distinct_rate'] = $this->manning_payroll_earning_m->distinct_rate($payroll->project_id);

        $this->data['payroll'] = $payroll;
        $this->data['columns'] = explode(',', $payroll->fields);
        $this->data['billing_rates'] = $this->manning_payroll_earning_m->get_billing_rates_array();
        
        $this->data['page_title'] = $project->title . '<br><small class="label label-danger">Period Covered: <strong>'. date('M j, y', strtotime($payroll->date_start)) . ' - ' . date('M j, y', strtotime($payroll->date_end)) .'</strong></small>';
        
        // Load view 
        return $this->load_view('manning_payroll/listing');
    }

    public function edit_earning()
    {
        $this->output->enable_profiler(FALSE);
        $status = 'error';
        $value = $this->input->post('value');
        $name = $this->input->post('name');
        $id = $this->input->post('pk');

        // Set up the form validation
        $rules = $this->manning_payroll_earning_m->single_column_rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) 
        {
            // $proj_employee = $this->manning_payroll_earning_m->get_manning_payroll_earning(NULL, $id, TRUE);
            // dump($proj_employee);
            // rate multiplier
            $rate = array(
                'cola' => 'cola',
                'no_hrs' => 'hourly_rate',
                'rw_day' => 'daily_rate',
                'rw_ot_day' => 'regular_ot_day',

                'nd_day' => 'night_diff',
                'nd_ot_day' => 'night_ot_diff',
                'sd_day' => 'straight_duty',
                'sd_ot_day' => 'straight_ot_duty',

                'rd_day' => 'rest_day_rate',
                'rd_ot_day' => 'rest_day_ot_rate',
                'rd_sh_day' => 'rest_day_special_holiday',
                'rd_sh_ot_day' => 'rest_day_special_ot_holiday',
                'rd_lg_hl' => 'rest_day_legal_holiday',
                'rd_lg_ot_hl' => 'rest_day_legal_ot_holiday',

                'lg_day' => 'legal_holiday',
                'lg_ot_day' => 'legal_ot_holiday',
                'sp_day' => 'special_holiday',
                'sp_ot_day' => 'special_ot_holiday',

                'late_minutes' => 'late_amount',
                'no_absences_per_hr' => 'absent_rate',              // no of absent per hour
                'no_absences_per_day' => 'absent_rate_per_day',     // no of absent per day

                // 'incentive' => 'r_incentive',     // no of absent per day
                // '13thmonth' => 'r_13thmonth',     // no of absent per day
            );

            

            // retreive data
            $pbt = $this->manning_payroll_earning_m->get($id, TRUE);
            // save data
            $affected = $this->manning_payroll_earning_m->save_earning(
                $pbt->payroll_id, 
                $pbt->employee_id, 
                ['field' => $name, 'value' => $value],
                $id
            );
            
            // billing period
            $this->db->select('payroll_id, project_id, fields');
            $payroll = $this->manning_payroll_m->get($pbt->payroll_id, TRUE);
            // dump($this->db->last_query());
            // dump($payroll->fields);

            // billing details and computation array
            $billing_rates = $this->manning_payroll_earning_m->get_billing_rates_array();

            $current_field = explode('|', $billing_rates[$rate[$name]]);
            $current_amount = $current_field[3];
            $current_cnt = $current_field[4];
            $current_val = $current_field[0];
            $current_fieldname = $rate[$name];
            // project billing
            // $project = $this->projects->get($payroll->project_id, TRUE);

            
            // payroll summary 
            $this->db->where('manning_payroll_earning.payroll_id', $pbt->payroll_id);
            $this->db->group_by('manning_payroll_earning.payroll_id');
            $grand_total = $this->manning_payroll_earning_m->get_project_summary(NULL, TRUE);

            // payroll summary per row
            $sub_total = $this->manning_payroll_earning_m->get_project_summary($id, TRUE);

            $project = $this->projects->get($payroll->payroll_id, TRUE);

            $payroll->fields .= ',hourly_rate';

            $grandtotal = $subtotal = $column1total = $column2total = 0.00;

            // add to computation semi-monthly & monthly rate

            // manning.rate !IMPORTANT field
            // it is either hourly/monthly/semi-monthly

            $subtotal += $sub_total->semi_monthly_rate;
            $subtotal += $sub_total->monthly_rate;
            $subtotal += $sub_total->r_allowance;
            $subtotal += $sub_total->cola;

            $grandtotal += $grand_total->semi_monthly_rate;
            $grandtotal += $grand_total->monthly_rate;
            $grandtotal += $grand_total->r_allowance;
            $grandtotal += $grand_total->cola;


                // dump($sub_total);
            // loops through selected columns/fields
            foreach (explode(',', $payroll->fields) as $wage_name)
            {
                // dump($billing_rates);
                $rate_data = explode('|', $billing_rates[$wage_name]);
                // $rate_data = explode('|', $billing_rates[$name]);
                $rate_basis = $rate_data[0];
                $rate_title = $rate_data[1];
                $rate_abbr = $rate_data[2];
                $fieldname = $rate_data[3];
                $fieldcount = $rate_data[4];
                $total = $sub_total->$fieldname;

                if ( ! empty($grand_total->$fieldname))
                {
                    $grandtotal += $grand_total->$fieldname;
                }

                if ( ! empty($sub_total->$fieldname))
                {
                    $subtotal += $sub_total->$fieldname;
                }

                // if ($wage_name == ) {
                    
                // }
            }

            


            //     // column sub-total
            //     $column1total = floatval($pbt_proj->$fieldcount);
            if ( ($grand_total->$fieldname))
            {
                $column1total = floatval($grand_total->$current_cnt);
                $column2total = floatval($grand_total->$fieldname);
                // $grandtotal += $grand_total->$fieldname;
            }

            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(
                    [
                        'success' =>  TRUE, 
                        'wages' => $payroll->fields,
                        'newValue' => $current_amount, 
                        'rate' => $fieldname, 
                        'rate_name' => '#' . $rate[$name],
                        'total_amt' => nf(floatval($sub_total->$current_amount)), 
                        'subtotal' => nf(floatval($subtotal)), 
                        'column1total' => $column1total,
                        'column2total' => $column2total,
                        'grandtotal' => nf(floatval($grandtotal)),
                        'cola' => ! empty($sub_total->cola) ? $sub_total->cola : 0.00,
                        'total_cola' => ! empty($grand_total->cola) ? nf($grand_total->cola) : 0.00,
                        'allowance' => ! empty($sub_total->r_allowance) ? $sub_total->r_allowance : 0.00,
                        'total_allowance' => ! empty($grand_total->r_allowance) ? nf($grand_total->r_allowance) : 0.00,
                        'fieldname' => $fieldname,
                        'name' => $name,
                        'value' => $value,
                        'current_fieldname' => $current_fieldname,
                        'comp_rate' => $current_amount,
                        'grand_total' => $grand_total,
                        // 'sub_total' => $sub_total,
                    ]
                ));
            // ->set_output(json_encode(['success' =>  TRUE, 'newValue' => $this->input->post('value', TRUE), 'rate' => $proj_employee->$rate[$name]]));
            // registrar transaction log
            # code here ...
        }
        else
        {
            $this->output->set_status_header('400');
            return validation_errors('<p>','</p>');
        }

    }

    public function print_payroll($payroll_id)
    {
        // $this->output->enable_profiler(TRUE);
        $now = date('Y-m-d H:i:s');
        $this->manning_payroll_m->save(['date_printed' => $now, 'IsPayrollPrinted' => 1], $payroll_id);

        $this->load->model('manning_payroll_deduction_m');
        $affected = $this->manning_payroll_deduction_m->generate_deduction($payroll_id);
        $this->data['payroll'] = $this->manning_payroll_earning_m->get_payroll($payroll_id);
        $this->db->select('manning_payroll.*, b.title, tin, po, business_style');
        $this->db->join('projects b', 'b.project_id = manning_payroll.project_id', 'left');
        $this->data['payroll_info'] = $this->manning_payroll_m->get($payroll_id);

        $this->data['invoice'] = TRUE;
        $this->data['page_title'] = 'P A Y R O L L &nbsp; R E G I S T E R';
        // return $this->load->view('manning_payroll/payroll', $data);
        return parent::load_view('manning_payroll/payroll');
    }

    public function validate_contribution_modal()
    {
        $data = $this->manning_payroll_m->validate_contribution();
        return $this->output->set_content_type('application/json')
                    ->set_output(json_encode($data));
    }

    public function contribution()
    {
        $this->load->model(array('deduction_categories', 'manning'));

        $data['months'] = $this->manning_payroll_m->get_month();        
        $data['projects'] = $this->projects->get_projects();
                                            
        $data['employees'] = array('-1' => 'All Active Employees') + $this->manning->as_dropdown();
        
        $data['deductions'] = $this->deduction_categories->as_dropdown();
        $data['govt_dues'] = array(
                                            // '0' => 'Select Gov\'t Due',
                                            '1' => 'PHILHEALTH',
                                            '2' => 'PAGIBIG',
                                            '3' => 'SSS',
                                          );
        // die(dump($this->data));

        unset($data['projects'][0]);
        unset($data['employees'][0]);
        unset($data['deductions'][0]);

        return $this->load->view('manning_payroll/contribution', $data);
    }

    public function pagibig_contribution()
    {
        // $this->output->enable_profiler(TRUE);
        $this->load->model('manning_payroll_deduction_m');

        
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
        
        $validation = $this->form_validation->run();

        // Fecth all row
        $this->db->having('employee_share_pagibig >', 0);
        $this->data['result'] = $this->manning_payroll_deduction_m->get_manning_payroll_deduction();
        $this->data['last_query'] = $this->db->last_query();
        $this->data['page_title'] = 'PAGIBIG CONTRIBUTION REPORT';
        // dump($this->data['last_query']);
        // Load view 
        $this->load_view('manning_payroll/pagibig_contribution2');
    }

    public function philhealth_contribution()
    {
        $this->load->model('manning_payroll_deduction_m');

        $field_arr = array(
                            // manning info
                            'employee_no',
                            'lastname',
                            'firstname',
                            'middlename',
                            'position_code',
                            'position',
                            'SUM(gross_income) gross_income',
                        );        

        // $validation = $this->manning_payroll_deduction_m->get_deduction();
        $validation = $this->manning_payroll_deduction_m->validate_search_form();
        if ($validation['success'] == FALSE) 
        {
            $this->session->set_flashdata('error', $validation['messages']);
            redirect('manning_payroll','refresh');
        }
        // die(dump($_POST));

        $post['payroll_month'] = NULL;

        foreach ($validation['form'] as $key => $value) {
            empty($_POST[$key]) || $post[$key] = $_POST[$key];
        }

        if ($post['deduction_and_govtdue'] == 1) 
        {
            $govt_dues = strtolower($post['contribution']);
            // philhealth
            if ($govt_dues == 1) 
            {
                $govt_dues = 'philhealth';
                // deduction 
                $field_arr = array_merge($field_arr, array(
                                                'philhealth_no',
                                                'SUM(employee_share_philhealth) employee_share_philhealth',
                                                'SUM(employer_share_philhealth) employer_share_philhealth',
                                                'SUM(total_monthly_premium_philhealth) total_monthly_premium_philhealth',
                                                ));
            }

            // pagibig
            if ($govt_dues == 2) 
            {
                $govt_dues = 'pagibig';
                // deduction 
                $field_arr = array_merge($field_arr, array(
                                                'pagibig_no',
                                                'SUM(employee_share_pagibig) employee_share_pagibig',
                                                'SUM(employer_share_pagibig) employer_share_pagibig',
                                                'SUM(total_monthly_premium_pagibig) total_monthly_premium_pagibig',
                                                ));
            }

            // sss
            if ($govt_dues == 3) 
            {
                $govt_dues = 'sss';
                unset($field_arr['SUM(gross_income) gross_income']);
                // deduction 
                $field_arr = array_merge($field_arr, array(
                                                'sss_no',
                                                'SUM(employee_share_sss) employee_share_sss',
                                                'SUM(employer_share_sss) employer_share_sss',
                                                'SUM(total_monthly_premium_sss) total_monthly_premium_sss',
                                                'SUM(employee_compensation_program_sss) employee_compensation_program_sss'
                                                ));
            }

            $this->data['contribution'] = $govt_dues;
        }
        
        if ($post['deduction_and_govtdue'] == 2) 
        {
            $this->load->model('manning_payroll_deduction_detail_m', 'deduction_detail');
            $this->load->model('deduction_categories');

            $deduction_category_id = $post['deduction'];
            $deduction_category = $this->deduction_categories->get($deduction_category_id);
            $govt_dues = $deduction_category->deduction_category;

            // per employee
            if ($post['scope'] == 1) 
            {
                if (in_array(-1, $post['manning_id'])) 
                $post['manning_id'] = NULL;

                ! $post['manning_id'] || $this->db->where('manning_id IN (' . implode(',', $post['manning_id']) . ')');
                $this->db->where(
                                    array(
                                        'I.deduction_category_id' => $deduction_category_id,
                                        'payroll_year' => $post['payroll_year']                                    
                                    )
                                );
                empty($post['payroll_month']) || $this->db->where('payroll_month', $post['payroll_month']);
                $result = $this->deduction_detail->get_manning_payroll_deduction_detail();

                $project[] = array(
                                    'project_id' => -1,
                                    'project_title' => '',
                                    'project_data' => $result
                                );
            }

            // per project
            if ($post['scope'] == 2) 
            {
                $project = array();
                $proj = $this->db->where_in('project_id', $post['project_id'])->get('projects')->result();
                foreach ($proj as $row) 
                {
                    $this->db->where(
                                        array(
                                            'I.deduction_category_id' => $deduction_category_id,
                                            'payroll_year' => $post['payroll_year']                                    
                                        )
                                    );
                    empty($post['payroll_month']) || $this->db->where('payroll_month', $post['payroll_month']);
                    $this->db->group_by('G.project_id, manning_id');
                    $result = $this->deduction_detail->get_manning_payroll_deduction_detail();

                    $project[] = array(
                                        'project_id' => $row->project_id,
                                        'project_title' => $row->title,
                                        'project_data' => $result,
                                      );
                }

            }
            // die(dump($this->db->last_query()));
            // die(dump($project));
        }
        else
        {
            if ($post['scope'] == 1) 
            {
                if (in_array(-1, $post['manning_id'])) 
                $post['manning_id'] = NULL;

                $project[] = array(
                                    'project_id'    => -1,
                                    'project_title' => '',
                                    'project_data'  => $this->manning_payroll_deduction_m
                                                       ->get_by_employee_contribution(
                                                                                        $field_arr, 
                                                                                        $post['payroll_year'], 
                                                                                        $post['manning_id'], 
                                                                                        $post['payroll_month']
                                                                                     )
                                  );

            }

            if ($post['scope'] == 2) 
            {
                $project = $this->manning_payroll_deduction_m
                               ->get_by_project_contribution(
                                                                $field_arr, 
                                                                $post['payroll_year'], 
                                                                $post['project_id'], 
                                                                $post['payroll_month']
                                                            );
            }

        }

        


        $this->data['project'] = $project;
        
        // die(dump($result));
        $this->data['invoice'] = TRUE;
        $this->data['field_arr'] = $field_arr;
        $this->data['last_query'] = $this->db->last_query();
        $this->data['page_title'] = t($govt_dues) . ' CONTRIBUTION REPORT';
        $this->data['covered_period'] = "FOR THE " . (! empty($post['payroll_month']) ? "MONTH OF $post[payroll_month]" : "") . " YEAR $post[payroll_year]";

        if ($post['deduction_and_govtdue'] == 2) 
        {
            $this->data['page_title'] = t($govt_dues) . ' DEDUCTION REPORT';
            $this->load_view('manning_payroll/deduction_dues');
        }

        else
        $this->load_view('manning_payroll/government_dues');
    }

    public function philhealth_contribution_project()
    {
        // $this->output->enable_profiler(TRUE);
        $this->load->model('manning_payroll_deduction_m');

        $validation = $this->manning_payroll_deduction_m->get_deduction();

        // Fecth all row
        // $this->db->having('employee_share_philhealth >', 0);

        $field_arr = array(
                            // payroll info
                            'payroll_month',
                            'payroll_year',

                            'SUM(gross_income) gross_income',

                            // deduction 
                            'SUM(employee_share_philhealth) employee_share_philhealth',
                            'SUM(employer_share_philhealth) employer_share_philhealth',
                            'SUM(total_monthly_premium_philhealth) total_monthly_premium_philhealth',

                            // manning info
                            'employee_no',
                            'lastname',
                            'firstname',
                            'middlename',
                            'position_code',
                            'position',
                            // 'pagibig_no',
                            'philhealth_no',
                            // 'tin_no',
                            // 'sss_no',
                            
                        );
        
        $result = $this->manning_payroll_deduction_m->fields($field_arr)->group_by('project_id, manning_id')->get_manning_payroll_deduction();
        $this->data['result'] = $result;
        // die(dump($result));
        $this->data['contribution'] = 'philhealth';
        $this->data['field_arr'] = $field_arr;
        $this->data['last_query'] = $this->db->last_query();
        $this->data['page_title'] = 'PHILHEALTH CONTRIBUTION REPORT';
        $this->data['covered_period'] = 'FOR THE MONTH OF ' . $this->input->post('payroll_month') . ' ' . $this->input->post('payroll_year');
        // dump($this->data['last_query']);
        // Load view 
        $this->load_view('manning_payroll/government_dues');
    }

    public function sss_contribution()
    {
        // $this->output->enable_profiler(TRUE);
        $this->load->model('manning_payroll_deduction_m');

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
        
        $validation = $this->form_validation->run();


        // Fecth all row
        // $this->db->like('title', 'azumi', 'right');
        $this->db->having('employee_share_sss >', 0);
        $this->data['result'] = $this->manning_payroll_deduction_m->get_manning_payroll_deduction();
        $this->data['last_query'] = $this->db->last_query();
        $this->data['page_title'] = 'SSS CONTRIBUTION REPORT';
        // dump($this->data['last_query']);
        // Load view 
        $this->load_view('manning_payroll/sss_contribution2');
    }

    public function print_payslip($payroll_id)
    {
        $this->load->model('manning_payroll_deduction_m');

        $now = date('Y-m-d H:i:s');
        $this->manning_payroll_m->save(['DatePayslipPrinted' => $now, 'IsPayslipPrinted' => 1], $payroll_id);

        $affected = $this->manning_payroll_deduction_m->generate_deduction($payroll_id);
        $this->data['payroll'] = $this->manning_payroll_earning_m->get_payroll($payroll_id);
        $this->db->select('manning_payroll.*, b.title, tin, po, business_style');
        $this->db->join('projects b', 'b.project_id = manning_payroll.project_id', 'left');
        $this->data['payroll_info'] = $this->manning_payroll_m->get($payroll_id);

        // $this->data['invoice'] = TRUE;
        $this->data['page_title'] = 'PAYSLIP';
        return parent::load_view('manning_payroll/payslip');   
    }

    public function _valid_id($id)
    {
        $id = intval($id);
        if ($id) 
        {
            $this->db->select('manning_payroll_earning_id');
            $result = $this->manning_payroll_earning_m->get($id);
            if ( ! count($result)) 
            {
                $this->form_validation->set_message('_valid_id', "This manning payroll ID does not exists. ");
                return FALSE;
            }

            return TRUE;
        }

        $this->form_validation->set_message('_valid_id', 'This manning payroll ID is not valid.');
        return FALSE;
    }

    public function _valid_month($payroll_month)
    {
        $months = $this->manning_payroll_m->get_month();
        if ( ! in_array($payroll_month, $months)) 
        {
            $this->form_validation->set_message('_valid_month', 'This %s is not a valid month.');
            return FALSE;
        }

        return TRUE;
    }

}

/* End of file manning_payroll.php */
/* Location: ./application/controllers/manning_payroll.php */