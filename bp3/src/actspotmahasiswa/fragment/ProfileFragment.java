package com.divakrishnam.actspotmahasiswa.fragment;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import com.bumptech.glide.Glide;
import com.divakrishnam.actspotmahasiswa.R;
import com.divakrishnam.actspotmahasiswa.activity.LoginActivity;
import com.divakrishnam.actspotmahasiswa.activity.MainActivity;
import com.divakrishnam.actspotmahasiswa.activity.PasswordActivity;
import com.divakrishnam.actspotmahasiswa.activity.ProfileActivity;
import com.divakrishnam.actspotmahasiswa.activity.TextActivity;
import com.divakrishnam.actspotmahasiswa.util.SharedPrefManager;
import com.divakrishnam.actspotmahasiswa.util.Urls;
public class ProfileFragment extends Fragment implements View.OnClickListener{
    private ImageView ivProfile;
    private TextView tvProfile, tvPassword, tvNama, tvKeluar;
    private SharedPrefManager pref;
    public ProfileFragment() {
    }
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        ((MainActivity) getActivity()).setActionBarTitle("My Profile");
        return inflater.inflate(R.layout.fragment_profile, container, false);
    }
    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        ivProfile = view.findViewById(R.id.img_profile);
        tvNama = view.findViewById(R.id.tv_nama);
        tvProfile = view.findViewById(R.id.tv_profile);
        tvPassword = view.findViewById(R.id.tv_password);
        tvKeluar = view.findViewById(R.id.tv_keluar);
        pref = SharedPrefManager.getInstance(getContext());
        tvNama.setText(pref.getMahasiswaLogin().getNamaMahasiswa());
        Glide.with(this).load(Urls.IMAGE_URL+"mahasiswa/"+pref.getMahasiswaLogin().getFotoMahasiswa()).error(R.drawable.profile).into(ivProfile);
        tvProfile.setOnClickListener(this);
        tvPassword.setOnClickListener(this);
        tvKeluar.setOnClickListener(this);
    }
    @Override
    public void onResume() {
        super.onResume();
        tvNama.setText(pref.getMahasiswaLogin().getNamaMahasiswa());
        Glide.with(this).load(Urls.IMAGE_URL+"mahasiswa/"+pref.getMahasiswaLogin().getFotoMahasiswa()).error(R.drawable.profile).into(ivProfile);
    }
    @Override
    public void onClick(View view) {
        if (view == tvProfile){
            Intent intent = new Intent(getContext(), ProfileActivity.class);
            startActivity(intent);
        }else if (view == tvPassword){
            Intent intent = new Intent(getContext(), PasswordActivity.class);
            startActivity(intent);
        }else if (view == tvKeluar) {
            pref.logout();
            getActivity().finish();
            startActivity(new Intent(getContext(), LoginActivity.class));
        }
    }
}
