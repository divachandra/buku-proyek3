package com.divakrishnam.actspotmahasiswa.activity;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.core.content.FileProvider;
import android.Manifest;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;
import com.bumptech.glide.Glide;
import com.divakrishnam.actspotmahasiswa.R;
import com.divakrishnam.actspotmahasiswa.api.APIClient;
import com.divakrishnam.actspotmahasiswa.api.APIService;
import com.divakrishnam.actspotmahasiswa.model.Pembimbing;
import com.divakrishnam.actspotmahasiswa.model.ResponseInfo;
import com.divakrishnam.actspotmahasiswa.model.ResponsePembimbing;
import com.divakrishnam.actspotmahasiswa.util.SharedPrefManager;
import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import id.zelory.compressor.Compressor;
import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
public class CompanyActivity extends AppCompatActivity implements View.OnClickListener, LocationListener {
    private APIService mApiInterface;
    private List<Pembimbing> pembimbings;
    private SharedPrefManager pref;
    private String[] keys;
    private String[] values;
    private ImageView ivPerusahaan;
    private Spinner spPerusahaan;
    private Spinner spPembimbing;
    private Button btnSimpan;
    private String latitude = "";
    private String longtitude = "";
    private LocationManager locationManager;
    private String imageFilePath = "";
    public static final int REQUEST_IMAGE = 200;
    public static final int PERMISSION_ALL = 100;
    private String[] PERMISSIONS = {
            android.Manifest.permission.ACCESS_FINE_LOCATION,
            android.Manifest.permission.WRITE_EXTERNAL_STORAGE,
            android.Manifest.permission.READ_PHONE_STATE,
            android.Manifest.permission.CAMERA
    };
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_company);
        if (!hasPermissions(this, PERMISSIONS)) {
            ActivityCompat.requestPermissions(this, PERMISSIONS, PERMISSION_ALL);
        }
        getSupportActionBar().setTitle("Register Perusahaan");
        ivPerusahaan = findViewById(R.id.img_perusahaan);
        spPerusahaan = findViewById(R.id.sp_perusahaan);
        spPembimbing = findViewById(R.id.sp_pembimbing);
        btnSimpan = findViewById(R.id.btn_simpan);
        pref = SharedPrefManager.getInstance(getApplicationContext());
        mApiInterface = APIClient.getClient().create(APIService.class);
        getLocation();
        loadPembimbing();
        btnSimpan.setOnClickListener(this);
        ivPerusahaan.setOnClickListener(this);
    }
    public static boolean hasPermissions(Context context, String... permissions) {
        if (context != null && permissions != null) {
            for (String permission : permissions) {
                if (ActivityCompat.checkSelfPermission(context, permission) != PackageManager.PERMISSION_GRANTED) {
                    return false;
                }
            }
        }
        return true;
    }
    public void simpanPerusahaan(){
        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();
        int idPer = (int) spPerusahaan.getSelectedItemId();
        int idPem = (int) spPembimbing.getSelectedItemId();
        String idPembimbing = keys[idPem];
        String namaPerusahaan = values[idPer];
        String idIntern = pref.getRegistrasiPerusahaan().getIdIntern();
        String idMahasiswa = pref.getRegistrasiPerusahaan().getIdMahasiswa();
        String idDosen = pref.getRegistrasiPerusahaan().getIdDosen();
        File image = new File(imageFilePath);
        File file = null;
        try {
            file = new Compressor(getApplicationContext()).compressToFile(image);
        } catch (IOException e) {
            e.printStackTrace();
        }
        if (idIntern != null && idMahasiswa != null && !namaPerusahaan.isEmpty() && !idPembimbing.isEmpty() && !latitude.isEmpty() && !longtitude.isEmpty() && file != null){
            RequestBody mIdDosen = RequestBody.create(MediaType.parse("text/plain"), idDosen);
            RequestBody mIdIntern = RequestBody.create(MediaType.parse("text/plain"), idIntern);
            RequestBody mIdMahasiswa = RequestBody.create(MediaType.parse("text/plain"), idMahasiswa);
            RequestBody mNamaPerusahaan = RequestBody.create(MediaType.parse("text/plain"), namaPerusahaan);
            RequestBody mIdPembimbing = RequestBody.create(MediaType.parse("text/plain"), idPembimbing);
            RequestBody mLatitudePerusahaan = RequestBody.create(MediaType.parse("text/plain"), latitude);
            RequestBody mLongitudePerusahaan = RequestBody.create(MediaType.parse("text/plain"), longtitude);
            RequestBody requestFile = RequestBody.create(MediaType.parse("multipart/form-data"), file);
            MultipartBody.Part mFotoPerusahaan = MultipartBody.Part.createFormData("foto_perusahaan", file.getName(), requestFile);
            Call<ResponseInfo> call = mApiInterface.registrasiPerusahaan(mIdDosen, mIdIntern, mIdMahasiswa, mNamaPerusahaan, mIdPembimbing, mLatitudePerusahaan, mLongitudePerusahaan, mFotoPerusahaan);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getApplicationContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    if(response.body().getStatus().equals("200")){
                        startActivity(new Intent(getApplicationContext(), LoginActivity.class));
                        finish();
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
    public void loadPembimbing(){
        Call<ResponsePembimbing> call = mApiInterface.getPembimbing();
        call.enqueue(new Callback<ResponsePembimbing>() {
            @Override
            public void onResponse(Call<ResponsePembimbing> call, Response<ResponsePembimbing> response) {
                pembimbings = response.body().getData();
                spinnerPerusahaan(pembimbings);
                spinnerPembimbing(pembimbings);
            }
            @Override
            public void onFailure(Call<ResponsePembimbing> call, Throwable t) {
                Toast.makeText(getApplicationContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });
    }
    private void capturePhoto() {
        Intent pictureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        if (pictureIntent.resolveActivity(getPackageManager()) != null) {
            File photoFile;
            try {
                photoFile = createImageFile();

            } catch (IOException e) {
                e.printStackTrace();
                return;
            }
            Uri photoUri = FileProvider.getUriForFile(this, getPackageName() + ".provider", photoFile);
            pictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoUri);
            startActivityForResult(pictureIntent, REQUEST_IMAGE);
        }
    }
    private File createImageFile() throws IOException {
        String timeStamp = new SimpleDateFormat("yyyyMMddHHmmss", Locale.getDefault()).format(new Date());
        String imageFileName = "IMG_" + timeStamp + "_";
        File storageDir = getExternalFilesDir(Environment.DIRECTORY_PICTURES);
        File image = File.createTempFile(imageFileName, ".jpg", storageDir);
        imageFilePath = image.getAbsolutePath();
        return image;
    }
    private void getLocation() {
        try {
            locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
            locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 5000, 5, this);
        } catch (SecurityException e) {
            e.printStackTrace();
        }
    }
    public void spinnerPembimbing(List<Pembimbing> pembimbings) {
        int size = pembimbings.size()+1;
        String[] values = new String[size];
        keys = new String[size];
        HashMap<String, String> map;
        int i = 0;
        map = new HashMap<>();
        values[i] = "Pilih Pembimbing";
        keys[i] = "0";
        map.put(keys[i], values[i]);
        i++;
        for (Pembimbing pembimbing : pembimbings ) {
            values[i] = pembimbing.getNamaPembimbing();
            keys[i] = pembimbing.getIdPembimbing();
            map.put(keys[i], values[i]);
            i++;
        }
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, values) {
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
        spPembimbing.setAdapter(adapter);
    }
    public void spinnerPerusahaan(List<Pembimbing> pembimbings) {
        int size = pembimbings.size()+1;
        values = new String[size];
        int i = 0;
        values[i] = "Pilih Perusahaan";
        i++;
        for (Pembimbing pembimbing : pembimbings ) {
            values[i] = pembimbing.getNamaPerusahaan();
            i++;
        }
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, values) {
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
        spPerusahaan.setAdapter(adapter);
    }
    @Override
    public void onClick(View view) {
        if (view == btnSimpan){
            simpanPerusahaan();
        }else if(view == ivPerusahaan){
            capturePhoto();
        }
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
    @Override
    public void onRequestPermissionsResult(int requestCode, String[] permissions, int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == PERMISSION_ALL && grantResults.length > 0) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                Toast.makeText(this, "Thanks for granting Permission", Toast.LENGTH_SHORT).show();
            }
        }
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == REQUEST_IMAGE) {
            if (resultCode == RESULT_OK) {
                Glide.with(this).load(imageFilePath).into(ivPerusahaan);
            } else if (resultCode == RESULT_CANCELED) {
                imageFilePath = "";
                Toast.makeText(this, "You cancelled the operation", Toast.LENGTH_SHORT).show();
            }
        }
    }
}
