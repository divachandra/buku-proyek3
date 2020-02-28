package com.divakrishnam.actspotpembimbinginternal.activity;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.app.AlertDialog;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.divakrishnam.actspotpembimbinginternal.R;
import com.divakrishnam.actspotpembimbinginternal.adapter.ProgressAdapter;
import com.divakrishnam.actspotpembimbinginternal.api.APIClient;
import com.divakrishnam.actspotpembimbinginternal.api.APIService;
import com.divakrishnam.actspotpembimbinginternal.model.Mahasiswa;
import com.divakrishnam.actspotpembimbinginternal.model.Progress;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseProgress;
import com.divakrishnam.actspotpembimbinginternal.util.SharedPrefManager;
import com.divakrishnam.actspotpembimbinginternal.util.Urls;

import java.util.List;
import java.util.Locale;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ProgressActivity extends AppCompatActivity implements ProgressAdapter.ProgressListener, View.OnClickListener {

    public static final String EXTRA_MAHASISWA = "extra_mahasiswa";

    private ImageView ivPerusahaan, ivMahasiswa, ivMap;
    private TextView tvMahasiswa, tvKelas, tvProdi, tvAngkatan, tvPerusahaan, tvPembimbing;

    private RecyclerView rvProgress;

    private APIService mApiInterface;
    private SharedPrefManager pref;

    private ProgressBar pbProgress;
    private TextView tvError;

    private String idMahasiswa = "";
    private String idIntern = "";

    private Mahasiswa mahasiswa;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_progress);

        mahasiswa = getIntent().getParcelableExtra(EXTRA_MAHASISWA);

        ivPerusahaan = findViewById(R.id.img_perusahaan);
        ivMahasiswa = findViewById(R.id.img_mahasiswa);
        ivMap = findViewById(R.id.img_map);

        tvMahasiswa = findViewById(R.id.tv_mahasiswa);
        tvKelas = findViewById(R.id.tv_kelas);
        tvProdi = findViewById(R.id.tv_prodi);
        tvAngkatan = findViewById(R.id.tv_angkatan);
        tvPerusahaan = findViewById(R.id.tv_perusahaan);
        tvPembimbing = findViewById(R.id.tv_pembimbing);
        pbProgress = findViewById(R.id.pb_progress);
        rvProgress = findViewById(R.id.rv_progress);

        tvError = findViewById(R.id.tv_error);

        tvMahasiswa.setText(mahasiswa.getNamaMahasiswa());
        tvKelas.setText(mahasiswa.getKelasMahasiswa());
        tvProdi.setText(mahasiswa.getNamaProdi());
        tvAngkatan.setText(mahasiswa.getAngkatanMahasiswa());
        tvPerusahaan.setText(mahasiswa.getNamaPerusahaan());
        tvPembimbing.setText(mahasiswa.getNamaPembimbing());


        Glide.with(this).load(Urls.IMAGE_URL+"mahasiswa/"+mahasiswa.getFotoMahasiswa()).error(R.drawable.profile).into(ivMahasiswa);
        Glide.with(this).load(Urls.IMAGE_URL+"perusahaan/"+mahasiswa.getFotoPerusahaan()).error(R.drawable.profile).into(ivPerusahaan);

        idMahasiswa = mahasiswa.getIdMahasiswa();
        idIntern = mahasiswa.getIdIntern();

        pref = SharedPrefManager.getInstance(getApplicationContext());
        getSupportActionBar().setTitle("Progress "+pref.getDosen().getNamaDosen());
        mApiInterface = APIClient.getClient().create(APIService.class);

        ivMap.setOnClickListener(this);
    }

    @Override
    public void onResume() {
        super.onResume();
        if(pref.getSort() == null){
            showProgress("bulan");
            pref.setSort("bulan");
        }{
            showProgress(pref.getSort());
        }
    }

    private void showProgress(String sort) {
        showLoading(true);

        rvProgress.setLayoutManager(new GridLayoutManager(getApplicationContext(), 2));

        Log.d("lilil", idIntern+idMahasiswa+sort);
        Call<ResponseProgress> call = mApiInterface.progressMahasiswa(idIntern, idMahasiswa, sort);
        call.enqueue(new Callback<ResponseProgress>() {
            @Override
            public void onResponse(Call<ResponseProgress> call, Response<ResponseProgress> response) {
                showLoading(false);
                if(response.body().getStatus().equals("201") || response.body().getStatus().equals("202") || response.body().getStatus().equals("203")){
                    showData(response.body().getData());
                }else{
                    showMessage(true, response.body().getMessage());
                }
            }

            @Override
            public void onFailure(Call<ResponseProgress> call, Throwable t) {
                showLoading(false);
                showMessage(true, t.getMessage());
            }
        });
    }

    private void showData(List<Progress> data) {
        ProgressAdapter progressAdapter = new ProgressAdapter(getApplicationContext(), data, this);
        rvProgress.setAdapter(progressAdapter);
    }

    private void showLoading(Boolean state) {
        if (state) {
            pbProgress.setVisibility(View.VISIBLE);
        } else {
            pbProgress.setVisibility(View.GONE);
        }
    }

    private void showMessage(Boolean state, String message) {
        if (state) {
            tvError.setText(message);
            tvError.setVisibility(View.VISIBLE);
        } else {
            tvError.setVisibility(View.GONE);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_progress, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem menuItem) {
        if (menuItem.getItemId() == R.id.menu_sort_progress) {
            sortProgress();
        }
        return true;
    }

    private void sortProgress() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        String[] sorts = {"Date", "Week", "Month"};
        builder.setItems(sorts, (dialog, which) -> {
            switch (which) {
                case 0:
                    showProgress("hari");
                    pref.setSort("hari");
                    break;
                case 1:
                    showProgress("minggu");
                    pref.setSort("minggu");
                    break;
                case 2:
                    showProgress("bulan");
                    pref.setSort("bulan");
                    break;
            }
        });

        AlertDialog dialog = builder.create();
        dialog.show();
    }

    @Override
    public void onMonthClickProgress() {
        showProgress("minggu");
        pref.setSort("minggu");
    }

    @Override
    public void onWeekClickProgress() {
        showProgress("hari");
        pref.setSort("hari");
    }

    @Override
    public void onClick(View view) {
        if (view == ivMap){
            String uri = String.format(Locale.ENGLISH, "http://maps.google.com/maps?q=loc:%f,%f", Float.valueOf(mahasiswa.getLatitudePerusahaan()), Float.valueOf(mahasiswa.getLongitudePerusahaan()));
            Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(uri));
            startActivity(intent);
            Log.d("kiki", mahasiswa.getLatitudePerusahaan());
        }
    }
}
