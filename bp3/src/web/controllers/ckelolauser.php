<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_kelola_user extends CI_Controller {
    
    function __construct(){
		parent::__construct();
		$this->load->model('m_data_user');
		$this->load->helper('url');
	
		if($this->session->userdata('status') != "login"){
			redirect(site_url("c_login"));
		}
	}
	
	public function index()
	{	
		$data['user'] = $this->m_data_user->tampil_data()->result();
		
		$this->load->view('v_kelola_user',$data);
	}
	

	//start kelola prodi

	public function getProdi()
	{
		$this->output->set_content_type('application/json');
		$employee = $this->m_data_user->getprodiJSON();
		echo json_encode($employee);
	}

	public function saveprodi()
	{
		$input = $this->m_data_user->saveprodi();
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	
	public function updateprodi($id)
	{
		$input = $this->m_data_user->updateprodi($id);
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	public function destroyprodi()
	{
		$id = $_REQUEST['id_prodi'];
		$input = $this->m_data_user->destroyprodi($id);
		if ($input) {
			echo json_encode(array('success'=>true));
		}else {
			echo json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	}

	//end kelola prodi

	//start kelola dosen

	public function getdosen()
	{
		$this->output->set_content_type('application/json');
		$employee = $this->m_data_user->getdosenJSON();
		echo json_encode($employee);
	}

	public function savedosen()
	{
		$input = $this->m_data_user->savedosen();
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	
	public function updatedosen($id)
	{
		$input = $this->m_data_user->updatedosen($id);
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	public function destroydosen()
	{
		$id = $_REQUEST['id_dosen'];
		$input = $this->m_data_user->destroydosen($id);
		if ($input) {
			echo json_encode(array('success'=>true));
		}else {
			echo json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	}

	//end kelola dosen

	//start kelola mahasiswa

	public function getmahasiswa()
	{
		$this->output->set_content_type('application/json');
		$employee = $this->m_data_user->getmahasiswaJSON();
		echo json_encode($employee);
	}

	public function savemahasiswa()
	{
		$input = $this->m_data_user->savemahasiswa();
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	
	public function updatemahasiswa($id)
	{
		$input = $this->m_data_user->updatemahasiswa($id);
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	public function destroymahasiswa()
	{
		$id = $_REQUEST['id_mahasiswa'];
		$input = $this->m_data_user->destroymahasiswa($id);
		if ($input) {
			echo json_encode(array('success'=>true));
		}else {
			echo json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	}

	//end kelola prodi

	//start kelola intern

	public function getintern()
	{
		$this->output->set_content_type('application/json');
		$employee = $this->m_data_user->getinternJSON();
		echo json_encode($employee);
	}

	public function saveintern()
	{
		$input = $this->m_data_user->saveintern();
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	
	public function updateintern($id)
	{
		$input = $this->m_data_user->updateintern($id);
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	public function destroyintern()
	{
		$id = $_REQUEST['id_intern'];
		$input = $this->m_data_user->destroyintern($id);
		if ($input) {
			echo json_encode(array('success'=>true));
		}else {
			echo json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	}

	//start kelola absensi

	public function getabsensi()
	{
		$this->output->set_content_type('application/json');
		$employee = $this->m_data_user->getabsensiJSON();
		echo json_encode($employee);
	}

	public function saveabsensi()
	{
		$input = $this->m_data_user->saveabsensi();
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	
	public function updateabsensi($id)
	{
		$input = $this->m_data_user->updateabsensi($id);
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	public function destroyabsensi()
	{
		$id = $_REQUEST['id_absensi'];
		$input = $this->m_data_user->destroyabsensi($id);
		if ($input) {
			echo json_encode(array('success'=>true));
		}else {
			echo json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	}

	//end kelola absensi

	// start kelola trigger
	public function gettrigger_radius()
	{
		$this->output->set_content_type('application/json');
		$employee = $this->m_data_user->gettrigger_radiusJSON();
		echo json_encode($employee);
	}
	// end kelola trigger

	// start kelola user
    public function getCustomers()
	{
		$this->output->set_content_type('application/json');
		$employee = $this->m_data_user->getCustomers();
		echo json_encode($employee);
	}
	public function getCustomerJSON()
	{
		$this->output->set_content_type('application/json');
		$data = $this->m_data_user->getCustomersJSON();
  		echo json_encode($data);
    }
    
    public function saveCustomer()
	{
		$input = $this->m_data_user->saveCustomer();
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
    }
    
    public function updateCustomer($id)
	{
		$input = $this->m_data_user->updateCustomer($id);
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	public function destroyCustomer()
	{
		$id = intval($_REQUEST['id_user']);
		$input = $this->m_data_user->destroyCustomer($id);
		if ($input) {
			echo json_encode(array('success'=>true));
		}else {
			echo json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	}

	
}
