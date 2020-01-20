<?php
include ('../conn.php');
header('Content-Type: application/json');
class Mahasiswa
{
    private $db;
    private $connection;
    public function __construct()
    {
        $this->db = new Connection();
        $this->connection = $this
            ->db
            ->get_connection();
    }

    public function ambil_absensi($id_intern, $id_mahasiswa, $id_dosen, $latitude_absensi, $longitude_absensi, $imei_perangkat, $id_kegiatan, $foto_absensi, $tgl_waktu)
    {
        $query = "INSERT INTO absensi(id_intern_absensi, id_mahasiswa_absensi, id_dosen_absensi, 
        latitude_absensi, longitude_absensi, imei_perangkat_absensi, id_kegiatan_absensi, 
        foto_absensi, tgl_waktu_absensi) VALUES ('$id_intern', '$id_mahasiswa', 
        '$id_dosen', '$latitude_absensi', '$longitude_absensi', '$imei_perangkat', '$id_kegiatan', 
        '$foto_absensi', '$tgl_waktu')";

        $result = mysqli_query($this->connection, $query);

        if ($result)
        {
            $json['status'] = 200;
            $json['message'] = 'Berhasil melakukan absensi';
            echo json_encode($json);
            mysqli_close($this->connection);
            return true;
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Gagal melakukan absensi';
            echo json_encode($json);
            mysqli_close($this->connection);
            return false;
        }
    }

    public function list_kegiatan()
    {
        $query = "SELECT * FROM kegiatan";

        $result = mysqli_query($this->connection, $query);
        if (mysqli_num_rows($result) > 0)
        {
            $datas = array();

            while ($row = mysqli_fetch_array($result))
            {
                $datas[] = array(
                    "id_kegiatan" => $row['id_kegiatan'],
                    "nama_kegiatan" => $row['nama_kegiatan']
                );
            }

            $json['status'] = 200;
            $json['message'] = 'Berhasil mengambil data';
            $json['data'] = $datas;

            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Gagal mengambil data';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function list_pembimbing()
    {
        $query = "SELECT * FROM pembimbing_perusahaan";

        $result = mysqli_query($this->connection, $query);
        if (mysqli_num_rows($result) > 0)
        {
            $datas = array();

            while ($row = mysqli_fetch_array($result))
            {
                $datas[] = array(
                    "id_pembimbing" => $row['id_pembimbing'],
                    "nama_pembimbing" => $row['nama_pembimbing'],
                    "nama_perusahaan" => $row['nama_perusahaan_perusahaan']
                );
            }

            $json['status'] = 200;
            $json['message'] = 'Berhasil mengambil data';
            $json['data'] = $datas;

            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Gagal mengambil data';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function get_distance($id_pembimbing)
    {
        $query = "SELECT lat_pembimbing_perusahaan, long_pembimbing_perusahaan FROM pembimbing_perusahaan";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_array($result);
        $data = array(
            "lat" => $row['lat_pembimbing_perusahaan'],
            "lon" => $row['long_pembimbing_perusahaan']

        );
        if ($result)
        {
            return $data;
        }
        else
        {
            return false;
        }
    }
    public function registrasi_perusahaan($id_intern, $id_mahasiswa, $id_pembimbing, $latitude_perusahaan, $longitude_perusahaan, $foto_perusahaan)
    {
        $query = "UPDATE detail_intern SET id_pembimbing_dt_intern='$id_pembimbing', latitude_perusahaan='$latitude_perusahaan', 
                longitude_perusahaan='$longitude_perusahaan', foto_perusahaan='$foto_perusahaan' 
                WHERE id_intern_dt_intern = '$id_intern' AND id_mahasiswa_dt_intern ='$id_mahasiswa' ";

        $result = mysqli_query($this->connection, $query);

        if ($this
            ->connection->affected_rows > 0 && $result)
        {
            $json['status'] = 200;
            $json['message'] = 'Berhasil melakukan registrasi perusahaan';
            echo json_encode($json);
            mysqli_close($this->connection);
            return true;
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Gagal melakukan registrasi perusahaan';
            echo json_encode($json);
            mysqli_close($this->connection);
            return false;
        }
    }

    public function progress_mahasiswa($id_intern, $id_mahasiswa, $sort)
    {
        $query = "SET @rank=0;";
        mysqli_query($this->connection, $query);

        switch ($sort)
        {
            case 'hari':
                $query1 = "
            SELECT @rank:=@rank+1 AS rank, DAYOFYEAR(tgl_waktu_absensi) as date, ROUND(COUNT(*) / 3 * 100, 2) 
            as percent FROM absensi WHERE id_intern_absensi=$id_intern AND id_mahasiswa_absensi = '$id_mahasiswa' 
            GROUP BY DAYOFYEAR(tgl_waktu_absensi) ORDER BY rank ASC";

                $result1 = mysqli_query($this->connection, $query1);
                if (mysqli_num_rows($result1) > 0)
                {
                    $datas = array();
                    while ($row = mysqli_fetch_array($result1))
                    {
                        $datas[] = array(
                            "sort" => "Hari ke-" . $row['rank'],
                            "persen" => $row['percent']
                        );
                    }

                    $json['status'] = 201;
                    $json['message'] = 'Berhasil mengambil data';
                    $json['data'] = $datas;

                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
                elseif (mysqli_num_rows($result1) == 0)
                {
                    $json['status'] = 300;
                    $json['message'] = 'Data tidak ada';
                    //$json['data']  = [];
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
                else
                {
                    $json['status'] = 400;
                    $json['message'] = 'Gagal mengambil data';

                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
            break;
            case 'minggu':
                $query2 = "
            SELECT @rank:=@rank+1 AS rank, WEEK(`tgl_waktu_absensi`,1) as week, ROUND(COUNT(*) / 21 * 100, 2) 
            as percent FROM `absensi` WHERE `id_intern_absensi`=$id_intern  AND `id_mahasiswa_absensi` = '$id_mahasiswa' 
            GROUP BY WEEK(`tgl_waktu_absensi`) ORDER BY rank ASC";
                $result2 = mysqli_query($this->connection, $query2);
                if (mysqli_num_rows($result2) > 0)
                {
                    $datas = array();

                    while ($row = mysqli_fetch_array($result2))
                    {
                        $datas[] = array(
                            "sort" => "Minggu ke-" . $row['rank'],
                            "persen" => $row['percent']
                        );
                    }

                    $json['status'] = 202;
                    $json['message'] = 'Berhasil mengambil data';
                    $json['data'] = $datas;

                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
                elseif (mysqli_num_rows($result2) == 0)
                {
                    $json['status'] = 300;
                    $json['message'] = 'Data tidak ada';
                    //$json['data']  = [];
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
                else
                {
                    $json['status'] = 400;
                    $json['message'] = 'Gagal mengambil data';

                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
            break;
            case 'bulan':
                $query3 = "
                SELECT @rank:=@rank+1 AS rank, MONTH(tgl_waktu_absensi) as month, ROUND(COUNT(*) / 90 * 100, 2) 
                as percent FROM absensi WHERE id_intern_absensi=$id_intern  AND id_mahasiswa_absensi = '$id_mahasiswa' 
                GROUP BY MONTH(tgl_waktu_absensi) ORDER BY rank ASC";
                $result3 = mysqli_query($this->connection, $query3);
                if (mysqli_num_rows($result3) > 0)
                {
                    $datas = array();

                    while ($row = mysqli_fetch_array($result3))
                    {
                        $datas[] = array(
                            "sort" => "Bulan ke-" . $row['rank'],
                            "persen" => $row['percent']
                        );
                    }

                    $json['status'] = 203;
                    $json['message'] = 'Berhasil mengambil data';
                    $json['data'] = $datas;

                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
                elseif (mysqli_num_rows($result3) == 0)
                {
                    $json['status'] = 300;
                    $json['message'] = 'Data tidak ada';
                    //$json['data']  = [];
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
                else
                {
                    $json['status'] = 400;
                    $json['message'] = 'Gagal mengambil data';

                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
            break;
        }
    }

    public function progress_mahasiswa_perhari($id_intern, $id_mahasiswa, $tgl)
    {
        $query = "SELECT tgl_waktu_absensi, nama_kegiatan, foto_absensi, pergeseran_absensi 
        FROM absensi
        INNER JOIN detail_absensi ON absensi.id_absensi = detail_absensi.id_absensi_dt_absensi
        INNER JOIN kegiatan ON absensi.id_kegiatan_absensi = kegiatan.id_kegiatan
        WHERE id_intern_absensi ='$id_intern' AND id_mahasiswa_absensi ='$id_mahasiswa' AND 
        DATE(`tgl_waktu_absensi`) = '$tgl'";
        $result = mysqli_query($this->connection, $query);
        if (mysqli_num_rows($result) > 0)
        {
            $datas = array();

            while ($row = mysqli_fetch_array($result))
            {
                $datas[] = array(
                    "tgl_waktu" => $row['tgl_waktu_absensi'],
                    "kegiatan" => $row['nama_kegiatan'],
                    "foto_absensi" => $row['foto_absensi'],
                    "pergeseran" => $row['pergeseran_absensi']
                );
            }

            $json['status'] = 200;
            $json['message'] = 'Berhasil mengambil data';
            $json['data'] = $datas;

            echo json_encode($json);
            mysqli_close($this->connection);
        }
        elseif (mysqli_num_rows($result) == 0)
        {
            $json['status'] = 300;
            $json['message'] = 'Data tidak ada';
            //$json['data']  = [];
            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = $query;
            $json['message'] = 'Gagal mengambil data';

            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function login_mahasiswa($user, $pass)
    {
        $query = "SELECT id_intern, id_mahasiswa, username, password, nama_mahasiswa, kelas_mahasiswa, 
        angkatan_mahasiswa, foto_mahasiswa, nama_prodi, id_dosen, 
        nama_dosen, nama_perusahaan_perusahaan as nama_perusahaan, status_perusahaan, id_pembimbing_dt_intern as id_pembimbing
        FROM user 
        INNER JOIN mahasiswa ON user.id_user = mahasiswa.id_mahasiswa 
        INNER JOIN prodi ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi 
        INNER JOIN detail_intern ON user.id_user = detail_intern.id_mahasiswa_dt_intern 
        INNER JOIN intern ON detail_intern.id_intern_dt_intern = intern.id_intern
        INNER JOIN dosen ON detail_intern.id_dosen_dt_intern = dosen.id_dosen
        INNER JOIN pembimbing_perusahaan ON pembimbing_perusahaan.id_pembimbing = detail_intern.id_pembimbing_dt_intern 
        WHERE username='$user' AND password='$pass' AND user.role_user='mahasiswa' 
        AND user.status_user='aktif' AND status_intern = 'berjalan'";

        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_array($result);
        $id_intern = $row['id_intern'];
        if (mysqli_num_rows($result) > 0 && ($row['id_pembimbing'] != "" || $row['id_pembimbing'] != null) && $row['status_perusahaan'] == "diterima")
        {

            $query = "SELECT id_intern_dt_intern as id_intern, id_mahasiswa, username, password, nama_mahasiswa, kelas_mahasiswa, 
            angkatan_mahasiswa, foto_mahasiswa, nama_prodi, id_dosen, nama_dosen, nama_perusahaan_perusahaan as nama_perusahaan, 
            status_perusahaan, nama_pembimbing, id_pembimbing_dt_intern as id_pembimbing FROM user 
            INNER JOIN mahasiswa 
            ON user.id_user = mahasiswa.id_mahasiswa 
            INNER JOIN prodi 
            ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi 
            INNER JOIN detail_intern 
            ON user.id_user = detail_intern.id_mahasiswa_dt_intern
            INNER JOIN intern ON detail_intern.id_intern_dt_intern = intern.id_intern
            INNER JOIN dosen 
            ON detail_intern.id_dosen_dt_intern = dosen.id_dosen 
            INNER JOIN pembimbing_perusahaan ON pembimbing_perusahaan.id_pembimbing = detail_intern.id_pembimbing_dt_intern 
            WHERE username='$user' AND password='$pass' AND user.role_user='mahasiswa' 
            AND user.status_user='aktif' AND status_intern = 'berjalan'";

            $result = mysqli_query($this->connection, $query);
            $row = mysqli_fetch_array($result);

            $data = array(
                "id_intern" => $id_intern,
                "id_mahasiswa" => $row['id_mahasiswa'],
                "username" => $row['username'],
                "password" => $row['password'],
                "nama_mahasiswa" => $row['nama_mahasiswa'],
                "kelas_mahasiswa" => $row['kelas_mahasiswa'],
                "angkatan_mahasiswa" => $row['angkatan_mahasiswa'],
                "foto_mahasiswa" => $row['foto_mahasiswa'],
                "nama_prodi" => $row['nama_prodi'],
                "id_dosen" => $row['id_dosen'],
                "nama_dosen" => $row['nama_dosen'],
                "nama_pembimbing" => $row['nama_pembimbing'],
                "nama_perusahaan" => $row['nama_perusahaan']
            );

            $json['status'] = 201;
            $json['message'] = 'Login berhasil';
            $json['data'] = $data;

            echo json_encode($json);
            mysqli_close($this->connection);
        }
        elseif (mysqli_num_rows($result) > 0 && ($row['id_pembimbing'] != "" || $row['id_pembimbing'] != null) && ($row['status_perusahaan'] == "" || $row['status_perusahaan'] == null))
        {
            $data = array(
                "id_intern" => $id_intern,
                "id_mahasiswa" => $row['id_mahasiswa'],
                "username" => $row['username'],
                "password" => $row['password'],
                "nama_mahasiswa" => $row['nama_mahasiswa'],
                "kelas_mahasiswa" => $row['kelas_mahasiswa'],
                "angkatan_mahasiswa" => $row['angkatan_mahasiswa'],
                "foto_mahasiswa" => $row['foto_mahasiswa'],
                "nama_prodi" => $row['nama_prodi'],
                "id_dosen" => $row['id_dosen'],
                "nama_dosen" => $row['nama_dosen'],
                "nama_perusahaan" => $row['nama_perusahaan']
            );

            $json['status'] = 203;
            $json['message'] = 'Login berhasil';
            $json['data'] = $data;

            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $query = "SELECT id_intern_dt_intern as id_intern, id_mahasiswa, username, password, nama_mahasiswa, kelas_mahasiswa, 
            angkatan_mahasiswa, foto_mahasiswa, nama_prodi, id_dosen, nama_dosen, kode_otp,
            status_perusahaan, id_pembimbing_dt_intern as id_pembimbing FROM user INNER JOIN mahasiswa 
            ON user.id_user = mahasiswa.id_mahasiswa INNER JOIN prodi 
            ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi INNER JOIN detail_intern 
            ON user.id_user = detail_intern.id_mahasiswa_dt_intern
            INNER JOIN intern ON detail_intern.id_intern_dt_intern = intern.id_intern
            INNER JOIN dosen 
            ON detail_intern.id_dosen_dt_intern = dosen.id_dosen 
            WHERE username='$user' AND password='$pass' AND user.role_user='mahasiswa' 
            AND user.status_user='aktif' AND status_intern = 'berjalan'";

            $result = mysqli_query($this->connection, $query);
            $row = mysqli_fetch_array($result);
            if (mysqli_num_rows($result) > 0 && ($row['id_pembimbing'] == "" || $row['id_pembimbing'] == null) && ($row['status_perusahaan'] == "" || $row['status_perusahaan'] == null) && $row['kode_otp'] == '-')
            {
                $data = array(
                    "id_intern" => $id_intern,
                    "id_mahasiswa" => $row['id_mahasiswa'],
                    "username" => $row['username'],
                    "password" => $row['password'],
                    "nama_mahasiswa" => $row['nama_mahasiswa'],
                    "kelas_mahasiswa" => $row['kelas_mahasiswa'],
                    "angkatan_mahasiswa" => $row['angkatan_mahasiswa'],
                    "foto_mahasiswa" => $row['foto_mahasiswa'],
                    "nama_prodi" => $row['nama_prodi'],
                    "id_dosen" => $row['id_dosen'],
                    "nama_dosen" => $row['nama_dosen']
                );

                $json['status'] = 202;
                $json['message'] = 'Login berhasil';
                $json['data'] = $data;

                echo json_encode($json);
                mysqli_close($this->connection);
            }
            else
            {

                $json['status'] = 400;
                $json['message'] = 'Username dan password salah';
                echo json_encode($json);
                mysqli_close($this->connection);
            }
        }
    }

    public function registrasi_mahasiswa($kode_otp)
    {
        $query = "SELECT kode_otp FROM mahasiswa WHERE kode_otp = '$kode_otp'";

        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_array($result);
        if (mysqli_num_rows($result) > 0)
        {

            $query = "UPDATE mahasiswa SET kode_otp='-' WHERE kode_otp='$kode_otp'";

            $result = mysqli_query($this->connection, $query);
            if ($this
                ->connection->affected_rows > 0 && $result)
            {
                $json['status'] = 200;
                $json['message'] = 'Registrasi berhasil';

                echo json_encode($json);
                mysqli_close($this->connection);
            }
            else
            {

                $json['status'] = 400;
                $json['message'] = 'Registrasi gagal';
                echo json_encode($json);
                mysqli_close($this->connection);
            }
        }
        else
        {

            $json['status'] = 400;
            $json['message'] = 'Registrasi gagal';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function list_notifikasi($id_intern, $id_mahasiswa)
    {

        $query = "SELECT id_intern, nama_pembimbing, pesan_notifikasi, nama_perusahaan_perusahaan, tgl_waktu_notifikasi FROM notifikasi
INNER JOIN pembimbing_perusahaan ON id_pembimbing = id_pembimbing_notifikasi
INNER JOIN mahasiswa ON id_mahasiswa = id_mahasiswa_notifikasi
INNER JOIN intern ON id_intern = id_intern_notifikasi
WHERE id_mahasiswa_notifikasi='$id_mahasiswa' AND id_intern_notifikasi='$id_intern' ORDER BY tgl_waktu_notifikasi DESC";

        $result = mysqli_query($this->connection, $query);

        if (mysqli_num_rows($result) > 0)
        {
            $datas = array();

            $kalimat1 = "melakukan absensi pada";
            $kalimat2 = "mengkonfirmasi absensi";
            $kalimat3 = "mendaftar ke perusahaan";
            $kalimat4 = "mengkonfirmasi pendaftaran";

            while ($row = mysqli_fetch_array($result))
            {
                $pesan = "";
                if (preg_match("~\b" . $row['pesan_notifikasi'] . "\b~", $kalimat1))
                {
                    $pesan = "Anda " . $row['pesan_notifikasi'];
                }
                elseif (preg_match("~\b" . $row['pesan_notifikasi'] . "\b~", $kalimat2))
                {
                    $pesan = ucwords(($row['nama_pembimbing'])) . " " . $row['pesan_notifikasi'] . " Anda pada";
                }
                elseif (preg_match("~\b" . $row['pesan_notifikasi'] . "\b~", $kalimat3))
                {
                    $pesan = "Anda " . $row['pesan_notifikasi'] . " " . ucwords(($row['nama_perusahaan_perusahaan'])) . " pada";
                }
                elseif (preg_match("~\b" . $row['pesan_notifikasi'] . "\b~", $kalimat4))
                {
                    $pesan = ucwords(($row['nama_pembimbing'])) . " " . $row['pesan_notifikasi'] . " Anda pada";
                }

                $datas[] = array(
                    "id_intern" => $row['id_intern'],
                    "pesan" => $pesan . " " . date_format(date_create($row['tgl_waktu_notifikasi']) , 'd F Y \p\u\k\u\l G:i A') ,
                    "tgl_waktu" => $row['tgl_waktu_notifikasi']
                );

            }

            $json['status'] = 200;
            $json['message'] = 'Berhasil mengambil notifikasi';
            $json['data'] = $datas;

            echo json_encode($json);
            mysqli_close($this->connection);
        }
        elseif (mysqli_num_rows($result) == 0)
        {
            $json['status'] = 300;
            $json['message'] = 'Notifikasi tidak ada';

            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Gagal mengambil notifikasi';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function ubah_username($id_mahasiswa, $username)
    {
        $query = "UPDATE user SET username='$username' WHERE id_user='$id_mahasiswa'";

        $result = mysqli_query($this->connection, $query);

        if ($this
            ->connection->affected_rows > 0 && $result)
        {
            $json['status'] = 200;
            $json['message'] = 'Username berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Username gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function ubah_nama($id_mahasiswa, $nama)
    {
        $query = "UPDATE mahasiswa SET nama_mahasiswa='$nama' WHERE id_mahasiswa='$id_mahasiswa'";

        $result = mysqli_query($this->connection, $query);

        if ($this
            ->connection->affected_rows > 0 && $result)
        {
            $json['status'] = 200;
            $json['message'] = 'Nama berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Nama gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function ubah_kelas($id_mahasiswa, $kelas)
    {
        $query = "UPDATE mahasiswa SET kelas_mahasiswa='$kelas' WHERE id_mahasiswa='$id_mahasiswa'";

        $result = mysqli_query($this->connection, $query);

        if ($this
            ->connection->affected_rows > 0 && $result)
        {
            $json['status'] = 200;
            $json['message'] = 'Nama berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Nama gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function ubah_angkatan($id_mahasiswa, $angkatan)
    {
        $query = "UPDATE mahasiswa SET angkatan_mahasiswa='$angkatan' WHERE id_mahasiswa='$id_mahasiswa'";

        $result = mysqli_query($this->connection, $query);

        if ($this
            ->connection->affected_rows > 0 && $result)
        {
            $json['status'] = 200;
            $json['message'] = 'Nama berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Nama gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function ubah_kontak($id_mahasiswa, $kontak)
    {
        $query = "UPDATE mahasiswa SET kontak_mahasiswa='$kontak' WHERE id_mahasiswa='$id_mahasiswa'";

        $result = mysqli_query($this->connection, $query);

        if ($this
            ->connection->affected_rows > 0 && $result)
        {
            $json['status'] = 200;
            $json['message'] = 'Kontak berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Kontak gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function ubah_foto($id_mahasiswa, $foto)
    {
        $query = "UPDATE mahasiswa SET foto_mahasiswa='$foto' WHERE id_mahasiswa='$id_mahasiswa'";

        $result = mysqli_query($this->connection, $query);

        if ($this
            ->connection->affected_rows > 0 && $result)
        {
            $json['status'] = 200;
            $json['message'] = 'Foto berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
            return true;
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Foto gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
            return false;
        }
    }

    public function ubah_password($id_mahasiswa, $password)
    {
        $query = "UPDATE user SET password='$password' WHERE id_user='$id_mahasiswa'";

        $result = mysqli_query($this->connection, $query);

        if ($this
            ->connection->affected_rows > 0 && $result)
        {
            $json['status'] = 200;
            $json['message'] = 'Password berhasil diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
        else
        {
            $json['status'] = 400;
            $json['message'] = 'Password gagal diubah';
            echo json_encode($json);
            mysqli_close($this->connection);
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2))
        {
            return 0;
        }
        else
        {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            return ($miles * 1.609344) * 1000;
        }
    }
}

