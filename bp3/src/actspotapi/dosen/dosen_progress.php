<?php
include('dosen.php');
header('Content-Type: application/json');
$d = new Dosen();
if (isset($_POST['id_intern'], $_POST['id_mahasiswa'], $_POST['sort'])) {
    $id_intern = $_POST['id_intern'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $sort = $_POST['sort'];
    if (!empty($id_intern) && !empty($id_mahasiswa) && !empty($sort)) {
        $d->progress_mahasiswa($id_intern, $id_mahasiswa, $sort);
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosong';
        echo json_encode($json);
    }
}
