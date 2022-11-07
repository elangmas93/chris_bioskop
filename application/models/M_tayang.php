<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tayang extends CI_Model {

	public function get_tayang()
	{
		$tm_tayang=$this->db->get('tayang')->result();
		return $tm_tayang;
	}
	public function get_tayang_join()
	{
		$tm_tayang=$this->db->join('film','film.id=tayang.film_id')
		->get('tayang')->result();
		return $tm_tayang;
	}
	public function amount_data(){
		return $this->db->get('tayang')->num_rows();
	}	

	public function kode_tayang($judul_, $lastCounter){

	}
	
	public function save_tayang()
	{	
		$bioskop = explode("~",$this->input->post('bioskop'));
		$kode_bioskop = substr($bioskop[0],0,3);
		$id_bioskop= $bioskop[2];
		$film = explode("~",$this->input->post('film'));
		$kode_film = $film[0];
		$judul_film = $film[1];
		$id_film = $film[2];
		$tanggalstring= new DateTime($this->input->post('tgl_launch'));
		$tanggalstring = $tanggalstring->format("dmYHi");

		$kd_tayang =  $kode_bioskop. $tanggalstring. $kode_film. sprintf("%05d", $this->amount_data()+1);
		$object=array(
				'kd_tayang' =>$kd_tayang,				
				'waktu_tayang'=>$this->input->post('tgl_launch'),
				'judul_film'=>$judul_film,
				'film_id'=>$id_film,
				'bioskop_id'=>$id_bioskop,
				'jml_kursi'=>$this->input->post('jml_kursi')
			);
		
		return $this->db->insert('tayang', $object);
	}

	public function detail($a)
	{
		$tm_tayang=$this->db->join('film','film.id=tayang.film_id')
		->join('bioskop','bioskop.id=tayang.bioskop_id')
		->where('tayang.id',$a)
		->get('tayang')->row();
		return $tm_tayang;
	}

	public function tayang_update_no_foto()
	{
		$kd_tayang =  $kode_bioskop. $tanggalstring. $kode_film. sprintf("%05d", $this->amount_data()+1);
		$object=array(
			'kd_tayang' =>$kd_tayang,				
			'waktu_tayang'=>$this->input->post('tgl_launch'),
			'judul_film'=>$judul_film,
			'film_id'=>$id_film,
			'bioskop_id'=>$id_bioskop,
			'jml_kursi'=>$this->input->post('jml_kursi')
					
			);
		return $this->db->where('tayang_code', $this->input->post('tayang_code'))
						->update('tayang',$object);

	}		
	public function hapus_tayang($id)
	{
		return $this->db->where('id', $id)->delete('tayang');
	}

}

/* End of file M_tayang.php */
/* Location: ./application/models/M_tayang.php */