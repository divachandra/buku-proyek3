package com.divakrishnam.actspotmahasiswa.activity;
import androidx.appcompat.app.AppCompatActivity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import com.divakrishnam.actspotmahasiswa.R;
import com.divakrishnam.actspotmahasiswa.api.APIClient;
import com.divakrishnam.actspotmahasiswa.api.APIService;
import com.divakrishnam.actspotmahasiswa.model.ResponseLogin;
import com.divakrishnam.actspotmahasiswa.util.SharedPrefManager;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;
public class LoginActivity extends AppCompatActivity implements View.OnClickListener{
    private EditText etUsername, etPassword;
    private Button btnLogin, btnRegistrasi;
    private APIService mApiInterface;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        getSupportActionBar().setTitle("Login");
        etUsername = findViewById(R.id.et_username);
        etPassword = findViewById(R.id.et_password);
        btnLogin = findViewById(R.id.btn_login);
        btnRegistrasi = findViewById(R.id.btn_registrasi);
        btnLogin.setOnClickListener(this);
        btnRegistrasi.setOnClickListener(this);
        mApiInterface = APIClient.getClient().create(APIService.class);
    }
    @Override
    public void onClick(View view) {
        if (view == btnLogin){
            mahasiswaLogin();
        }else if(view == btnRegistrasi){
            startActivity(new Intent(getApplicationContext(), RegisterActivity.class));
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
            Call<ResponseLogin> call = mApiInterface.mahasiswaLogin(username, password);
            call.enqueue(new Callback<ResponseLogin>() {
                @Override
                public void onResponse(Call<ResponseLogin> call, Response<ResponseLogin> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    switch (response.body().getStatus()) {
                        case "202":
                            SharedPrefManager.getInstance(getApplicationContext()).registrasiPerusahaan(response.body().getData());
                            startActivity(new Intent(getApplicationContext(), CompanyActivity.class));
                            finish();
                            break;
                        case "203":
                            startActivity(new Intent(getApplicationContext(), NoticeActivity.class));
                            finish();
                            break;
                        case "201":
                            SharedPrefManager.getInstance(getApplicationContext()).mahasiswaLogin(response.body().getData());
                            startActivity(new Intent(getApplicationContext(), MainActivity.class));
                            finish();
                            break;
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
