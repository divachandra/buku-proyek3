package com.divakrishnam.actspotpembimbingeksternal.api;

import com.divakrishnam.actspotpembimbingeksternal.model.ResponseConfirmAbsence;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseConfirmMahasiswa;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseInfo;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseLogin;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseMahasiswa;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseNotification;

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
    @POST("pembimbing/pembimbing_login.php")
    Call<ResponseLogin> pembimbingLogin(
            @Field("username") String username,
            @Field("password") String password
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_registrasi.php")
    Call<ResponseInfo> pembimbingRegistrasi(
            @Field("nama_pembimbing") String nama_pembimbing,
            @Field("kontak_pembimbing") String kontak_pembimbing,
            @Field("nama_perusahaan") String nama_perusahaan,
            @Field("username") String username,
            @Field("password") String password,
            @Field("latitude_perusahaan") String latitude_perusahaan,
            @Field("longitude_perusahaan") String longitude_perusahaan
    );

    //List

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_notifikasi.php")
    Call<ResponseNotification> pembimbingListNotifikasi(
            @Field("id_pembimbing") String id_pembimbing
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_mahasiswa.php")
    Call<ResponseMahasiswa> pembimbingListMahasiswa(
            @Field("id_pembimbing") String id_pembimbing
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_list_konfirm_absensi.php")
    Call<ResponseConfirmAbsence> pembimbingListKonfirmAbsensi(
            @Field("id_pembimbing") String id_pembimbing
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_list_konfirm_mahasiswa.php")
    Call<ResponseConfirmMahasiswa> pembimbingListKonfirmMahasiswa(
            @Field("id_pembimbing") String id_pembimbing
    );

    //Acc

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_konfirm_mahasiswa.php")
    Call<ResponseInfo> pembimbingKonfirmMahasiswa(
            @Field("id_pembimbing") String id_pembimbing,
            @Field("id_mahasiswa") String id_mahasiswa,
            @Field("id_intern") String id_intern,
            @Field("id_dosen") String id_dosen
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_konfirm_absensi.php")
    Call<ResponseInfo> pembimbingKonfirmAbsensi(
            @Field("id_pembimbing") String id_pembimbing,
            @Field("id_mahasiswa") String id_mahasiswa,
            @Field("id_intern") String id_intern,
            @Field("id_dosen") String id_dosen,
            @Field("id_absensi") String id_absensi
    );

    //Ubah

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_ubah.php")
    Call<ResponseInfo> pembimbingUbahUsername(
            @Field("id_pembimbing") String id_pembimbing,
            @Field("username") String username
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_ubah.php")
    Call<ResponseInfo> pembimbingUbahPassword(
            @Field("id_pembimbing") String id_pembimbing,
            @Field("password") String password
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_ubah.php")
    Call<ResponseInfo> pembimbingUbahNama(
            @Field("id_pembimbing") String id_pembimbing,
            @Field("nama") String nama
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_ubah.php")
    Call<ResponseInfo> pembimbingUbahPerusahaan(
            @Field("id_pembimbing") String id_pembimbing,
            @Field("perusahaan") String perusahaan
    );

    @FormUrlEncoded
    @POST("pembimbing/pembimbing_ubah.php")
    Call<ResponseInfo> pembimbingUbahKontak(
            @Field("id_pembimbing") String id_pembimbing,
            @Field("kontak") String kontak
    );

    @Multipart
    @POST("pembimbing/pembimbing_ubah.php")
    Call<ResponseInfo> pembimbingUbahFoto(
            @Part("id_pembimbing") RequestBody id_pembimbing,
            @Part MultipartBody.Part foto
    );

}
