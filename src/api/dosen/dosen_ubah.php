<?php
include('dosen.php');
header('Content-Type: application/json');
$d = new Dosen();

$id_dosen = $_POST['id_dosen'];
if (isset($_POST['username'])) $username = $_POST['username'];
if (isset($_POST['nama'])) $nama = $_POST['nama'];
if (isset($_POST['kontak'])) $kontak = $_POST['kontak'];
if (isset($_POST['password'])) $password = $_POST['password'];

if (isset($_FILES['foto']['name'])){
    $foto = $_FILES['foto']['name'];
    $temp_foto = $_FILES['foto']['tmp_name'];

    $dir_dosen = "../images/dosen/";
}

if (!empty($id_dosen) && !empty($username)) {
    $d->ubah_username($id_dosen, $username);
} elseif (!empty($id_dosen) && !empty($nama)) {
    $d->ubah_nama($id_dosen, $nama);
} elseif (!empty($id_dosen) && !empty($kontak)) {
    $d->ubah_kontak($id_dosen, $kontak);
} elseif (!empty($id_dosen) && !empty($password)) {
    $d->ubah_password($id_dosen, $password);
} elseif(!empty($id_dosen) && !empty($foto)){
    $result = $d->ubah_foto($id_dosen, $foto);
    if ($result) {
        $upload = move_uploaded_file($temp_foto, $dir_dosen.$foto);
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
