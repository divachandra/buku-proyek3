<?php
include('pembimbing.php');
header('Content-Type: application/json');
$p = new Pembimbing();
if (isset($_POST['id_absensi'])) {
    $id_absensi = $_POST['id_absensi'];
    if (!empty($id_absensi)) {
        $p->konfirm_absensi($id_absensi);
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
