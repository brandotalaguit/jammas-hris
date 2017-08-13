<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: manning_payroll_m.php
 * Author: Brando Talaguit (ITC Developer)
 */
class Manning_payroll_m extends MY_Model
{
    protected $table_name = "manning_payroll";
    protected $primary_key = "payroll_id";
    protected $order_by = "payroll_id DESC, project_id ASC";
    protected $alias = "A";

    public $rules = array(
        'project_id' => ['field' => 'project_id', 'label' => 'Project', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'payroll_date' => ['field' => 'payroll_date', 'label' => 'Payroll Date', 'rules' => 'trim|xss_clean'],
        'payroll_month' => ['field' => 'payroll_month', 'label' => 'Payroll Month', 'rules' => 'trim|required|callback__valid_month|xss_clean'],
        'payroll_year' => ['field' => 'payroll_year', 'label' => 'Payroll Year', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'payroll_period' => ['field' => 'payroll_period', 'label' => 'Payroll Period', 'rules' => 'trim|enum[1st,2nd]|required|callback__unique_period|xss_clean'],
        'date_start' => ['field' => 'date_start', 'label' => 'Date Start', 'rules' => 'trim|required|xss_clean'],
        'date_end' => ['field' => 'date_end', 'label' => 'Date End', 'rules' => 'trim|required|xss_clean'],
        'date_printed' => ['field' => 'date_printed', 'label' => 'Date Printed', 'rules' => 'trim|xss_clean'],
        'fields[]' => ['field' => 'fields', 'label' => 'Wage', 'rules' => 'required|callback__add_field|xss_clean'],
        'remarks' => ['field' => 'remarks', 'label' => 'Remarks', 'rules' => 'trim|xss_clean'],
        'is_vat' => ['field' => 'is_vat', 'label' => '', 'rules' => 'intval|xss_clean'],
        'is_wt_tax' => ['field' => 'is_wt_tax', 'label' => '', 'rules' => 'intval|xss_clean'],
    );

    public $search_rules = array(
        'by' => ['field' => 'by', 'label' => 'Search Category', 'rules' => 'trim|xss_clean'],
        'search' => ['field' => 'search', 'label' => 'Search Text', 'rules' => 'trim|xss_clean'],
        'project_id' => ['field' => 'project_id', 'label' => 'Project', 'rules' => 'intval|xss_clean'],
    );

    private $search_contribution_rules = array(
        'payroll_month' => ['field' => 'payroll_month', 'label' => 'Payroll Month', 'rules' => 'trim|xss_clean'],
        'payroll_year' => ['field' => 'payroll_year', 'label' => 'Payroll Year', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'deduction_and_govtdue' => ['field' => 'deduction_and_govtdue', 'label' => 'Type of Report', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'scope' => ['field' => 'scope', 'label' => 'Scope of Report', 'rules' => 'intval|is_natural_no_zero|required|xss_clean'],
        'contribution' => ['field' => 'contribution', 'label' => 'Contribution', 'rules' => 'trim|xss_clean'],
        'deduction' => ['field' => 'deduction', 'label' => 'Deduction', 'rules' => 'trim|xss_clean'],
        'manning_id' => ['field' => 'manning_id', 'label' => 'Employee Id', 'rules' => 'trim|xss_clean'],
        'project_id' => ['field' => 'project_id', 'label' => 'Project Id', 'rules' => 'trim|xss_clean'],

    );

    public $search_option = array(
        '0' => 'Search by',
        'fields' => 'Wage',
        'title' => 'Project',
        'payroll_date' => 'Date',
        'date_printed' => 'Date Printed',
        'payroll_month' => 'Month',
        'payroll_year' => 'Year',
        'remarks' => 'Remarks',
    );

    public $filter_option = array(
        'lastname' => 'Lastname',
        'firstname' => 'Firstname',
        'position' => 'Position',
        'title' => 'Project',
        'address' => 'Address',
    );

    protected $fillable = array(
        'project_id',
        'payroll_period',
        'payroll_date',
        'payroll_month',
        'payroll_year',
        'date_start',
        'date_end',
        'date_printed',
        'remarks',
        'is_vat',
        'is_wt_tax',
        'official_time',
        'fields',
        'user_id'
    );

    function __construct()
    {
        parent::__construct();
    }

    public function get_new()
    {

        $data = new stdClass();
        $data->project_id = 0;
        $data->payroll_date = date('Y-m-d');
        $data->payroll_month = ucwords(date('M'));
        $data->payroll_year = date('Y');
        $data->payroll_period = 0;
        $data->date_start = '';
        $data->date_end = '';
        $data->date_printed = '';
        $data->fields = '';
        $data->remarks = '';
        $data->is_vat = 0;
        $data->is_wt_tax = 0;

        return $data;
    }

    public function get_last_proj_setup($project_id)
    {
        $this->db->order_by('payroll_id DESC');
        $data = $this->get_by(array('project_id' => $project_id), TRUE);
        return count($data) ? $data : FALSE;
    }

    public function get_index()
    {
        $this->db->select('manning_payroll.*, title, description, rate_hourly, rate_daily, rate_monthly, rate_semi_monthly');
        $this->db->order_by('payroll_id', 'desc');
        return self::get_manning_payroll();
    }

    public function get_manning_payroll($payroll_id = NULL, $single = FALSE)
    {
        $this->db->join('projects as B', 'B.project_id = manning_payroll.project_id', 'left');
        $this->db->join('users as C', 'C.Id = manning_payroll.user_id', 'left');
        return parent::get($payroll_id, $single);
    }

    // Return key -> value pair array
    public function get_billing_period($project_id)
    {
        // Fetch project billing period
        $condition = array('project_id' => $project_id, 'is_actived' => 1);
        $project_billing = $this->db->order_by('manning_payroll.created_at')->where($condition)->get('manning_payroll')->result();

        $array = array('0' => 'Select a billing period');
        if (count($project_billing)) 
        {
            foreach ($project_billing as $bill) 
            {
                $array[$bill->payroll_id] = date('M j, y', strtotime($bill->date_start)) . '-' . date('M j, y', strtotime($bill->date_end)) . ' ' . $bill->remarks;
            }
        }
        return $array;
    }

    public function collect($id = NULL, $single = FALSE)
    {
        $field = array(
            'A.*',
            // 'sum_income',
            // 'sum_deduction',
        );
        $this->db->select($field, FALSE);
        return self::_get($id, $single);
    }

    private function _get($id = NULL, $single = FALSE)
    {
        if ($id != NULL) 
        {
            $filter = $this->primary_filter;
            $id = $filter($id);
            $this->db->where("{$this->table_name}.{$this->primary_key}", $id);
            $method = 'row';
        }
        elseif ($single == TRUE) 
            $method = 'row';
        else
            $method = 'result';

        if (!count($this->db->ar_orderby)) 
        {
            $this->db->order_by($this->order_by);
        }

        $this->db->where("A.is_actived", 1);

        return $this->db->get($this->table_name . ' as A')->$method();
    }


    public function get_month()
    {
        return ['' => 'Choose a month', 'January' => 'January','February' => 'February','March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December'];
    }

    public function validate_contribution()
    {
        $data = array('success' => FALSE, 'messages' => array());
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

        if ($this->form_validation->run() == TRUE) 
        {
            $data['success'] = TRUE;
        } else 
        {
            foreach ($this->search_contribution_rules as $key => $value) {
                $data['messages'][$key] = form_error($key);
            }
            // die(dump(validation_errors()));
            // die(dump($rules));
        }

        return $data;
    }

}

/*Location: ./application/models/manning_payroll.php*/