<?php
include('pembimbing.php');
header('Content-Type: application/json');
$p = new Pembimbing();

$id_pembimbing = $_POST['id_pembimbing'];
if (isset($_POST['username'])) $username = $_POST['username'];
if (isset($_POST['nama'])) $nama = $_POST['nama'];
if (isset($_POST['kontak'])) $kontak = $_POST['kontak'];
if (isset($_POST['perusahaan'])) $perusahaan = $_POST['perusahaan'];
if (isset($_POST['password'])) $password = $_POST['password'];

if (isset($_FILES['foto']['name'])){
    $foto = $_FILES['foto']['name'];
    $temp_foto = $_FILES['foto']['tmp_name'];

    $dir_pembimbing = "../images/pembimbing/";
}

if (!empty($id_pembimbing) && !empty($username)) {
    $p->ubah_username($id_pembimbing, $username);
} elseif (!empty($id_pembimbing) && !empty($nama)) {
    $p->ubah_nama($id_pembimbing, $nama);
} elseif (!empty($id_pembimbing) && !empty($kontak)) {
    $p->ubah_kontak($id_pembimbing, $kontak);
} elseif (!empty($id_pembimbing) && !empty($perusahaan)) {
    $p->ubah_perusahaan($id_pembimbing, $perusahaan);
} elseif (!empty($id_pembimbing) && !empty($password)) {
    $p->ubah_password($id_pembimbing, $password);
} elseif(!empty($id_pembimbing) && !empty($foto)){
    $result = $p->ubah_foto($id_pembimbing, $foto);
    if ($result) {
        $upload = move_uploaded_file($temp_foto, $dir_pembimbing.$foto);
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
