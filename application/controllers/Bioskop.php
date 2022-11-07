<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bioskop extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_bioskop','bioskop');
	}
	public function index()
	{
		$this->load->library('pagination');
		$amount_data = $this->bioskop->amount_data();
		$data['get_bioskop']=$this->bioskop->get_bioskop();		
		$data['content']="v_bioskop";

		$data['total_rows'] = $amount_data;
		$data['per_page'] = 1;
		$from = $this->uri->segment(3);
		$this->pagination->initialize($data);		
		$data['user'] = $this->bioskop->get_bioskop($data['per_page'],$from);

		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		$this->form_validation->set_rules('bioskop_title', 'bioskop_title', 'trim|required');		
		$this->form_validation->set_rules('alamat_bioskop', 'alamat_bioskop', 'trim|required');
		$this->form_validation->set_rules('kota', 'kota', 'trim|required');
		
		
		if ($this->form_validation->run() == TRUE) {		
			
			if ($this->bioskop->save_bioskop('')) {
				$this->session->set_flashdata('message', 'bioskop has been added successfully');
			} else {
				$this->session->set_flashdata('message', 'bioskop has failed to Add');
			}
			redirect('bioskop','refresh');
		}
	
	}

	public function edit_bioskop($id)
	{
		$data=$this->bioskop->detail($id);
		echo json_encode($data);
	}

	public function bioskop_update()
	{
		if ($this->input->post('save')) {
			
			if ($this->bioskop->bioskop_update_no_foto()) {
				$this->session->set_flashdata('message', 'bioskop Details has been updated successfully.');
				redirect('bioskop');
			} else {
				$this->session->set_flashdata('message', 'Failed to update');
				redirect('bioskop');
			}
		
		}
	}

	public function hapus($id='')
	{
		if ($this->bioskop->hapus_bioskop($id)) {
			$this->session->set_flashdata('message', 'bioskop has been deleted successfully.');
			redirect('bioskop','refresh');
		} else {
			$this->session->set_flashdata('message', 'Delete Failed');
			redirect('bioskop','refresh');
		}
	}

}

/* End of file bioskop.php */
/* Location: ./application/controllers/bioskop.php */