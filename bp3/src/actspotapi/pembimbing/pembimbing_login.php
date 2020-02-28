<?php
include('pembimbing.php');
header('Content-Type: application/json');
$p = new Pembimbing();
if (isset($_POST['username'], $_POST['password'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    if (!empty($user) && !empty($pass)) {
        $p->login_pembimbing($user, $pass);        
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosong';
        echo json_encode($json);
    }
}
?>