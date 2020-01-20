<?php
include('pembimbing.php');
header('Content-Type: application/json');
$p = new Pembimbing();
if (isset($_POST['id_pembimbing'])) {
    $id_pembimbing = $_POST['id_pembimbing'];
    if (!empty($id_pembimbing)) {
        $p->list_konfirm_absensi($id_pembimbing);
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
