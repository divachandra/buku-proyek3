package com.divakrishnam.actspotpembimbingeksternal.model;

import com.google.gson.annotations.SerializedName;

public class ConfirmMahasiswa {
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
    @SerializedName("id_dosen")
    private String idDosen;

    public ConfirmMahasiswa(String idIntern, String idMahasiswa, String namaMahasiswa, String fotoMahasiswa, String kontakMahasiswa, String namaProdi, String idDosen) {
        this.idIntern = idIntern;
        this.idMahasiswa = idMahasiswa;
        this.namaMahasiswa = namaMahasiswa;
        this.fotoMahasiswa = fotoMahasiswa;
        this.kontakMahasiswa = kontakMahasiswa;
        this.namaProdi = namaProdi;
        this.idDosen = idDosen;
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

    public Object getFotoMahasiswa() {
        return fotoMahasiswa;
    }

    public String getKontakMahasiswa() {
        return kontakMahasiswa;
    }

    public String getNamaProdi() {
        return namaProdi;
    }

    public String getIdDosen() {
        return idDosen;
    }
}
