package com.divakrishnam.actspotpembimbinginternal.activity;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.divakrishnam.actspotpembimbinginternal.R;
import com.divakrishnam.actspotpembimbinginternal.adapter.DetailProgressAdapter;
import com.divakrishnam.actspotpembimbinginternal.api.APIClient;
import com.divakrishnam.actspotpembimbinginternal.api.APIService;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseProgressPerDay;
import com.divakrishnam.actspotpembimbinginternal.util.SharedPrefManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class DetailProgressActivity extends AppCompatActivity {


    public static final String EXTRA_DAY = "extra_day";
    public static final String EXTRA_ID = "extra_id";
    public static final String EXTRA_INTERN = "extra_intern";

    private RecyclerView rvProgress;

    private APIService mApiInterface;
    private SharedPrefManager pref;

    private ProgressBar pbProgress;
    private TextView tvError;

    private String tglWaktu, idMahasiswa, idIntern;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_progress);

        getSupportActionBar().setTitle("Detail Progress");

        pbProgress = findViewById(R.id.pb_progress);
        rvProgress = findViewById(R.id.rv_progress);
        tvError = findViewById(R.id.tv_error);

        pref = SharedPrefManager.getInstance(getApplicationContext());
        mApiInterface = APIClient.getClient().create(APIService.class);

        tglWaktu = getIntent().getStringExtra(EXTRA_DAY);
        idMahasiswa = getIntent().getStringExtra(EXTRA_ID);
        idIntern = getIntent().getStringExtra(EXTRA_INTERN);

        showDetailProgress();
    }

    private void showDetailProgress() {
        showLoading(true);

        rvProgress.setLayoutManager(new LinearLayoutManager(getApplicationContext()));

        Log.d("lali", idIntern+idMahasiswa+tglWaktu);

        Call<ResponseProgressPerDay> call = mApiInterface.progressPerDayMahasiswa(idIntern, idMahasiswa, tglWaktu);
        call.enqueue(new Callback<ResponseProgressPerDay>() {
            @Override
            public void onResponse(Call<ResponseProgressPerDay> call, Response<ResponseProgressPerDay> response) {
                showLoading(false);
                if (response.body().getStatus().equals("200")) {
                    DetailProgressAdapter detailProgressAdapter = new DetailProgressAdapter(getApplicationContext(), response.body().getData());
                    rvProgress.setAdapter(detailProgressAdapter);
                } else {
                    showMessage(true, response.body().getMessage());
                }
            }

            @Override
            public void onFailure(Call<ResponseProgressPerDay> call, Throwable t) {
                showLoading(false);
                showMessage(true, t.getMessage());
            }
        });
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
}