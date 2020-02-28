<?php
include('dosen.php');
header('Content-Type: application/json');
$d = new Dosen();
if (isset($_POST['id_dosen'])) {
    $id_dosen = $_POST['id_dosen'];
    if (!empty($id_dosen)) {
        $d->list_mahasiswa($id_dosen);        
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
?>