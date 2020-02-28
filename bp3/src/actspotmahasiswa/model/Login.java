package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
public class Login {
    @SerializedName("id_mahasiswa")
    private String idMahasiswa;
    @SerializedName("username")
    private String username;
    @SerializedName("password")
    private String password;
    @SerializedName("nama_mahasiswa")
    private String namaMahasiswa;
    @SerializedName("kelas_mahasiswa")
    private String kelasMahasiswa;
    @SerializedName("angkatan_mahasiswa")
    private String angkatanMahasiswa;
    @SerializedName("foto_mahasiswa")
    private String fotoMahasiswa;
    @SerializedName("nama_prodi")
    private String namaProdi;
    @SerializedName("id_intern")
    private String idIntern;
    @SerializedName("id_dosen")
    private String idDosen;
    @SerializedName("nama_dosen")
    private String namaDosen;
    @SerializedName("nama_pembimbing")
    private String namaPembimbing;
    @SerializedName("id_pembimbing")
    private String idPembimbing;
    @SerializedName("nama_perusahaan")
    private String namaPerusahaan;
    @SerializedName("kontak_mahasiswa")
    private String kontakMahasiswa;
    public Login(String idIntern, String idMahasiswa, String idDosen) {
        this.idMahasiswa = idMahasiswa;
        this.idIntern = idIntern;
        this.idDosen = idDosen;
    }
    public Login(String idMahasiswa, String username, String password, String namaMahasiswa, String kelasMahasiswa, String angkatanMahasiswa, String fotoMahasiswa, String namaProdi, String idIntern, String idDosen, String namaDosen, String namaPembimbing, String idPembimbing, String namaPerusahaan, String kontakMahasiswa) {
        this.idMahasiswa = idMahasiswa;
        this.username = username;
        this.password = password;
        this.namaMahasiswa = namaMahasiswa;
        this.kelasMahasiswa = kelasMahasiswa;
        this.angkatanMahasiswa = angkatanMahasiswa;
        this.fotoMahasiswa = fotoMahasiswa;
        this.namaProdi = namaProdi;
        this.idIntern = idIntern;
        this.idDosen = idDosen;
        this.namaDosen = namaDosen;
        this.namaPembimbing = namaPembimbing;
        this.idPembimbing = idPembimbing;
        this.namaPerusahaan = namaPerusahaan;
        this.kontakMahasiswa = kontakMahasiswa;
    }
    public String getIdMahasiswa() {
        return idMahasiswa;
    }
    public String getUsername() {
        return username;
    }
    public String getPassword() {
        return password;
    }
    public String getNamaMahasiswa() {
        return namaMahasiswa;
    }
    public String getKelasMahasiswa() {
        return kelasMahasiswa;
    }
    public String getAngkatanMahasiswa() {
        return angkatanMahasiswa;
    }
    public String getFotoMahasiswa() {
        return fotoMahasiswa;
    }
    public String getNamaProdi() {
        return namaProdi;
    }
    public String getIdIntern() {
        return idIntern;
    }
    public String getIdDosen() {
        return idDosen;
    }
    public String getNamaDosen() {
        return namaDosen;
    }
    public String getNamaPerusahaan() {
        return namaPerusahaan;
    }
    public String getIdPembimbing() {
        return idPembimbing;
    }
    public String getNamaPembimbing() {
        return namaPembimbing;
    }
    public String getKontakMahasiswa() {
        return kontakMahasiswa;
    }
    public void setIdMahasiswa(String idMahasiswa) {
        this.idMahasiswa = idMahasiswa;
    }
    public void setUsername(String username) {
        this.username = username;
    }
    public void setPassword(String password) {
        this.password = password;
    }
    public void setNamaMahasiswa(String namaMahasiswa) {
        this.namaMahasiswa = namaMahasiswa;
    }
    public void setKelasMahasiswa(String kelasMahasiswa) {
        this.kelasMahasiswa = kelasMahasiswa;
    }
    public void setAngkatanMahasiswa(String angkatanMahasiswa) {
        this.angkatanMahasiswa = angkatanMahasiswa;
    }
    public void setFotoMahasiswa(String fotoMahasiswa) {
        this.fotoMahasiswa = fotoMahasiswa;
    }
    public void setNamaProdi(String namaProdi) {
        this.namaProdi = namaProdi;
    }
    public void setIdIntern(String idIntern) {
        this.idIntern = idIntern;
    }
    public void setIdDosen(String idDosen) {
        this.idDosen = idDosen;
    }
    public void setNamaDosen(String namaDosen) {
        this.namaDosen = namaDosen;
    }
    public void setNamaPembimbing(String namaPembimbing) {
        this.namaPembimbing = namaPembimbing;
    }
    public void setIdPembimbing(String idPembimbing) {
        this.idPembimbing = idPembimbing;
    }
    public void setNamaPerusahaan(String namaPerusahaan) {
        this.namaPerusahaan = namaPerusahaan;
    }
    public void setKontakMahasiswa(String kontakMahasiswa) {
        this.kontakMahasiswa = kontakMahasiswa;
    }
}
