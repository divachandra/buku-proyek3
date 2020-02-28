package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
public class Pembimbing {
    @SerializedName("id_pembimbing")
    private String idPembimbing;
    @SerializedName("nama_pembimbing")
    private String namaPembimbing;
    @SerializedName("nama_perusahaan")
    private String namaPerusahaan;
    public Pembimbing(String idPembimbing, String namaPembimbing, String namaPerusahaan) {
        this.idPembimbing = idPembimbing;
        this.namaPembimbing = namaPembimbing;
        this.namaPerusahaan = namaPerusahaan;
    }
    public String getIdPembimbing() {
        return idPembimbing;
    }
    public String getNamaPembimbing() {
        return namaPembimbing;
    }
    public String getNamaPerusahaan() {
        return namaPerusahaan;
    }
}
