package com.divakrishnam.actspotpembimbingeksternal.activity;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.FileProvider;

import android.app.ProgressDialog;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.api.APIClient;
import com.divakrishnam.actspotpembimbingeksternal.api.APIService;
import com.divakrishnam.actspotpembimbingeksternal.model.Login;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseInfo;
import com.divakrishnam.actspotpembimbingeksternal.util.SharedPrefManager;
import com.divakrishnam.actspotpembimbingeksternal.util.Urls;
import com.theartofdev.edmodo.cropper.CropImage;
import com.theartofdev.edmodo.cropper.CropImageView;

import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

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

    private ImageView imgProfile;
    private TextView tvNama, tvEditNama, tvKontak, tvEditKontak, tvPerusahaan, tvEditPerusahaan, tvUsername, tvEditUsername;

    private SharedPrefManager pref;
    private APIService mApiInterface;

    private static final int REQUEST_IMAGE = 200;
    private static final int REQUEST_PHOTO = 300;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        imgProfile = findViewById(R.id.img_profile);
        tvNama = findViewById(R.id.tv_nama);
        tvEditNama = findViewById(R.id.tv_edit_nama);
        tvKontak = findViewById(R.id.tv_kontak);
        tvEditKontak = findViewById(R.id.tv_edit_kontak);
        tvPerusahaan = findViewById(R.id.tv_perusahaan);
        tvEditPerusahaan = findViewById(R.id.tv_edit_perusahaan);
        tvUsername = findViewById(R.id.tv_username);
        tvEditUsername = findViewById(R.id.tv_edit_username);

        pref = SharedPrefManager.getInstance(getApplicationContext());
        mApiInterface = APIClient.getClient().create(APIService.class);


        imgProfile.setOnClickListener(this);
        tvEditNama.setOnClickListener(this);
        tvEditUsername.setOnClickListener(this);
        tvEditPerusahaan.setOnClickListener(this);
        tvEditKontak.setOnClickListener(this);
    }

    @Override
    protected void onResume() {
        Login pembimbing = pref.getPembimbing();
        if (pembimbing!=null){
            tvNama.setText(pembimbing.getNamaPembimbing());
            tvKontak.setText(pembimbing.getKontakPembimbing());
            tvPerusahaan.setText(pembimbing.getNamaPerusahaan());
            tvUsername.setText(pembimbing.getUsername());
            Glide.with(this).load(Urls.IMAGE_URL+"pembimbing/"+pembimbing.getFotoPembimbing()).error(R.drawable.profile).into(imgProfile);
        }

        super.onResume();
    }

    @Override
    public void onClick(View view) {
        if (view == imgProfile){
            menuDialog();
        }else if (view == tvEditNama){
            Intent text = new Intent(getApplicationContext(), TextActivity.class);
            text.putExtra(TextActivity.EXTRA_NAMA, pref.getPembimbing().getNamaPembimbing());
            startActivity(text);
        }else if(view == tvEditKontak){
            Intent text = new Intent(getApplicationContext(), TextActivity.class);
            text.putExtra(TextActivity.EXTRA_KONTAK, pref.getPembimbing().getKontakPembimbing());
            startActivity(text);
        }else if (view == tvEditPerusahaan){
            Intent text = new Intent(getApplicationContext(), TextActivity.class);
            text.putExtra(TextActivity.EXTRA_PERUSAHAAN, pref.getPembimbing().getNamaPerusahaan());
            startActivity(text);
        }else if (view == tvEditUsername){
            Intent text = new Intent(getApplicationContext(), TextActivity.class);
            text.putExtra(TextActivity.EXTRA_USER, pref.getPembimbing().getUsername());
            startActivity(text);
        }
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

        String idPembimbing = pref.getPembimbing().getIdPembimbing();
        String namaFile = file.getName();

        if (!idPembimbing.isEmpty() && !namaFile.isEmpty()){
            RequestBody mIdPembimbing = RequestBody.create(MediaType.parse("text/plain"), idPembimbing);
            RequestBody requestFile = RequestBody.create(MediaType.parse("multipart/form-data"), file);
            MultipartBody.Part mFotoPembimbing = MultipartBody.Part.createFormData("foto", file.getName(), requestFile);

            Call<ResponseInfo> call = mApiInterface.pembimbingUbahFoto(mIdPembimbing, mFotoPembimbing);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        Login login = pref.getPembimbing();
                        login.setFotoPembimbing(namaFile);
                        pref.pembimbingLogin(login);
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
}
