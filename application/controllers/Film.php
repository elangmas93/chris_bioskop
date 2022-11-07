<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Film extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('m_film','film');
	}
	public function index()
	{
		$this->load->library('pagination');
		$amount_data = $this->film->amount_data();
		$data['get_film']=$this->film->get_film();
		$data['category']=$this->film->data_category();
		$data['content']="v_film";

		$data['total_rows'] = $amount_data;
		$data['per_page'] = 1;
		$from = $this->uri->segment(3);
		$this->pagination->initialize($data);		
		$data['user'] = $this->film->get_film($data['per_page'],$from);

		$data['test_kode'] = $this->film->kode_film('Hai', 5);

		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		$this->form_validation->set_rules('film_title', 'film_title', 'trim|required');
		$this->form_validation->set_rules('tgl_launch', 'tgl_launch', 'trim|required');
		$this->form_validation->set_rules('price', 'price', 'trim|required');
		$this->form_validation->set_rules('category', 'category', 'trim|required');
		
		
		if ($this->form_validation->run() == TRUE) {
			$config['upload_path'] = './assets/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			if ($_FILES['gambar']['name']!="") {
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('gambar')){
				$this->session->set_flashdata('message', $this->upload->display_errors());
				redirect('film','refresh');
			}
			else{
				if ($this->film->save_film($this->upload->data('file_name'))) {
					$this->session->set_flashdata('message', 'film has been added successfully');
				} else {
					$this->session->set_flashdata('message', 'film has failed to Add');
				}
				redirect('film','refresh');
			}
		} else {
			if ($this->film->save_film('')) {
				$this->session->set_flashdata('message', 'film has been added successfully');
			} else {
				$this->session->set_flashdata('message', 'film has failed to Add');
			}
			redirect('film','refresh');
		}
	} else {
		$this->session->set_flashdata('message', validation_errors());
		redirect('film','refresh');
	}
}

	public function edit_film($id)
	{
		$data=$this->film->detail($id);
		echo json_encode($data);
	}

	public function film_update()
	{
		if ($this->input->post('save')) {
			if ($_FILES['gambar']['name']=="") {
				if ($this->film->film_update_no_foto()) {
					$this->session->set_flashdata('message', 'film Details has been updated successfully.');
					redirect('film');
				} else {
					$this->session->set_flashdata('message', 'Failed to update');
					redirect('film');
				}
			} else {
				$config['upload_path'] = './assets/gambar/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']  = '100000000';
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('gambar')){
					$this->session->set_flashdata('message', 'failed to upload');
					redirect('film');
				}
				else{
					if ($this->film->film_update_dengan_foto($this->upload->data("file_name"))) {
						$this->session->set_flashdata('message', 'Updated successfully!');
						redirect('film');
					} else {
						$this->session->set_flashdata('message', 'Failed to update');
						redirect('film');
					}
				}
			}
		}
	}

	public function hapus($film_code='')
	{
		if ($this->film->hapus_film($film_code)) {
			$this->session->set_flashdata('message', 'film has been deleted successfully.');
			redirect('film','refresh');
		} else {
			$this->session->set_flashdata('message', 'Delete Failed');
			redirect('film','refresh');
		}
	}

}

/* End of file film.php */
/* Location: ./application/controllers/film.php */