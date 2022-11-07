<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tayang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_tayang','tayang');
		$this->load->model('m_film','film');
		$this->load->model('m_bioskop','bioskop');
	}
	public function index()
	{
		$this->load->library('pagination');
		$amount_data = $this->tayang->amount_data();
		$data['get_tayang']=$this->tayang->get_tayang();
		$data['film']=$this->film->get_film();
		$data['bioskop']=$this->bioskop->get_bioskop();		
		$data['content']="v_tayang";

		$data['total_rows'] = $amount_data;
		$data['per_page'] = 1;
		$from = $this->uri->segment(3);
		$this->pagination->initialize($data);		
		$data['user'] = $this->tayang->get_tayang($data['per_page'],$from);
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		$this->form_validation->set_rules('tgl_launch', 'tgl_launch', 'trim|required');
		$this->form_validation->set_rules('bioskop', 'bioskop', 'trim|required');
		$this->form_validation->set_rules('film', 'film', 'trim|required');		
		
		
		if ($this->form_validation->run() == TRUE) {
			
				if ($this->tayang->save_tayang('')) {
					$this->session->set_flashdata('message', 'tayang has been added successfully');
				} else {
					$this->session->set_flashdata('message', 'tayang has failed to Add');
				}
			redirect('tayang','refresh');		
		} else {
			$this->session->set_flashdata('message', validation_errors());
			redirect('tayang','refresh');
		}
	}

	public function edit_tayang($id)
	{
		$data=$this->tayang->detail($id);
		echo json_encode($data);
	}

	public function tayang_update()
	{
		if ($this->input->post('save')) {
			if ($_FILES['gambar']['name']=="") {
				if ($this->tayang->tayang_update_no_foto()) {
					$this->session->set_flashdata('message', 'tayang Details has been updated successfully.');
					redirect('tayang');
				} else {
					$this->session->set_flashdata('message', 'Failed to update');
					redirect('tayang');
				}
			} else {
				$config['upload_path'] = './assets/gambar/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']  = '100000000';
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('gambar')){
					$this->session->set_flashdata('message', 'failed to upload');
					redirect('tayang');
				}
				else{
					if ($this->tayang->tayang_update_dengan_foto($this->upload->data("file_name"))) {
						$this->session->set_flashdata('message', 'Updated successfully!');
						redirect('tayang');
					} else {
						$this->session->set_flashdata('message', 'Failed to update');
						redirect('tayang');
					}
				}
			}
		}
	}

	public function hapus($tayang_code='')
	{
		if ($this->tayang->hapus_tayang($tayang_code)) {
			$this->session->set_flashdata('message', 'tayang has been deleted successfully.');
			redirect('tayang','refresh');
		} else {
			$this->session->set_flashdata('message', 'Delete Failed');
			redirect('tayang','refresh');
		}
	}

}

/* End of file tayang.php */
/* Location: ./application/controllers/tayang.php */