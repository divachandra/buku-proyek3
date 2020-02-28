package com.divakrishnam.actspotpembimbingeksternal.model;

import com.google.gson.annotations.SerializedName;

public class ConfirmAbsence {
    @SerializedName("id_absensi")
    private String idAbsensi;
    @SerializedName("id_intern")
    private String idIntern;
    @SerializedName("id_mahasiswa")
    private String idMahasiswa;
    @SerializedName("nama_mahasiswa")
    private String namaMahasiswa;
    @SerializedName("foto_mahasiswa")
    private String fotoMahasiswa;
    @SerializedName("kontak_mahasiswa")
    private String kontakMahasiswa;
    @SerializedName("nama_prodi")
    private String namaProdi;
    @SerializedName("kegiatan")
    private String kegiatan;
    @SerializedName("tgl_waktu")
    private String tglWaktu;
    @SerializedName("id_dosen")
    private String idDosen;

    public ConfirmAbsence(String idAbsensi, String idIntern, String idMahasiswa, String namaMahasiswa, String fotoMahasiswa, String kontakMahasiswa, String namaProdi, String kegiatan, String tglWaktu, String idDosen) {
        this.idAbsensi = idAbsensi;
        this.idIntern = idIntern;
        this.idMahasiswa = idMahasiswa;
        this.namaMahasiswa = namaMahasiswa;
        this.fotoMahasiswa = fotoMahasiswa;
        this.kontakMahasiswa = kontakMahasiswa;
        this.namaProdi = namaProdi;
        this.kegiatan = kegiatan;
        this.tglWaktu = tglWaktu;
        this.idDosen = idDosen;
    }

    public String getIdAbsensi() {
        return idAbsensi;
    }

    public String getIdIntern() {
        return idIntern;
    }

    public String getIdMahasiswa() {
        return idMahasiswa;
    }

    public String getNamaMahasiswa() {
        return namaMahasiswa;
    }

    public String getFotoMahasiswa() {
        return fotoMahasiswa;
    }

    public String getKontakMahasiswa() {
        return kontakMahasiswa;
    }

    public String getNamaProdi() {
        return namaProdi;
    }

    public String getKegiatan() {
        return kegiatan;
    }

    public String getTglWaktu() {
        return tglWaktu;
    }

    public String getIdDosen() {
        return idDosen;
    }
}
