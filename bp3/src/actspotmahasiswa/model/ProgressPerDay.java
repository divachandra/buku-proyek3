package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
public class ProgressPerDay {
    @SerializedName("tgl_waktu")
    private String tglWaktu;
    @SerializedName("kegiatan")
    private String kegiatan;
    @SerializedName("foto_absensi")
    private String fotoAbsensi;
    @SerializedName("pergeseran")
    private String pergeseran;
    public ProgressPerDay(String tglWaktu, String kegiatan, String fotoAbsensi, String pergeseran) {
        this.tglWaktu = tglWaktu;
        this.kegiatan = kegiatan;
        this.fotoAbsensi = fotoAbsensi;
        this.pergeseran = pergeseran;
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
