package com.divakrishnam.actspotmahasiswa.activity;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;
import com.bumptech.glide.Glide;
import com.divakrishnam.actspotmahasiswa.R;
import com.divakrishnam.actspotmahasiswa.api.APIClient;
import com.divakrishnam.actspotmahasiswa.api.APIService;
import com.divakrishnam.actspotmahasiswa.model.Login;
import com.divakrishnam.actspotmahasiswa.model.ResponseInfo;
import com.divakrishnam.actspotmahasiswa.util.SharedPrefManager;
import com.divakrishnam.actspotmahasiswa.util.Urls;
import com.theartofdev.edmodo.cropper.CropImage;
import com.theartofdev.edmodo.cropper.CropImageView;
import java.io.File;
import java.io.IOException;
import id.zelory.compressor.Compressor;
import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import pl.aprilapps.easyphotopicker.DefaultCallback;
import pl.aprilapps.easyphotopicker.EasyImage;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
public class ProfileActivity extends AppCompatActivity implements View.OnClickListener {
    private ImageView ivProfil;
    private TextView tvNama, tvEditNama, tvKelas, tvEditKelas, tvAngkatan, tvEditAngkatan, tvKontak, tvEditKontak, tvProdi, tvDosen, tvPembimbing, tvPerusahaan, tvUsername, tvEditUsername;
    private SharedPrefManager pref;
    private APIService mApiInterface;
    private static final int REQUEST_IMAGE = 200;
    private static final int REQUEST_PHOTO = 300;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);
        ivProfil = findViewById(R.id.img_profile);
        tvNama = findViewById(R.id.tv_nama);
        tvEditNama = findViewById(R.id.tv_edit_nama);
        tvKelas = findViewById(R.id.tv_kelas);
        tvEditKelas = findViewById(R.id.tv_edit_kelas);
        tvAngkatan = findViewById(R.id.tv_angkatan);
        tvEditAngkatan = findViewById(R.id.tv_edit_angkatan);
        tvKontak = findViewById(R.id.tv_kontak);
        tvEditKontak = findViewById(R.id.tv_edit_kontak);
        tvProdi = findViewById(R.id.tv_prodi);
        tvDosen = findViewById(R.id.tv_dosen);
        tvPembimbing = findViewById(R.id.tv_pembimbing);
        tvPerusahaan = findViewById(R.id.tv_perusahaan);
        tvUsername = findViewById(R.id.tv_username);
        tvEditUsername = findViewById(R.id.tv_edit_username);
        pref = SharedPrefManager.getInstance(getApplicationContext());
        mApiInterface = APIClient.getClient().create(APIService.class);
        ivProfil.setOnClickListener(this);
        tvEditUsername.setOnClickListener(this);
        tvEditAngkatan.setOnClickListener(this);
        tvEditKontak.setOnClickListener(this);
        tvEditKelas.setOnClickListener(this);
        tvEditNama.setOnClickListener(this);
    }
    @Override
    protected void onResume() {
        super.onResume();
        Login mahasiswa = pref.getMahasiswaLogin();
        if (mahasiswa != null){
            getSupportActionBar().setTitle(mahasiswa.getNamaMahasiswa());
            tvNama.setText(mahasiswa.getNamaMahasiswa());
            tvKelas.setText(mahasiswa.getKelasMahasiswa());
            tvAngkatan.setText(mahasiswa.getAngkatanMahasiswa());
            tvProdi.setText(mahasiswa.getNamaProdi());
            tvDosen.setText(mahasiswa.getNamaDosen());
            tvPembimbing.setText(mahasiswa.getNamaPembimbing());
            tvPerusahaan.setText(mahasiswa.getNamaPerusahaan());
            tvUsername.setText(mahasiswa.getUsername());
            tvKontak.setText(mahasiswa.getKontakMahasiswa());
            Glide.with(this).load(Urls.IMAGE_URL+"mahasiswa/"+pref.getMahasiswaLogin().getFotoMahasiswa()).error(R.drawable.profile).into(ivProfil);
        }
    }
    @Override
    public void onClick(View view) {
        if (view == ivProfil){
            menuDialog();
        }else if (view == tvEditUsername){
            Intent text = new Intent(getApplicationContext(), TextActivity.class);
            text.putExtra(TextActivity.EXTRA_USER, pref.getMahasiswaLogin().getUsername());
            startActivity(text);
        }else if (view == tvEditAngkatan){
            Intent text = new Intent(getApplicationContext(), SpinnerActivity.class);
            text.putExtra(SpinnerActivity.EXTRA_TEXT, pref.getMahasiswaLogin().getAngkatanMahasiswa());
            startActivity(text);
        }else if (view == tvEditKontak){
            Intent text = new Intent(getApplicationContext(), TextActivity.class);
            text.putExtra(TextActivity.EXTRA_KONTAK, pref.getMahasiswaLogin().getKontakMahasiswa());
            startActivity(text);
        }else if (view == tvEditKelas){
            Intent text = new Intent(getApplicationContext(), SpinnerActivity.class);
            text.putExtra(SpinnerActivity.EXTRA_TEXT, pref.getMahasiswaLogin().getKelasMahasiswa());
            startActivity(text);
        }else if (view == tvEditNama){
            Intent text = new Intent(getApplicationContext(), TextActivity.class);
            text.putExtra(TextActivity.EXTRA_NAMA, pref.getMahasiswaLogin().getNamaMahasiswa());
            startActivity(text);
        }
    }
    private void menuDialog(){
        CharSequence[] menu = {"Camera", "Select Photo"};
        AlertDialog.Builder dialog = new AlertDialog.Builder(this)
                .setItems(menu, (dialogInterface, i) -> {
                    switch (i){
                        case 0:
                            EasyImage.openCamera(this, REQUEST_IMAGE);
                            break;
                        case 1:
                            EasyImage.openChooserWithGallery(this, "Choose Picture",REQUEST_PHOTO);
                            break;
                    }
                });
        dialog.create();
        dialog.show();
    }
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        EasyImage.handleActivityResult(requestCode, resultCode, data, this, new DefaultCallback() {
            @Override
            public void onImagePicked(File imageFile, EasyImage.ImageSource source, int type) {
                CropImage.activity(Uri.fromFile(imageFile))
                        .setGuidelines(CropImageView.Guidelines.ON)
                        .setCropShape(CropImageView.CropShape.OVAL)
                        .setFixAspectRatio(true)
                        .start(ProfileActivity.this);
            }
            @Override
            public void onImagePickerError(Exception e, EasyImage.ImageSource source, int type) {
                super.onImagePickerError(e, source, type);
                Toast.makeText(ProfileActivity.this, e.getMessage(), Toast.LENGTH_SHORT).show();
            }
            @Override
            public void onCanceled(EasyImage.ImageSource source, int type) {
                super.onCanceled(source, type);
            }
        });
        if (requestCode == CropImage.CROP_IMAGE_ACTIVITY_REQUEST_CODE) {
            CropImage.ActivityResult result = CropImage.getActivityResult(data);
            if (resultCode == RESULT_OK) {
                Uri resultUri = result.getUri();
                simpanFoto(resultUri);
            } else if (resultCode == CropImage.CROP_IMAGE_ACTIVITY_RESULT_ERROR_CODE) {
                Exception error = result.getError();
                Toast.makeText(this, error.toString(), Toast.LENGTH_SHORT).show();
            }
        }
    }
    public void simpanFoto(Uri resultUri){
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();
        File image = new File(resultUri.getPath());
        File file = null;
        try {
            file = new Compressor(getApplicationContext()).compressToFile(image);
        } catch (IOException e) {
            e.printStackTrace();
        }
        String idMahasiswa = pref.getMahasiswaLogin().getIdMahasiswa();
        String namaFile = file.getName();
        if (!idMahasiswa.isEmpty() && !namaFile.isEmpty()){
            RequestBody mIdDosen = RequestBody.create(MediaType.parse("text/plain"), idMahasiswa);
            RequestBody requestFile = RequestBody.create(MediaType.parse("multipart/form-data"), file);
            MultipartBody.Part mFotoMahasiswa = MultipartBody.Part.createFormData("foto", file.getName(), requestFile);
            Call<ResponseInfo> call = mApiInterface.mahasiswaUbahFoto(mIdDosen, mFotoMahasiswa);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        Login login = pref.getMahasiswaLogin();
                        login.setFotoMahasiswa(namaFile);
                        pref.mahasiswaLogin(login);
                        recreate();
                    }
                }
                @Override
                public void onFailure(Call<ResponseInfo> call, Throwable t) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }else{
            progressDialog.dismiss();
            Toast.makeText(getApplicationContext(), "Something empty", Toast.LENGTH_LONG).show();
        }
    }
}
