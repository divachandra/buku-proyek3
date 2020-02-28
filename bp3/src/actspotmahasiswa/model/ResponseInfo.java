package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
public class ResponseInfo {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    public ResponseInfo(String status, String message) {
        this.status = status;
        this.message = message;
    }
    public String getStatus() {
        return status;
    }
    public String getMessage() {
        return message;
    }
}
