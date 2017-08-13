<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_billing_info extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->data['controller'] = 'project_employee';
        $this->data['page_title'] = 'Project Personnel';
        $this->data['page_subtitle'] = '';
        $this->data['icon'] = '<i class="fa fa-gears"></i>';

        $this->load->model('projects');
        $this->load->model('project_billings');
        $this->load->model('project_billing_trans');
    }

    public function index($project_id)
    {
        $this->output->enable_profiler(FALSE);
        $project = $this->_isProjectExists($project_id);
        // $project_billings = $this->project_billings->get_project_billing_info($project_id);


        // Filter user account per user
        if ($this->session->userdata('AccountType') !== 'S') 
        {
            $filter_user = array('A.user_id' => $this->session->userdata('Id'));
            $this->db->where($filter_user);
        }

        $condition = ['A.project_id' => $project_id, 'A.is_actived' => 1];
        $this->data['project_billings'] = $this->project_billing_trans->get_project_summary_by($condition);

        // Set up view
        $this->data['page_title'] = $project->title;
        $this->data['page_subtitle'] = $project->project_id;

        // Fetch project data
        $this->data['project'] = $project;
        $this->data['proj_rate_arr'] = $this->projects->get_project_rates_array();
        // $this->data['project_billings'] = $project_billings;

        $this->load_view('admin/project_billing_info/index');
    }

    public function edit($project_id, $id = NULL)
    {
        $project = $this->_isProjectExists($project_id);

        if ($id === NULL)
        {            
            $this->data['project_billing'] = $this->project_billings->get_new();

            // fetch last bill options
            $this->db->order_by('project_billing_info.project_bill_id DESC');
            $last_proj_bill = $this->project_billings->get_by(array('project_id' => $project_id), TRUE);
            if ($last_proj_bill) 
            {
                $this->data['project_billing']->is_vat = $last_proj_bill->is_vat;
            }
        }
        else
        {
            $this->data['project_billing'] = $this->_isProjectBillingExists($id);
        }

        $rules = $this->project_billings->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE)
        {
            // prep post data
            $_POST['user_id'] = $this->session->userdata('Id');
            $_POST['project_id'] = $project_id;

            $data = $this->project_billings->array_from_post([
                    'project_id', 
                    'date_start', 
                    'date_end', 
                    'remarks', 
                    'is_vat', 
                    'is_wt_tax', 
                    'official_time', 
                    'user_id']
                );

            $data['fields'] = implode(",", $_POST['fields']);

            // save post data
            $pb_id = $this->project_billings->save($data, $id);


            // save/update billing rates
            $this->load->model('project_billing_trans');
            $project_billings = $this->project_billing_trans->fill_billing($pb_id, $project_id);

            // redirect to project billing details
            parent::redirect_to('You have sucessfully saved a new project billing period!', 
                'projectBillingTrans/'.$project_id.'/'.$pb_id.'/summary', 
                FALSE);
            // $this->output->enable_profiler(TRUE);
            
        }

        // Set up view
        $this->data['project'] = $project;
        $this->data['project_id'] = $project_id;
        $this->data['page_title'] = $project->title;
        $this->data['page_subtitle'] = $project->description;

        /*$sql = "SELECT `cola`, `straight_duty`, `straight_ot_day`, `night_diff`, `regular_ot_day`, 
                `special_holiday`, `special_ot_holiday`, `legal_holiday`, 
                `legal_ot_holiday`, `rest_day_rate`, `rest_day_special_holiday`, `rest_day_special_ot_holiday`, 
                `rest_day_legal_holiday`, `rest_day_legal_ot_holiday`, 
                `late_amount`, `absent_rate`, `absent_rate_per_day`
                FROM `project_position_rates` LIMIT 0";*/

        $this->data['columns'] = $this->projects->get_columns();
        
        
        if ($project->rate_hourly == 1) 
        {
            unset($this->data['columns']['hourly_rate']);
            unset($this->data['columns']['semi_monthly_rate']);
            unset($this->data['columns']['monthly_rate']);
        }

        if ($project->rate_daily == 1) 
        {
            unset($this->data['columns']['daily_rate']);
            unset($this->data['columns']['semi_monthly_rate']);
            unset($this->data['columns']['monthly_rate']);
        }

        if (($project->rate_semi_monthly == 1) || ($project->rate_monthly == 1)) 
        {
            unset($this->data['columns']['semi_monthly_rate']);
            unset($this->data['columns']['monthly_rate']);
        }

        // dump($this->data['columns']);

        // Load the view
        $this->load_view('admin/project_billing_info/edit');
        
    }

    public function delete($id = NULL)
    {
        // fetch data
        $project_billing = $this->project_billings->get($id, TRUE);
        // process delete
        $billing_id = $this->project_billings->delete($id);

        // save log

        // redirect
        // parent::redirect_to('You have successfully delete a project billing id ' . $billing_id, 'projectBillingInfo/' . $project_billing->project_id, FALSE);

        $this->session->set_userdata('success', 'You have successfully delete a project billing id ' . $billing_id);
        
        if (empty($project_billing)) 
        {
            redirect(base_url('project'));
        }

        redirect(base_url("projectBillingInfo/" . $project_billing->project_id));

    }

    private function _isProjectExists($project_id)
    {
        $project = $this->projects->get(intval($project_id), TRUE);
        count($project) || parent::redirect_to('Access denied, invalid project id detected');

        return $project;
    }

    private function _isProjectBillingExists($project_billing_id)
    {
        $billing = $this->project_billings->get(intval($project_billing_id), TRUE);
        count($billing) || parent::redirect_to('Access denied, invalid project billing id detected');

        return $billing;
    }

    public function _display_message($msg, $redirect_to = 'dashboard')
    {
        $this->session->set_userdata('error', $msg);
        redirect(site_url($redirect_to));
    }


    public function _unique_period($str)
    {
        // Do NOT validate if project_employee already exists
        // UNLESS it's the name for the current project_employee
        $id = $this->uri->segment(3, 0);
        $project_id = $this->uri->segment(2, 0);

        $date_start = $this->input->post('date_start', TRUE);
        $date_end = $this->input->post('date_end', TRUE);
        $remarks = $this->input->post('remarks', TRUE);

        $this->db->where('date_start', $date_start);
        $this->db->where('date_end', $date_end);
        $this->db->where('remarks', $remarks);
        $this->db->where('project_id', $project_id);
        $this->db->where('is_actived', 1);

        !$id || $this->db->where('project_bill_id !=', $id);

        $project_billing_info = $this->project_billings->get();

        if (count($project_billing_info))
        {
            $this->form_validation->set_message('_unique_period', "%s billing period <strong>$date_start to $date_end</strong> already exists.");

            return FALSE;
        }

        return TRUE;
    }

    public function billing_statement()
    {
        $this->load_view('sample_billing_statement');
    }

}

/* End of file project_employee.php */
/* Location: ./application/controllers/project_employee.php */