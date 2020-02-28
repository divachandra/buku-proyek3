package com.divakrishnam.actspotpembimbingeksternal.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.api.APIClient;
import com.divakrishnam.actspotpembimbingeksternal.api.APIService;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseLogin;
import com.divakrishnam.actspotpembimbingeksternal.util.SharedPrefManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity implements View.OnClickListener {

    private EditText etUsername;
    private EditText etPassword;
    private Button btnLogin;
    private Button btnRegistrasi;

    private APIService mApiInterface;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        etUsername = findViewById(R.id.et_username);
        etPassword = findViewById(R.id.et_password);
        btnLogin = findViewById(R.id.btn_login);
        btnRegistrasi = findViewById(R.id.btn_registrasi);

        mApiInterface = APIClient.getClient().create(APIService.class);

        btnLogin.setOnClickListener(this);
        btnRegistrasi.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        if (view == btnLogin){
            dosenLogin();
        }else if (view == btnRegistrasi){
            startActivity(new Intent(getApplicationContext(), RegisterActivity.class));
        }
    }

    private void dosenLogin() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Log In...");
        progressDialog.setCancelable(false);
        progressDialog.show();


        String username = etUsername.getText().toString();
        String password = etPassword.getText().toString();

        if (!username.isEmpty() && !password.isEmpty()){

            Call<ResponseLogin> call = mApiInterface.pembimbingLogin(username, password);
            call.enqueue(new Callback<ResponseLogin>() {
                @Override
                public void onResponse(Call<ResponseLogin> call, Response<ResponseLogin> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {

                        SharedPrefManager.getInstance(getApplicationContext()).pembimbingLogin(response.body().getData());
                        Log.d("lolo", SharedPrefManager.getInstance(getApplicationContext()).getPembimbing().getUsername());
                        Log.d("lolo", SharedPrefManager.getInstance(getApplicationContext()).getPembimbing().getPassword());
                        startActivity(new Intent(getApplicationContext(), MainActivity.class));
                        finish();
                    }
                }

                @Override
                public void onFailure(Call<ResponseLogin> call, Throwable t) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }else{
            progressDialog.dismiss();
            Toast.makeText(getApplicationContext(), "Field tidak boleh kosong", Toast.LENGTH_LONG).show();
        }
    }
}
