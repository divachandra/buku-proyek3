<?php
include('pembimbing.php');
header('Content-Type: application/json');
$p = new Pembimbing();
if (isset($_POST['nama_pembimbing'], $_POST['kontak_pembimbing'], $_POST['nama_perusahaan'], $_POST['username'], $_POST['password'], $_POST['latitude_perusahaan'], $_POST['longitude_perusahaan'])) {
    $nama_pembimbing = $_POST['nama_pembimbing'];
    $kontak_pembimbing = $_POST['kontak_pembimbing'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $latitude_perusahaan = $_POST['latitude_perusahaan'];
    $longitude_perusahaan = $_POST['longitude_perusahaan'];

    if (!empty($nama_pembimbing) && !empty($kontak_pembimbing) && !empty($nama_perusahaan) && !empty($username) && !empty($password) && !empty($latitude_perusahaan) && !empty($longitude_perusahaan)) {
        $p->registrasi_pembimbing($nama_pembimbing, $kontak_pembimbing, $nama_perusahaan, $username, $password, $latitude_perusahaan, $longitude_perusahaan);
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosong';
        echo json_encode($json);
    }
} else {
    $json['status']  = 100;
    $json['message'] = 'Field tidak boleh kosong';
    echo json_encode($json);
}
