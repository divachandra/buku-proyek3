package com.divakrishnam.actspotpembimbinginternal.api;

import com.divakrishnam.actspotpembimbinginternal.model.ResponseInfo;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseLogin;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseMahasiswa;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseNotification;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseProgress;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseProgressPerDay;

import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;

public interface APIService {
    @FormUrlEncoded
    @POST("dosen/dosen_login.php")
    Call<ResponseLogin> dosenLogin(
            @Field("username") String username,
            @Field("password") String password
    );

    @FormUrlEncoded
    @POST("dosen/dosen_mahasiswa.php")
    Call<ResponseMahasiswa> dosenMahasiswa(
            @Field("id_dosen") String id_dosen
    );

    @FormUrlEncoded
    @POST("dosen/dosen_progress.php")
    Call<ResponseProgress> progressMahasiswa(
            @Field("id_intern") String idIntern,
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("sort") String sort
    );

    @FormUrlEncoded
    @POST("dosen/dosen_progress_harian.php")
    Call<ResponseProgressPerDay> progressPerDayMahasiswa(
            @Field("id_intern") String idIntern,
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("tgl") String tgl
    );

    @FormUrlEncoded
    @POST("dosen/dosen_notifikasi.php")
    Call<ResponseNotification> dosenNotifikasi(
            @Field("id_dosen") String id_dosen
    );

    //Ubah

    @FormUrlEncoded
    @POST("dosen/dosen_ubah.php")
    Call<ResponseInfo> dosenUbahUsername(
            @Field("id_dosen") String id_dosen,
            @Field("username") String username
    );

    @FormUrlEncoded
    @POST("dosen/dosen_ubah.php")
    Call<ResponseInfo> dosenUbahPassword(
            @Field("id_dosen") String id_dosen,
            @Field("password") String password
    );

    @FormUrlEncoded
    @POST("dosen/dosen_ubah.php")
    Call<ResponseInfo> dosenUbahNama(
            @Field("id_dosen") String id_dosen,
            @Field("nama") String nama
    );

    @FormUrlEncoded
    @POST("dosen/dosen_ubah.php")
    Call<ResponseInfo> dosenUbahKontak(
            @Field("id_dosen") String id_dosen,
            @Field("kontak") String kontak
    );

    @Multipart
    @POST("dosen/dosen_ubah.php")
    Call<ResponseInfo> dosenUbahFoto(
            @Part("id_dosen") RequestBody id_dosen,
            @Part MultipartBody.Part foto
    );
}
