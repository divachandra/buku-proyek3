package com.divakrishnam.actspotpembimbinginternal.model;

import com.google.gson.annotations.SerializedName;

public class ProgressPerDay {
    @SerializedName("id_absensi")
    private String idAbsensi;
    @SerializedName("tgl_waktu")
    private String tglWaktu;
    @SerializedName("kegiatan")
    private String kegiatan;
    @SerializedName("foto_absensi")
    private String fotoAbsensi;
    @SerializedName("pergeseran")
    private String pergeseran;

    public ProgressPerDay(String idAbsensi, String tglWaktu, String kegiatan, String fotoAbsensi, String pergeseran) {
        this.idAbsensi = idAbsensi;
        this.tglWaktu = tglWaktu;
        this.kegiatan = kegiatan;
        this.fotoAbsensi = fotoAbsensi;
        this.pergeseran = pergeseran;
    }

    public String getIdAbsensi() {
        return idAbsensi;
    }

    public String getTglWaktu() {
        return tglWaktu;
    }

    public String getKegiatan() {
        return kegiatan;
    }

    public String getFotoAbsensi() {
        return fotoAbsensi;
    }

    public String getPergeseran() {
        return pergeseran;
    }
}
