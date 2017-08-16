<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manning_list extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['controller'] = 'manning_list';
		$this->data['page_title'] = 'Manning List';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-primary' href='".base_url('manning_list/new')."'><i class='fa fa-plus'></i> New Employee</a>";
		$this->data['page_btn_view_all'] = "<a class='btn btn-primary' href='".base_url('manning_list')."'><i class='fa fa-eye'></i> View All Employees</a>";
		$this->data['page_btn_print'] = "<button class='btn btn-primary' name='btn_print' type='submit' value='Print'><span class='fa fa-print'></span> Print </button>";
		$this->data['page_btn_download'] = "<button class='btn btn-primary' name='btn_download' type='submit' value='Download'><span class='fa fa-download'></span> Download to Excel </button>";

		$this->load->helper('file');
   		$this->load->helper('dompdf');
   		$this->load->helper('text');
		$this->load->model('manning');
	}

	public function index()
	{
		$search = FALSE;
		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S')
		{
			$filter_user = array('user_id' => $this->session->userdata('Id'));
			$this->db->where($filter_user);
		}


		$this->data['projects'] = $this->manning->get_projects();
		$this->data['positions'] = $this->manning->get_positions();
		$this->data['employment_statuses'] = $this->manning->get_employment_statuses();
		$this->data['fields'] = array('manning_id','lastname,firstname,middlename','gender','date_of_birth','age','address1,address2','d.title as title','e.position as position','f.employment_status as employment_status');

		// Set up pagination
		$config['total_rows'] = $this->manning->count();
		$config['per_page'] = 15;

		$this->pagination->initialize($config);

		// Create pagination links
		$this->data['pagination'] = $this->pagination->create_links();

		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);


		if ($this->input->post('btn_search') == 'Search')
		{

			$fields = '';
			foreach($this->input->post('columns') as $column)
			{

				$fields .= $column . ',';
			}

			$this->data['fields'] = $this->input->post('columns');


			if($this->input->post('by') != '0')
			{
				$this->form_validation->set_rules('search', 'Search', 'required|strtoupper');
				$q = $this->input->post('search');
				$by = $this->input->post('by');
				if ($by == "lastname")
				{
					$this->db->like('lastname', $q, 'after');
				}
				elseif ($by == "firstname")
				{
					$this->db->like('firstname', $q, 'after');
				}
				elseif ($by == "position")
				{
					$this->db->like('position', $q, 'after');
				}
				elseif ($by == "address")
				{
					$this->db->like('address1', $q, 'after');
					$this->db->or_like('address2', $q, 'after');
				}
				elseif ($by == "project")
				{
					$this->db->like('title', $q, 'after');
				}


			}

			if ($this->input->post('position_id') != 0)
			{
				$this->form_validation->set_rules('position_id', 'Position', 'required|strtoupper');
				$position_id = $this->input->post('position_id');
				$this->db->where('manning.position_id', $position_id);

			}

			if ($this->input->post('project_id') != 0)
			{
				$this->form_validation->set_rules('project_id', 'Project', 'required|strtoupper');
				$project_id = $this->input->post('project_id');
				$this->db->where('manning.project_id', $project_id);

			}

			if ($this->input->post('employment_status_id') != 0)
			{
				$this->form_validation->set_rules('employment_status_id', 'Employment Status', 'required|strtoupper');
				$employment_status_id = $this->input->post('employment_status_id');
				$this->db->where('manning.employment_status_id', $employment_status_id);

			}

			if ($this->input->post('dateby') != 0)
			{
				$this->form_validation->set_rules('dateby', 'Date Field', 'required|strtoupper');
				$this->form_validation->set_rules('date_start', 'Date Start', 'required|strtoupper');
				$this->form_validation->set_rules('date_end', 'Date End', 'required|strtoupper');

				$ds = $this->input->post('date_start');
				$de = $this->input->post('date_end');
				$by = $this->input->post('dateby');
				if ($by == "date_of_birth")
				{
					$this->db->where('date_of_birth >=', $ds);
					$this->db->where('date_of_birth <=', $de);
				}
				elseif ($by == "date_hired")
				{
					$this->db->where('date_hired >=', $ds);
					$this->db->where('date_hired <=', $de);
				}
				elseif ($by == "date_renew")
				{
					$this->db->where('date_renew >=', $ds);
					$this->db->where('date_renew <=', $de);
				}
				elseif ($by == "contract_expiry_date")
				{
					$this->db->where('contract_expiry_date >=', $ds);
					$this->db->where('contract_expiry_date <=', $de);
				}
			}

			if ($this->input->post('orderby') != 0)
			{
				$oby = $this->input->post('orderby');
				$ascdesc = $this->input->post('orderbyascdesc');
				$this->db->order_by($oby,$ascdesc);
			}

			//echo $this->data['fields'];

			unset($this->data['pagination']);
			$search = TRUE;
		}



			! $search || $this->db->ar_limit = FALSE;


		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S')
		{
			$this->db->where($filter_user);
		}

		// Fecth all project

		$this->data['employees'] = $this->manning->get_employees('','',$this->data['fields']);
		$this->data['last_query'] = $this->db->last_query();
		// Load view

		//echo $this->data['last_query'];
		$this->load_view('manning/index');

	}


	public function view($id = NULL)
	{
		// Fetch a project or create a new project
		if ($id)
		{
			$this->data['employee'] = $this->manning->get_employees($id);
			// $this->data['cases'] = $this->manning->get_cases($id);
			count($this->data['employee']) || $this->data['errors'][] = 'Employee could not be found';
		}
		else
		{
			redirect(site_url('manning_list/index'));
		}



		// Set up view
		$this->data['page_title'] = 'View Employee Details - ' . $this->data['employee']->firstname . ' ' . $this->data['employee']->lastname ;


		// Load the view
		$this->load_view('manning/view');
	}

	public function export_pdf_excel($id = NULL)
	{

		$this->data['fields'] = $this->input->post('last_fields');

		$limit = 'LIMIT';
		$last_query = explode($limit,$this->input->post('last_query'));
		$this->data['query'] = $this->db->query($last_query[0]);

		$this->data['employees'] = $this->data['query']->result();

		// Set up view
		$this->data['page_title'] = 'Manning List';


		if ($this->input->post('btn_print'))
		{
			ini_set("memory_limit","256M");
			$this->load->library('pdf');
			$this->pdf->set_paper("A4", "landscape");
			$this->pdf->load_view('manning/export_pdf_excel',$this->data);
			$this->pdf->render();
			$this->pdf->stream("manning_list.pdf");
		}

		if ($this->input->post('btn_download'))
		{
			header("Content-type: application/vnd.ms-excel");
        	header("Content-Disposition: attachment;Filename=statistics.xls");
        	$this->load_view('manning/export_pdf_excel');
		}

		//Load the view



	}



	public function print_profile_pdf($id = NULL)
	{

		// Fetch a project or create a new project
		if ($id)
		{
			$this->data['employee'] = $this->manning->get_employees($id);
			count($this->data['employee']) || $this->data['errors'][] = 'Employee could not be found';
		}
		else
		{
			redirect(site_url('manning_list/index'));
		}



		// Set up view
		$this->data['page_title'] = 'JAMMAS Employee Profile';


		// Load the view
		//$this->load_view('manning/print');

		ini_set("memory_limit","256M");
		$this->load->library('pdf');
		$this->pdf->load_view('manning/print_profile',$this->data);
		$this->pdf->render();
		$this->pdf->stream("employee_profile.pdf");

	}

	public function edit($id = NULL)
	{

		// Fetch a project or create a new project
		if ($id)
		{

			$this->data['employee'] = $this->manning->get($id);
			count($this->data['employee']) || $this->data['errors'][] = 'Employee could not be found';
			$this->data['page_title'] = 'Editing Employee - ' . $this->data['employee']->firstname . ' ' . $this->data['employee']->lastname ;
		}
		else
		{
			$this->data['employee'] = $this->manning->get_new();
			$this->data['page_title'] = 'New Employee' . $id;
		}

		// Set up the form
		$rules = $this->manning->rules;
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message('greater_than', 'The %s field is required.');

		// Process the form
		if ($this->form_validation->run() == TRUE)
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->manning->array_from_post(array(
				'employee_no',

				'lastname',
				'firstname',
				'middlename',
				'gender',
				'mobile_no',
				'telephone_no',
				'email',
				'project_id',
				'employment_status_id',
				'position_id',
				'length_of_service',
				'date_hired',
				'date_renew',
				'contract_expiry_date',
				'sss_no',
				'philhealth_no',
				'pagibig_no',
				'tin_no',
				'date_of_birth',
				'age',
				'address1',
				'address2',
				'contract_remarks',
				'rate',
				'daily_rate',
				'semi_monthly_rate',
				'monthly_rate',
				'e_cola',
				'allowance',
				'allowance_mode_of_payment',
				'allowance_remarks',
				'nbi_clearance_date_submitted',
				'police_clearance_date_submitted',
				'brgy_clearance_date_submitted',
				'medical_clearance_date_submitted',
				'drugtest_clearance_date_submitted',
				'mayors_permit_clerance_date_submitted',
				'fit_to_work_date_submitted',
				'xray_date_submitted',
				'date_resigned',
				'insurance_remarks',
				'date_filed_up',
				'remarks',
				)
			);

			if (empty($data['employee_no']))
			{
				$max = str_pad($this->manning->max_proj_id($data['project_id']), 5, 0, STR_PAD_LEFT);
				$data['employee_no'] = 'PRJ-' . str_pad($data['project_id'], 4, '0', STR_PAD_LEFT).'-'. $max;
				// dd($data['employee_no']);
			}


			$this->manning->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[title]</strong> Employee has been updated";
			$this->activity_m->write($message, $this->data['deductions'], $data);

			// redirect to project
			redirect(site_url('manning_list/index'));
		}

		$this->data['projects'] = $this->manning->get_projects();
		$this->data['positions'] = $this->manning->get_positions();
		$this->data['employment_statuses'] = $this->manning->get_employment_statuses();

		// Set up view

		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);




		// Load the view
		$this->load_view('manning/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$employee = $this->manning->get($id, TRUE);

		// process delete
		$this->manning->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> Employee <strong>" . $employee->firstname . " " . $employee->lastname ."</strong>  has been removed";
		$this->activity_m->write($message);

		// redirect to project
		redirect(site_url('manning_list'));
	}


	public function _unique_name($str)
	{
		// Do NOT validate if project already exists
		// UNLESS it's the name for the current project
		$id = $this->uri->segment(2);

		$this->db->where('lastname',$this->input->post('lastname'));
		$this->db->where('firstname',$this->input->post('firstname'));
		!$id || $this->db->where('manning_id !=', $id);

		$employees = $this->manning->get();

		if (count($employees))
		{
			$this->form_validation->set_message('_unique_name', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

	public function _is_unique($str)
	{
		// Do NOT validate if project already exists
		// UNLESS it's the name for the current project
		$id = $this->uri->segment(2);

		$this->db->where('employee_no',$this->input->post('employee_no'));
		!$id || $this->db->where('manning_id !=', $id);

		$employees = $this->manning->get();

		if (count($employees))
		{
			$this->form_validation->set_message('_is_unique', "The %s field is already been used.");
			return FALSE;
		}

		return TRUE;
	}


	public function get_employee()
	{
		$search = $this->input->post('search');

		if( !isset($_POST['search']) )
		{
			$this->db->limit(10);
		}

		$this->db->where("(lastname like '{$search}%' OR firstname like '{$search}%')");
		$search_result = $this->manning->as_dropdown($search,$SyID);

		unset($search_result[0]);
	    $data = array();

	    foreach ($search_result as $key => $value)
	    {
	      $data[] = array(
	      					"id" => $key,
	      					'text' => $value
	      				);
	    }

	    $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
}

/* End of file deduction.php */
/* Location: ./application/controllers/deduction.php */
