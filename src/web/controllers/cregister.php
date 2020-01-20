<?php 

class c_register extends CI_Controller{

	function __construct(){
		parent::__construct();		
		
		#$this->load->model('m_login');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('m_register');
		$this->data['user'] = $this->m_register->getAllUsers();

	}

	function index(){
		
		
		$this->load->view('v_register',$this->data);

	}

	public function register(){
		#$this->form_validation->set_rules('email', 'Email', 'valid_email|required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[30]');
        #$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) { 
         	$this->load->view('v_register', $this->data);
		}
		else{
			//get user inputs
			
			$npm = $this->input->post('npm');
			$nama = $this->input->post('nama');
			$kelas = $this->input->post('kelas');
			$prodi = $this->input->post('prodi');
			$angkatan = $this->input->post('angkatan');
			$foto = $this->input->post('foto');
			$username = $this->input->post('nama');
			$password = $this->input->post('password');
			$email = $this->input->post('email');

			//generate simple random code
			$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code = substr(str_shuffle($set), 0, 12);

			//insert user to users table and get id
			$mahasiswa['id_mahasiswa'] = $npm;
			$mahasiswa['nama_mahasiswa'] = $nama;
			$mahasiswa['kelas_mahasiswa'] = $kelas;
			$mahasiswa['id_prodi_mahasiswa'] = $prodi;
			$mahasiswa['angkatan_mahasiswa'] = $angkatan;
			$mahasiswa['foto_mahasiswa'] = $foto;

			$user['id_user'] = $npm;
			$user['username'] = $username;
			$user['password'] = $password;
			
			$user['code'] = $code;
			$user['status_user'] = 'tidak aktif';
			$user['role_user'] = 'mahasiswa';
			
			$input = $this->m_register->create('user',$user);
			$input2 = $this->m_register->create('mahasiswa',$mahasiswa);
			$id = $npm;
			#$id = $user['id_user'];
			
			$this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = 'assets/images/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
		$image_name=$npm.'.png'; //buat name dari qr code sesuai dengan nim
		$link = site_url("c_register/activate/".$id."/".$code."");
 
        $params['data'] = $link; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $gambarqr= $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE


			//set up email
			$config = array(
		  		'protocol' => 'smtp',
		  		'smtp_host' => 'ssl://smtp.googlemail.com',
		  		'smtp_port' => 465,
		  		'smtp_user' => 'chandrakiranapoetracendana@gmail.com', // change it to yours
		  		'smtp_pass' => 'Code1157', // change it to yours
		  		'mailtype' => 'html',
		  		'charset' => 'iso-8859-1',
		  		'wordwrap' => TRUE
			);

			$message = 	'
						<html>
						<head>
							<title>Verification Code</title>
						</head>
						<body>
							<h2>Thank you for Registering.</h2>
							<p>Your Account:</p>
							<p>Email: '.$email.'</p>
							<p>Password: '.$password.'</p>
							<p>Gambar QR : '.$gambarqr.'</p>
							<img src="cid:'.$image_name.'" border="0">
	                        <img src='.$gambarqr.'>
							<p>Please click the link below to activate your account.</p>
							<h4><a href="'.base_url().'c_register/activate/'.$id.'/'.$code.'">Activate My Account</a></h4>
						</body>
						</html>
						';
	 		
		    $this->load->library('email', $config);
		    $this->email->set_newline("\r\n");
		    $this->email->from($config['smtp_user']);
			$this->email->to($email);
			$this->email->attach($gambarqr, "inline");
		    $this->email->subject('Signup Verification Email');
			$this->email->message($message);
			
			

		    //sending email
		    if($this->email->send()){
		    	$this->session->set_flashdata('message','Activation code sent to email');
		    }
		    else{
		    	$this->session->set_flashdata('message', $this->email->print_debugger());
	 
		    }

        	redirect('c_register');
		}
	}
	public function activate(){
		$id =  $this->uri->segment(3);
		$code = $this->uri->segment(4);

		//fetch user details
		$user = $this->m_register->getUser($id);

		//if code matches
		if($user['code'] == $code){
			//update user active status
			$data['status_user'] = 'aktif';
			$query = $this->m_register->activate($data, $id);

			if($query){
				$this->session->set_flashdata('message', 'User activated successfully');
			}
			else{
				$this->session->set_flashdata('message', 'Something went wrong in activating account');
			}
		}
		else{
			$this->session->set_flashdata('message', 'Cannot activate account. Code didnt match');
		}

		redirect('c_register');

	}

	
}