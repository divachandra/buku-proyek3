package com.divakrishnam.actspotmahasiswa.api;
import com.divakrishnam.actspotmahasiswa.model.ResponseInfo;
import com.divakrishnam.actspotmahasiswa.model.ResponseKegiatan;
import com.divakrishnam.actspotmahasiswa.model.ResponseLogin;
import com.divakrishnam.actspotmahasiswa.model.ResponseNotification;
import com.divakrishnam.actspotmahasiswa.model.ResponsePembimbing;
import com.divakrishnam.actspotmahasiswa.model.ResponseProgress;
import com.divakrishnam.actspotmahasiswa.model.ResponseProgressPerDay;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;
public interface APIService {
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_registrasi.php")
    Call<ResponseInfo> mahasiswaRegistrasi(
            @Field("kode_otp") String kode_otp
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_login.php")
    Call<ResponseLogin> mahasiswaLogin(
            @Field("username") String username,
            @Field("password") String password
    );
    @GET("mahasiswa/mahasiswa_pembimbing.php")
    Call<ResponsePembimbing> getPembimbing();
    @GET("mahasiswa/mahasiswa_kegiatan.php")
    Call<ResponseKegiatan> getKegiatan();
    @Multipart
    @POST("mahasiswa/mahasiswa_perusahaan.php")
    Call<ResponseInfo> registrasiPerusahaan(
            @Part("id_dosen") RequestBody id_dosen,
            @Part("id_intern") RequestBody id_intern,
            @Part("id_mahasiswa") RequestBody id_mahasiswa,
            @Part("nama_perusahaan") RequestBody nama_perusahaan,
            @Part("id_pembimbing") RequestBody id_pembimbing,
            @Part("latitude_perusahaan") RequestBody latitude_perusahaan,
            @Part("longitude_perusahaan") RequestBody longitude_perusahaan,
            @Part MultipartBody.Part foto_perusahaan
    );
    @Multipart
    @POST("mahasiswa/mahasiswa_absensi.php")
    Call<ResponseInfo> takeAbsence(
            @Part("id_intern") RequestBody id_intern,
            @Part("id_mahasiswa") RequestBody id_mahasiswa,
            @Part("id_dosen") RequestBody id_dosen,
            @Part("latitude_absensi") RequestBody latitude_absensi,
            @Part("longitude_absensi") RequestBody longitude_absensi,
            @Part("imei_perangkat") RequestBody imei_perangkat,
            @Part("id_kegiatan") RequestBody id_kegiatan,
            @Part("tgl_waktu") RequestBody tgl_waktu,
            @Part("id_pembimbing") RequestBody id_pembimbing,
            @Part MultipartBody.Part foto_absensi
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_progress.php")
    Call<ResponseProgress> progressMahasiswa(
            @Field("id_intern") String idIntern,
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("sort") String sort
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_progress_harian.php")
    Call<ResponseProgressPerDay> progressPerDayMahasiswa(
            @Field("id_intern") String idIntern,
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("tgl") String tgl
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_notifikasi.php")
    Call<ResponseNotification> notificationMahasiswa(
            @Field("id_intern") String idIntern,
            @Field("id_mahasiswa") String idMahasiswa
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_ubah.php")
    Call<ResponseInfo> mahasiswaUbahUsername(
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("username") String username
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_ubah.php")
    Call<ResponseInfo> mahasiswaUbahPassword(
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("password") String password
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_ubah.php")
    Call<ResponseInfo> mahasiswaUbahNama(
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("nama") String nama
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_ubah.php")
    Call<ResponseInfo> mahasiswaUbahKontak(
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("kontak") String kontak
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_ubah.php")
    Call<ResponseInfo> mahasiswaUbahKelas(
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("kelas") String kelas
    );
    @FormUrlEncoded
    @POST("mahasiswa/mahasiswa_ubah.php")
    Call<ResponseInfo> mahasiswaUbahAngkatan(
            @Field("id_mahasiswa") String idMahasiswa,
            @Field("angkatan") String angkatan
    );
    @Multipart
    @POST("mahasiswa/mahasiswa_ubah.php")
    Call<ResponseInfo> mahasiswaUbahFoto(
            @Part("id_mahasiswa") RequestBody id_mahasiswa,
            @Part MultipartBody.Part foto
    );
}
