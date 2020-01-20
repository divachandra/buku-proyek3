<?php 

class m_data_user extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
        $this->load->database()
        ;
	}
    
    function tampil_data(){
		return $this->db->get('user');
    }
    
    //get all data mahasiswa

    public function getdata_mahasiswa(){
    
        return $this->db->get('mahasiswa');
    }

    //get data intern
    public function getintern(){
        $this->db->where('status_intern','berjalan');
        
        
        return $this->db->get('intern');
    }
    
    //get all data dosen

    public function getdata_dosen(){
    
        return $this->db->get('dosen');
    }
    public function getdata_user(){
    
        return $this->db->get('user');
    }
    
    

    //get jumlah dosen eksternal
    public function getjumlahdosenJSON(){
        
        $this->db->where('status','eksternal');
        
        return $this->db->get('dosen')->num_rows();
    }

    //get jumlah dosen internal
    public function getjumlahdoseninternalJSON(){
        
        $this->db->where('status','internal');
        
        return $this->db->get('dosen')->num_rows();
    }
    //get jumlah dosen

    public function gettahunangkatan(){
        
        $this->db->select('angkatan_mahasiswa');
        $this->db->distinct();
        $this->db->order_by("angkatan_mahasiswa", "asc");

        return $this->db->get('mahasiswa');
    }

    //get jumlah mahasiswa 2015
    public function getjumlahmahasiswa2015(){
        
        $this->db->where('angkatan_mahasiswa','2015');
        
        return $this->db->get('mahasiswa')->num_rows();
    }
    //get jumlah mahasiswa

    //get jumlah mahasiswa 2016
    public function getjumlahmahasiswa2016(){
        
        $this->db->where('angkatan_mahasiswa','2016');
        
        return $this->db->get('mahasiswa')->num_rows();
    }
    //get jumlah mahasiswa

    //get jumlah mahasiswa 2017
    public function getjumlahmahasiswa2017(){
        
        $this->db->where('angkatan_mahasiswa','2017');
        
        return $this->db->get('mahasiswa')->num_rows();
    }
    //get jumlah mahasiswa

    //get jumlah mahasiswa
    public function getjumlahmahasiswaJSON(){
        
        $query = $this->db->get('mahasiswa');
        if($query->num_rows()>0)
        {
        return $query->num_rows();
        }
        else
        {
        return 0;
        }
    }
    //get jumlah mahasiswa

    //get jumlah intern
    public function getjumlahlokasiinternshipJSON(){
        
        $query = $this->db->get('intern');
        if($query->num_rows()>0)
        {
        return $query->num_rows();
        }
        else
        {
        return 0;
        }
    }
    //get jumlah intern
    
    //get jumlah user
    public function getjumlahuserJSON(){
        $this->db->where('status_user','aktif');
        $query = $this->db->get('user');
        if($query->num_rows()>0)
        {
        return $query->num_rows();
        }
        else
        {
        return 0;
        }
    }
    //get jumlah user

    public function getCustomers()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'user.id_user';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_customer']) ? strval($_POST['search_customer']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('user')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from user
            where concat(id_user,username,password,status_user,role_user)  like '%$search%' order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    
    public function getCustomersJSON(){
        
        
        $query = $this->db->get('absensi');

        // Return associative data array
        return $query->result_array();
    }

    

    //start prodi 
    public function getprodiJSON(){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'prodi.id_prodi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_prodi']) ? strval($_POST['search_prodi']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('prodi')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from prodi
            where concat(id_prodi,'',nama_prodi)  like '%$search%' order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    public function saveprodi()
    {
        $data = [
            'id_prodi' => $this->input->post('id_prodi'),
            'nama_prodi' => $this->input->post('nama_prodi'),
        ];
        $this->db->insert('prodi',$data);
        return $this;
    }

    public function updateprodi($id)
    {
        $data =  [
            
            'nama_prodi' => $this->input->post('nama_prodi'),
            
        ];

        $this->db->where('id_prodi',$id);
        $this->db->set($data);
        return $this->db->update('prodi');
    }

    public function destroyprodi($id_prodi)
    {
        $this->db->where('id_prodi',$id_prodi);
        return $this->db->delete('prodi');
        // return $this->db->delete($this->table,['id' => $id]);
    }

    //end prodi


    //start dosen 
    public function getdosenJSON(){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'dosen.id_dosen';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_dosen']) ? strval($_POST['search_dosen']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('dosen')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from dosen
            where concat(id_dosen,nama_dosen,id_prodi_dosen,foto_dosen,status)  like '%$search%' order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    public function savedosen()
    {
        $data = [
            'id_dosen' => $this->input->post('id_dosen'),
            'nama_dosen' => $this->input->post('nama_dosen'),
            'id_prodi_dosen' => $this->input->post('id_prodi_dosen'),
            'foto_dosen' => $this->input->post('foto_dosen'),
            'status' => $this->input->post('status'),
        ];
        $this->db->insert('dosen',$data);
        return $this;
    }

    public function updatedosen($id)
    {
        $data =  [
            
            'nama_dosen' => $this->input->post('nama_dosen'),
            'id_prodi_dosen' => $this->input->post('id_prodi_dosen'),
            'foto_dosen' => $this->input->post('foto_dosen'),
            'status' => $this->input->post('status'),
            
        ];

        $this->db->where('id_dosen',$id);
        $this->db->set($data);
        return $this->db->update('dosen');
    }

    public function destroydosen($id_dosen)
    {
        $this->db->where('id_dosen',$id_dosen);
        return $this->db->delete('dosen');
        // return $this->db->delete($this->table,['id' => $id]);
    }

    //end dosen

    //start mahasiswa 
    public function getmahasiswaJSON(){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'mahasiswa.id_mahasiswa';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_mahasiswa']) ? strval($_POST['search_mahasiswa']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('mahasiswa')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from mahasiswa
            where concat(id_mahasiswa,nama_mahasiswa,kelas_mahasiswa,id_prodi_mahasiswa,angkatan_mahasiswa,foto_mahasiswa)  like '%$search%' order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    public function savemahasiswa()
    {
        $data = [
            'id_mahasiswa' => $this->input->post('id_mahasiswa'),
            'nama_mahasiswa' => $this->input->post('nama_mahasiswa'),
            'kelas_mahasiswa' => $this->input->post('kelas_mahasiswa'),
            'id_prodi_mahasiswa' => $this->input->post('id_prodi_mahasiswa'),
            'angkatan_mahasiswa' => $this->input->post('angkatan_mahasiswa'),
            'foto_mahasiswa' => $this->input->post('foto_mahasiswa'),
        ];
        $this->db->insert('mahasiswa',$data);
        return $this;
    }

    public function updatemahasiswa($id)
    {
        $data =  [
            
            'nama_mahasiswa' => $this->input->post('nama_mahasiswa'),
            'kelas_mahasiswa' => $this->input->post('kelas_mahasiswa'),
            'id_prodi_mahasiswa' => $this->input->post('id_prodi_mahasiswa'),
            'angkatan_mahasiswa' => $this->input->post('angkatan_mahasiswa'),
            'foto_mahasiswa' => $this->input->post('foto_mahasiswa'),
            
        ];

        $this->db->where('id_mahasiswa',$id);
        $this->db->set($data);
        return $this->db->update('mahasiswa');
    }

    public function destroymahasiswa($id_mahasiswa)
    {
        $this->db->where('id_mahasiswa',$id_mahasiswa);
        return $this->db->delete('mahasiswa');
        // return $this->db->delete($this->table,['id' => $id]);
    }

    //end mahasiswa

    //start intern 
    public function getinternJSON(){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'intern.id_intern';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_intern']) ? strval($_POST['search_intern']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('intern')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from intern
            where concat(id_intern,id_koor_intern,status_intern,tgl_mulai_intern,tgl_akhir_intern)  like '%$search%' order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    public function saveintern()
    {   
        $tanggal_mulai = $this->input->post('tgl_mulai_intern');
        $tanggal_mulai = $this->input->post('tgl_akhir_intern');
        $formattanggalmulai = date("YYYY-MM-DD hh:mm:ss", strtotime($tanggal_mulai));
        $formattanggalakhir = date("YYYY-MM-DD hh:mm:ss", strtotime($tanggal_mulai));
        

        $data = [
            'id_intern' => $this->input->post('id_intern'),
            'id_koor_intern' => $this->input->post('id_koor_intern'),
            'status_intern' => $this->input->post('status_intern'),
            'tgl_mulai_intern' => $formattanggalmulai,
            'tgl_akhir_intern' => $formattanggalakhir,
        ];
        $this->db->insert('intern',$data);
        return $this;
    }

    public function updateintern($id)
    {
        $tanggal_mulai = $this->input->post('tgl_mulai_intern');
        $tanggal_mulai = $this->input->post('tgl_akhir_intern');
        $formattanggalmulai = date("YYYY-MM-DD hh:mm:ss", strtotime($tanggal_mulai));
        $formattanggalakhir = date("YYYY-MM-DD hh:mm:ss", strtotime($tanggal_mulai));

        $data =  [
            'id_koor_intern' => $this->input->post('id_koor_intern'),
            'status_intern' => $this->input->post('status_intern'),
            'tgl_mulai_intern' => $formattanggalmulai,
            'tgl_akhir_intern' => $formattanggalakhir,
        ];

        $this->db->where('id_intern',$id);
        $this->db->set($data);
        return $this->db->update('intern');
    }

    public function destroyintern($id_intern)
    {
        $this->db->where('id_intern',$id_intern);
        return $this->db->delete('intern');
        // return $this->db->delete($this->table,['id' => $id]);
    }

    //end intern

    //start absensi 
    public function getabsensiJSON(){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'absensi.id_absensi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_absensi']) ? strval($_POST['search_absensi']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('absensi')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from absensi
            where concat(id_absensi,id_intern_absensi,id_mahasiswa_absensi,id_dosen_absensi,latitude_absensi,longitude_absensi,tgl_waktu_absensi,imei_perangkat_absensi,foto_absensi)  like '%$search%' order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    
    
    public function saveabsensi()
    {
        $data = [
            
            'id_absensi' => $this->input->post('id_absensi'),
            'id_intern_absensi' => $this->input->post('id_intern_absensi'),
            'id_mahasiswa_absensi' => $this->input->post('id_mahasiswa_absensi'),
            'id_dosen_absensi' => $this->input->post('id_dosen_absensi'),
            'latitude_absensi' => $this->input->post('latitude_absensi'),
            'longitude_absensi' => $this->input->post('longitude_absensi'),
            'tgl_waktu_absensi' => $this->input->post('tgl_waktu_absensi')  ,
            'imei_perangkat_absensi' => $this->input->post('imei_perangkat_absensi'),
            'kegiatan_absensi' => $this->input->post('kegiatan_absensi'),
            'foto_absensi' => $this->input->post('foto_absensi'),
            
        
        ];
        
        return $this->db->insert('absensi',$data);
    }

    public function updateabsensi($id)
    {
        $data =  [
            
            'id_intern_absensi' => $this->input->post('id_intern_absensi'),
            'id_mahasiswa_absensi' => $this->input->post('id_mahasiswa_absensi'),
            'id_dosen_absensi' => $this->input->post('id_dosen_absensi'),
            'latitude_absensi' => $this->input->post('latitude_absensi'),
            'longitude_absensi' => $this->input->post('longitude_absensi'),
            'tgl_waktu_absensi' => $this->input->post('tgl_waktu_absensi')  ,
            'imei_perangkat_absensi' => $this->input->post('imei_perangkat_absensi'),
            'kegiatan_absensi' => $this->input->post('kegiatan_absensi'),
            'foto_absensi' => $this->input->post('foto_absensi'),
        ];
        $this->db->where('id_absensi',$id);
        $this->db->set($data);
        return $this->db->update('absensi');
    }

    public function destroyabsensi($id_absensi)
    {
        $this->db->where('id_absensi',$id_absensi);
        return $this->db->delete('absensi');
        // return $this->db->delete($this->table,['id' => $id]);
    }

    //end absensi

    //start trigger_radius

    public function gettrigger_radiusJSON(){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'trigger_radius.id_trigger';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_trigger_radius']) ? strval($_POST['search_trigger_radius']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('trigger_radius')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from trigger_radius
            where concat(id_trigger,'',id_intern,'','id_absensi','radius')  like '%$search%' order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }

    //end trigger_radius

    public function saveCustomer()
    {
        $data = [
            'id_user' => $this->input->post('id_user'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'status_user' => $this->input->post('status_user'),
            'role_user' => $this->input->post('role_user'),
            
        
        ];
        $this->db->insert('user',$data);
        return $this;
    }

    public function updateCustomer($id)
    {
        $data =  [
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'status_user' => $this->input->post('status_user'),
            'role_user' => $this->input->post('role_user'),
        ];

        $this->db->where('id_user',$id);
        $this->db->set($data);
        return $this->db->update('user');
    }

    public function destroyCustomer($id_user)
    {
        $this->db->where('id_user',$id_user);
        return $this->db->delete('user');
        // return $this->db->delete($this->table,['id' => $id]);
    }

    // get data untuk dropdown
    function getprodidropdownn(){
		$query = $this->db->query('SELECT * FROM prodi');
        return $query;
    }
    
    function get_data_stok($id){
        $query = $this->db->query("SELECT id_mahasiswa,COUNT(id_mahasiswa) AS kegiatan,datetime_absensi FROM absensi WHERE DATE_FORMAT(datetime_absensi, '%M') = '$id'");
          
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    //start laporan per mahasiswa

    function get_data_jan($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='January' AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_feb($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='February' AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_mar($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='March' AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_apr($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='April' AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_may($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='May' AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_june($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='June' AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_july($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='July' AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_aug($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='August'AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_sep($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='September'AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_oct($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='October'AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_nov($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='November'AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_dec($id){
        $query = $this->db->query("SELECT id_mahasiswa_absensi ,COUNT(DATE_FORMAT(tgl_waktu_absensi, '%M')) as kegiatan FROM absensi
        WHERE DATE_FORMAT(tgl_waktu_absensi, '%M') ='December'AND id_mahasiswa_absensi =$id");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }


    //end laporan per mahasiswa
    
    // start kelola halaman dosen
    //start kelola profile dosen

    //start dosen 
    public function getprofiledosenJSON($id_pengguna){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.id_dosen';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('dosen')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT a.id_dosen,a.nama_dosen,a.id_prodi_dosen,a.foto_dosen,b.username,b.password
            from dosen a
            INNER JOIN user b ON a.id_dosen = b.id_user
            WHERE a.id_dosen = $id_pengguna
            order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    public function updatprofiledosentabledosen($id)
    {
        $data =  [
            
            'nama_dosen' => $this->input->post('nama_dosen'),
            'foto_dosen' => $this->input->post('foto_dosen'),
        ];

        $this->db->where('id_dosen',$id);
        $this->db->set($data);
        return $this->db->update('dosen');
    }

    public function updatprofiledosentableuser($id)
    {
        $data =  [
            
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
        ];

        $this->db->where('id_user',$id);
        $this->db->set($data);
        return $this->db->update('user');
    }

    

    //end dosen


    //end kelola profile dosen

    //start view dosen mahasiswa
    public function getdosenmahasiswa($id_pengguna){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.id_mahasiswa';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('dosen')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT DISTINCT
                    a.id_mahasiswa,a.nama_mahasiswa,a.kelas_mahasiswa,a.id_prodi_mahasiswa,a.angkatan_mahasiswa,a.foto_mahasiswa
                    FROM mahasiswa a 
                    INNER JOIN absensi b ON a.id_mahasiswa = b.id_mahasiswa_absensi
                    WHERE b.id_dosen_absensi = $id_pengguna
            order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    //end view dosen mahasiswa

    // start kelola intern dosen


    //start dosen 
    public function getdoseninternJSON($id_pengguna){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'intern.id_intern';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_intern']) ? strval($_POST['search_intern']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('intern')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from intern
            where concat(id_intern,id_koor_intern,status_intern,tgl_mulai_intern,tgl_akhir_intern)  like '%$search%' 
            AND id_koor_intern = $id_pengguna
            order by $sort $order limit $offset, $rows";

        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }
    

    public function updatedosenintern($id)
    {
        $data =  [
            
            'id_koor_intern' => $this->input->post('id_koor_intern'),
            'status_intern' => $this->input->post('status_intern'),
            'tgl_mulai_intern' => $this->input->post('tgl_mulai_intern'),
            'tgl_akhir_intern' => $this->input->post('tgl_akhir_intern'),
            
        ];

        $this->db->where('id_intern',$id);
        $this->db->set($data);
        return $this->db->update('intern');
    }


    // end kelola intern dosen 

    //view absensi mahasiswa

    //start absensi 
    public function getabsensimahasiswahalamandosenJSON($id_pengguna){
        
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'absensi.id_absensi';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $search = isset($_POST['search_absensi']) ? strval($_POST['search_absensi']) : '';
        $offset = ($page-1)*$rows;

        $result = array();
        $result['total'] = $this->db->get('absensi')->num_rows();
        $row = array();

        // select data from table product
        $query = "SELECT *
            from absensi
            where concat(id_absensi,id_intern_absensi,id_mahasiswa_absensi,id_dosen_absensi,latitude_absensi,longitude_absensi,tgl_waktu_absensi,imei_perangkat_absensi,foto_absensi)  like '%$search%' 
            AND id_dosen_absensi = $id_pengguna
            order by $sort $order limit $offset, $rows";
            
        $country = $this->db->query($query)->result_array();    
        $result = array_merge($result, ['rows' => $country]);
        return $result;
    }

    //end absensi mahasiswa

    // start peta mahasiswa untuk masing masing dosen

    public function getmahasiswauntukdosenJSON($id_pengguna){
        
        $this->db->where('id_dosen_absensi',$id_pengguna);
        $query = $this->db->get('absensi');

        // Return associative data array
        return $query->result_array();
    }
    // start peta mahasiswa untuk masing masing dosen 
    // end kelola halaman dosen
}