<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('pdf');
		$this->load->model('m_data_peta');
		$this->load->model('m_data_user');
		$this->load->helper('url');
	
		if($this->session->userdata('status') != "login"){
			redirect(site_url("c_login"));
		}
	}

	public function index()
	{
		
		$data['data_prodi'] = $this->m_data_user->getprodidropdownn()->result();
		$data['totaldosen'] = $this->m_data_user->getjumlahdosenJSON();
		$data['totaldoseninternal'] = $this->m_data_user->getjumlahdoseninternalJSON();
		$data['gettahunangkatan'] = $this->m_data_user->gettahunangkatan()->result();
		$data['totalmahasiswa2015'] = $this->m_data_user->getjumlahmahasiswa2015();
		$data['totalmahasiswa2016'] = $this->m_data_user->getjumlahmahasiswa2016();
		$data['totalmahasiswa2017'] = $this->m_data_user->getjumlahmahasiswa2017();
		$data['totalmahasiswa'] = $this->m_data_user->getjumlahmahasiswaJSON();
		$data['totallokasiinternship'] = $this->m_data_user->getjumlahlokasiinternshipJSON();
		$data['totaluser'] = $this->m_data_user->getjumlahuserJSON();
		$data['data_mahasiswa'] = $this->m_data_user->getdata_mahasiswa()->result();
		$data['data_dosen'] = $this->m_data_user->getdata_dosen()->result();
		$data['data_user'] = $this->m_data_user->getdata_user()->result();
		$data['data_intern'] = $this->m_data_user->getintern()->result();
		
		
		$this->load->view('index',$data);
	}

	function perorang(){
		//$x['data']=$this->m_grafik->get_data_stok();
		$id = $this->input->post('npmmahasiswa');
		$x['jan']=$this->m_data_user->get_data_jan($id);
		$x['feb']=$this->m_data_user->get_data_feb($id);
		$x['mar']=$this->m_data_user->get_data_mar($id);
		$x['apr']=$this->m_data_user->get_data_apr($id);
		$x['may']=$this->m_data_user->get_data_may($id);
		$x['jun']=$this->m_data_user->get_data_june($id);
		$x['jul']=$this->m_data_user->get_data_july($id);
		$x['aug']=$this->m_data_user->get_data_aug($id);
		$x['sep']=$this->m_data_user->get_data_sep($id);
		$x['oct']=$this->m_data_user->get_data_oct($id);
		$x['nov']=$this->m_data_user->get_data_nov($id);
		$x['dec']=$this->m_data_user->get_data_dec($id);
		$this->load->view('v_grafik',$x);
	}

	function viewdosen(){
		$data['data_prodi'] = $this->m_data_user->getprodidropdownn()->result();
		$data['totaldosen'] = $this->m_data_user->getjumlahdosenJSON();
		$data['totaldoseninternal'] = $this->m_data_user->getjumlahdoseninternalJSON();
		$data['gettahunangkatan'] = $this->m_data_user->gettahunangkatan()->result();
		$data['totalmahasiswa2015'] = $this->m_data_user->getjumlahmahasiswa2015();
		$data['totalmahasiswa2016'] = $this->m_data_user->getjumlahmahasiswa2016();
		$data['totalmahasiswa2017'] = $this->m_data_user->getjumlahmahasiswa2017();
		$data['totalmahasiswa'] = $this->m_data_user->getjumlahmahasiswaJSON();
		$data['totallokasiinternship'] = $this->m_data_user->getjumlahlokasiinternshipJSON();
		$data['totaluser'] = $this->m_data_user->getjumlahuserJSON();
		$data['data_mahasiswa'] = $this->m_data_user->getdata_mahasiswa()->result();
		$data['data_dosen'] = $this->m_data_user->getdata_dosen()->result();
		$data['data_user'] = $this->m_data_user->getdata_user()->result();
		$data['data_intern'] = $this->m_data_user->getintern()->result();
		$this->load->view('dosen',$data);
	}

	/// start kelola halaman dosen

	//start kelola profile dosen

	

	public function getprofiledosen()
	{
		
		$this->output->set_content_type('application/json');
		$id_pengguna = $this->session->userdata("id");
		$employee = $this->m_data_user->getprofiledosenJSON($id_pengguna);
		echo json_encode($employee);
	}
	
	public function updateprofiledosen($id)
	{
		$input = $this->m_data_user->updatprofiledosentabledosen($id);
		$input2 = $this->m_data_user->updatprofiledosentableuser($id);
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	
	//end kelola profile dosen

	//start view dosen mahasiswa
	
	public function getdosenmahasiswa()
	{
		
		$this->output->set_content_type('application/json');
		$id_pengguna = $this->session->userdata("id");
		$employee = $this->m_data_user->getdosenmahasiswa($id_pengguna);
		echo json_encode($employee);
	}

	//end view dosen mahasiswa

	//start kelola dosen intern

	public function getdosenintern()
	{
		$this->output->set_content_type('application/json');
		$id_pengguna = $this->session->userdata("id");
		$employee = $this->m_data_user->getdoseninternJSON($id_pengguna);
		echo json_encode($employee);
	}
	
	public function updatedosenintern($id)
	{
		$input = $this->m_data_user->updatedosenintern($id);
		if ($input) {
			echo json_encode(['success' => true]);
		}else {
			echo json_encode(['Msg'=>'Some Error occured!.']);
		}
	}
	
	// end kelola dosen intern

	//end kelola halaman dosen
	
	//start kelola absensi halaman dosen

	public function getabsensimahasiswahalamandosenJSON()
	{
		$this->output->set_content_type('application/json');
		$id_pengguna = $this->session->userdata("id");
		$employee = $this->m_data_user->getabsensimahasiswahalamandosenJSON($id_pengguna);
		echo json_encode($employee);
	}

	public function getmahasiswauntukdosenJSON()
	{
		$this->output->set_content_type('application/json');
		$id_pengguna = $this->session->userdata("id");
		$data = $this->m_data_user->getmahasiswauntukdosenJSON($id_pengguna);
  		echo json_encode($data);
    }

	//end kelola absensi halaman dosen
	public function buatpdfprodi(){
        $pdf = new FPDF('l','mm','A5');
		// membuat halaman baru
		date_default_timezone_set('US/Eastern');
		$currentdate = date("m-d-Y");
		
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'Laporan Daftar Prodi',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,$currentdate,0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'ID Prodi',1,0);
        $pdf->Cell(85,6,'Nama Prodi',1,1);
        $pdf->SetFont('Arial','',10);
        $mahasiswa = $this->db->get('prodi')->result();
        foreach ($mahasiswa as $row){
            $pdf->Cell(20,6,$row->id_prodi,1,0);
            $pdf->Cell(85,6,$row->nama_prodi,1,1);
        }
        $pdf->Output();
	}

	public function buatpdfuser(){
        $pdf = new FPDF('l','mm','A5');
		// membuat halaman baru
		date_default_timezone_set('US/Eastern');
		$currentdate = date("m-d-Y");
		
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'Laporan Daftar user',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,$currentdate,0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'ID user',1,0);
		$pdf->Cell(25,6,'Username',1,0);
		$pdf->Cell(25,6,'Password',1,0);
		$pdf->Cell(25,6,'Status',1,0);
		$pdf->Cell(25,6,'Role',1,1);
        $pdf->SetFont('Arial','',10);
        $mahasiswa = $this->db->get('user')->result();
        foreach ($mahasiswa as $row){
            $pdf->Cell(20,6,$row->id_user,1,0);
			$pdf->Cell(25,6,$row->username,1,0);
			$pdf->Cell(25,6,$row->password,1,0);
			$pdf->Cell(25,6,$row->status_user,1,0);
			$pdf->Cell(25,6,$row->role_user,1,1);
        }
        $pdf->Output();
	}

	public function buatpdfdosen(){
        $pdf = new FPDF('l','mm','A5');
		// membuat halaman baru
		date_default_timezone_set('US/Eastern');
		$currentdate = date("m-d-Y");
		
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'Laporan Daftar dosen',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,$currentdate,0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(20,6,'ID Dosen',1,0);
		$pdf->Cell(70,6,'Nama Dosen',1,0);
		$pdf->Cell(15,6,'Prodi ',1,0);
		#$pdf->Cell(70,6,'Foto',1,0);
		$pdf->Cell(25,6,'Status',1,1);
        $pdf->SetFont('Arial','',10);
        $mahasiswa = $this->db->get('dosen')->result();
        foreach ($mahasiswa as $row){
			$pdf->Cell(20,6,$row->id_dosen,1,0);
			$pdf->Cell(70,6,$row->nama_dosen,1,0);
			$pdf->Cell(15,6,$row->id_prodi_dosen,1,0);
			##$pdf->Cell(70,6,$row->foto_dosen,1,0);
			$pdf->Cell(25,6,$row->status,1,1);
        }
        $pdf->Output();
	}
	
	public function buatpdfmahasiswa(){
        $pdf = new FPDF('l','mm','A5');
		// membuat halaman baru
		date_default_timezone_set('US/Eastern');
		$currentdate = date("m-d-Y");
		
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'Laporan Daftar mahasiswa',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,$currentdate,0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,6,'ID mahasiswa',1,0);
		$pdf->Cell(40,6,'Nama ',1,0);
		$pdf->Cell(15,6,'Kelas ',1,0);
		$pdf->Cell(15,6,'Prodi',1,0);
		#$pdf->Cell(20,6,'Foto',1,0);
		$pdf->Cell(25,6,'Angkatan',1,1);

		
        $pdf->SetFont('Arial','',10);
        $mahasiswa = $this->db->get('mahasiswa')->result();
        foreach ($mahasiswa as $row){
			$pdf->Cell(30,6,$row->id_mahasiswa,1,0);
			$pdf->Cell(40,6,$row->nama_mahasiswa,1,0);
			#$pdf->Cell(20,6,$row->foto_mahasiswa,1,0);
			$pdf->Cell(15,6,$row->kelas_mahasiswa,1,0);
			$pdf->Cell(15,6,$row->id_prodi_mahasiswa,1,0);						
			$pdf->Cell(25,6,$row->angkatan_mahasiswa,1,1);
        }
        $pdf->Output();
	}

	public function buatpdfintern(){
        $pdf = new FPDF('l','mm','A5');
		// membuat halaman baru
		date_default_timezone_set('US/Eastern');
		$currentdate = date("m-d-Y");
		
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'Laporan Daftar intern',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,$currentdate,0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(20,6,'ID Intern',1,0);
		$pdf->Cell(25,6,'ID Koor Intern',1,0);
		$pdf->Cell(20,6,'Status',1,0);
		$pdf->Cell(40,6,'Tanggal Mulai ',1,0);
		$pdf->Cell(40,6,'Tanggal Berakhir',1,1);
        $pdf->SetFont('Arial','',10);
        $mahasiswa = $this->db->get('intern')->result();
        foreach ($mahasiswa as $row){
			$pdf->Cell(20,6,$row->id_intern,1,0);
			$pdf->Cell(25,6,$row->id_koor_intern,1,0);
			$pdf->Cell(20,6,$row->status_intern,1,0);
			$pdf->Cell(40,6,$row->tgl_mulai_intern,1,0);
			$pdf->Cell(40,6,$row->tgl_akhir_intern,1,1);
        }
        $pdf->Output();
	}

	public function getaddress($lat,$lng)
  	{
		
		#hapus pagar pada lat dan lng kemudian ubah return jadi echo
		#$lat = "-6.873656";
		#$lng = "107.575550";
		$url = 'https://us1.locationiq.com/v1/reverse.php?key=1e2358be8ca540&lat='.$lat.'&lon='.$lng.'&format=json';

		$json = @file_get_contents($url);
		$data=json_decode($json,true);
		$status = $data['display_name'];
		if(isset($status))
		{
		return $status;
		}
		else
		{
		return false;
		}
  	}

	public function buatpdfabsensi(){
        $pdf = new FPDF('l','mm','A3');
		// membuat halaman baru
		date_default_timezone_set('US/Eastern');
		$currentdate = date("m-d-Y");
		
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'Laporan Daftar absensi',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,$currentdate,0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(15,6,'Absensi',1,0);
		$pdf->Cell(15,6,'Intern',1,0);
		$pdf->Cell(20,6,'Mahasiswa',1,0);
		$pdf->Cell(20,6,'Dosen ',1,0);
		$pdf->Cell(140,6,'Lokasi',1,0);
		#$pdf->Cell(45,6,'Longitude',1,0);
		$pdf->Cell(20,6,'Jarak',1,0);
		$pdf->Cell(25,6,'Tanggal',1,0);
		$pdf->Cell(20,6,'Kegiatan',1,0);
		$pdf->Cell(25,6,'IMEI',1,1);
		$pdf->SetFont('Arial','',10);
		$this->db->distinct();
		$this->db->select('a.id_absensi,a.id_intern_absensi,a.id_mahasiswa_absensi,a.id_dosen_absensi,
		a.latitude_absensi,a.longitude_absensi,a.tgl_waktu_absensi,a.imei_perangkat_absensi,a.kegiatan_absensi
		,b.pergeseran_absensi ');
		$this->db->from('absensi a'); 
		$this->db->join('detail_absensi b', 'b.id_mahasiswa_dt_absensi=a.id_mahasiswa_absensi', 'inner');     
		$mahasiswa = $this->db->get('absensi')->result(); 
		
		
        foreach ($mahasiswa as $row){
			$pdf->Cell(15,6,$row->id_absensi,1,0);
			$pdf->Cell(15,6,$row->id_intern_absensi,1,0);
			$pdf->Cell(20,6,$row->id_mahasiswa_absensi,1,0);
			$pdf->Cell(20,6,$row->id_dosen_absensi,1,0);
			$lat =$row->latitude_absensi;
			$long = $row->longitude_absensi;
			$pdf->Cell(140,6,$this->getaddress($lat,$long),1,0);
			$pdf->Cell(20,6,$this->getstatusjarak($row->pergeseran_absensi),1,0);
			$pdf->Cell(25,6,$row->tgl_waktu_absensi,1,0);
			$pdf->Cell(20,6,$row->kegiatan_absensi,1,0);
			$pdf->Cell(25,6,$row->imei_perangkat_absensi,1,1);
        }
        $pdf->Output();
	}

	public function getstatusjarak($pergeseran_absensi){
		if($pergeseran_absensi > 20){
			return 'out spot';
		} else {
			return 'on the spot';
		}
	}

	function buatlaporangrafik($id){
        $x['data']=$this->m_data_user->get_data_stok($id);
        $this->load->view('chart_view',$x);
    }
	
}
