<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();
if (isset($_POST['kode_otp'])) {
    $kode_otp = $_POST['kode_otp'];
    if (!empty($kode_otp)) {
        $m->registrasi_mahasiswa($kode_otp);        
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosong';
        echo json_encode($json);
    }
}
?>