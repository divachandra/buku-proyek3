package com.divakrishnam.actspotmahasiswa.activity;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import android.Manifest;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.Bundle;
import android.widget.FrameLayout;
import android.widget.TextView;
import android.widget.Toast;
import com.divakrishnam.actspotmahasiswa.R;
import com.divakrishnam.actspotmahasiswa.api.APIClient;
import com.divakrishnam.actspotmahasiswa.api.APIService;
import com.divakrishnam.actspotmahasiswa.model.ResponseInfo;
import com.google.zxing.Result;
import me.dm7.barcodescanner.zxing.ZXingScannerView;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
public class RegisterActivity extends AppCompatActivity implements ZXingScannerView.ResultHandler {
    private ZXingScannerView mScannerView;
    private FrameLayout flCamera;
    private APIService mApiInterface;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        getSupportActionBar().setTitle("Register");
        flCamera = findViewById(R.id.fl_camera);
        mApiInterface = APIClient.getClient().create(APIService.class);
        initScannerView();
    }
    private void initScannerView(){
        mScannerView = new ZXingScannerView(this);
        mScannerView.setAutoFocus(true);
        mScannerView.setResultHandler(this);
        flCamera.addView(mScannerView);
    }
    @Override
    protected void onStart() {
        doRequestPermission();
        mScannerView.startCamera();
        super.onStart();
    }
    @Override
    protected void onPause() {
        mScannerView.stopCamera();
        super.onPause();
    }
    private void doRequestPermission() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            if (checkSelfPermission(Manifest.permission.CAMERA) != PackageManager.PERMISSION_GRANTED) {
                requestPermissions(new String[]{Manifest.permission.CAMERA}, 100);
            }
        }
    }
    @Override
    public void handleResult(Result result) {
        mahasiswaRegister(result.getText());
        mScannerView.resumeCameraPreview(this);
    }
    private void mahasiswaRegister(String register) {
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Verification...");
        progressDialog.setCancelable(false);
        progressDialog.show();
        if (!register.isEmpty() && register!= null){
            Call<ResponseInfo> call = mApiInterface.mahasiswaRegistrasi(register);
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
        }
    }
    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == 100) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                Toast.makeText(getApplicationContext(), "Camera permission granted", Toast.LENGTH_LONG).show();
            } else {
                Toast.makeText(getApplicationContext(), "Camera permission denied", Toast.LENGTH_LONG).show();
            }
        }
    }
}
