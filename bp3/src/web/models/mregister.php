<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_register extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getAllUsers(){
		$query = $this->db->get('user');
		return $query->result(); 
	}

	public function insert($user){
		$this->db->insert('user', $user);
		return $this; 
    }

    public function inserttabelmahasiswa($user){
		$this->db->insert('mahasiswa', $user);
		return $this;
    }
    
    function create($table,$data){
        $query = $this->db->insert($table, $data);
        return $this;// return last insert id
    }
    
    

	public function getUser($id){
		$query = $this->db->get_where('user',array('id'=>$id));
		return $query->row_array();
	}

	public function activate($data, $id){
		$this->db->where('user.id_user', $id);
		return $this->db->update('user', $data);
	}

}
