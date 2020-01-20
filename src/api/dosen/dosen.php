<?php
include('../conn.php');
header('Content-Type: application/json');
class Dosen
{
    private $db;
    private $connection;
    public function __construct()
    {
        $this->db         = new Connection();
        $this->connection = $this->db->get_connection();
    }

    public function list_mahasiswa($id_dosen)
    {
        $query  = "SELECT id_mahasiswa, nama_perusahaan_perusahaan, lama_internship, nama_mahasiswa, foto_mahasiswa, 
        angkatan_mahasiswa, foto_perusahaan, kelas_mahasiswa, foto_mahasiswa, nama_prodi, 
        nama_pembimbing, lat_pembimbing_perusahaan, long_pembimbing_perusahaan, id_intern, COUNT(id_mahasiswa_dt_absensi) as jumlah_absensi
        FROM detail_intern
        INNER JOIN intern ON detail_intern.id_intern_dt_intern = intern.id_intern
        INNER JOIN pembimbing_perusahaan ON detail_intern.id_pembimbing_dt_intern = pembimbing_perusahaan.id_pembimbing
        INNER JOIN mahasiswa ON detail_intern.id_mahasiswa_dt_intern = mahasiswa.id_mahasiswa
        INNER JOIN prodi ON mahasiswa.id_prodi_mahasiswa= prodi.id_prodi
        INNER JOIN detail_absensi ON detail_intern.id_mahasiswa_dt_intern = detail_absensi.id_mahasiswa_dt_absensi
        WHERE id_dosen_dt_intern = '$id_dosen' AND status_intern = 'berjalan'";

        $result = mysqli_query($this->connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $datas = array();

            while ($row  = mysqli_fetch_array($result)) {
                $datas[] =  array(
                "id_intern" => $row['id_intern'],
                "id_mahasiswa" => $row['id_mahasiswa'],
                "nama_perusahaan" => ucwords($row['nama_perusahaan_perusahaan']),
                "nama_mahasiswa" => ucwords($row['nama_mahasiswa']),
                "foto_mahasiswa" => $row['foto_mahasiswa'],
                "angkatan_mahasiswa" => $row['angkatan_mahasiswa'],
                "foto_perusahaan" => $row['foto_perusahaan'],
                "kelas_mahasiswa" => strtoupper($row['kelas_mahasiswa']),
                "foto_mahasiswa" => $row['foto_mahasiswa'],
                "nama_prodi" => ucwords($row['nama_prodi']),
                "nama_pembimbing" => ucwords($row['nama_pembimbing']),
                "latitude_perusahaan" => $row['lat_pembimbing_perusahaan'],
                "longitude_perusahaan" => $row['long_pembimbing_perusahaan'],
                "presentase_internship" => round($row['jumlah_absensi']/$row['lama_internship']*100,1)
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

    public function login_dosen($user, $pass)
    {
        $query = "SELECT 
        username, password, id_dosen, nama_dosen, foto_dosen, id_intern, nama_prodi
        FROM user
        INNER JOIN dosen ON user.id_user = dosen.id_dosen
        INNER JOIN detail_intern ON user.id_user = detail_intern.id_dosen_dt_intern
        INNER JOIN intern ON detail_intern.id_intern_dt_intern = intern.id_intern
        INNER JOIN prodi ON dosen.id_prodi_dosen = prodi.id_prodi
        WHERE username = '$user' AND password = '$pass' AND status_user='aktif' AND role_user='dosen'";

        $result = mysqli_query($this->connection, $query);

        $row  = mysqli_fetch_array($result);
        if (mysqli_num_rows($result) > 0) {
            $data = array(
                "username" => $row['username'],
                "password" => $row['password'],
                "id_dosen" => $row['id_dosen'],
                "nama_dosen" => ucwords($row['nama_dosen']),
                "foto_dosen" => $row['foto_dosen'],
                "nama_prodi" => ucwords($row['nama_prodi'])

            );
            
            $json['status']  = 200;
            $json['message'] = 'Berhasil melakukan login';
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

    public function progress_mahasiswa($id_intern, $id_mahasiswa, $sort)
    {
        $query  = "SET @rank=0;";
        mysqli_query($this->connection, $query);
        switch ($sort) {
            case 'hari':
            $query1  = "
            SELECT @rank:=@rank+1 AS rank, DAYOFYEAR(tgl_waktu_absensi) as date, ROUND(COUNT(*) / 3 * 100, 2) 
            as percent FROM absensi WHERE id_intern_absensi='$id_intern' AND id_mahasiswa_absensi = '$id_mahasiswa' 
            GROUP BY DAYOFYEAR(tgl_waktu_absensi) ORDER BY rank ASC";
            $result1 = mysqli_query($this->connection, $query1);
            if (mysqli_num_rows($result1) > 0) {
                $datas = array();

                while ($row  = mysqli_fetch_array($result1)) {
                    $datas[] =  array(
                    "sort" => "Hari ke-".$row['rank'],
                    "persen" => $row['percent']
            );
                }
            
                $json['status']  = 201;
                $json['message'] = 'Berhasil mengambil progress';
                $json['data']  = $datas;
                
                echo json_encode($json);
                mysqli_close($this->connection);
            } elseif (mysqli_num_rows($result1) == 0) {
                $json['status']  = 300;
                $json['message'] = 'Progress tidak ada';
                //$json['data']  = [];
                
                echo json_encode($json);
                mysqli_close($this->connection);
            } else {
                $json['status']  = 400;
                $json['message'] = 'Gagal mengambil progress';
                echo json_encode($json);
                mysqli_close($this->connection);
            }
            break;
            case 'minggu':
            $query2  = "
            SELECT @rank:=@rank+1 AS rank, WEEK(tgl_waktu_absensi,1) as week, ROUND(COUNT(*) / 21 * 100, 2) 
            as percent FROM absensi WHERE id_intern_absensi='$id_intern' AND id_mahasiswa_absensi = '$id_mahasiswa' 
            GROUP BY WEEK(tgl_waktu_absensi) ORDER BY rank ASC";
            $result2 = mysqli_query($this->connection, $query2);
            if (mysqli_num_rows($result2) > 0) {
                $datas = array();

                while ($row  = mysqli_fetch_array($result2)) {
                    $datas[] =  array(
                    "sort" => "Minggu ke-".$row['rank'],
                    "persen" => $row['percent']
            );
                }
            
                $json['status']  = 202;
                $json['message'] = 'Berhasil mengambil progress';
                $json['data']  = $datas;
                
                echo json_encode($json);
                mysqli_close($this->connection);
            } elseif (mysqli_num_rows($result2) == 0) {
                $json['status']  = 300;
                $json['message'] = 'Progress tidak ada';
                
                echo json_encode($json);
                mysqli_close($this->connection);
            } else {
                $json['status']  = 400;
                $json['message'] = 'Gagal mengambil progress';
                echo json_encode($json);
                mysqli_close($this->connection);
            }
            break;
            case 'bulan':
                $query3  = "
                SELECT @rank:=@rank+1 AS rank, MONTH(tgl_waktu_absensi) as month, ROUND(COUNT(*) / 90 * 100, 2) 
                as percent FROM absensi WHERE id_intern_absensi='$id_intern' AND id_mahasiswa_absensi = '$id_mahasiswa' 
                GROUP BY MONTH(tgl_waktu_absensi) ORDER BY rank ASC";
                $result3 = mysqli_query($this->connection, $query3);
                if (mysqli_num_rows($result3) > 0) {
                    $datas = array();

                    while ($row  = mysqli_fetch_array($result3)) {
                        $datas[] =  array(
                            "sort" => "Bulan ke-".$row['rank'],
                            "persen" => $row['percent']
                        );
                    }
                
                    $json['status']  = 203;
                    $json['message'] = 'Berhasil mengambil progress';
                    $json['data']  = $datas;
                    
                    echo json_encode($json);
                    mysqli_close($this->connection);
                } elseif (mysqli_num_rows($result3) == 0) {
                    $json['status']  = 300;
                    $json['message'] = 'Progress tidak ada';
                
                    echo json_encode($json);
                    mysqli_close($this->connection);
                } else {
                    $json['status']  = 400;
                    $json['message'] = 'Gagal mengambil progress';
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
            break;
        }
    }

    public function progress_mahasiswa_perhari($id_intern, $id_mahasiswa, $tgl)
    {
        $query  = "SELECT id_absensi, tgl_waktu_absensi, nama_kegiatan, foto_absensi, pergeseran_absensi 
        FROM absensi
        INNER JOIN detail_absensi ON absensi.id_absensi = detail_absensi.id_absensi_dt_absensi
        INNER JOIN kegiatan ON absensi.id_kegiatan_absensi = kegiatan.id_kegiatan
        WHERE id_intern_absensi ='$id_intern' AND id_mahasiswa_absensi ='$id_mahasiswa' AND 
        DATE(tgl_waktu_absensi) = '$tgl'";
        $result = mysqli_query($this->connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $datas = array();

            while ($row  = mysqli_fetch_array($result)) {
                $datas[] =  array(
                    "id_absensi" => $row['id_absensi'],
                    "tgl_waktu" => $row['tgl_waktu_absensi'],
                "kegiatan" => ucfirst($row['nama_kegiatan']),
                "foto_absensi" => $row['foto_absensi'],
                "pergeseran" => $row['pergeseran_absensi']." M"
            );
            }
        
            $json['status']  = 200;
            $json['message'] = 'Berhasil mengambil progress harian';
            $json['data']  = $datas;
            
            echo json_encode($json);
            mysqli_close($this->connection);
        } elseif (mysqli_num_rows($result) == 0) {
            $json['status']  = 300;
            $json['message'] = 'Progress harian tidak ada';
                
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Gagal mengambil progress harian';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function list_notifikasi($id_dosen){
        
        
        $query = "SELECT id_intern, nama_mahasiswa, nama_pembimbing, nama_perusahaan_perusahaan, pesan_notifikasi, tgl_waktu_notifikasi FROM notifikasi INNER JOIN pembimbing_perusahaan ON id_pembimbing = id_pembimbing_notifikasi INNER JOIN mahasiswa ON id_mahasiswa = id_mahasiswa_notifikasi INNER JOIN intern ON id_intern = id_intern_notifikasi WHERE id_dosen_notifikasi='$id_dosen' AND status_intern='berjalan' ORDER BY tgl_waktu_notifikasi DESC ";
        
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
                    $pesan = ucwords($row['nama_pembimbing'])." ".$row['pesan_notifikasi']." ".ucwords($row['nama_mahasiswa'])." pada";
                }elseif(preg_match("~\b".$row['pesan_notifikasi']."\b~",$kalimat3)){
                    $pesan = ucwords(($row['nama_mahasiswa']))." ".$row['pesan_notifikasi']." ".ucwords($row['nama_perusahaan_perusahaan'])." pada";
                }elseif(preg_match("~\b".$row['pesan_notifikasi']."\b~",$kalimat4)){
                    $pesan = ucwords($row['nama_pembimbing'])." ".$row['pesan_notifikasi']." ".ucwords($row['nama_mahasiswa'])." pada";
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
    
    public function ubah_username($id_dosen, $username){
        $query = "UPDATE user SET username='$username' WHERE id_user='$id_dosen'";

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
    
    public function ubah_nama($id_dosen, $nama){
        $query = "UPDATE dosen SET nama_dosen='$nama' WHERE id_dosen='$id_dosen'";

        $result = mysqli_query($this->connection, $query);

        if ($this->connection->affected_rows > 0 && $result) {
            $json['status']  = 200;
            $json['message'] = 'Nama berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        } else {
            $json['status']  = 400;
            $json['message'] = 'Nama berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }
    
    public function ubah_kontak($id_dosen, $kontak){
        $query = "UPDATE dosen SET kontak_dosen='$kontak' WHERE id_dosen='$id_dosen'";

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
    
    public function ubah_foto($id_dosen, $foto){
        $query = "UPDATE dosen SET foto_dosen='$foto' WHERE id_dosen='$id_dosen'";

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
    
    public function ubah_password($id_dosen, $password){
        $query = "UPDATE user SET password='$password' WHERE id_user='$id_dosen'";

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
