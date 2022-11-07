<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_film extends CI_Model {

	public function get_film()
	{
		$tm_film=$this->db->join('film_category','film_category.category_code=film.category_code')
		->get('film')->result();
		return $tm_film;
	}
	public function amount_data(){
		return $this->db->get('film')->num_rows();
	}
	public function data_category()
	{
		return $this->db->get('film_category')->result();
	}
	
	
	public function kode_film($judul_film, $lastCounter){
		$lastCounter = sprintf("%03d", $lastCounter);
		$judul_film = $judul_film !=""? ltrim(rtrim($judul_film)): "";
		$wordcount = $judul_film !=""? count(explode(" ", $judul_film)):0;
		$patternvocal = "/[aiueo]/i";  
		if($wordcount > 0){			
			$konsonan = preg_replace($patternvocal, "", $judul_film);
			$arrkons = explode(" ",$konsonan);
			$jmlarrkons = count($arrkons);
			
			if ($jmlarrkons == 1){
			$kode = str_split($konsonan);
			$countCode = count($kode);
			if ($countCode>1){
				$hasil=$kode[0].$kode[1];
			}else{
				$vocal = preg_replace("/[^aiueo]/i", "", $judul_film);
				$hasil = $kode[0].substr($vocal, 0,1);
			}
			
			}    
			elseif($jmlarrkons > 1){
			$kode = explode(" ",$konsonan);
			$countCode = count($kode);
			$hasil = substr($kode[0], 0,1).substr($kode[$countCode-1], 0,1);
			}
		}		
		
		return strtoupper($hasil).$lastCounter;
	}

	public function save_film($nama_file)
	{
		$kd_film = $this->kode_film($this->input->post('film_title'), $this->amount_data()+1);

		if ($nama_file=="") {
				$object=array(
						'kd_film' =>$kd_film,
						'judul_film'=>$this->input->post('film_title'),
						'tgl_launch'=>$this->input->post('tgl_launch'),
						'price'=>$this->input->post('price'),
						'category_code'=>$this->input->post('category'),						
						'writer'=>$this->input->post('writer'),	

					);
			}	else {
				$object=array(
						'kd_film' =>$kd_film,
						'judul_film'=>$this->input->post('film_title'),
						'tgl_launch'=>$this->input->post('tgl_launch'),
						'price'=>$this->input->post('price'),
						'category_code'=>$this->input->post('category'),
						'film_img'=>$nama_file,						
						'writer'=>$this->input->post('writer'),						

					);
			}
			return $this->db->insert('film', $object);
		}

		public function detail($a)
		{
			$tm_film=$this->db->join('film_category', 'film_category.category_code=film.category_code')
			->where('id',$a)
			->get('film')
			->row();
			return $tm_film;
		}

		public function film_update_no_foto()
		{
			$kd_film = $this->kode_film($this->input->post('film_title'), $this->amount_data()+1);
			$object=array(
					'kd_film' =>$kd_film,
					'judul_film'=>$this->input->post('film_title'),
					'tgl_launch'=>$this->input->post('tgl_launch'),
					'price'=>$this->input->post('price'),
					'category_code'=>$this->input->post('category'),
					'film_img'=>$nama_file,						
					'writer'=>$this->input->post('writer'),	
						
				);
			return $this->db->where('id', $this->input->post('film_code'))
							->update('film',$object);

		}
		public function film_update_dengan_foto($nama_foto='')
		{
			$kd_film = $this->kode_film($this->input->post('film_title'), $this->amount_data()+1);
			$object=array(
						'judul_film'=>$this->input->post('film_title'),
						'year'=>$this->input->post('year'),
						'price'=>$this->input->post('price'),
						'category_code'=>$this->input->post('category'),
						'film_img'=>$nama_foto,						
						'writer'=>$this->input->post('writer'),						

					);
			return $this->db->where('id', $this->input->post('film_code'))
							->update('film',$object);

		}
		public function hapus_film($id)
		{
			return $this->db->where('id', $id)->delete('film');
		}

}

/* End of file M_film.php */
/* Location: ./application/models/M_film.php */