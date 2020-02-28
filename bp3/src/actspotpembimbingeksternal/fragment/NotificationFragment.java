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
import com.divakrishnam.actspotpembimbingeksternal.activity.MainActivity;
import com.divakrishnam.actspotpembimbingeksternal.adapter.NotificationAdapter;
import com.divakrishnam.actspotpembimbingeksternal.api.APIClient;
import com.divakrishnam.actspotpembimbingeksternal.api.APIService;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseNotification;
import com.divakrishnam.actspotpembimbingeksternal.util.SharedPrefManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class NotificationFragment extends Fragment {

    private RecyclerView rvNotification;

    private APIService mApiInterface;
    private SharedPrefManager pref;

    private ProgressBar pbProgress;
    private TextView tvError;

    public NotificationFragment() {

    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        ((MainActivity) getActivity()).setActionBarTitle("Notification");
        return inflater.inflate(R.layout.fragment_notification, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        pbProgress = view.findViewById(R.id.pb_progress);
        rvNotification = view.findViewById(R.id.rv_notification);
        tvError = view.findViewById(R.id.tv_error);

        pref = SharedPrefManager.getInstance(getContext());
        mApiInterface = APIClient.getClient().create(APIService.class);

        showNotification();
    }

    private void showNotification() {
        showLoading(true);

        String idPembimbing = pref.getPembimbing().getIdPembimbing();

        rvNotification.setLayoutManager(new LinearLayoutManager(getContext()));

        Call<ResponseNotification> call = mApiInterface.pembimbingListNotifikasi(idPembimbing);
        call.enqueue(new Callback<ResponseNotification>() {
            @Override
            public void onResponse(Call<ResponseNotification> call, Response<ResponseNotification> response) {
                showLoading(false);
                if (response.body().getStatus().equals("200")){
                    NotificationAdapter notificationAdapter = new NotificationAdapter(getContext(), response.body().getData());
                    rvNotification.setAdapter(notificationAdapter);
                }else{
                    showMessage(true, response.body().getMessage());
                }
            }

            @Override
            public void onFailure(Call<ResponseNotification> call, Throwable t) {
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
