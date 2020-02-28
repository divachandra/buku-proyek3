package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
import java.util.List;
public class ResponsePembimbing {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    @SerializedName("data")
    private List<Pembimbing> data;
    public ResponsePembimbing(String status, String message, List<Pembimbing> data) {
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
    public List<Pembimbing> getData() {
        return data;
    }
}
