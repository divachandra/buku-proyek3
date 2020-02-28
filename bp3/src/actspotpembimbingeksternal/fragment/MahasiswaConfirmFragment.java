package com.divakrishnam.actspotpembimbingeksternal.fragment;


import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.adapter.ConfirmMahasiswaAdapter;
import com.divakrishnam.actspotpembimbingeksternal.api.APIClient;
import com.divakrishnam.actspotpembimbingeksternal.api.APIService;
import com.divakrishnam.actspotpembimbingeksternal.model.ConfirmMahasiswa;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseConfirmMahasiswa;
import com.divakrishnam.actspotpembimbingeksternal.util.SharedPrefManager;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MahasiswaConfirmFragment extends Fragment implements ConfirmMahasiswaAdapter.ConfirmMahasiswaListener {

    private RecyclerView rvMahasiswa;

    private APIService mApiInterface;
    private SharedPrefManager pref;

    private ProgressBar pbProgress;
    private TextView tvError;

    public MahasiswaConfirmFragment() {
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_mahasiswa_confirm, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        pbProgress = view.findViewById(R.id.pb_progress);
        rvMahasiswa = view.findViewById(R.id.rv_mahasiswa);
        tvError = view.findViewById(R.id.tv_error);

        pref = SharedPrefManager.getInstance(getContext());
        mApiInterface = APIClient.getClient().create(APIService.class);

        showMahasiswaConfirm();
    }

    private void showMahasiswaConfirm() {
        showLoading(true);

        String idPembimbing = pref.getPembimbing().getIdPembimbing();

        rvMahasiswa.setLayoutManager(new LinearLayoutManager(getContext()));

        Call<ResponseConfirmMahasiswa> call = mApiInterface.pembimbingListKonfirmMahasiswa(idPembimbing);
        call.enqueue(new Callback<ResponseConfirmMahasiswa>() {
            @Override
            public void onResponse(Call<ResponseConfirmMahasiswa> call, Response<ResponseConfirmMahasiswa> response) {
                showLoading(false);
                if (response.body().getStatus().equals("200")){
                    showConfirm(response.body().getData());
                }else{
                    showMessage(true, response.body().getMessage());
                }
            }

            @Override
            public void onFailure(Call<ResponseConfirmMahasiswa> call, Throwable t) {
                showLoading(false);
                showMessage(true, t.getMessage());
            }
        });
    }

    private void showConfirm(List<ConfirmMahasiswa> data) {
        ConfirmMahasiswaAdapter confirmMahasiswaAdapter = new ConfirmMahasiswaAdapter(getContext(), data, this);
        confirmMahasiswaAdapter.notifyDataSetChanged();
        rvMahasiswa.setAdapter(confirmMahasiswaAdapter);
        confirmMahasiswaAdapter.notifyDataSetChanged();
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
    public void onConfirmMahasiswa() {
        showMahasiswaConfirm();
    }

    @Override
    public void onResume() {
        super.onResume();
        //showMahasiswaConfirm();
    }
}
