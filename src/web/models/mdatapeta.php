<?php 

class M_data_peta extends CI_Model{
	function tampil_data(){
		return $this->db->get('absensi');
	}
}