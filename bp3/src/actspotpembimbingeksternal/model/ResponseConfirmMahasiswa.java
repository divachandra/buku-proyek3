package com.divakrishnam.actspotpembimbingeksternal.model;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class ResponseConfirmMahasiswa {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    @SerializedName("data")
    private List<ConfirmMahasiswa> data;

    public ResponseConfirmMahasiswa(String status, String message, List<ConfirmMahasiswa> data) {
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

    public List<ConfirmMahasiswa> getData() {
        return data;
    }
}
