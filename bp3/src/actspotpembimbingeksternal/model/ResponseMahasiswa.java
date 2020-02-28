package com.divakrishnam.actspotpembimbingeksternal.model;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class ResponseMahasiswa {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    @SerializedName("data")
    private List<Mahasiswa> data;

    public ResponseMahasiswa(String status, String message, List<Mahasiswa> data) {
        this.status = status;
        this.message = message;
        this.data = data;
    }

    public String getStatus() {
        return status;
    }

    public String getMessage() {
        return message;
    }

    public List<Mahasiswa> getData() {
        return data;
    }
}
