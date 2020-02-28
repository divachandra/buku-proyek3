<?php
include('dosen.php');
header('Content-Type: application/json');
$d = new Dosen();
if (isset($_POST['id_intern'], $_POST['id_pembimbing'], $_POST['id_mahasiswa'], $_POST['id_dosen'], $_POST['tgl'])) {
    $id_intern = $_POST['id_intern'];
    $id_pembimbing = $_POST['id_pembimbing'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_dosen = $_POST['id_dosen'];
    $tgl = $_POST['tgl'];
    if (!empty($id_intern) && !empty($id_pembimbing) && !empty($id_mahasiswa) && !empty($id_dosen) && !empty($tgl)) {
        $d->detail_konfirm_absensi($id_dosen, $id_intern, $id_mahasiswa, $id_pembimbing, $tgl);
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosong';
        echo json_encode($json);
    } 
}else {
    $json['status']  = 100;
    $json['message'] = 'Field tidak boleh kosongs';
    echo json_encode($json);
}