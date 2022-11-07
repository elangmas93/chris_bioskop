<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_transaction extends CI_Model {

	public function tm_transaction()
	{
		return $this->db->get('user')->result();
	}
	public function cek($book_code)
	{
		$cek_stock = $this->db->where('kd_tayang', $book_code)->get('tayang')->row()->jml_kursi;
		if($cek_stock == 0 ){
			return 0;
		}else{
			return 1;
		}
	}

	public function check()
	{
		$cek=1;
		for($i=0;$i<count($this->input->post('rowid'));$i++){		
				$stock = $this->db->where('kd_tayang', $this->input->post('kd_tayang')[$i])
								->get('tayang')
								->row()
								->stock;
				$qty = $this->input->post('qty')[$i];
				$sisa= $stock - $qty;
				if($sisa < 0){
					$oke = 0;
				}else{
					$oke = 1;
				}
				$cek = $oke * $cek;
		}
		return $cek;		
	}

	public function save_cart_db()
	{
		for($i=0; $i<count($this->input->post('rowid')); $i++){
				$stock = $this->db->where('kd_tayang', $this->input->post('kd_tayang')[$i])
								 ->get('tayang')
								 ->row()
								 ->jml_kursi;
				$qty = $this->input->post('qty')[$i];
				$sisa = $stock - $qty;
				$updatestock = array('jml_kursi' => $sisa);
				$this->db->where('kd_tayang', $this->input->post('kd_tayang')[$i])
						 ->update('tayang', $updatestock);
		}

		$object=array(
				'user_code'=>$this->input->post('user_code'),
				'buyer_name'=>$this->input->post('buyer_name'),
				'tgl' => date('Y-m-d'),
				'total'=>$this->input->post('total'),
				'judul_film'=>$this->input->post('bookname'),
				'jml_kursi'=>$this->input->post('book_qty'),

			);
		$this->db->insert('transaction', $object);
		$tm_nota=$this->db->order_by('transaction_code','desc')
						  ->where('user_code', $this->input->post('user_code'))
						  ->limit(1)
						  ->get('transaction')
						  ->row();
		for ($i=0; $i < count($this->input->post('rowid')); $i++) { 
			$hasil[]=array(
					'transaction_code'=>$tm_nota->transaction_code,
					'kd_tayang'=>$this->input->post('kd_tayang')[$i],
					'amount'=>$this->input->post('qty')[$i]
				);
		}

		//$proses=$this->db->insert_batch('transaction_detail',$hasil);
		$proses = true;
		if ($proses) {
			return $tm_nota->transaction_code;

		}else {
			return 0;
		
		}
	}

	public function detail_note($id_nota)
	{
		return $this->db->where('transaction_code', $id_nota)
						->join('user','user.user_code=transaction.user_code')
						->get('transaction')
						->row();
	}
	
	public function detail_transaction($id_nota)
	{
		return $this->db->where('transaction_code', $id_nota)
						->join('tayang', 'tayang.kd_tayang=transaction_detail.kd_tayang')						
						->get('transaction_detail')->result();
	}

}

/* End of file M_transaction.php */
/* Location: ./application/models/M_transaction.php */