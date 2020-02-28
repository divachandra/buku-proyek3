<?php
include('dosen.php');
header('Content-Type: application/json');
$d = new Dosen();
if (isset($_POST['id_intern'], $_POST['id_pembimbing'], $_POST['id_mahasiswa'], $_POST['id_dosen'], $_POST['nilai'], $_POST['tgl'])) {
    $id_intern = $_POST['id_intern'];
    $id_pembimbing = $_POST['id_pembimbing'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_dosen = $_POST['id_dosen'];
    $nilai = $_POST['nilai'];
    $tgl = $_POST['tgl'];
    if (!empty($id_intern) && !empty($id_pembimbing) && !empty($id_mahasiswa) && !empty($id_dosen) && !empty($nilai) && !empty($tgl)) {
        $d->konfirm_absensi($id_intern, $id_pembimbing, $id_mahasiswa, $id_dosen, $nilai, $tgl);
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosongs';
        echo json_encode($json);
    } 
}else {
    $json['status']  = 100;
    $json['message'] = 'Field tidak boleh kosong';
    echo json_encode($json);
}