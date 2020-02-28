package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
public class Kegiatan {
    @SerializedName("id_kegiatan")
    private String idKegiatan;
    @SerializedName("nama_kegiatan")
    private String namaKegiatan;
    public Kegiatan(String idKegiatan, String namaKegiatan) {
        this.idKegiatan = idKegiatan;
        this.namaKegiatan = namaKegiatan;
    }
    public String getIdKegiatan() {
        return idKegiatan;
    }
    public String getNamaKegiatan() {
        return namaKegiatan;
    }
}
