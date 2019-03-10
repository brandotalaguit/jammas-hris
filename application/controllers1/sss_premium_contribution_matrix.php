<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SSS_premium_contribution_matrix extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'SSS_premium_contribution_matrix';
		$this->data['page_title'] = 'SSS Premium Contribution Matrix';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-primary' href='".base_url('sss_premium_contribution_matrix/new')."'><i class='fa fa-plus'></i> New Row</a> <a class='btn btn-primary' href='".base_url('sss_premium_contribution_matrix/print')."'><i class='fa fa-print'></i> Print</a>";
		
		$this->load->model('sss_p_c_m');
	}

	public function index()
	{
		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
			$filter_user = array('user_id' => $this->session->userdata('Id'));
			$this->db->where($filter_user);
		}

		// Set up pagination 
		$config['total_rows'] = $this->sss_p_c_m->count();
		$config['per_page'] = 15;
		$this->pagination->initialize($config);

		// Create pagination links
		$this->data['pagination'] = $this->pagination->create_links();

		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		if ($this->input->post('btn_action') == 'Search') 
		{
			$this->form_validation->set_rules('search', 'Search', 'required|to_decimal');
			
			$q = to_decimal($this->input->post('search'));
			
			$this->db->where($q . ' between salary_range_start and salary_range_end','',FALSE);

			unset($this->data['pagination']);

			
		}
		

		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
			$this->db->where($filter_user);
		}

		// Fecth all row
		
		$this->data['sss_matrix'] = $this->sss_p_c_m->get();
		
		// Load view 
		$this->load_view('sss_premium_contribution_matrix/index');

	}	

	public function print_pdf($id = NULL)
	{
		
		$this->data['sss_matrix'] = $this->sss_p_c_m->get();

		// Set up view
		$this->data['page_title'] = 'SSS Premium Contribution Matrix';
		

		// Load the view
		
		ini_set("memory_limit","256M");
		$this->load->library('pdf');
		//$this->pdf->set_paper("A4", "landscape");
		$this->pdf->load_view('sss_premium_contribution_matrix/print',$this->data);
		$this->pdf->render();
		$this->pdf->stream("sss_premium_contribution_matrix.pdf");
		
	}

	public function edit($id = NULL)
	{
		// Fetch a project or create a new project
		if ($id) 
		{
			$this->data['sss_matrix'] = $this->sss_p_c_m->get($id);
			count($this->data['sss_matrix']) || $this->data['errors'][] = 'SSS Matrix Row ID could not be found';
		}
		else
		{
			$this->data['sss_matrix'] = $this->sss_p_c_m->get_new();
		}

		// Set up the form
		$rules = $this->sss_p_c_m->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->sss_p_c_m->array_from_post(array(
				'salary_range_start', 
				'salary_range_end',
				'monthly_salary_credit',
				'employee_share',
				'employer_share',
				'employee_compensation_program',
				'total_monthly_premium',
				'remarks',
				)
			);

			
			$this->sss_p_c_m->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> SSS Matrix has been updated";
			$this->activity_m->write($message, $this->data['sss_matrix'], $data);

			// redirect to project
			redirect(site_url('sss_premium_contribution_matrix/index'));
		}

		
		// Set up view
		$this->data['page_title'] = 'Editing SSS Matrix Row ID # ' . $id;
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);


		

		// Load the view
		$this->load_view('sss_premium_contribution_matrix/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$sss_matrix = $this->sss_p_c_m->get($id, TRUE);

		// process delete
		$this->sss_p_c_m->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i>  SSS Matrix Row ID <strong>$sss_matrix->ppc_id</strong> has been removed";
		$this->activity_m->write($message, $project);

		// redirect to project
		redirect(site_url('sss_premium_contribution_matrix'));
	}


	// public function _unique_range($str)
	// {
	// 	// Do NOT validate if project already exists
	// 	// UNLESS it's the name for the current project
	// 	$id = $this->uri->segment(2);
		
	// 	$this->db->where('deduction_category',$this->input->post('deduction_category'));
	// 	!$id || $this->db->where('deduction_category_id !=', $id);

	// 	$deductions = $this->deductions->get();

	// 	if (count($deductions)) 
	// 	{
	// 		$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
	// 		return FALSE;
	// 	}

	// 	return TRUE;
	// }

}

/* End of file deduction.php */
/* Location: ./application/controllers/deduction.php */