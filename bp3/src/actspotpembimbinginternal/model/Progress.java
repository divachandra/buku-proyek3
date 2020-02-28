package com.divakrishnam.actspotpembimbinginternal.model;

import com.google.gson.annotations.SerializedName;

public class Progress {
    @SerializedName("sort")
    private String sort;
    @SerializedName("persen")
    private String persen;
    @SerializedName("tgl_waktu")
    private String tglWaktu;
    @SerializedName("id_mahasiswa")
    private String idMahasiswa;
    @SerializedName("id_intern")
    private String idIntern;

    public Progress(String sort, String persen, String tglWaktu, String idMahasiswa, String idIntern) {
        this.sort = sort;
        this.persen = persen;
        this.tglWaktu = tglWaktu;
        this.idMahasiswa = idMahasiswa;
        this.idIntern = idIntern;
    }

    public String getSort() {
        return sort;
    }

    public String getPersen() {
        return persen;
    }

    public String getTglWaktu() {
        return tglWaktu;
    }

    public String getIdMahasiswa() {
        return idMahasiswa;
    }

    public String getIdIntern() {
        return idIntern;
    }
}

