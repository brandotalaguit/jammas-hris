<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Case_category extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'case_category';
		$this->data['page_title'] = 'Case Categories';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-primary' href='".base_url('case_category/new')."'><i class='fa fa-plus'></i> New Category</a> <a class='btn btn-primary' href='".base_url('case_category/print')."'><i class='fa fa-print'></i> Print</a>";
		
		$this->load->model('case_categories');
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
		$config['total_rows'] = $this->case_categories->count();
		$config['per_page'] = 15;
		$this->pagination->initialize($config);

		// Create pagination links
		$this->data['pagination'] = $this->pagination->create_links();

		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		if ($this->input->post('btn_action') == 'Search') 
		{
			$this->form_validation->set_rules('search', 'Search', 'required|strtoupper');
			
			$q = $this->input->post('search');
			$by = $this->input->post('by');
			if ($by == "case_category_code") 
			{
				$this->db->like('case_category_code', $q, 'after');
			}
			elseif ($by == "case_category") 
			{
				$this->db->like('case_category', $q, 'after');
			}
			unset($this->data['pagination']);
		}

		// Filter user account per user
		if ($this->session->userdata('AccountType') !== 'S') 
		{
			$this->db->where($filter_user);
		}

		// Fecth all project
		$this->db->order_by('case_category');
		$this->data['case_categories'] = $this->case_categories->get();
		
		// Load view 
		$this->load_view('case_category/index');

	}	

	public function print_pdf($id = NULL)
	{
		
		$this->data['case_categories'] = $this->case_categories->get();

		// Set up view
		$this->data['page_title'] = 'Case Categories';
		

		// Load the view
		
		ini_set("memory_limit","256M");
		$this->load->library('pdf');
		$this->pdf->load_view('case_category/print',$this->data);
		$this->pdf->render();
		$this->pdf->stream("case_category.pdf");
		
	}

	public function edit($id = NULL)
	{
		// Fetch a project or create a new project
		if ($id) 
		{
			$this->data['case_categories'] = $this->case_categories->get($id);
			count($this->data['case_categories']) || $this->data['errors'][] = 'Case Category could not be found';
		}
		else
		{
			$this->data['case_categories'] = $this->case_categories->get_new();
		}

		// Set up the form
		$rules = $this->case_categories->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->case_categories->array_from_post(array(
				'case_category_code', 
				'case_category',
				'remarks'
				)
			);

			
			

			$this->case_categories->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[title]</strong> Deduction Category has been updated";
			$this->activity_m->write($message, $this->data['case_categories'], $data);

			// redirect to project
			redirect(site_url('case_category/index'));
		}


		// Set up view
		$this->data['page_title'] = 'Editing Case Category # ' . $id;
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);


		

		// Load the view
		$this->load_view('case_category/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$case_categories = $this->case_categories->get($id, TRUE);

		// process delete
		$this->case_categories->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$case_categories->case_category</strong> Deduction Category has been removed";
		$this->activity_m->write($message, $project);

		// redirect to project
		redirect(site_url('case_category'));
	}


	public function _unique_title($str)
	{
		// Do NOT validate if project already exists
		// UNLESS it's the name for the current project
		$id = $this->uri->segment(2);
		
		$this->db->where('case_category',$this->input->post('case_category'));
		!$id || $this->db->where('case_category_id !=', $id);

		$case_categories = $this->case_categories->get();

		if (count($case_categories)) 
		{
			$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file case_category.php */
/* Location: ./application/controllers/case_category.php */