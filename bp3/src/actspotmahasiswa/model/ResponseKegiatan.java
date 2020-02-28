package com.divakrishnam.actspotmahasiswa.model;
import com.google.gson.annotations.SerializedName;
import java.util.List;
public class ResponseKegiatan {
    @SerializedName("status")
    private String status;
    @SerializedName("message")
    private String message;
    @SerializedName("data")
    private List<Kegiatan> data;
    public ResponseKegiatan(String status, String message, List<Kegiatan> data) {
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
    public List<Kegiatan> getData() {
        return data;
    }
}
