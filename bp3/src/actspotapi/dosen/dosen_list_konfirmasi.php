<?php
include('dosen.php');
header('Content-Type: application/json');
$d = new Dosen();
if (isset($_POST['id_dosen'])) {
    $id_dosen = $_POST['id_dosen'];
    if (!empty($id_dosen)) {
        $d->list_konfirm_absensi($id_dosen);
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosongx';
        echo json_encode($json);
    }
} else {
    $json['status']  = 100;
    $json['message'] = 'Field tidak boleh kosongs';
    echo json_encode($json);
}
