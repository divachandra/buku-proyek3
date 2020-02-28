package com.divakrishnam.actspotpembimbinginternal.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.divakrishnam.actspotpembimbinginternal.R;
import com.divakrishnam.actspotpembimbinginternal.api.APIClient;
import com.divakrishnam.actspotpembimbinginternal.api.APIService;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseInfo;
import com.divakrishnam.actspotpembimbinginternal.util.SharedPrefManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class PasswordActivity extends AppCompatActivity implements View.OnClickListener {

    private EditText etOldPass, etNewPass, etCNewPass;
    private Button btnSave;

    private SharedPrefManager pref;
    private APIService mApiInterface;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_password);

        getSupportActionBar().setTitle("Change Password");

        etOldPass = findViewById(R.id.et_oldpass);
        etNewPass = findViewById(R.id.et_newpass);
        etCNewPass = findViewById(R.id.et_cnewpass);
        btnSave = findViewById(R.id.btn_savepass);

        pref = SharedPrefManager.getInstance(getApplicationContext());
        mApiInterface = APIClient.getClient().create(APIService.class);

        btnSave.setOnClickListener(this);

    }

    @Override
    public void onClick(View view) {
        if (view == btnSave){
            savePassword();
        }
    }

    private void savePassword() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();

        String oldPass = etOldPass.getText().toString();
        String newPass = etNewPass.getText().toString();
        String cNewPass = etCNewPass.getText().toString();
        String idDosen = pref.getDosen().getIdDosen();

        if (!oldPass.isEmpty() && !newPass.isEmpty() && !cNewPass.isEmpty() && oldPass.equals(pref.getDosen().getPassword()) && newPass.equals(cNewPass)){

            Call<ResponseInfo> call = mApiInterface.dosenUbahPassword(idDosen, newPass);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
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
            if (!oldPass.isEmpty() && !newPass.isEmpty() && !cNewPass.isEmpty()){
                if (oldPass.equals(pref.getDosen().getPassword())){
                    Toast.makeText(getApplicationContext(), "Password baru tidak sama dengan password lama.", Toast.LENGTH_SHORT).show();
                }else if (newPass.equals(cNewPass)){
                    Toast.makeText(getApplicationContext(), "Password tidak sama", Toast.LENGTH_SHORT).show();
                }
            }else{
                Toast.makeText(getApplicationContext(), "Field kosong", Toast.LENGTH_SHORT).show();
            }
            progressDialog.dismiss();
        }
    }
}
