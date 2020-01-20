<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();
$m->list_pembimbing();
?>