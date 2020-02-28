package com.divakrishnam.actspotpembimbinginternal.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.divakrishnam.actspotpembimbinginternal.R;
import com.divakrishnam.actspotpembimbinginternal.api.APIClient;
import com.divakrishnam.actspotpembimbinginternal.api.APIService;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseLogin;
import com.divakrishnam.actspotpembimbinginternal.util.SharedPrefManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity implements View.OnClickListener {

    private EditText etUsername, etPassword;
    private Button btnLogin;

    private APIService mApiInterface;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        getSupportActionBar().setTitle("Login");

        etUsername = findViewById(R.id.et_username);
        etPassword = findViewById(R.id.et_password);
        btnLogin = findViewById(R.id.btn_login);
        btnLogin.setOnClickListener(this);

        mApiInterface = APIClient.getClient().create(APIService.class);
    }

    @Override
    public void onClick(View view) {
        if (view == btnLogin){
            mahasiswaLogin();
        }
    }

    private void mahasiswaLogin() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Log In...");
        progressDialog.setCancelable(false);
        progressDialog.show();


        String username = etUsername.getText().toString();
        String password = etPassword.getText().toString();

        if (!username.isEmpty() && !password.isEmpty()){

            Call<ResponseLogin> call = mApiInterface.dosenLogin(username, password);
            call.enqueue(new Callback<ResponseLogin>() {
                @Override
                public void onResponse(Call<ResponseLogin> call, Response<ResponseLogin> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        SharedPrefManager.getInstance(getApplicationContext()).dosenLogin(response.body().getData());
                        finish();
                        startActivity(new Intent(getApplicationContext(), MainActivity.class));
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
