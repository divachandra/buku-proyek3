package com.divakrishnam.actspotpembimbingeksternal.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.model.Mahasiswa;
import com.divakrishnam.actspotpembimbingeksternal.util.Urls;

public class DetailMahasiswaActivity extends AppCompatActivity {

    public static final String EXTRA_MAHASISWA = "extra_mahasiswa";
    private ImageView ivMahasiswa;
    private TextView tvMahasiswa, tvAngkatan, tvKontak, tvProdi;
    private Mahasiswa mahasiswa;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_mahasiswa);

        mahasiswa = getIntent().getParcelableExtra(EXTRA_MAHASISWA);

        ivMahasiswa= findViewById(R.id.img_mahasiswa);
        tvMahasiswa = findViewById(R.id.tv_mahasiswa);
        tvAngkatan = findViewById(R.id.tv_angkatan);
        tvKontak = findViewById(R.id.tv_kontak);
        tvProdi = findViewById(R.id.tv_prodi);

        tvMahasiswa.setText(mahasiswa.getNamaMahasiswa());
        tvAngkatan.setText(mahasiswa.getAngkatanMahasiswa());
        tvKontak.setText(mahasiswa.getKontakMahasiswa());
        tvProdi.setText(mahasiswa.getNamaProdi());

        Glide.with(this).load(Urls.IMAGE_URL+"mahasiswa/"+mahasiswa.getFotoMahasiswa()).error(R.drawable.profile).into(ivMahasiswa);
    }
}
