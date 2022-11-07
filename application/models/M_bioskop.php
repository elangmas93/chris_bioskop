<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bioskop extends CI_Model {

	public function get_bioskop()
	{
		$tm_bioskop=$this->db->get('bioskop')->result();
		return $tm_bioskop;
	}
	public function amount_data(){
		return $this->db->get('bioskop')->num_rows();
	}	
	
	public function kode_bioskop($judul_bioskop, $lastCounter){
		$lastCounter = sprintf("%03d", $lastCounter);
		$judul_bioskop = $judul_bioskop !=""? ltrim(rtrim($judul_bioskop)): "";
		$wordcount = $judul_bioskop !=""? count(explode(" ", $judul_bioskop)):0;
		$patternvocal = "/[aiueo]/i";  
		if($wordcount > 0){			
			$konsonan = preg_replace($patternvocal, "", $judul_bioskop);
			$arrkons = explode(" ",$konsonan);
			$jmlarrkons = count($arrkons);
			
			if ($jmlarrkons == 1){
				$kode = str_split($konsonan);
				$countCode = count($kode);
				$half_length = $countCode / 2;
				$median_index = (int) $half_length;
				if ($countCode > 1){
					$hasil=$kode[0].$kode[$median_index].$kode[$countCode-1];
				}else{
					$vocal = preg_replace("/[^aiueo]/i", "", $judul_bioskop);
					$hasil = $kode[0].substr($vocal, 0,1);
				}			
			}    
			elseif($jmlarrkons > 1){
				$kode = explode(" ",$konsonan);
				$countCode = count($kode);
				if($countCode<=2){
					$half_length = $countCode / 2;
					$median_index = (int) $half_length;
					$hasil = substr($kode[0], 0,1).substr($kode[$median_index], 0,1).substr($kode[$countCode-1], 0,1);				
				}else{					
					$hasil = substr($kode[0], 0,1).substr($kode[$countCode-1], 0,1);
				}
			}
		}		
		
		return strtoupper($hasil).$lastCounter;
	}

	public function save_bioskop($nama_file)
	{
		$kd_bioskop = $this->kode_bioskop($this->input->post('bioskop_title'), $this->amount_data()+1);

		$object=array(
				'kd_bioskop' =>$kd_bioskop,
				'nama_bioskop'=>$this->input->post('bioskop_title'),
				'alamat_bioskop'=>$this->input->post('alamat_bioskop'),
				'kota'=>$this->input->post('kota')				
			);
		
		return $this->db->insert('bioskop', $object);
	}

	public function detail($a)
	{
		$tm_bioskop=$this->db->where('id',$a)
		->get('bioskop')
		->row();
		return $tm_bioskop;
	}

	public function bioskop_update_no_foto()
	{
		$kd_bioskop = $this->kode_bioskop($this->input->post('bioskop_title'), $this->amount_data()+1);
		$object=array(
			'kd_bioskop' =>$kd_bioskop,
			'nama_bioskop'=>$this->input->post('bioskop_title'),
			'alamat_bioskop'=>$this->input->post('alamat_bioskop'),
			'kota'=>$this->input->post('kota')		
					
			);
		return $this->db->where('kd_bioskop', $this->input->post('bioskop_code'))
						->update('bioskop',$object);

	}		
	public function hapus_bioskop($id)
	{
		return $this->db->where('id', $id)->delete('bioskop');
	}

}

/* End of file M_bioskop.php */
/* Location: ./application/models/M_bioskop.php */