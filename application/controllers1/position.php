<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'position';
		$this->data['page_title'] = 'Positions';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="ion ion-android-star"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-danger' href='".base_url('position/new')."'><i class='fa fa-plus'></i> New Position</a>";
		
		$this->load->model('positions');
	}

	public function index()
	{
		// Set up pagination 
		$config['total_rows'] = $this->positions->count();
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
			if ($by == "Position") 
			{
				$this->db->like('position', $q, 'after');
			}
			elseif ($by == "Remarks") 
			{
				$this->db->like('remarks', $q, 'after');
			}
			unset($this->data['pagination']);
		}

		// Fecth all position
		$this->db->order_by('position_code');
		$this->data['positions'] = $this->positions->get();
		
		// Load view 
		$this->load_view('position/index');

	}	

	public function add_new()
	{
		// Fetch a position 
		$this->data['position'] = $this->positions->get_new();

		// Set up the form 
		$rules = $this->positions->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			
			$data = $this->positions->array_from_post(['position_code', 'position', 'remarks', 'created_at']);

			$this->positions->save($data);

			// save log
			$message = "<i class='fa fa-plus'></i> Position <strong>$data[position]</strong> has been added";
			$this->activity_m->write($message, NULL, $data);

			// redirect to position
			redirect(site_url('position/index'));
		}

		// Set up view
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('position/edit');
		
	}

	public function edit($id = NULL)
	{
		// Fetch a position or create a new position
		if ($id) 
		{
			$this->data['position'] = $this->positions->get($id);
			count($this->data['position']) || $this->data['errors'][] = 'Position could not be found';
		}
		else
		{
			$this->data['position'] = $this->positions->get_new();
		}

		// Set up the form
		$rules = $this->positions->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			$data = $this->positions->array_from_post(['position_code', 'position', 'remarks', 'updated_at']);

			$this->positions->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[position]</strong> Position has been updated";
			$this->activity_m->write($message, $this->data['position'], $data);

			// redirect to position
			redirect(site_url('position/index'));
		}


		// Set up view
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('position/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$position = $this->positions->get($id, TRUE);

		// process delete
		$this->positions->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$position->position</strong> Position has been removed";
		$this->activity_m->write($message, $position);

		// redirect to position
		redirect(site_url('position'));
	}


	public function _unique_position($str)
	{
		// Do NOT validate if position already exists
		// UNLESS it's the name for the current position
		$id = $this->uri->segment(2);
		
		$this->db->where('position',$this->input->post('position'));
		!$id || $this->db->where('position_id !=', $id);

		$position = $this->positions->get();

		if (count($position)) 
		{
			$this->form_validation->set_message('_unique_position', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

	public function _unique_position_code($str)
	{
		// Do NOT validate if position already exists
		// UNLESS it's the name for the current position
		$id = $this->uri->segment(2);
		
		$this->db->where('position_code', $this->input->post('position_code'));
		!$id || $this->db->where('position_id !=', $id);

		$position = $this->positions->get();

		if (count($position)) 
		{
			$this->form_validation->set_message('_unique_position_code', "%s is already exists in the database.");
			return FALSE;
		}

		return TRUE;
	}	

}

/* End of file position.php */
/* Location: ./application/controllers/position.php */