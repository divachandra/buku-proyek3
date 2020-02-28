package com.divakrishnam.actspotpembimbingeksternal.fragment;


import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.activity.LoginActivity;
import com.divakrishnam.actspotpembimbingeksternal.activity.MainActivity;
import com.divakrishnam.actspotpembimbingeksternal.activity.PasswordActivity;
import com.divakrishnam.actspotpembimbingeksternal.activity.ProfileActivity;
import com.divakrishnam.actspotpembimbingeksternal.util.SharedPrefManager;
import com.divakrishnam.actspotpembimbingeksternal.util.Urls;

public class ProfileFragment extends Fragment implements View.OnClickListener{

    private ImageView ivProfil;
    private TextView tvNama, tvProfil, tvPassword, tvKeluar;

    private SharedPrefManager pref;

    public ProfileFragment() {
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        ((MainActivity) getActivity()).setActionBarTitle("My Profile");
        return inflater.inflate(R.layout.fragment_profile, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        ivProfil = view.findViewById(R.id.img_profile);
        tvNama = view.findViewById(R.id.tv_nama);
        tvProfil = view.findViewById(R.id.tv_profile);
        tvPassword = view.findViewById(R.id.tv_password);
        tvKeluar = view.findViewById(R.id.tv_keluar);

        pref = SharedPrefManager.getInstance(getContext());

        tvProfil.setOnClickListener(this);
        tvPassword.setOnClickListener(this);
        tvKeluar.setOnClickListener(this);
    }

    @Override
    public void onResume() {
        super.onResume();
        tvNama.setText(pref.getPembimbing().getNamaPembimbing());
        Glide.with(this).load(Urls.IMAGE_URL+"pembimbing/"+pref.getPembimbing().getFotoPembimbing()).error(R.drawable.profile).into(ivProfil);
    }

    @Override
    public void onClick(View view) {
        if (view == tvProfil){
            Intent intent = new Intent(getContext(), ProfileActivity.class);
            startActivity(intent);
        }else if (view == tvPassword){
            Intent intent = new Intent(getContext(), PasswordActivity.class);
            startActivity(intent);
        }else if (view == tvKeluar){
            pref.logout();
            getActivity().finish();
            startActivity(new Intent(getContext(), LoginActivity.class));
        }
    }
}
