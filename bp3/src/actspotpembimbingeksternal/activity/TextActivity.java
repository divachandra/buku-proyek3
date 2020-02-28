package com.divakrishnam.actspotpembimbingeksternal.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.api.APIClient;
import com.divakrishnam.actspotpembimbingeksternal.api.APIService;
import com.divakrishnam.actspotpembimbingeksternal.model.Login;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseInfo;
import com.divakrishnam.actspotpembimbingeksternal.util.SharedPrefManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class TextActivity extends AppCompatActivity implements View.OnClickListener {

    public static final String EXTRA_NAMA = "extra_nama";
    public static final String EXTRA_KONTAK = "extra_kontak";
    public static final String EXTRA_USER = "extra_user";
    public static final String EXTRA_PERUSAHAAN = "extra_perusahaan";

    private TextView tvText;
    private EditText etText;
    private Button btnSave;

    private String user, nama, kontak, perusahaan;

    private SharedPrefManager pref;
    private APIService mApiInterface;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_text);


        tvText = findViewById(R.id.tv_text);
        etText = findViewById(R.id.et_text);
        btnSave = findViewById(R.id.btn_savetext);

        pref = SharedPrefManager.getInstance(getApplicationContext());
        mApiInterface = APIClient.getClient().create(APIService.class);

        user = getIntent().getStringExtra(EXTRA_USER);
        nama = getIntent().getStringExtra(EXTRA_NAMA);
        kontak = getIntent().getStringExtra(EXTRA_KONTAK);
        perusahaan = getIntent().getStringExtra(EXTRA_PERUSAHAAN);

        if (user!=null){
            tvText.setText("Username");
            etText.setText(user);
            etText.setSelection(user.length());
        }else if (nama!=null){
            tvText.setText("Nama");
            etText.setText(nama);
            etText.setSelection(nama.length());
        }else if (kontak!=null){
            tvText.setText("Kontak");
            etText.setText(kontak);
            etText.setSelection(kontak.length());
        }else if(perusahaan!=null){
            tvText.setText("Perusahaan");
            etText.setText(perusahaan);
            etText.setSelection(perusahaan.length());
        }

        btnSave.setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        if (view == btnSave){
            if (user!=null){
                saveUsername();
            }else if (nama!=null){
                saveNama();
            }else if (kontak!=null){
                saveKontak();
            }else if (perusahaan!=null){
                savePerusahaan();
            }
        }
    }

    private void savePerusahaan() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();

        String text = etText.getText().toString();
        String idPembimbing = pref.getPembimbing().getIdPembimbing();

        if (!text.isEmpty()){

            Call<ResponseInfo> call = mApiInterface.pembimbingUbahPerusahaan(idPembimbing, text);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        Login login = pref.getPembimbing();
                        login.setNamaPerusahaan(text);
                        pref.pembimbingLogin(login);
                        finish();
                    }
                }

                @Override
                public void onFailure(Call<ResponseInfo> call, Throwable t) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }else {
            Toast.makeText(getApplicationContext(), "Field kosong", Toast.LENGTH_SHORT).show();
            progressDialog.dismiss();
        }
    }

    private void saveKontak() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();

        String text = etText.getText().toString();
        String idPembimbing = pref.getPembimbing().getIdPembimbing();

        if (!text.isEmpty()){

            Call<ResponseInfo> call = mApiInterface.pembimbingUbahKontak(idPembimbing, text);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        Login login = pref.getPembimbing();
                        login.setKontakPembimbing(text);
                        pref.pembimbingLogin(login);
                        finish();
                    }
                }

                @Override
                public void onFailure(Call<ResponseInfo> call, Throwable t) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }else {
            Toast.makeText(getApplicationContext(), "Field kosong", Toast.LENGTH_SHORT).show();
            progressDialog.dismiss();
        }
    }

    private void saveNama() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();

        String text = etText.getText().toString();
        String idPembimbing = pref.getPembimbing().getIdPembimbing();

        if (!text.isEmpty()){

            Call<ResponseInfo> call = mApiInterface.pembimbingUbahNama(idPembimbing, text);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        Login login = pref.getPembimbing();
                        login.setNamaPembimbing(text);
                        pref.pembimbingLogin(login);
                        finish();
                    }
                }

                @Override
                public void onFailure(Call<ResponseInfo> call, Throwable t) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }else {
            Toast.makeText(getApplicationContext(), "Field kosong", Toast.LENGTH_SHORT).show();
            progressDialog.dismiss();
        }
    }

    private void saveUsername() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();

        String text = etText.getText().toString();
        String idPembimbing = pref.getPembimbing().getIdPembimbing();

        if (!text.isEmpty()){

            Call<ResponseInfo> call = mApiInterface.pembimbingUbahUsername(idPembimbing, text);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        Login login = pref.getPembimbing();
                        login.setUsername(text);
                        pref.pembimbingLogin(login);
                        //Log.d("didi", login.getUsername()+" "+text);
                        finish();
                    }
                }

                @Override
                public void onFailure(Call<ResponseInfo> call, Throwable t) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }else {
            Toast.makeText(getApplicationContext(), "Field kosong", Toast.LENGTH_SHORT).show();
            progressDialog.dismiss();
        }
    }
}
