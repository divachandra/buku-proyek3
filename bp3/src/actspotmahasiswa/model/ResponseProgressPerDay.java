package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
import java.util.List;
public class ResponseProgressPerDay {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    @SerializedName("data")
    private List<ProgressPerDay> data;
    public ResponseProgressPerDay(String status, String message, List<ProgressPerDay> data) {
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
    public List<ProgressPerDay> getData() {
        return data;
    }
}
