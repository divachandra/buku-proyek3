<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();
if (isset($_POST['username'], $_POST['password'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    if (!empty($user) && !empty($pass)) {
        $m->login_mahasiswa($user, $pass);        
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosong';
        echo json_encode($json);
    }
}
?>