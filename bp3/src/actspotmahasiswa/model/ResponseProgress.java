package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
import java.util.List;
public class ResponseProgress {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    @SerializedName("data")
    private List<Progress> data;
    public ResponseProgress(String status, String message, List<Progress> data) {
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
    public List<Progress> getData() {
        return data;
    }
}
