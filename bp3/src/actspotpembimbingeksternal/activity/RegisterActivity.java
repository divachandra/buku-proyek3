package com.divakrishnam.actspotpembimbingeksternal.activity;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.BitmapFactory;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.api.APIClient;
import com.divakrishnam.actspotpembimbingeksternal.api.APIService;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseInfo;
import com.divakrishnam.actspotpembimbingeksternal.util.SharedPrefManager;
import com.mapbox.android.core.permissions.PermissionsListener;
import com.mapbox.android.core.permissions.PermissionsManager;
import com.mapbox.mapboxsdk.Mapbox;
import com.mapbox.mapboxsdk.location.LocationComponent;
import com.mapbox.mapboxsdk.location.LocationComponentActivationOptions;
import com.mapbox.mapboxsdk.location.modes.CameraMode;
import com.mapbox.mapboxsdk.location.modes.RenderMode;
import com.mapbox.mapboxsdk.maps.MapView;
import com.mapbox.mapboxsdk.maps.MapboxMap;
import com.mapbox.mapboxsdk.maps.OnMapReadyCallback;
import com.mapbox.mapboxsdk.maps.Style;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class RegisterActivity extends AppCompatActivity implements OnMapReadyCallback, LocationListener, PermissionsListener, View.OnClickListener {

    private PermissionsManager permissionsManager;
    private MapboxMap mapboxMap;
    private MapView mapView;

    private String latitude = "";
    private String longtitude = "";
    private LocationManager locationManager;

    private APIService mApiInterface;
    private SharedPrefManager pref;

    private EditText etNama, etKontak, etPerusahaan, etUsername, etPassword, etCPassword;
    private Button btnSave;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if (ContextCompat.checkSelfPermission(getApplicationContext(), android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(getApplicationContext(), android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{android.Manifest.permission.ACCESS_FINE_LOCATION, android.Manifest.permission.ACCESS_COARSE_LOCATION}, 100);
        }

        Mapbox.getInstance(this, getString(R.string.access_token));
        setContentView(R.layout.activity_register);
        mapView = findViewById(R.id.mapView);
        mapView.onCreate(savedInstanceState);
        mapView.getMapAsync(this);

        etNama = findViewById(R.id.et_nama);
        etKontak = findViewById(R.id.et_kontak);
        etPerusahaan = findViewById(R.id.et_perusahaan);
        etUsername = findViewById(R.id.et_username);
        etPassword = findViewById(R.id.et_password);
        etCPassword = findViewById(R.id.et_cpassword);
        btnSave = findViewById(R.id.btn_save);

        btnSave.setOnClickListener(this);

        pref = SharedPrefManager.getInstance(getApplicationContext());
        mApiInterface = APIClient.getClient().create(APIService.class);

        getLocation();
    }

    private void registerPembimbing() {
        String nama = etNama.getText().toString();
        String kontak = etKontak.getText().toString();
        String perusahaan = etPerusahaan.getText().toString();
        String username = etUsername.getText().toString();
        String password = etPassword.getText().toString();
        String cPassword = etCPassword.getText().toString();

        boolean state = true;

        if (password.equals(cPassword)) {
            state = false;
        }

        Log.d("kiki", nama + kontak + perusahaan + username + password + cPassword + latitude + longtitude);

        if (!nama.isEmpty() && !kontak.isEmpty() && !perusahaan.isEmpty() && !username.isEmpty() && !password.isEmpty() && !cPassword.isEmpty() && !state) {
            final ProgressDialog progressDialog = new ProgressDialog(this);
            progressDialog.setMessage("Register...");
            progressDialog.setCancelable(false);
            progressDialog.show();

            Call<ResponseInfo> call = mApiInterface.pembimbingRegistrasi(nama, kontak, perusahaan, username, password, latitude, longtitude);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if (response.body().getStatus().equals("200")) {
                        finish();
                    }
                }

                @Override
                public void onFailure(Call<ResponseInfo> call, Throwable t) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), "Error : " + t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }
    }

    @Override
    public void onClick(View view) {
        if (view == btnSave) {
            registerPembimbing();
        }
    }

    @Override
    public void onMapReady(@NonNull MapboxMap mapboxMap) {
        RegisterActivity.this.mapboxMap = mapboxMap;
        mapboxMap.getUiSettings().setAllGesturesEnabled(false);
        mapboxMap.setStyle(new Style.Builder().fromUrl("mapbox://styles/mapbox/cjf4m44iw0uza2spb3q0a7s41"),
                this::enableLocationComponent);
    }

    @SuppressWarnings({"MissingPermission"})
    private void enableLocationComponent(@NonNull Style loadedMapStyle) {
        if (PermissionsManager.areLocationPermissionsGranted(this)) {
            LocationComponent locationComponent = mapboxMap.getLocationComponent();
            locationComponent.activateLocationComponent(
                    LocationComponentActivationOptions.builder(this, loadedMapStyle).build());
            locationComponent.setLocationComponentEnabled(true);
            locationComponent.setCameraMode(CameraMode.TRACKING);
            locationComponent.setRenderMode(RenderMode.COMPASS);
        } else {
            permissionsManager = new PermissionsManager(this);
            permissionsManager.requestLocationPermissions(this);
        }
    }

    @Override
    public void onExplanationNeeded(List<String> permissionsToExplain) {
        Toast.makeText(this, "Lala", Toast.LENGTH_LONG).show();
    }

    @Override
    public void onPermissionResult(boolean granted) {
        if (granted) {
            mapboxMap.getStyle(style -> enableLocationComponent(style));
        } else {
            Toast.makeText(this, "Tidak dikasi", Toast.LENGTH_LONG).show();
            finish();
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        if (requestCode == 100) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                mapboxMap.getStyle(this::enableLocationComponent);
                Toast.makeText(this, "Map permission granted", Toast.LENGTH_LONG).show();
                getLocation();
            }else{
                Toast.makeText(this, "Map permission disgranted", Toast.LENGTH_LONG).show();
            }
        }
    }

    @Override
    @SuppressWarnings({"MissingPermission"})
    protected void onStart() {
        super.onStart();
        mapView.onStart();
    }

    @Override
    protected void onResume() {
        super.onResume();
        mapView.onResume();
    }

    @Override
    protected void onPause() {
        super.onPause();
        mapView.onPause();
    }

    @Override
    protected void onStop() {
        super.onStop();
        mapView.onStop();
    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        mapView.onSaveInstanceState(outState);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        mapView.onDestroy();
    }

    @Override
    public void onLowMemory() {
        super.onLowMemory();
        mapView.onLowMemory();
    }

    @Override
    public void onLocationChanged(Location location) {
        latitude = String.valueOf(location.getLatitude());
        longtitude = String.valueOf(location.getLongitude());
    }

    @Override
    public void onStatusChanged(String s, int i, Bundle bundle) {

    }

    @Override
    public void onProviderEnabled(String s) {

    }

    @Override
    public void onProviderDisabled(String s) {
        Toast.makeText(this, "Please Enable GPS and Internet", Toast.LENGTH_SHORT).show();
    }

    private void getLocation() {
        try {
            locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
            locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 5000, 5, this);
        } catch (SecurityException e) {
            e.printStackTrace();
        }
    }
}
