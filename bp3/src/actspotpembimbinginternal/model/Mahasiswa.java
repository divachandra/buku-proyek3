package com.divakrishnam.actspotpembimbinginternal.model;

import android.os.Parcel;
import android.os.Parcelable;

import com.google.gson.annotations.SerializedName;

public class Mahasiswa implements Parcelable {
    @SerializedName("id_intern")
    private String idIntern;
    @SerializedName("id_mahasiswa")
    private String idMahasiswa;
    @SerializedName("nama_perusahaan")
    private String namaPerusahaan;
    @SerializedName("nama_mahasiswa")
    private String namaMahasiswa;
    @SerializedName("foto_mahasiswa")
    private String fotoMahasiswa;
    @SerializedName("angkatan_mahasiswa")
    private String angkatanMahasiswa;
    @SerializedName("foto_perusahaan")
    private String fotoPerusahaan;
    @SerializedName("kelas_mahasiswa")
    private String kelasMahasiswa;
    @SerializedName("nama_prodi")
    private String namaProdi;
    @SerializedName("nama_pembimbing")
    private String namaPembimbing;
    @SerializedName("latitude_perusahaan")
    private String latitudePerusahaan;
    @SerializedName("longitude_perusahaan")
    private String longitudePerusahaan;
    @SerializedName("presentase_internship")
    private String presentaseInternship;

    public Mahasiswa(String idIntern, String idMahasiswa, String namaPerusahaan, String namaMahasiswa, String fotoMahasiswa, String angkatanMahasiswa, String fotoPerusahaan, String kelasMahasiswa, String namaProdi, String namaPembimbing, String latitudePerusahaan, String longitudePerusahaan, String presentaseInternship) {
        this.idIntern = idIntern;
        this.idMahasiswa = idMahasiswa;
        this.namaPerusahaan = namaPerusahaan;
        this.namaMahasiswa = namaMahasiswa;
        this.fotoMahasiswa = fotoMahasiswa;
        this.angkatanMahasiswa = angkatanMahasiswa;
        this.fotoPerusahaan = fotoPerusahaan;
        this.kelasMahasiswa = kelasMahasiswa;
        this.namaProdi = namaProdi;
        this.namaPembimbing = namaPembimbing;
        this.latitudePerusahaan = latitudePerusahaan;
        this.longitudePerusahaan = longitudePerusahaan;
        this.presentaseInternship = presentaseInternship;
    }

    public String getIdMahasiswa() {
        return idMahasiswa;
    }

    public String getNamaPerusahaan() {
        return namaPerusahaan;
    }

    public String getNamaMahasiswa() {
        return namaMahasiswa;
    }

    public String getFotoMahasiswa() {
        return fotoMahasiswa;
    }

    public String getAngkatanMahasiswa() {
        return angkatanMahasiswa;
    }

    public String getFotoPerusahaan() {
        return fotoPerusahaan;
    }

    public String getKelasMahasiswa() {
        return kelasMahasiswa;
    }

    public String getNamaProdi() {
        return namaProdi;
    }

    public String getNamaPembimbing() {
        return namaPembimbing;
    }

    public String getLatitudePerusahaan() {
        return latitudePerusahaan;
    }

    public String getLongitudePerusahaan() {
        return longitudePerusahaan;
    }

    public String getIdIntern() {
        return idIntern;
    }

    public String getPresentaseInternship() {
        return presentaseInternship;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(this.idIntern);
        dest.writeString(this.idMahasiswa);
        dest.writeString(this.namaPerusahaan);
        dest.writeString(this.namaMahasiswa);
        dest.writeString(this.fotoMahasiswa);
        dest.writeString(this.angkatanMahasiswa);
        dest.writeString(this.fotoPerusahaan);
        dest.writeString(this.kelasMahasiswa);
        dest.writeString(this.namaProdi);
        dest.writeString(this.namaPembimbing);
        dest.writeString(this.latitudePerusahaan);
        dest.writeString(this.longitudePerusahaan);
    }

    protected Mahasiswa(Parcel in) {
        this.idIntern = in.readString();
        this.idMahasiswa = in.readString();
        this.namaPerusahaan = in.readString();
        this.namaMahasiswa = in.readString();
        this.fotoMahasiswa = in.readString();
        this.angkatanMahasiswa = in.readString();
        this.fotoPerusahaan = in.readString();
        this.kelasMahasiswa = in.readString();
        this.namaProdi = in.readString();
        this.namaPembimbing = in.readString();
        this.latitudePerusahaan = in.readString();
        this.longitudePerusahaan = in.readString();
    }

    public static final Creator<Mahasiswa> CREATOR = new Creator<Mahasiswa>() {
        @Override
        public Mahasiswa createFromParcel(Parcel source) {
            return new Mahasiswa(source);
        }

        @Override
        public Mahasiswa[] newArray(int size) {
            return new Mahasiswa[size];
        }
    };
}
