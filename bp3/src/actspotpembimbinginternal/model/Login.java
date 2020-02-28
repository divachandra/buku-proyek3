package com.divakrishnam.actspotpembimbinginternal.model;

import com.google.gson.annotations.SerializedName;

public class Login {
    @SerializedName("username")
    private String username;
    @SerializedName("password")
    private String password;
    @SerializedName("id_dosen")
    private String idDosen;
    @SerializedName("nama_dosen")
    private String namaDosen;
    @SerializedName("foto_dosen")
    private String fotoDosen;
//    @SerializedName("id_intern")
//    private String idIntern;
    @SerializedName("nama_prodi")
    private String namaProdi;
    @SerializedName("kontak_dosen")
    private String kontakDosen;

    public Login(String username, String password, String idDosen, String namaDosen, String fotoDosen, String namaProdi, String kontakDosen) {
        this.username = username;
        this.password = password;
        this.idDosen = idDosen;
        this.namaDosen = namaDosen;
        this.fotoDosen = fotoDosen;
        this.namaProdi = namaProdi;
        this.kontakDosen = kontakDosen;
    }

    public String getUsername() {
        return username;
    }

    public String getPassword() {
        return password;
    }

    public String getIdDosen() {
        return idDosen;
    }

    public String getNamaDosen() {
        return namaDosen;
    }

    public String getFotoDosen() {
        return fotoDosen;
    }

    public String getNamaProdi() {
        return namaProdi;
    }

    public String getKontakDosen() {
        return kontakDosen;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public void setIdDosen(String idDosen) {
        this.idDosen = idDosen;
    }

    public void setNamaDosen(String namaDosen) {
        this.namaDosen = namaDosen;
    }

    public void setFotoDosen(String fotoDosen) {
        this.fotoDosen = fotoDosen;
    }

    public void setNamaProdi(String namaProdi) {
        this.namaProdi = namaProdi;
    }

    public void setKontakDosen(String kontakDosen) {
        this.kontakDosen = kontakDosen;
    }
}
