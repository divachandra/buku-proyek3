package com.divakrishnam.actspotpembimbingeksternal.model;

import com.google.gson.annotations.SerializedName;

public class Login {
    @SerializedName("username")
    private String username;
    @SerializedName("password")
    private String password;
    @SerializedName("id_pembimbing")
    private String idPembimbing;
    @SerializedName("nama_pembimbing")
    private String namaPembimbing;
    @SerializedName("nama_perusahaan")
    private String namaPerusahaan;
    @SerializedName("foto_pembimbing")
    private String fotoPembimbing;
    @SerializedName("kontak_pembimbing")
    private String kontakPembimbing;

    public Login(String username, String password, String idPembimbing, String namaPembimbing, String namaPerusahaan, String fotoPembimbing, String kontakPembimbing) {
        this.username = username;
        this.password = password;
        this.idPembimbing = idPembimbing;
        this.namaPembimbing = namaPembimbing;
        this.namaPerusahaan = namaPerusahaan;
        this.fotoPembimbing = fotoPembimbing;
        this.kontakPembimbing = kontakPembimbing;
    }

    public String getUsername() {
        return username;
    }

    public String getPassword() {
        return password;
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

    public String getFotoPembimbing() {
        return fotoPembimbing;
    }

    public String getKontakPembimbing() {
        return kontakPembimbing;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public void setIdPembimbing(String idPembimbing) {
        this.idPembimbing = idPembimbing;
    }

    public void setNamaPembimbing(String namaPembimbing) {
        this.namaPembimbing = namaPembimbing;
    }

    public void setNamaPerusahaan(String namaPerusahaan) {
        this.namaPerusahaan = namaPerusahaan;
    }

    public void setFotoPembimbing(String fotoPembimbing) {
        this.fotoPembimbing = fotoPembimbing;
    }

    public void setKontakPembimbing(String kontakPembimbing) {
        this.kontakPembimbing = kontakPembimbing;
    }
}
