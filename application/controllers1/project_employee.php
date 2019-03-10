<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_employee extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->data['controller'] = 'project_employee';
        $this->data['page_title'] = 'Project Personnel';
        $this->data['page_subtitle'] = '';
        $this->data['icon'] = '<i class="fa fa-gears"></i>';

        $this->load->model('project_employees');
        $this->load->model('project_position_rates');
        $this->load->model('project_billing_trans');
    }

    public function index($project_id)
    {

        if (!intval($project_id)) {
            $this->session->set_userdata('error', 'Access denied, invalid project id detected');
            redirect(site_url('dashboard'));
        }

        $project = $this->projects->get($project_id);

        if ($this->input->post('btn_action1') == 'Search') 
        {
            $this->form_validation->set_rules('search1', 'Search', 'required|strtoupper');
            
            $q = $this->input->post('search1');
            $by = $this->input->post('by1');
            if ($by == "Position") 
            {
                $this->db->like('position', $q, 'after');
            }
            elseif ($by == "Description") 
            {
                $this->db->like('remarks', $q, 'after');
            }
        }

        $this->db->join('positions', 'positions.position_id = project_position_rates.position_id', 'left');
        $ppr = $this->project_position_rates->get_by(['project_id' => $project_id]);

        $this->data['ppr'] = $ppr;

        // Set up view
        $this->data['project_id'] = $project_id;
        $this->data['page_title'] = $project->title;
        $this->data['page_subtitle'] = $project->project_id;

        $this->db->join('employees', 'employees.employee_id = project_employees.employee_id', 'left');
        $this->db->join('project_position_rates', 'project_position_rates.ppr_id = project_employees.ppr_id', 'left');
        $this->db->join('positions', 'positions.position_id = project_position_rates.position_id', 'left');
        // $this->db->order_by('project_employees.created_at DESC');
        $this->db->order_by('lastname, firstname, middlename');
        
        if ($this->input->post('btn_action2') == 'Search') 
        {
            $this->form_validation->set_rules('search2', 'Search', 'required|strtoupper');
            
            $q = $this->input->post('search2');
            $by = $this->input->post('by2');
            if ($by == "Lastname") 
            {
                $this->db->like('lastname', $q, 'after');
            }
            elseif ($by == "Firstname") 
            {
                $this->db->like('firstname', $q, 'after');
            }
            elseif ($by == "Middlename") 
            {
                $this->db->like('middlename', $q, 'after');
            }
        }

        $this->data['project_personnels'] = 
                $this->project_employees->get_by(
                    array(
                        'project_employees.project_id' => $project_id,
                        'employees.is_actived' => 1,
                        'positions.is_actived' => 1,
                        'project_employees.w_adjustment' => 0
                    )
                );

        // Load the view
        $this->load_view('project_employee/index');
        
        $this->output->enable_profiler(FALSE);
    }

    public function _display_message($msg, $redirect_to = 'dashboard')
    {
        $this->session->set_userdata('error', $msg);
        redirect(site_url($redirect_to));
    }

    public function edit($project_id, $id = NULL)
    {

        if ($id == NULL) {
            $this->data['project_employee'] = $this->project_employees->get_new();
        } else {
            // Fetch project employee
            $this->data['project_employee'] = $this->project_employees->get($id);

            if (!count($this->data['project_employee'])) $this->_display_message('Access denied, invalid project id detected');
        }


        $project = $this->projects->get($project_id);
        if (!count($project)) $this->_display_message('Access denied, invalid project id detected');


        $rules = $this->project_employees->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            // prep post data
            $_POST['user_id'] = $this->session->userdata('Id');
            $_POST['project_id'] = $project_id;

            $data = $this->project_employees->array_from_post(
                [
                    'project_id',
                    'ppr_id',
                    'employee_id',
                    'regular_time_in',
                    'regular_time_out',
                    'user_id'
                ]
            );

            $id = $this->project_employees->save($data, $id);

            // // save log
            // $message = "<i class='fa fa-users'></i> <strong>$data[lastname] $data[firstname]</strong> is now a member of the coooperative";
            // $this->activity_m->write($message, NULL, $data);

            // // highligh row of the inserted data
            // $this->session->set_flashdata('id', $id);

            // // redirect to member
            if ($this->input->post('btnAdd') == "Save and Add") 
            {
                redirect(base_url("project_employee/$project_id/new"));
            }
            else
            {
                redirect(base_url("project_employee/$project_id/detail"));
            }


        }

        // dropdown menu
        $this->data['employees'] = $this->projects->get_employees();
        $this->data['positions'] = $this->project_position_rates->dropdown_select($project_id);

        $this->data['rates'] = $this->rates->get();


        // Set up view
        $this->data['project_id'] = $project_id;
        $this->data['page_title'] = $project->title;
        $this->data['page_subtitle'] = $project->description;


        $attribute = ['role' => 'form'];
        $this->data['form_url'] = form_open(NULL, $attribute);

        // Load the view
        $this->load_view('project_employee/edit');
    }


    public function special_addjustment_personnel($project_id, $project_bill_id)
    {
        $this->data['project_employee'] = $this->project_employees->get_new();

        $project = $this->projects->get($project_id);
        if (!count($project)) $this->_display_message('Access denied, invalid project id detected');


        $rules = $this->project_employees->rules;
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            // prep post data
            $_POST['user_id'] = $this->session->userdata('Id');
            $_POST['project_id'] = $project_id;

            $data = $this->project_employees->array_from_post(
                [
                    'project_id',
                    'ppr_id',
                    'employee_id',
                    'remarks',
                    'user_id'
                ]
            );
            $data['w_adjustment'] = 1;

            $id = $this->project_employees->save($data);

            $adjustment = ['project_employee_id' => $id, 'project_bill_id' => $project_bill_id];
            $this->project_billing_trans->save($adjustment);

            // // redirect to member
            if ($this->input->post('btnAdd') == "Save and Add") 
            {
                redirect(base_url("project_employee/$project_id/$project_bill_id/special_addjustment_personnel"));
            }
            else
            {
                redirect(base_url("projectBillingTrans/$project_id/$project_bill_id/summary"));
            }


        }

        // dropdown menu
        $this->data['employees'] = $this->projects->get_employees();
        $this->data['positions'] = $this->project_position_rates->dropdown_select($project_id);

        $this->data['rates'] = $this->rates->get();


        // Set up view
        $this->data['project_id'] = $project_id;
        $this->data['page_title'] = $project->title;
        $this->data['page_subtitle'] = $project->description;
        $this->data['project_bill_id'] = $project_bill_id;


        $attribute = ['role' => 'form'];
        $this->data['form_url'] = form_open(NULL, $attribute);

        // Load the view
        $this->load_view('project_employee/special_adjustment');

        $this->output->enable_profiler(FALSE);
    }


    public function add_personnel($project_id, $project_bill_id)
    {
        $this->data['project_employee'] = $this->project_employees->get_new();

        $project = $this->projects->get($project_id);
        if (!count($project)) $this->_display_message('Access denied, invalid project id detected');


        $rules = $this->project_employees->rules;
        $rules['employee_id']['rules'] .= '|callback__unique_project_employee';
        $this->form_validation->set_rules($rules);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            // prep post data
            $_POST['user_id'] = $this->session->userdata('Id');
            $_POST['project_id'] = $project_id;

            $data = $this->project_employees->array_from_post(
                [
                    'project_id',
                    'ppr_id',
                    'employee_id',
                    'remarks',
                    'user_id'
                ]
            );

            $id = $this->project_employees->save($data);

            $adjustment = ['project_employee_id' => $id, 'project_bill_id' => $project_bill_id];
            $this->project_billing_trans->save($adjustment);

            // // redirect to member
            if ($this->input->post('btnAdd') == "Save and Add") 
            {
                redirect(base_url("project_employee/$project_id/$project_bill_id/add_personnel"));
            }
            else
            {
                redirect(base_url("projectBillingTrans/$project_id/$project_bill_id/summary"));
            }


        }

        // dropdown menu
        $this->data['employees'] = $this->projects->get_employees();
        $this->data['positions'] = $this->project_position_rates->dropdown_select($project_id);

        $this->data['rates'] = $this->rates->get();


        // Set up view
        $this->data['project_id'] = $project_id;
        $this->data['page_title'] = $project->title;
        $this->data['page_subtitle'] = $project->description;
        $this->data['project_bill_id'] = $project_bill_id;


        $attribute = ['role' => 'form'];
        $this->data['form_url'] = form_open(NULL, $attribute);

        // Load the view
        $this->load_view('project_employee/special_adjustment');

        $this->output->enable_profiler(FALSE);
    }


    public function delete($id = NULL)
    {
        // fetch data
        $project_employee = $this->project_employees->get($id, TRUE);
        $project_id = $project_employee->project_id;

        // process delete
        $this->project_employees->delete($id);

        // save log
        $message = "<i class='fa fa-times'></i> <strong>Employee Id $project_employee->project_employee_id</strong> has been removed from Project Id $project_id";
        $this->activity_m->write($message, $project_employee);

        // redirect to project_employee
        redirect(base_url("project_employee/$project_id/detail"));
    }


    public function _unique_title($str)
    {
        // Do NOT validate if project_employee already exists
        // UNLESS it's the name for the current project_employee
        $id = $this->uri->segment(2);

        $this->db->where('title', $this->input->post('title'));
        !$id || $this->db->where('project_employee_id !=', $id);

        $project_employee = $this->project_employees->get();

        if (count($project_employee)) {
            $this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
            return FALSE;
        }

        return TRUE;
    }

    public function _unique_project_employee($str)
    {
        // Do NOT validate if employee already exists
        $project_id = $this->uri->segment(2, 0);

        $this->db->where('employee_id', $this->input->post('employee_id', TRUE));
        $this->db->where('project_id', $project_id);
        $this->db->where('ppr_id', $this->input->post('ppr_id', TRUE));
        $this->db->where('w_adjustment', 0);

        $project_employee = $this->project_employees->get();

        if (count($project_employee)) 
        {
            $this->form_validation->set_message('_unique_project_employee', "Duplicate entry detected. This %s is already exists in this project with the same position.");
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