package com.divakrishnam.actspotpembimbingeksternal.adapter;

import android.app.ProgressDialog;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.api.APIClient;
import com.divakrishnam.actspotpembimbingeksternal.api.APIService;
import com.divakrishnam.actspotpembimbingeksternal.model.ConfirmMahasiswa;
import com.divakrishnam.actspotpembimbingeksternal.model.ResponseInfo;
import com.divakrishnam.actspotpembimbingeksternal.util.SharedPrefManager;
import com.divakrishnam.actspotpembimbingeksternal.util.Urls;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ConfirmMahasiswaAdapter extends RecyclerView.Adapter<ConfirmMahasiswaAdapter.ConfirmMahasiswaViewHolder> {
    private List<ConfirmMahasiswa> mList;
    private Context mContext;
    private ConfirmMahasiswaListener mListener;

    public ConfirmMahasiswaAdapter(Context context, List<ConfirmMahasiswa> list, ConfirmMahasiswaListener listener) {
        mContext = context;
        mList = list;
        mListener = listener;
    }

    @NonNull
    @Override
    public ConfirmMahasiswaViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_confirm_notification, parent, false);
        ConfirmMahasiswaViewHolder mViewHolder = new ConfirmMahasiswaViewHolder(mView);
        return mViewHolder;
    }

    @Override
    public void onBindViewHolder(@NonNull ConfirmMahasiswaViewHolder holder, int position) {
        final ConfirmMahasiswa confirmMahasiswa = mList.get(position);

        holder.tvMahasiswa.setText(confirmMahasiswa.getNamaMahasiswa());
        holder.tvMessage.setText(confirmMahasiswa.getNamaProdi());
        Glide.with(mContext).load(Urls.IMAGE_URL+"mahasiswa/"+confirmMahasiswa.getFotoMahasiswa()).error(R.drawable.profile).into(holder.ivMahasiswa);

        holder.btnConfirm.setOnClickListener(view -> confirmAbsence(confirmMahasiswa, position));
    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class ConfirmMahasiswaViewHolder extends RecyclerView.ViewHolder {

        ImageView ivMahasiswa;
        TextView tvMahasiswa, tvMessage;
        Button btnConfirm;

        public ConfirmMahasiswaViewHolder(@NonNull View itemView) {
            super(itemView);

            ivMahasiswa = itemView.findViewById(R.id.img_mahasiswa);
            tvMahasiswa = itemView.findViewById(R.id.tv_mahasiswa);
            tvMessage = itemView.findViewById(R.id.tv_message);
            btnConfirm = itemView.findViewById(R.id.btn_confirm);
        }
    }

    private void confirmAbsence(ConfirmMahasiswa confirmMahasiswa, int position) {
        final ProgressDialog progressDialog = new ProgressDialog(mContext);
        progressDialog.setMessage("Konfirmasi data...");
        progressDialog.setCancelable(false);
        progressDialog.show();


        APIService mApiInterface = APIClient.getClient().create(APIService.class);
        SharedPrefManager pref = SharedPrefManager.getInstance(mContext);

        Call<ResponseInfo> call = mApiInterface.pembimbingKonfirmMahasiswa(pref.getPembimbing().getIdPembimbing(), confirmMahasiswa.getIdMahasiswa(), confirmMahasiswa.getIdIntern(), confirmMahasiswa.getIdDosen());
        call.enqueue(new Callback<ResponseInfo>() {
            @Override
            public void onResponse(Call<ResponseInfo> call, Response<ResponseInfo> response) {
                progressDialog.dismiss();
                Toast.makeText(mContext, response.body().getMessage(), Toast.LENGTH_LONG).show();
                if(response.body().getStatus().equals("200")){
                    mList.remove(position);
                    mListener.onConfirmMahasiswa();
                }
            }

            @Override
            public void onFailure(Call<ResponseInfo> call, Throwable t) {
                progressDialog.dismiss();
                Toast.makeText(mContext, "Error : "+t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });
    }

    public interface ConfirmMahasiswaListener {
        void onConfirmMahasiswa();
    }
}
