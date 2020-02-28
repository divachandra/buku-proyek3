package com.divakrishnam.actspotmahasiswa.activity;
import androidx.appcompat.app.AppCompatActivity;
import android.app.ProgressDialog;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;
import com.divakrishnam.actspotmahasiswa.R;
import com.divakrishnam.actspotmahasiswa.api.APIClient;
import com.divakrishnam.actspotmahasiswa.api.APIService;
import com.divakrishnam.actspotmahasiswa.model.Login;
import com.divakrishnam.actspotmahasiswa.model.ResponseInfo;
import com.divakrishnam.actspotmahasiswa.util.SharedPrefManager;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
public class SpinnerActivity extends AppCompatActivity implements View.OnClickListener {
    public static final String EXTRA_TEXT = "extra_text";
    private TextView tvText;
    private Spinner spText;
    private Button btnSave;
    private String text;
    private SharedPrefManager pref;
    private APIService mApiInterface;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_spinner);
        tvText = findViewById(R.id.tv_text);
        spText = findViewById(R.id.sp_text);
        btnSave = findViewById(R.id.btn_savetext);
        pref = SharedPrefManager.getInstance(getApplicationContext());
        mApiInterface = APIClient.getClient().create(APIService.class);
        text = getIntent().getStringExtra(EXTRA_TEXT);
        if (text != null){
            if (text.length() == 2){
                getSupportActionBar().setTitle("Change Kelas");
                tvText.setText("Kelas");
                spinnerKelas();
            }else {
                getSupportActionBar().setTitle("Change Angkatan");
                tvText.setText("Angkatan");
                spinnerAngkatan();
            }
        }
        btnSave.setOnClickListener(this);
    }
    @Override
    public void onClick(View view) {
        if (view == btnSave){
            if (text.length() == 2){
                saveKelas();
            }else {
                saveAngkatan();
            }
        }
    }
    private void saveKelas() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();
        String text = spText.getSelectedItem().toString();
        String idMahasiswa = pref.getMahasiswaLogin().getIdMahasiswa();
        if (!text.isEmpty()){
            Call<ResponseInfo> call = mApiInterface.mahasiswaUbahKelas(idMahasiswa, text);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        Login login = pref.getMahasiswaLogin();
                        login.setKelasMahasiswa(text);
                        pref.mahasiswaLogin(login);
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
    private void saveAngkatan() {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();
        String text = spText.getSelectedItem().toString();
        String idMahasiswa = pref.getMahasiswaLogin().getIdMahasiswa();
        if (!text.isEmpty()){
            Call<ResponseInfo> call = mApiInterface.mahasiswaUbahAngkatan(idMahasiswa, text);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")) {
                        Login login = pref.getMahasiswaLogin();
                        login.setAngkatanMahasiswa(text);
                        pref.mahasiswaLogin(login);
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
    public void spinnerKelas() {
        List<String> list = new ArrayList<>();
        list.add("Pilih Kelas");
        list.add("4A");
        list.add("4B");
        list.add("4C");
        list.add("3A");
        list.add("3B");
        list.add("3C");
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, list) {
            @Override
            public boolean isEnabled(int position) {
                return position != 0;
            }
            @Override
            public View getDropDownView(int position, View convertView, ViewGroup parent) {
                View view = super.getDropDownView(position, convertView, parent);
                TextView tv = (TextView) view;
                if (position == 0) {
                    tv.setTextColor(Color.GRAY);
                } else {
                    tv.setTextColor(Color.BLACK);
                }
                return view;
            }
        };
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spText.setAdapter(adapter);
        if(text != null){
            spText.setSelection(adapter.getPosition(text));
        }
    }
    public void spinnerAngkatan() {
        List<String> list = new ArrayList<>();
        int year = Calendar.getInstance().get(Calendar.YEAR)-3;
        list.add("Pilih Angkatan");
        for (int i = 0; i < 6; i++){
            list.add(String.valueOf(year));
            year--;
        }
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, list) {
            @Override
            public boolean isEnabled(int position) {
                return position != 0;
            }
            @Override
            public View getDropDownView(int position, View convertView, ViewGroup parent) {
                View view = super.getDropDownView(position, convertView, parent);
                TextView tv = (TextView) view;
                if (position == 0) {
                    tv.setTextColor(Color.GRAY);
                } else {
                    tv.setTextColor(Color.BLACK);
                }
                return view;
            }
        };
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spText.setAdapter(adapter);
        if(text != null){
            spText.setSelection(adapter.getPosition(text));
        }
    }
}
