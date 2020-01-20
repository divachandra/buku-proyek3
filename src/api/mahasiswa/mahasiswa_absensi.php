<?php
include('mahasiswa.php');
header('Content-Type: application/json');
$m = new Mahasiswa();
if (isset($_POST['id_intern'], $_POST['id_mahasiswa'], $_POST['id_dosen'], $_POST['latitude_absensi'], $_POST['longitude_absensi'], $_POST['imei_perangkat'], $_POST['id_kegiatan'], $_FILES['foto_absensi']['name'], $_POST['tgl_waktu'])) {
    $id_intern = $_POST['id_intern'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_dosen = $_POST['id_dosen'];
    $latitude_absensi = $_POST['latitude_absensi'];
    $longitude_absensi = $_POST['longitude_absensi'];
    $imei_perangkat = $_POST['imei_perangkat'];
    $id_kegiatan = $_POST['id_kegiatan'];
    $tgl_waktu = $_POST['tgl_waktu'];
    $foto_absensi = $_FILES['foto_absensi']['name'];
    $temp_foto_absensi = $_FILES['foto_absensi']['tmp_name'];

    $dir_absensi = "../images/absensi/";

    if (!empty($id_intern) && !empty($id_mahasiswa) && !empty($id_dosen) && !empty($latitude_absensi)
    && !empty($longitude_absensi) && !empty($imei_perangkat) && !empty($id_kegiatan) && !empty($tgl_waktu)
    && !empty($foto_absensi)) {
        $take_absensi = $m->ambil_absensi($id_intern, $id_mahasiswa, $id_dosen, $latitude_absensi, $longitude_absensi, $imei_perangkat, $id_kegiatan, $foto_absensi, $tgl_waktu);
        if ($take_absensi) {
            $upload = move_uploaded_file($temp_foto_absensi, $dir_absensi.$foto_absensi);
            if (!$upload) {
                $json['status']  = 400;
                $json['message'] = 'Gambar gagal terupload';
                echo json_encode($json);
            }
        }
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
