package com.divakrishnam.actspotpembimbinginternal.model;

import com.google.gson.annotations.SerializedName;

public class ResponseLogin {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    @SerializedName("data")
    private Login data;

    public ResponseLogin(String status, String message, Login data) {
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

    public Login getData() {
        return data;
    }
}
