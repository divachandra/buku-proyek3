<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();
if (isset($_POST['id_intern'], $_POST['id_mahasiswa'], $_POST['tgl'])) {
    $id_intern = $_POST['id_intern'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $tgl = $_POST['tgl'];
    if (!empty($id_intern) && !empty($id_mahasiswa) && !empty($tgl)) {
        $m->progress_mahasiswa_perhari($id_intern, $id_mahasiswa, $tgl);        
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosong';
        echo json_encode($json);
    }
}
?>