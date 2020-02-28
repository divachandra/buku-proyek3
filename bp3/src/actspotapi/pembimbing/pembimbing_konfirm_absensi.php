<?php
include('pembimbing.php');
header('Content-Type: application/json');
$p = new Pembimbing();
if (isset($_POST['id_intern'], $_POST['id_pembimbing'], $_POST['id_mahasiswa'], $_POST['id_dosen'], $_POST['id_absensi'])) {
    $id_intern = $_POST['id_intern'];
    $id_pembimbing = $_POST['id_pembimbing'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_dosen = $_POST['id_dosen'];
    $id_absensi = $_POST['id_absensi'];
    if (!empty($id_intern) && !empty($id_pembimbing) && !empty($id_mahasiswa) && !empty($id_dosen) && !empty($id_absensi)) {
        $p->konfirm_absensi($id_intern, $id_pembimbing, $id_mahasiswa, $id_dosen, $id_absensi);
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
