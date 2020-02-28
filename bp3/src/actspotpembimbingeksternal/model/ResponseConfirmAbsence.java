package com.divakrishnam.actspotpembimbingeksternal.model;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class ResponseConfirmAbsence {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    @SerializedName("data")
    private List<ConfirmAbsence> data;

    public ResponseConfirmAbsence(String status, String message, List<ConfirmAbsence> data) {
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

    public List<ConfirmAbsence> getData() {
        return data;
    }
}
