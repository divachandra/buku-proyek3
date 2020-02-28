package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
public class Notification {
    @SerializedName("id_intern")
    private String idIntern;
    @SerializedName("pesan")
    private String pesan;
    @SerializedName("tgl_waktu")
    private String tglWaktu;
    public Notification(String idIntern, String pesan, String tglWaktu) {
        this.idIntern = idIntern;
        this.pesan = pesan;
        this.tglWaktu = tglWaktu;
    }
    public String getIdIntern() {
        return idIntern;
    }
    public String getPesan() {
        return pesan;
    }
    public String getTglWaktu() {
        return tglWaktu;
    }
}
