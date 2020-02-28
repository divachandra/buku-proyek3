<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();
if (isset($_POST['id_intern'], $_POST['id_mahasiswa'], $_POST['sort'])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_intern = $_POST['id_intern'];
    $sort = $_POST['sort'];
    if (!empty($id_intern) && !empty($id_mahasiswa) && !empty($sort)) {
        $m->progress_mahasiswa($id_intern, $id_mahasiswa, $sort);
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
