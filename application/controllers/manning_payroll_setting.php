<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manning_payroll_setting extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
	    $this->data['controller'] = 'manning_payroll_setting';
	}

	public function index($id = NULL)
	{
	    // $this->output->enable_profiler(TRUE);

		$this->data['config'] = $this->manning_payroll_setting_m->get(1);

	    $rules = $this->manning_payroll_setting_m->rules;
	    $this->form_validation->set_rules($rules);

	    // Process the form
	    if ($this->form_validation->run() == TRUE)
	    {
	        // post data
	        $data = $this->manning_payroll_setting_m->array_from_post([
                'mode_of_payment_pagibig', 
                'mode_of_payment_philhealth', 
                'mode_of_payment_sss', 
            ]);

	        $now = date('Y-m-d H:i:s');

	        $data['created_at'] = $now;
	        $data['updated_at'] = $now;

	        $save_option = $_POST['save_option'];

	        	
        	$sql = "UPDATE projects 
        				SET 
        					mode_of_payment_pagibig = ?, 
        					mode_of_payment_philhealth = ?,
        					mode_of_payment_sss = ?,
        					created_at = ?,
        					updated_at = ?
        			WHERE is_actived";

	        if ($save_option == 2) 
	        {
		        $where = implode(",", $_POST['projects']);
	        	$sql .= " AND project_id IN ({$where})";
	        }

	        // save post data
	        $query = $this->db->query($sql, $data);
	        $affected = $this->db->affected_rows();
	        $last_qry = $this->db->last_query();
	        $this->db->close();

	        unset($data['created_at']);
	        unset($data['updated_at']);
	        
	        $this->manning_payroll_setting_m->save($data, 1);

	        $msg = "<h4>Success.</h4><p>Payroll setting has been successfully applied to {$affected} project(s).</p>";

	        $payroll_id = $this->uri->segment(4, 0);
	        if ($payroll_id) 
	        {
	        	$this->load->model('manning_payroll_m');
	        	$payroll = $this->manning_payroll_m->get($payroll_id);
	        	if ( ! empty($payroll)) 
	        	{
	        		if ($save_option == 2)
			        $msg = "<h4>Success.</h4><p>Payroll setting has been successfully applied to this project(s).</p>";
	        		$payroll->IsFinal || parent::redirect_to($msg, 'manning_payroll/earning/' . $payroll_id, FALSE);
	        	}
	        }

	        return parent::redirect_to($msg, 'manning_payroll_setting', FALSE);
	    }

	    // Set up view
        $this->data['page_title'] = 'Payroll Setting';
	    $this->data['projects'] = $this->projects->get_projects(TRUE);

	    // Load the view
	    return parent::load_view('manning_payroll_setting/edit');
	}

	public function _check_projects($projects)
	{
		$save_option = intval($this->input->post('save_option', TRUE));
		if ($save_option == 2) 
		{
			if ( ! count($projects)) 
			{
				$this->form_validation->set_message('_check_projects', "To apply changes please select at-least one project");
				return FALSE;
			}
		}

		if ($save_option == 0) 
		{
			$this->form_validation->set_message('_check_projects', "Please select save option");
			return FALSE;
		}

		return TRUE;
	}


}

/* End of file  */
/* Location: ./application/controllers/ */