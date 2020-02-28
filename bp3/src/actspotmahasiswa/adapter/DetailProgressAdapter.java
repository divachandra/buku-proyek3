package com.divakrishnam.actspotmahasiswa.adapter;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.bumptech.glide.Glide;
import com.divakrishnam.actspotmahasiswa.R;
import com.divakrishnam.actspotmahasiswa.model.ProgressPerDay;
import com.divakrishnam.actspotmahasiswa.util.Urls;
import java.util.List;
public class DetailProgressAdapter  extends RecyclerView.Adapter<DetailProgressAdapter.DetailProgressViewHolder> {
    private List<ProgressPerDay> mList;
    private Context mContext;
    public DetailProgressAdapter(Context context, List<ProgressPerDay> list){
        mContext = context;
        mList = list;
    }
    @NonNull
    @Override
    public DetailProgressViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_detail_progress, parent, false);
        DetailProgressViewHolder mViewHolder = new DetailProgressViewHolder(mView);
        return mViewHolder;
    }
    @Override
    public void onBindViewHolder(@NonNull DetailProgressViewHolder holder, int position) {
        ProgressPerDay progressPerDay = mList.get(position);
        holder.tvKegiatan.setText(progressPerDay.getKegiatan());
        holder.tvTglWaktu.setText(progressPerDay.getTglWaktu());
        Glide.with(mContext).load(Urls.IMAGE_URL+"absensi/"+progressPerDay.getFotoAbsensi()).error(R.drawable.profile).into(holder.ivProgress);
    }
    @Override
    public int getItemCount() {
        return mList.size();
    }
    public class DetailProgressViewHolder extends RecyclerView.ViewHolder {
        ImageView ivProgress;
        TextView tvTglWaktu, tvKegiatan;
        public DetailProgressViewHolder(@NonNull View itemView) {
            super(itemView);
            ivProgress = itemView.findViewById(R.id.iv_progress);
            tvTglWaktu = itemView.findViewById(R.id.tv_tgl_waktu);
            tvKegiatan = itemView.findViewById(R.id.tv_kegiatan);
        }
    }
}
