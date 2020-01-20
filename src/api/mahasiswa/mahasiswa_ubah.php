<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();

$id_mahasiswa = $_POST['id_mahasiswa'];
if (isset($_POST['username'])) $username = $_POST['username'];
if (isset($_POST['nama'])) $nama = $_POST['nama'];
if (isset($_POST['kelas'])) $kelas = $_POST['kelas'];
if (isset($_POST['angkatan'])) $angkatan = $_POST['angkatan'];
if (isset($_POST['kontak'])) $kontak = $_POST['kontak'];
if (isset($_POST['password'])) $password = $_POST['password'];

if (isset($_FILES['foto']['name'])){
    $foto = $_FILES['foto']['name'];
    $temp_foto = $_FILES['foto']['tmp_name'];

    $dir_mahasiswa = "../images/mahasiswa/";
}

if (!empty($id_mahasiswa) && !empty($username)) {
    $m->ubah_username($id_mahasiswa, $username);
} elseif (!empty($id_mahasiswa) && !empty($nama)) {
    $m->ubah_nama($id_mahasiswa, $nama);
} elseif (!empty($id_mahasiswa) && !empty($kelas)) {
    $m->ubah_kelas($id_mahasiswa, $kelas);
} elseif (!empty($id_mahasiswa) && !empty($angkatan)) {
    $m->ubah_angkatan($id_mahasiswa, $angkatan);
} elseif (!empty($id_mahasiswa) && !empty($kontak)) {
    $m->ubah_kontak($id_mahasiswa, $kontak);
} elseif (!empty($id_mahasiswa) && !empty($password)) {
    $m->ubah_password($id_mahasiswa, $password);
} elseif(!empty($id_mahasiswa) && !empty($foto)){
    $result = $m->ubah_foto($id_mahasiswa, $foto);
    if ($result) {
        $upload = move_uploaded_file($temp_foto, $dir_mahasiswa.$foto);
        if (!$upload) {
            $json['status']  = 400;
            $json['message'] = 'Gambar gagal terupload';
            echo json_encode($json);
        }
    }
} else {
    $json['status']  = 100;
    $json['message'] = 'Field tidak boleh kosong';
    echo json_encode($json);
}
