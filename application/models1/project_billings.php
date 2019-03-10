<?php

/**
 * Filename: project_billings.php
 * Author: Brando Talaguit (ITC Developer)
 */
class Project_billings extends MY_Model
{
    protected $table_name = "project_billing_info";
    protected $primary_key = "project_bill_id";
    protected $order_by = "project_billing_info.created_at";
    protected $timestamps = TRUE;

    public $rules = array(
        'date_start' => ['field' => 'date_start', 'label' => 'Date Start', 'rules' => 'required|xss_clean'],
        'date_end'   => ['field' => 'date_end', 'label' => 'Date End', 'rules' => 'required|xss_clean'],
        'remarks'   => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
        'project_id' => ['field' => 'project_id', 'label' => 'Project', 'rules' => 'intval|is_natural_no_zero|callback__unique_period|xss_clean'],
        'fields[]' => ['field' => 'fields', 'label' => 'Columns', 'rules' => 'required|xss_clean'],
        'is_vat'   => ['field' => 'is_vat', 'label' => '', 'rules' => 'trim|intval|xss_clean'],
        'is_wt_tax'   => ['field' => 'is_wt_tax', 'label' => '', 'rules' => 'trim|intval|xss_clean'],
        'official_time' => ['field' => 'official_time', 'label' => '', 'rules' => 'trim|intval|xss_clean'],

    );

    function __construct()
    {
        parent::__construct();
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->project_id = intval($this->uri->segment(3, 0));
        $data->date_start = '';
        $data->date_end = '';
        $data->remarks = '';
        $data->fields = '';
        $data->is_vat = 0;
        $data->is_wt_tax = 0;
        $data->official_time = 0;

        return $data;
    }

    public function get_project_billing_info($project_id = NULL, $project_billing_id = NULL, $single = FALSE)
    {
        $this->db->join('projects as B', 'B.project_id = project_billing_info.project_id', 'left');
        $this->db->join('users as C', 'C.Id = project_billing_info.user_id', 'left');

        return $project_billing_id !== NULL ? parent::get($project_billing_id, $single) : parent::get_by(['B.project_id' => $project_id]);
    }

    public function get_billing_period($project_id)
    {
        // Fetch project billing period
        $condition = array('project_id' => $project_id, 'is_actived' => 1);
        $project_billing = $this->db->order_by('project_billing_info.created_at')->where($condition)->get('project_billing_info')->result();

        // Return key -> value pair array
        $array = array('0' => 'Select a billing period');
        if (count($project_billing)) 
        {
            foreach ($project_billing as $bill) 
            {
                $array[$bill->project_bill_id] = date('M j, y', strtotime($bill->date_start)) . '-' . date('M j, y', strtotime($bill->date_end)) . ' ' . $bill->remarks;
                // $array[$employee->employee_id] = $employee->member_status;
            }
        }
        return $array;
    }

}

/*Location: ./application/models/projects.php*/
?>