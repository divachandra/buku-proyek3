package com.divakrishnam.actspotpembimbinginternal.adapter;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.divakrishnam.actspotpembimbinginternal.R;
import com.divakrishnam.actspotpembimbinginternal.activity.ProgressActivity;
import com.divakrishnam.actspotpembimbinginternal.model.Mahasiswa;
import com.divakrishnam.actspotpembimbinginternal.util.Urls;

import java.util.List;

public class MahasiswaAdapter extends RecyclerView.Adapter<MahasiswaAdapter.MahasiswaViewHolder> {

    private List<Mahasiswa> mList;
    private Context mContext;

    public MahasiswaAdapter(Context context, List<Mahasiswa> list){
        mContext = context;
        mList = list;
    }

    @NonNull
    @Override
    public MahasiswaViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_mahasiswa, parent, false);
        MahasiswaViewHolder mViewHolder = new MahasiswaViewHolder(mView);
        return mViewHolder;
    }

    @Override
    public void onBindViewHolder(@NonNull MahasiswaViewHolder holder, int position) {
        final Mahasiswa mahasiswa = mList.get(position);

        holder.tvMahasiswa.setText(mahasiswa.getNamaMahasiswa());
        holder.tvPerusahaan.setText(mahasiswa.getNamaPerusahaan());
        holder.tvAngkatan.setText(mahasiswa.getAngkatanMahasiswa());
        holder.tvPresentase.setText(mahasiswa.getPresentaseInternship()+"%");
        Glide.with(mContext).load(Urls.IMAGE_URL+"mahasiswa/"+mahasiswa.getFotoMahasiswa()).error(R.drawable.profile).into(holder.ivMahasiswa);
        holder.itemView.setOnClickListener(view -> {
            Intent intent = new Intent(mContext, ProgressActivity.class);
            intent.putExtra(ProgressActivity.EXTRA_MAHASISWA, mahasiswa);
            mContext.startActivity(intent);
        });
    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MahasiswaViewHolder extends RecyclerView.ViewHolder {

        ImageView ivMahasiswa;
        TextView tvMahasiswa, tvPerusahaan, tvAngkatan, tvPresentase;

        public MahasiswaViewHolder(@NonNull View itemView) {
            super(itemView);

            ivMahasiswa = itemView.findViewById(R.id.img_mahasiswa);
            tvMahasiswa = itemView.findViewById(R.id.tv_mahasiswa);
            tvPerusahaan = itemView.findViewById(R.id.tv_perusahaan);
            tvAngkatan = itemView.findViewById(R.id.tv_angkatan);
            tvPresentase = itemView.findViewById(R.id.tv_presentase);
        }
    }
}
