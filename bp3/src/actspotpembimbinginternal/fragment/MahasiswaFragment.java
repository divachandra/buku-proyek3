package com.divakrishnam.actspotpembimbinginternal.fragment;


import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.divakrishnam.actspotpembimbinginternal.R;
import com.divakrishnam.actspotpembimbinginternal.activity.MainActivity;
import com.divakrishnam.actspotpembimbinginternal.adapter.MahasiswaAdapter;
import com.divakrishnam.actspotpembimbinginternal.api.APIClient;
import com.divakrishnam.actspotpembimbinginternal.api.APIService;
import com.divakrishnam.actspotpembimbinginternal.model.ResponseMahasiswa;
import com.divakrishnam.actspotpembimbinginternal.util.SharedPrefManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MahasiswaFragment extends Fragment {

    private RecyclerView rvProgress;
    private RecyclerView.LayoutManager mLayoutManager;

    private APIService mApiInterface;
    SharedPrefManager pref;

    private ProgressBar pbProgress;
    private TextView tvError;

    public MahasiswaFragment() {
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        ((MainActivity) getActivity()).setActionBarTitle("My Mahasiswa");
        return inflater.inflate(R.layout.fragment_mahasiswa, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        pbProgress = view.findViewById(R.id.pb_progress);
        rvProgress = view.findViewById(R.id.rv_mahasiswa);
        tvError = view.findViewById(R.id.tv_error);

        pref = SharedPrefManager.getInstance(getContext());
        mApiInterface = APIClient.getClient().create(APIService.class);

        showProgress();
    }

    private void showProgress() {
        showLoading(true);
        String idMahasiswa = pref.getDosen().getIdDosen();

        rvProgress.setLayoutManager(new LinearLayoutManager(getContext()));

        Call<ResponseMahasiswa> call = mApiInterface.dosenMahasiswa(idMahasiswa);
        call.enqueue(new Callback<ResponseMahasiswa>() {
            @Override
            public void onResponse(Call<ResponseMahasiswa> call, Response<ResponseMahasiswa> response) {
                showLoading(false);
               if (response.body().getStatus().equals("200")){
                   MahasiswaAdapter progressAdapter = new MahasiswaAdapter(getContext(), response.body().getData());
                   rvProgress.setAdapter(progressAdapter);
               }else{
                   showMessage(true, response.body().getMessage());
               }
            }

            @Override
            public void onFailure(Call<ResponseMahasiswa> call, Throwable t) {
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
