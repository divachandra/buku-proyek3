<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();
if (isset($_POST['id_intern'], $_POST['id_mahasiswa'], $_POST['id_pembimbing'], $_POST['latitude_perusahaan'], $_POST['id_dosen'], $_POST['longitude_perusahaan'], $_FILES['foto_perusahaan']['name'])) {
    $id_intern = $_POST['id_intern'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_dosen = $_POST['id_dosen'];
    $id_pembimbing = $_POST['id_pembimbing'];
    $latitude_perusahaan = $_POST['latitude_perusahaan'];
    $longitude_perusahaan = $_POST['longitude_perusahaan'];
    $foto_perusahaan = $_FILES['foto_perusahaan']['name'];
    $temp_foto_perusahaan = $_FILES['foto_perusahaan']['tmp_name'];
    $dir_perusahaan = "../images/perusahaan/";
    if (!empty($id_dosen) && !empty($id_intern) && !empty($id_mahasiswa) && !empty($id_pembimbing) && !empty($latitude_perusahaan) && !empty($longitude_perusahaan) && !empty($foto_perusahaan)) {
        if ($m->get_distance($id_pembimbing) == false) {
            $json['status']  = 400;
            $json['message'] = 'Jarak kosong';
            echo json_encode($json);
        } else {
            $distance = $m->get_distance($id_pembimbing);
            $gap = $m->distance($latitude_perusahaan, $longitude_perusahaan, $distance['lat'], $distance['lon']);
            if ($gap>500) {
                $json['status']  = 300;
                $json['message'] = 'Jarak terlalu jauh, '.$gap.$latitude_perusahaan. $longitude_perusahaan. $distance['lat']. $distance['lon'];
                echo json_encode($json);
            } else {
                $registrasi_perusahaan = $m->registrasi_perusahaan($id_intern, $id_mahasiswa, $id_pembimbing, $latitude_perusahaan, $longitude_perusahaan, $foto_perusahaan, $id_dosen);
                if ($registrasi_perusahaan) {
                    $upload = move_uploaded_file($temp_foto_perusahaan, $dir_perusahaan.$foto_perusahaan);
                    if (!$upload) {
                        $json['status']  = 400;
                        $json['message'] = 'Gambar gagal terupload';
                        echo json_encode($json);
                    }
                }
            }
        }
    } else {
        $json['status']  = 100;
        $json['message'] = 'Field tidak boleh kosongs';
        echo json_encode($json);
    }
} else {
    $json['status']  = 100;
    $json['message'] = 'Field tidak boleh kosong';
    echo json_encode($json);
}
