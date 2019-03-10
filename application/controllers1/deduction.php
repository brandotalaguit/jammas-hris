<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deduction extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'deduction';
		$this->data['page_title'] = 'Deductions';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-primary' href='".base_url('deduction/new')."'><i class='fa fa-plus'></i> New Deduction</a> <button class='btn btn-primary' name='btn_print' type='submit' value='Search'>Print <span class='fa fa-print'></span></button>";
		
		$this->load->model('deductions');
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
		$this->data['employees'] = $this->deductions->get_employees();
		$this->data['deduction_categories'] = $this->deductions->get_deduction_categories();

		// Set up pagination 
		$config['total_rows'] = $this->deductions->count();
		$config['per_page'] = 15;
		$this->pagination->initialize($config);

		// Create pagination links
		$this->data['pagination'] = $this->pagination->create_links();

		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		if ($this->input->post('btn_search') == 'Search') 
		{

			if ($this->input->post('date_filter') != 0) 
			{
				$this->form_validation->set_rules('date_start', 'Date Start', 'required|strtoupper');
				$this->form_validation->set_rules('date_end', 'Date End', 'required|strtoupper');
				
				$ds = $this->input->post('date_start');
				$de = $this->input->post('date_end');

				if($this->input->post('date_filter') == 1)
				{
					$this->db->where('date_filed >=', $ds);
					$this->db->where('date_filed <=', $de);	
				}	
				
				if($this->input->post('date_filter') == 2)
				{
					$this->db->where('coverage_date_start >=', $ds);
					$this->db->where('coverage_date_start <=', $de);	
				}	

				if($this->input->post('date_filter') == 3)
				{
					$this->db->where('coverage_date_end >=', $ds);
					$this->db->where('coverage_date_end <=', $de);	
				}	

				unset($this->data['pagination']);
			}
					
		
			if ($this->input->post('employee_id') != 0) 
			{
				$this->form_validation->set_rules('employee_id', 'Employee', 'required|strtoupper');
				$employee_id = $this->input->post('employee_id');
				$this->db->where('deductions.employee_id', $employee_id);
				
			}

			if ($this->input->post('deduction_category_id') != 0) 
			{
				$this->form_validation->set_rules('deduction_category_id', 'Deduction Category', 'required|strtoupper');
				$deduction_category_id = $this->input->post('deduction_category_id');
				$this->db->where('deductions.deduction_category_id', $deduction_category_id);
				
			}


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
		$this->db->order_by('date_filed DESC');
		$this->data['deductions'] = $this->deductions->get_deductions();
		$this->data['last_query'] = $this->db->last_query();
		
		// Load view 
		$this->load_view('deduction/index');

	}	

	public function print_pdf($id = NULL)
	{
		$limit = 'LIMIT';
		$last_query = explode($limit,$this->input->post('last_query'));
		$this->data['query'] = $this->db->query($last_query[0]);

		$this->data['deductions'] = $this->data['query']->result();

		// Set up view
		$this->data['page_title'] = 'Deductions';
		
		
		//Load the view
		
		ini_set("memory_limit","256M");
		$this->load->library('pdf');
		$this->pdf->set_paper("A4", "landscape");
		$this->pdf->load_view('deduction/print',$this->data);
		$this->pdf->render();
		$this->pdf->stream("deduction.pdf");
		
	}

	public function edit($id = NULL)
	{
		// Fetch a project or create a new project
		if ($id) 
		{
			$this->data['deductions'] = $this->deductions->get($id);
			count($this->data['deductions']) || $this->data['errors'][] = 'Deduction could not be found';
		}
		else
		{
			$this->data['deductions'] = $this->deductions->get_new();
		}

		// Set up the form
		$rules = $this->deductions->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->deductions->array_from_post(array(
				'employee_id', 
				'deduction_category_id',
				'date_filed',
				'coverage_date_start',
				'coverage_date_end',
				'payment_type',
				'percentage',
				'fixed_amount',
				'mode_of_payment',
				'remarks',
				)
			);

			
			$this->deductions->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[title]</strong> Deduction has been updated";
			$this->activity_m->write($message, $this->data['deductions'], $data);

			// redirect to project
			redirect(site_url('deduction/index'));
		}

		$this->data['employees'] = $this->deductions->get_employees();
		$this->data['deduction_categories'] = $this->deductions->get_deduction_categories();

		// Set up view
		$this->data['page_title'] = 'Editing Deduction # ' . $id;
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);


		

		// Load the view
		$this->load_view('deduction/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$deductions = $this->deductions->get($id, TRUE);

		// process delete
		$this->deductions->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$deductions->deduction_category</strong> Deduction has been removed";
		$this->activity_m->write($message, $project);

		// redirect to project
		redirect(site_url('deduction'));
	}


	public function _unique_title($str)
	{
		// Do NOT validate if project already exists
		// UNLESS it's the name for the current project
		$id = $this->uri->segment(2);
		
		$this->db->where('deduction_category',$this->input->post('deduction_category'));
		!$id || $this->db->where('deduction_category_id !=', $id);

		$deductions = $this->deductions->get();

		if (count($deductions)) 
		{
			$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file deduction.php */
/* Location: ./application/controllers/deduction.php */