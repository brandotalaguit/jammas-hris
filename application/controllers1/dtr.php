<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dtr extends Admin_Controller 
{
	function __construct() 
	{
		parent::__construct();		
		$this->data['controller'] = 'dtr';
		$this->data['page_title'] = 'Daily Time Records';
		$this->data['page_subtitle'] = '';
		$this->data['icon'] = '<i class="fa fa-gears"></i>';
		$this->data['page_btn_add'] = "<a class='btn btn-danger' href='".base_url('dtr/new')."'><i class='fa fa-plus'></i> New Dtr</a>";
		
		$this->load->library('excel');

		$this->load->model('projects');
		$this->load->model('project_employees');
	}

	public function download_dtr($project_id)
	{
		$project = $this->projects->get($project_id);
		$project_employees = $this->project_employees->get_by(['project_id' => $project_id], FALSE);
	    $total_personnel = count($project_employees);

		$box = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			),
			'aligment' => array(
				'wrap' => TRUE,
				'Horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
			),
			'autosize' => TRUE
		);

		$sheet = 0;

			// Add new sheet
		   $objWorkSheet = $this->excel->createSheet($sheet); //Setting index when creating

		   $this->excel->setActiveSheetIndex(0);

		   // Set column properties
		   $objWorkSheet->getStyle('A:A')->getAlignment()->setWrapText(true);
		   $objWorkSheet->getStyle('B:B')->getAlignment()->setWrapText(true);
		   $objWorkSheet->getStyle('C:C')->getAlignment()->setWrapText(true);
		   $objWorkSheet->getStyle('D:D')->getAlignment()->setWrapText(true);
		   $objWorkSheet->getStyle('E:E')->getAlignment()->setWrapText(true);
		   $objWorkSheet->getStyle('F:F')->getAlignment()->setWrapText(true);

		   
		   foreach (range('D', 'F') as $column)
		   {
			   $objWorkSheet->getColumnDimension($column)->setWidth(10);
		   }
		   foreach (range('G', 'Z') as $column) 
		   {
			   $objWorkSheet->getColumnDimension($column)->setWidth(9);
		   }

		   $objWorkSheet->getRowDimension('2')->setRowHeight(60);
		   $objWorkSheet->getStyle("A1:AB" . ($total_personnel + 3))->applyFromArray($box);

		   $objWorkSheet
				   ->mergeCells('A1:F1')
		           ->mergeCells('A2:C2')
				   ->mergeCells('G1:J1')
				   ->mergeCells('K1:P1')
				   ->mergeCells('Q1:V1')
				   ->mergeCells('W1:AB1');

		   //Write cells
		   $objWorkSheet
				   ->setCellValue('A1', 'PERIOD: Jan 01 - 15, 2014')
				   ->setCellValue('G1', 'FIRST 8 HRS - DAY')
				   ->setCellValue('K1', 'FIRST 8 HRS - NIGHT')
				   ->setCellValue('Q1', 'OT EXCESS OF 8HRS - DAY')
				   ->setCellValue('W1', 'OT EXCESS OF 8HRS - NIGHT')

		           ->setCellValue('A2', 'NAME')
		           ->setCellValue('D2', 'TOTAL HOURS RENDERED')
		           ->setCellValue('E2', 'UNDER TIME / LATE (MINS)')
		           ->setCellValue('F2', 'ABSENT (HRS)')		           

		           ->setCellValue('G2', 'RD')
		           ->setCellValue('H2', 'SH')
		           ->setCellValue('I2', 'SH & RD')
		           ->setCellValue('J2', 'LH & RD')

		           ->setCellValue('K2', 'NSD')
		           ->setCellValue('L2', 'RD')
		           ->setCellValue('M2', 'SH')
		           ->setCellValue('N2', 'SH & RD')
		           ->setCellValue('O2', 'LH')
		           ->setCellValue('P2', 'LH & RD')

		           ->setCellValue('Q2', 'REG')
		           ->setCellValue('R2', 'RD')
		           ->setCellValue('S2', 'SH')
		           ->setCellValue('T2', 'SH & RD')
		           ->setCellValue('U2', 'LH')
		           ->setCellValue('V2', 'LH & RD')

		           ->setCellValue('W2', 'REG')
		           ->setCellValue('X2', 'RD')
		           ->setCellValue('Y2', 'SH')
		           ->setCellValue('Z2', 'SH & RD')
		           ->setCellValue('AA2', 'LH')
		           ->setCellValue('AB2', 'LH & RD');
		    
		    $row = 3;
		    $col = 3;

			foreach ($project_employees as $personnel) 
			{
				$employee = $this->employees->get($personnel->employee_id);
				$objWorkSheet->setCellValue('A' . $row, $employee->lastname . ', ' . $employee->firstname . ' ' . $employee->middlename)->mergeCells("A$row:C$row");
				$objWorkSheet->setCellValue('D' . $row, $row + 1);
				$objWorkSheet->setCellValue('E' . $row, $row + 2);
				$objWorkSheet->setCellValue('F' . $row, $row + 3);
				$row++;
			}

		    $objWorkSheet->mergeCells('A' . $row . ':' . 'C' . $row);
		    
		    // total
		    $row++;
		    $objWorkSheet->mergeCells('A' . $row . ':' . 'C' . $row)->setCellValue('A' . $row, 'TOTAL');
			$objWorkSheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(14);
			
			$formula_hrs_rendered = '=SUM(D3:D' . ($total_personnel + 2) . ')';
			$objWorkSheet->setCellValue('D' . $row, $formula_hrs_rendered);
			$formula_undertime_late = '=SUM(E3:E' . ($total_personnel + 2) . ')';
			$objWorkSheet->setCellValue('E' . $row, $formula_undertime_late);
			$formula_absent = '=SUM(F3:F' . ($total_personnel + 2) . ')';
			$objWorkSheet->setCellValue('F' . $row, $formula_absent);
		    
			// Rename sheet
			$objWorkSheet->setTitle("Summary");

			// $sheet++;

			$this->excel->removeSheetByIndex(1);

		//  Get the current sheet with all its newly-set style properties
		$baseWorkSheet = clone $objWorkSheet;
		$baseWorkSheet->setTitle('Copied0');

		// clone baseWorkSheet
		$this->excel->addSheet($baseWorkSheet);		


		// create new sheet
		$baseWorkSheet = $this->excel->createSheet();
		$baseWorkSheet->setTitle('Base Work Sheet');


		$style = 
			[
				'font' => 
					[
						'bold'	=> FALSE,
						'italic'=> FALSE,
						'size'	=> 10
					],
				'alignment' => 
					[
						'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'		=> FALSE
					]
			];

		$baseWorkSheet->getStyle('A2')->applyFromArray($style);
		$baseWorkSheet->getStyle('U2')->applyFromArray($style);
		$baseWorkSheet->getStyle('A3')->applyFromArray($style);
		$baseWorkSheet->getStyle('U3')->applyFromArray($style);
		$baseWorkSheet->getStyle('A4')->applyFromArray($style);
		$baseWorkSheet->getStyle('U4')->applyFromArray($style);
		
		$dtr_title = $style;
		$dtr_title['font']['bold'] = TRUE;
		$dtr_title['font']['size'] = 14;
		$dtr_title['borders']['bottom']['style'] = PHPExcel_Style_Border::BORDER_THICK;

		$baseWorkSheet->getStyle('C2:H2')->applyFromArray($dtr_title);
		$baseWorkSheet->getStyle('W2:AA2')->applyFromArray($dtr_title);
		$baseWorkSheet->getStyle('C3:H3')->applyFromArray($dtr_title);
		$baseWorkSheet->getStyle('W3:AA3')->applyFromArray($dtr_title);
		$baseWorkSheet->getStyle('C4:H4')->applyFromArray($dtr_title);
		$baseWorkSheet->getStyle('W4:AA4')->applyFromArray($dtr_title);
		
		// header
		$baseWorkSheet
			->setCellValue('A2', 'PROPERTY NAME:')
			->setCellValue('C2', $project->title)
			->setCellValue('U2', 'PERIOD COVERED:')
			->setCellValue('W2', 'Dec. 1-15, 2013')
			->setCellValue('A3', 'AGENCY NAME:')
			->setCellValue('C3', 'JAMMAS Inc.')
			->setCellValue('U3', 'POSITION:')
			->setCellValue('W3', '')
			->setCellValue('A4', 'PERSONNEL NAME :')
			->setCellValue('C4', '')
			->setCellValue('U4', 'MONTHLY CONTRACT RATE:')
			->setCellValue('W4', '');

		$column_style = $style;
		$column_style['font']['size'] = 8;
		$column_style['font']['bold'] = TRUE;
		$column_style['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_THIN;
		$column_style['alignment']['wrap'] = TRUE;
		$column_style['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;

		$baseWorkSheet->getStyle('A6:AI6')->applyFromArray($column_style);
		$baseWorkSheet->getStyle('A7:AI7')->applyFromArray($column_style);
		
		$baseWorkSheet
			->mergeCells('B6:E6')
			->mergeCells('F6:J6')
			->mergeCells('M6:Q6')
			->mergeCells('R6:W6')
			->mergeCells('X6:AC6')
			->mergeCells('AD6:AI6')
			->mergeCells('K6:K7')
			->mergeCells('L6:L7');

		// column name
		$baseWorkSheet
			->setCellValue('A6', 'DTR NO.')
			->setCellValue('B6', 'WORK SCHEDULE')
			->setCellValue('F6', 'ACTUAL LOGS')
			->setCellValue('K6', 'UNDER TIME / LATE (MINS)')
			->setCellValue('L6', 'ABSENT (HRS)')
			->setCellValue('M6', 'FIRST 8 HRS - DAY')
			->setCellValue('R6', 'FIRST 8 HRS - NIGHT')
			->setCellValue('X6', 'OT EXCESS OF 8HRS - DAY')
			->setCellValue('AD6', 'OT EXCESS OF 8HRS - NIGHT')
			
			->setCellValue('B7', 'IN')
			->setCellValue('C7', 'PM/AM')
			->setCellValue('D7', 'OUT')
			->setCellValue('E7', 'PM/AM')
			->setCellValue('F7', 'IN')
			->setCellValue('G7', 'PM/AM')
			->setCellValue('H7', 'OUT')
			->setCellValue('I7', 'PM/AM')
			->setCellValue('J7', 'HOURS RENDERED')

			->setCellValue('M7', 'RD')
			->setCellValue('N7', 'SH')
			->setCellValue('O7', 'SH & RD')
			->setCellValue('P7', 'LH')
			->setCellValue('Q7', 'LH & RD')
			->setCellValue('R7', 'NSD')
			->setCellValue('S7', 'RD')
			->setCellValue('T7', 'SH')
			->setCellValue('U7', 'SH & RD')
			->setCellValue('V7', 'LH')
			->setCellValue('W7', 'LH & RD')
			->setCellValue('X7', 'REG')
			->setCellValue('Y7', 'RD')
			->setCellValue('Z7', 'SH')
			->setCellValue('AA7', 'SH & RD')
			->setCellValue('AB7', 'LH')
			->setCellValue('AC7', 'LH & RD')
			->setCellValue('AD7', 'REG')
			->setCellValue('AE7', 'RD')
			->setCellValue('AF7', 'SH')
			->setCellValue('AG7', 'SH & RD')
			->setCellValue('AH7', 'LH')
			->setCellValue('AI7', 'LH & RD');

		for ($i=8; $i <= 24 ; $i++) 
		{ 
			$baseWorkSheet
				->setCellValue('A'.$i, $i-7)
				->setCellValue('B'.$i, '')
				->setCellValue('C'.$i, 'AM')
				->setCellValue('D'.$i, '')
				->setCellValue('E'.$i, 'PM')
				->setCellValue('F'.$i, '')
				->setCellValue('G'.$i, 'AM')
				->setCellValue('H'.$i, '')
				->setCellValue('I'.$i, 'PM');
		}

		$baseWorkSheet->getStyle("A8:AI$i")->applyFromArray($column_style);
		$baseWorkSheet->getStyle("B8:AI$i")->getNumberFormat()->setFormatCode('[h]:mm:ss');
		
		$rowCtr = 1;

		// Get the project employee, position and rates
		$this->db->order_by('position,lastname, firstname, middlename');
		$project_epr = $this->project_employees->get_employee_position_rate($project_id);
		// dump($this->db->last_query());
		foreach ($project_epr as $personnel) 
		{
			$name = $personnel->lastname . ", " . $personnel->firstname . " " . $personnel->middlename;
			//  Get the current sheet with all its newly-set style properties
			$cloneWorkSheet = clone $baseWorkSheet;
			$cloneWorkSheet->setTitle($personnel->employee_id . '-' . $name);

			// clone baseWorkSheet
			$this->excel->addSheet($cloneWorkSheet);
			$cloneWorkSheet
				->setCellValue('W3', $personnel->position)
				->setCellValue('C4', $name);
			
		}

		// excel implements zero index
		$this->excel->removeSheetByIndex(2);

		

		// $this->excel->setActiveSheetIndex(0);

		$filename = str_replace(' ', '-', $project->title) . date('-m-d-y-H-i-s') . '.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

		// $this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		// Set up pagination 
		$config['total_rows'] = $this->projects->count();
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
			if ($by == "Title") 
			{
				$this->db->like('title', $q, 'after');
			}
			elseif ($by == "Description") 
			{
				$this->db->like('description', $q, 'after');
			}
			unset($this->data['pagination']);
		}

		// Fecth all dtr
		$this->data['projects'] = $this->projects->get();
		
		// Load view 
		$this->load_view('dtr/index');

	}	

	public function add_new()
	{
		// Fetch a dtr 
		$this->data['projects'] = $this->projects->get_new();

		// Set up the form 
		$rules = $this->projects->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->projects->array_from_post(array(
				'title', 
				'description',
				'user_id',
				'created_at')
			);

			$this->projects->save($data);

			// save log
			$message = "<i class='fa fa-plus'></i> Dtr <strong>$data[title]</strong> has been added";
			$this->activity_m->write($message, NULL, $data);

			// redirect to dtr
			redirect(site_url('dtr/index'));
		}

		// Set up view
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('dtr/edit');
		
	}

	public function edit($id = NULL)
	{
		// Fetch a dtr or create a new dtr
		if ($id) 
		{
			$this->data['projects'] = $this->projects->get($id);
			count($this->data['projects']) || $this->data['errors'][] = 'Dtr could not be found';
		}
		else
		{
			$this->data['projects'] = $this->projects->get_new();
		}

		// Set up the form
		$rules = $this->projects->rules;
		$this->form_validation->set_rules($rules);

		// Process the form
		if ($this->form_validation->run() == TRUE) 
		{
			// store user id
			$_POST['user_id'] = $this->session->userdata('Id');

			$data = $this->projects->array_from_post(array(
				'title', 
				'description',
				'updated_at')
			);

			$this->projects->save($data, $id);

			// save log
			$message = "<i class='fa fa-pencil'></i> <strong>$data[title]</strong> Dtr has been updated";
			$this->activity_m->write($message, $this->data['dtr'], $data);

			// redirect to dtr
			redirect(site_url('dtr/index'));
		}


		// Set up view
		$attribute = ['class' =>'form-horizontal', 'role' => 'form'];
		$this->data['form_url'] = form_open(NULL, $attribute);

		// Load the view
		$this->load_view('dtr/edit');
	}

	public function delete($id = NULL)
	{
		// fetch data
		$dtr = $this->projects->get($id, TRUE);

		// process delete
		$this->projects->delete($id);

		// save log
		$message = "<i class='fa fa-times'></i> <strong>$dtr->title</strong> Dtr has been removed";
		$this->activity_m->write($message, $dtr);

		// redirect to dtr
		redirect(site_url('dtr'));
	}


	public function _unique_title($str)
	{
		// Do NOT validate if dtr already exists
		// UNLESS it's the name for the current dtr
		$id = $this->uri->segment(2);
		
		$this->db->where('title',$this->input->post('title'));
		!$id || $this->db->where('project_id !=', $id);

		$dtr = $this->projects->get();

		if (count($dtr)) 
		{
			$this->form_validation->set_message('_unique_title', "%s is already exists in the list.");
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file dtr.php */
/* Location: ./application/controllers/dtr.php */