package com.divakrishnam.actspotpembimbingeksternal.model;

import android.os.Parcel;
import android.os.Parcelable;

import com.google.gson.annotations.SerializedName;

public class Mahasiswa implements Parcelable {
    @SerializedName("id_intern")
    private String idIntern;
    @SerializedName("id_mahasiswa")
    private String idMahasiswa;
    @SerializedName("nama_mahasiswa")
    private String namaMahasiswa;
    @SerializedName("foto_mahasiswa")
    private String fotoMahasiswa;
    @SerializedName("kontak_mahasiswa")
    private String kontakMahasiswa;
    @SerializedName("nama_prodi")
    private String namaProdi;
    @SerializedName("angkatan_mahasiswa")
    private String angkatanMahasiswa;

    public Mahasiswa(String idIntern, String idMahasiswa, String namaMahasiswa, String fotoMahasiswa, String kontakMahasiswa, String namaProdi, String angkatanMahasiswa) {
        this.idIntern = idIntern;
        this.idMahasiswa = idMahasiswa;
        this.namaMahasiswa = namaMahasiswa;
        this.fotoMahasiswa = fotoMahasiswa;
        this.kontakMahasiswa = kontakMahasiswa;
        this.namaProdi = namaProdi;
        this.angkatanMahasiswa = angkatanMahasiswa;
    }

    public String getIdIntern() {
        return idIntern;
    }

    public String getIdMahasiswa() {
        return idMahasiswa;
    }

    public String getNamaMahasiswa() {
        return namaMahasiswa;
    }

    public String getFotoMahasiswa() {
        return fotoMahasiswa;
    }

    public String getKontakMahasiswa() {
        return kontakMahasiswa;
    }

    public String getNamaProdi() {
        return namaProdi;
    }

    public String getAngkatanMahasiswa() {
        return angkatanMahasiswa;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(this.idIntern);
        dest.writeString(this.idMahasiswa);
        dest.writeString(this.namaMahasiswa);
        dest.writeString(this.fotoMahasiswa);
        dest.writeString(this.kontakMahasiswa);
        dest.writeString(this.namaProdi);
        dest.writeString(this.angkatanMahasiswa);
    }

    protected Mahasiswa(Parcel in) {
        this.idIntern = in.readString();
        this.idMahasiswa = in.readString();
        this.namaMahasiswa = in.readString();
        this.fotoMahasiswa = in.readString();
        this.kontakMahasiswa = in.readString();
        this.namaProdi = in.readString();
        this.angkatanMahasiswa = in.readString();
    }

    public static final Parcelable.Creator<Mahasiswa> CREATOR = new Parcelable.Creator<Mahasiswa>() {
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
