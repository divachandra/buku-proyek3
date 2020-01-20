<?php 

class c_login extends CI_Controller{

	function __construct(){
		parent::__construct();		
		
		$this->load->model('m_login');

	}

	function index(){
		
		
		$this->load->view('login');

	}

	function aksi_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => $password
			);
		$cek = $this->m_login->cek_login("user",$where)->num_rows();
		$cekstatus = $this->m_login->cek_login("user",$where)->row_array();
		
		if($cek > 0){
			if ($cekstatus['status_user'] == "aktif") {
				if($cekstatus['role_user'] == "admin"){
					$data_session = array(
						'nama' => $username,
						'id' => $cekstatus['id_user'],
						'statusakun' => $cekstatus['status_user'],
						'status' => "login"
						);
					$this->session->set_userdata($data_session);
	
					redirect(site_url("dashboard"));
				} else if($cekstatus['role_user'] == "dosen"){
					$data_session = array(
						'nama' => $username,
						'id' => $cekstatus['id_user'],
						'statusakun' => $cekstatus['status_user'],
						'status' => "login"
						);
					$this->session->set_userdata($data_session);
	
					redirect(site_url("dashboard/viewdosen"));
				}
			}
			else {
				echo 'akun anda tidak aktif';
			}
		}else if ($cek == 0){
			echo "Akun tidak ada !";
		} else {
			echo "Username dan password salah !";
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(site_url('c_login'));
	}
}