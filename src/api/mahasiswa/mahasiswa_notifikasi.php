<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();
if (isset($_POST['id_intern'], $_POST['id_mahasiswa'])) {
    $id_intern = $_POST['id_intern'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    if (!empty($id_intern) && !empty($id_mahasiswa)) {
        $m->list_notifikasi($id_intern, $id_mahasiswa);
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosongs';
        echo json_encode($json);
    }
} else {
    $json['status']  = 100;
    $json['message'] = 'Field tidak boleh kosong';
    echo json_encode($json);
}
