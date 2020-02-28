package com.divakrishnam.actspotmahasiswa.fragment;
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
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.core.content.FileProvider;
import androidx.fragment.app.Fragment;
import android.os.Environment;
import android.provider.MediaStore;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.LayoutInflater;
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
import com.divakrishnam.actspotmahasiswa.activity.MainActivity;
import com.divakrishnam.actspotmahasiswa.api.APIClient;
import com.divakrishnam.actspotmahasiswa.api.APIService;
import com.divakrishnam.actspotmahasiswa.model.Kegiatan;
import com.divakrishnam.actspotmahasiswa.model.ResponseInfo;
import com.divakrishnam.actspotmahasiswa.model.ResponseKegiatan;
import com.divakrishnam.actspotmahasiswa.util.SharedPrefManager;
import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
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
import static android.app.Activity.RESULT_CANCELED;
import static android.app.Activity.RESULT_OK;
public class AbsenceFragment extends Fragment implements View.OnClickListener, LocationListener {
    private ImageView ivMahasiswa;
    private Spinner spKegiatan;
    private Button btnAbsence;
    private APIService mApiInterface;
    private List<Kegiatan> kegiatans;
    private SharedPrefManager pref;
    private String[] keys;
    private String[] values;
    private String latitude = "";
    private String longtitude = "";
    private LocationManager locationManager;
    private String imageFilePath = "";
    private String deviceid = "";
    private TelephonyManager mTelephonyManager;
    public static final int REQUEST_IMAGE = 400;
    public AbsenceFragment() {
    }
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        ((MainActivity) getActivity()).setActionBarTitle("Absence");
        return inflater.inflate(R.layout.fragment_absence, container, false);
    }
    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        ivMahasiswa = view.findViewById(R.id.iv_absence);
        spKegiatan = view.findViewById(R.id.sp_kegiatan);
        btnAbsence = view.findViewById(R.id.btn_absence);
        pref = SharedPrefManager.getInstance(getContext());
        mApiInterface = APIClient.getClient().create(APIService.class);
        getLocation();
        getDeviceImei();
        loadKegiatan();
        ivMahasiswa.setOnClickListener(this);
        btnAbsence.setOnClickListener(this);
    }
    public void simpanAbsensi(){
        final ProgressDialog progressDialog = new ProgressDialog(getContext());
        progressDialog.setMessage("Menyimpan data...");
        progressDialog.setCancelable(false);
        progressDialog.show();
        int idKeg = (int) spKegiatan.getSelectedItemId();
        String idKegiatan = keys[idKeg];
        String idIntern = pref.getMahasiswaLogin().getIdIntern();
        String idMahasiswa = pref.getMahasiswaLogin().getIdMahasiswa();
        String idDosen = pref.getMahasiswaLogin().getIdDosen();
        String idPembimbing = pref.getMahasiswaLogin().getIdPembimbing();
        Calendar calendar = Calendar.getInstance();
        SimpleDateFormat simpledateformat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String time = simpledateformat.format(calendar.getTime());
        File image = new File(imageFilePath);
        File file = null;
        try {
            file = new Compressor(getContext()).compressToFile(image);
        } catch (IOException e) {
            e.printStackTrace();
        }
        if (idIntern != null && idMahasiswa != null && idDosen != null && !latitude.isEmpty() && !longtitude.isEmpty() && !deviceid.isEmpty() && !idKegiatan.isEmpty() && file!=null && !time.isEmpty()){
            RequestBody mIdIntern = RequestBody.create(MediaType.parse("text/plain"), idIntern);
            RequestBody mIdMahasiswa = RequestBody.create(MediaType.parse("text/plain"), idMahasiswa);
            RequestBody mIdDosen = RequestBody.create(MediaType.parse("text/plain"), idDosen);
            RequestBody mLatitude = RequestBody.create(MediaType.parse("text/plain"), latitude);
            RequestBody mLongitude = RequestBody.create(MediaType.parse("text/plain"), longtitude);
            RequestBody mImei = RequestBody.create(MediaType.parse("text/plain"), deviceid);
            RequestBody mIdKegiatan = RequestBody.create(MediaType.parse("text/plain"), idKegiatan);
            RequestBody mWaktu = RequestBody.create(MediaType.parse("text/plain"), time);
            RequestBody mIdPembimbing = RequestBody.create(MediaType.parse("text/plain"), idPembimbing);
            RequestBody requestFile = RequestBody.create(MediaType.parse("multipart/form-data"), file);
            MultipartBody.Part mFotoAbsensi = MultipartBody.Part.createFormData("foto_absensi", file.getName(), requestFile);
            Call<ResponseInfo> call = mApiInterface.takeAbsence(mIdIntern, mIdMahasiswa, mIdDosen, mLatitude, mLongitude, mImei, mIdKegiatan, mWaktu, mIdPembimbing, mFotoAbsensi);
            call.enqueue(new Callback<ResponseInfo>() {
                @Override
                public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                    progressDialog.dismiss();
                    Toast.makeText(getContext(), response.body().getMessage(), Toast.LENGTH_LONG).show();
                    Glide.with(getContext()).load(R.drawable.profile).into(ivMahasiswa);
                    spKegiatan.setSelection(0);
                }
                @Override
                public void onFailure(Call<ResponseInfo> call, Throwable t) {
                    progressDialog.dismiss();
                    Toast.makeText(getContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
        }else{
            progressDialog.dismiss();
            Toast.makeText(getContext(), "Something empty", Toast.LENGTH_LONG).show();
        }
    }
    private void getDeviceImei() {
        try {
            mTelephonyManager = (TelephonyManager) getContext().getSystemService(Context.TELEPHONY_SERVICE);
            deviceid = mTelephonyManager.getDeviceId();
        } catch (SecurityException e) {
            e.printStackTrace();
        }
    }
    public void loadKegiatan(){
        Call<ResponseKegiatan> call = mApiInterface.getKegiatan();
        call.enqueue(new Callback<ResponseKegiatan>() {
            @Override
            public void onResponse(Call<ResponseKegiatan> call, Response<ResponseKegiatan> response) {
                kegiatans = response.body().getData();
                if(kegiatans != null){
                    spinnerKegiatan(kegiatans);
                }
            }
            @Override
            public void onFailure(Call<ResponseKegiatan> call, Throwable t) {
                Toast.makeText(getContext(), "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });
    }
    private void capturePhoto() {
        Intent pictureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        if (pictureIntent.resolveActivity(getActivity().getPackageManager()) != null) {
            File photoFile;
            try {
                photoFile = createImageFile();

            } catch (IOException e) {
                e.printStackTrace();
                return;
            }
            Uri photoUri = FileProvider.getUriForFile(getContext(), getActivity().getPackageName() + ".provider", photoFile);
            pictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoUri);
            startActivityForResult(pictureIntent, REQUEST_IMAGE);
        }
    }
    private File createImageFile() throws IOException {
        String timeStamp = new SimpleDateFormat("yyyyMMddHHmmss", Locale.getDefault()).format(new Date());
        String imageFileName = "IMG_" + timeStamp + "_";
        File storageDir = getActivity().getExternalFilesDir(Environment.DIRECTORY_PICTURES);
        File image = File.createTempFile(imageFileName, ".jpg", storageDir);
        imageFilePath = image.getAbsolutePath();

        return image;
    }
    private void getLocation() {
        try {
            locationManager = (LocationManager) getActivity().getSystemService(Context.LOCATION_SERVICE);
            locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 5000, 5, this);
        } catch (SecurityException e) {
            e.printStackTrace();
        }
    }
    public void spinnerKegiatan(List<Kegiatan> kegiatans) {
        int size = kegiatans.size()+1;
        String[] values = new String[size];
        keys = new String[size];
        HashMap<String, String> map;
        int i = 0;
        map = new HashMap<>();
        values[i] = "Pilih Kegiatan";
        keys[i] = "0";
        map.put(keys[i], values[i]);
        i++;
        for (Kegiatan kegiatan : kegiatans ) {
            values[i] = kegiatan.getNamaKegiatan();
            keys[i] = kegiatan.getIdKegiatan();
            map.put(keys[i], values[i]);
            i++;
        }
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(getContext(), android.R.layout.simple_spinner_item, values) {
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
        spKegiatan.setAdapter(adapter);
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
        Toast.makeText(getContext(), "Please Enable GPS and Internet", Toast.LENGTH_SHORT).show();
    }
    @Override
    public void onClick(View view) {
        if (view == ivMahasiswa){
            capturePhoto();
        }else if(view == btnAbsence){
            simpanAbsensi();
        }
    }
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == REQUEST_IMAGE) {
            if (resultCode == RESULT_OK) {
                Glide.with(this).load(imageFilePath).into(ivMahasiswa);
            } else if (resultCode == RESULT_CANCELED) {
                imageFilePath = "";
                Toast.makeText(getContext(), "You cancelled the operation", Toast.LENGTH_SHORT).show();
            }
        }
    }
}
