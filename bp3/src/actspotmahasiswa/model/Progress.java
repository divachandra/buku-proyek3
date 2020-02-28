package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
public class Progress {
    @SerializedName("sort")
    private String sort;
    @SerializedName("persen")
    private String persen;
    @SerializedName("tgl_waktu")
    private String tglWaktu;
    public Progress(String sort, String persen, String tglWaktu) {
        this.sort = sort;
        this.persen = persen;
        this.tglWaktu = tglWaktu;
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
}
