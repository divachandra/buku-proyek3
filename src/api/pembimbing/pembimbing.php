<?php
include('../conn.php');
header('Content-Type: application/json');
class Pembimbing
{
    private $db;
    private $connection;
    public function __construct()
    {
        $this->db         = new Connection();
        $this->connection = $this->db->get_connection();
    }

    public function registrasi_pembimbing($nama_pembimbing, $kontak_pembimbing, $nama_perusahaan, $username, $password, $latitude_perusahaan, $longitude_perusahaan)
    {
        $query1 = "SELECT nama_pembimbing FROM pembimbing_perusahaan";
        $result1 = mysqli_query($this->connection, $query1);
        
        $query2 = "SELECT username FROM user WHERE username='$username'";
        $result2 = mysqli_query($this->connection, $query2);
        
        if (mysqli_num_rows($result1) > 0 && mysqli_num_rows($result2) == 0) {
            $query1 = "INSERT INTO pembimbing_perusahaan (nama_pembimbing, nama_perusahaan_perusahaan, 
            lat_pembimbing_perusahaan, long_pembimbing_perusahaan, kontak_pembimbing) VALUES ('$nama_pembimbing', 
            '$nama_perusahaan', '$latitude_perusahaan', '$longitude_perusahaan', '$kontak_pembimbing')";
            
            $query2 = "INSERT INTO user VALUES ((SELECT LAST_INSERT_ID(id_pembimbing) FROM pembimbing_perusahaan 
            ORDER BY id_pembimbing DESC LIMIT 1), '$username', '$password', 'tidak aktif', 'pembimbing')";
    
            $result1 = mysqli_query($this->connection, $query1);
            $result2 = mysqli_query($this->connection, $query2);
            
            if ($result1 && $result2) {
                $json['status']  = 200;
                $json['message'] = 'Registrasi berhasil';
                echo json_encode($json);
                mysqli_close($this->connection);
            } else {
                $json['status']  = 400;
                $json['message'] = 'Registrasi gagal';
                echo json_encode($json);
                mysqli_close($this->connection);
            }
        } else if(mysqli_num_rows($result2) == 0){
            $query3 = "ALTER TABLE pembimbing_perusahaan AUTO_INCREMENT = 1";
            $query1 = "INSERT INTO pembimbing_perusahaan (id_pembimbing, nama_pembimbing, nama_perusahaan_perusahaan, 
            lat_pembimbing_perusahaan, long_pembimbing_perusahaan, kontak_pembimbing) VALUES (190001, '$nama_pembimbing', 
            '$nama_perusahaan', '$latitude_perusahaan', '$longitude_perusahaan', '$kontak_pembimbing')";
            
            $query2 = "INSERT INTO user VALUES ((SELECT LAST_INSERT_ID(id_pembimbing) FROM pembimbing_perusahaan 
            ORDER BY id_pembimbing DESC LIMIT 1), '$username', '$password', 'tidak aktif', 'pembimbing')";
    
            mysqli_query($this->connection, $query3);
            $result1 = mysqli_query($this->connection, $query1);
            $result2 = mysqli_query($this->connection, $query2);
            
            if ($result1 && $result2) {
                $json['status']  = 200;
                $json['message'] = 'Registrasi berhasil';
                echo json_encode($json);
                mysqli_close($this->connection);
            } else {
                $json['status']  = 400;
                $json['message'] = 'Registrasi gagal';
                echo json_encode($json);
                mysqli_close($this->connection);
            }
        }else{
                $json['status']  = 400;
                $json['message'] = 'Registrasi gagal';
                echo json_encode($json);
                mysqli_close($this->connection);
        }
    }

    public function login_pembimbing($user, $pass)
    {
        $query = "SELECT id_pembimbing, username, password, nama_pembimbing, 
        nama_perusahaan_perusahaan, kontak_pembimbing, 
        foto_pembimbing FROM user 
        INNER JOIN pembimbing_perusahaan 
        ON user.id_user = pembimbing_perusahaan.id_pembimbing
        WHERE username='$user' AND password='$pass'
        AND status_user='aktif' AND role_user='pembimbing'";

        $result = mysqli_query($this->connection, $query);

        if (mysqli_num_rows($result) > 0) {
            $row  = mysqli_fetch_array($result);
            $data = array(
                "username" => $row['username'],
                "password" => $row['password'],
                "id_pembimbing" => $row['id_pembimbing'],
                "nama_pembimbing" => ucwords($row['nama_pembimbing']),
                "nama_perusahaan" => ucwords($row['nama_perusahaan_perusahaan']),
                "foto_pembimbing" => $row['foto_pembimbing'],
                "kontak_pembimbing" => $row['kontak_pembimbing']

            );
            
            $json['status']  = 200;
            $json['message'] = 'Login berhasil';
            $json['data']  = $data;
            
            echo json_encode($json);
            mysqli_close($this->connection);
        } elseif (mysqli_num_rows($result) == 0) {
                $json['status']  = 300;
                $json['message'] = 'Username atau password salah';
                
                echo json_encode($json);
                mysqli_close($this->connection);
            } else {
            $json['status']  = 400;
            $json['message'] = 'Gagal melakukan login';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function list_konfirm_absensi($id_pembimbing){
        $query = "SELECT id_absensi, id_intern, id_mahasiswa, nama_mahasiswa, foto_mahasiswa, kontak_mahasiswa, nama_prodi, nama_kegiatan, tgl_waktu_absensi FROM absensi INNER JOIN mahasiswa ON absensi.id_mahasiswa_absensi = mahasiswa.id_mahasiswa INNER JOIN prodi ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi INNER JOIN kegiatan ON kegiatan.id_kegiatan = absensi.id_kegiatan_absensi INNER JOIN intern ON absensi.id_intern_absensi = intern.id_intern WHERE id_pembimbing_absensi='$id_pembimbing' AND intern.status_intern='berjalan' AND (status_absensi IS NULL OR status_absensi = '') ORDER BY id_absensi DESC";
        
        $result = mysqli_query($this->connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $datas = array();
            while ($row  = mysqli_fetch_array($result)) {
                $datas[] =  array(
                    "id_absensi" => $row['id_absensi'],
                "id_intern" => $row['id_intern'],
                "id_mahasiswa" => $row['id_mahasiswa'],
                "nama_mahasiswa" => ucwords($row['nama_mahasiswa']),
                "foto_mahasiswa" => $row['foto_mahasiswa'],
                "kontak_mahasiswa" => $row['kontak_mahasiswa'],
                "nama_prodi" => ucwords($row['nama_prodi']),
                "kegiatan" => ucfirst($row['nama_kegiatan']),
                "tgl_waktu" => $row['tgl_waktu_absensi']
            );
                
            }
            
            $json['status']  = 200;
            $json['message'] = 'Berhasil mengambil konfirmasi';
            $json['data']  = $datas;
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } elseif (mysqli_num_rows($result) == 0) {
            $json['status']  = 300;
            $json['message'] = 'Konfirmasi tidak ada';
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Gagal mengambil konfirmasi';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function list_konfirm_mahasiswa($id_pembimbing){
        
        
        $query = "SELECT id_intern, id_mahasiswa, nama_mahasiswa, foto_mahasiswa, kontak_mahasiswa, nama_prodi FROM detail_intern INNER JOIN intern ON detail_intern.id_intern_dt_intern = intern.id_intern INNER JOIN mahasiswa ON detail_intern.id_mahasiswa_dt_intern = mahasiswa.id_mahasiswa INNER JOIN prodi ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi WHERE id_pembimbing_dt_intern='$id_pembimbing' AND intern.status_intern='berjalan' AND (status_perusahaan IS NOT NULL OR status_perusahaan != '')";
        
        $result = mysqli_query($this->connection, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $datas = array();

            while ($row  = mysqli_fetch_array($result)) {
                $datas[] =  array(
                "id_intern" => $row['id_intern'],
                "id_mahasiswa" => $row['id_mahasiswa'],
                "nama_mahasiswa" => ucwords($row['nama_mahasiswa']),
                "foto_mahasiswa" => $row['foto_mahasiswa'],
                "kontak_mahasiswa" => $row['kontak_mahasiswa'],
                "nama_prodi" => ucwords($row['nama_prodi'])
            );
                
            }
            
            $json['status']  = 200;
            $json['message'] = 'Berhasil mengambil konfirmasi';
            $json['data']  = $datas;
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } elseif (mysqli_num_rows($result) == 0) {
            $json['status']  = 300;
            $json['message'] = 'Konfirmasi tidak ada';
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Gagal mengambil konfirmasi';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function list_notifikasi($id_pembimbing){
        
        
        $query = "SELECT id_intern, nama_mahasiswa, pesan_notifikasi, tgl_waktu_notifikasi FROM notifikasi
INNER JOIN pembimbing_perusahaan ON id_pembimbing = id_pembimbing_notifikasi
INNER JOIN mahasiswa ON id_mahasiswa = id_mahasiswa_notifikasi
INNER JOIN intern ON id_intern = id_intern_notifikasi
WHERE id_pembimbing_notifikasi='$id_pembimbing' AND status_intern='berjalan' ORDER BY tgl_waktu_notifikasi DESC";
        
        $result = mysqli_query($this->connection, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $datas = array();
            
            $kalimat1 = "melakukan absensi pada";
            $kalimat2 = "mengkonfirmasi absensi";
            $kalimat3 = "mendaftar ke perusahaan";
            $kalimat4 = "mengkonfirmasi pendaftaran";

            while ($row  = mysqli_fetch_array($result)) {
                $pesan = "";
                if(preg_match("~\b".$row['pesan_notifikasi']."\b~",$kalimat1)){
                    $pesan = ucwords($row['nama_mahasiswa'])." ".$row['pesan_notifikasi'];
                }elseif(preg_match("~\b".$row['pesan_notifikasi']."\b~",$kalimat2)){
                    $pesan = "Anda ".$row['pesan_notifikasi']." ".ucwords($row['nama_mahasiswa'])." pada";
                }elseif(preg_match("~\b".$row['pesan_notifikasi']."\b~",$kalimat3)){
                    $pesan = ucwords(($row['nama_mahasiswa']))." ".$row['pesan_notifikasi']." Anda pada";
                }elseif(preg_match("~\b".$row['pesan_notifikasi']."\b~",$kalimat4)){
                    $pesan = "Anda ".$row['pesan_notifikasi']." ".ucwords($row['nama_mahasiswa'])." pada";
                }
                
                $datas[] =  array(
                "id_intern" => $row['id_intern'],
                "pesan" => $pesan." ".date_format(date_create($row['tgl_waktu_notifikasi']), 'd F Y \p\u\k\u\l G:i A'),
                "tgl_waktu" => $row['tgl_waktu_notifikasi']
            );
                
            }
            
            $json['status']  = 200;
            $json['message'] = 'Berhasil mengambil notifikasi';
            $json['data']  = $datas;
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } elseif (mysqli_num_rows($result) == 0) {
            $json['status']  = 300;
            $json['message'] = 'Notifikasi tidak ada';
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Gagal mengambil notifikasi';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function konfirm_mahasiswa($id_intern, $id_pembimbing, $id_mahasiswa)
    {
        $query = "UPDATE detail_intern SET status_perusahaan='diterima'
        WHERE id_pembimbing_dt_intern='$id_pembimbing' AND id_mahasiswa_dt_intern='$id_mahasiswa' AND id_intern_dt_intern='$id_intern' AND (status_perusahaan IS NULL OR status_perusahaan = '')";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Mahasiswa berhasil dikonfirmasi';
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Mahasiswa gagal dikonfirmasi';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function konfirm_absensi($id_absensi)
    {
        $query = "UPDATE absensi SET status_absensi='diterima'
        WHERE id_absensi='$id_absensi'";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Absensi berhasil dikonfirmasi';
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Absensi gagal dikonfirmasi';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function list_mahasiswa($id_pembimbing)
    {
        $query = "SELECT id_intern, id_mahasiswa, nama_mahasiswa, foto_mahasiswa, kontak_mahasiswa, nama_prodi, angkatan_mahasiswa FROM detail_intern INNER JOIN intern ON detail_intern.id_intern_dt_intern = intern.id_intern INNER JOIN mahasiswa ON detail_intern.id_mahasiswa_dt_intern = mahasiswa.id_mahasiswa INNER JOIN prodi ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi WHERE id_pembimbing_dt_intern='$id_pembimbing' AND intern.status_intern='berjalan' AND (status_perusahaan IS NOT NULL OR status_perusahaan != '') ORDER BY nama_mahasiswa ASC";
        
        $result = mysqli_query($this->connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $datas = array();

            while ($row  = mysqli_fetch_array($result)) {
                $datas[] =  array(
                "id_intern" => $row['id_intern'],
                "id_mahasiswa" => $row['id_mahasiswa'],
                "nama_mahasiswa" => ucwords($row['nama_mahasiswa']),
                "foto_mahasiswa" => $row['foto_mahasiswa'],
                "kontak_mahasiswa" => $row['kontak_mahasiswa'],
                "nama_prodi" => ucwords($row['nama_prodi']),
                "angkatan_mahasiswa" => $row['angkatan_mahasiswa']
            );
            }
            
            $json['status']  = 200;
            $json['message'] = 'Berhasil mengambil mahasiswa';
            $json['data']  = $datas;
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } elseif (mysqli_num_rows($result) == 0) {
            $json['status']  = 300;
            $json['message'] = 'Mahasiswa tidak ada';
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Gagal mengambil mahasiswa';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function ubah_username($id_pembimbing, $username){
        $query = "UPDATE user SET username='$username' WHERE id_user='$id_pembimbing'";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Username berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Username gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function ubah_nama($id_pembimbing, $nama){
        $query = "UPDATE pembimbing_perusahaan SET nama_pembimbing='$nama' WHERE id_pembimbing='$id_pembimbing'";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Nama berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Nama gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function ubah_kontak($id_pembimbing, $kontak){
        $query = "UPDATE pembimbing_perusahaan SET kontak_pembimbing='$kontak' WHERE id_pembimbing='$id_pembimbing'";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Kontak berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Kontak gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function ubah_perusahaan($id_pembimbing, $perusahaan){
        $query = "UPDATE pembimbing_perusahaan SET nama_perusahaan_perusahaan='$perusahaan' WHERE id_pembimbing='$id_pembimbing'";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Perusahaan berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Perusahaan gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function ubah_foto($id_pembimbing, $foto){
        $query = "UPDATE pembimbing_perusahaan SET foto_pembimbing='$foto' WHERE id_pembimbing='$id_pembimbing'";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Foto berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
            return true;
        } else {
            $json['status']  = 400;
            $json['message'] = 'Foto gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
            return false;
        }
    }
    
    public function ubah_password($id_pembimbing, $password){
        $query = "UPDATE user SET password='$password' WHERE id_user='$id_pembimbing'";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Password berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Password gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
}
