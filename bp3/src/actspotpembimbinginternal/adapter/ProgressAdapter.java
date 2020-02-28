package com.divakrishnam.actspotpembimbinginternal.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.divakrishnam.actspotpembimbinginternal.R;
import com.divakrishnam.actspotpembimbinginternal.activity.DetailProgressActivity;
import com.divakrishnam.actspotpembimbinginternal.model.Progress;
import com.github.mikephil.charting.charts.PieChart;
import com.github.mikephil.charting.data.PieData;
import com.github.mikephil.charting.data.PieDataSet;
import com.github.mikephil.charting.data.PieEntry;
import com.github.mikephil.charting.formatter.PercentFormatter;
import com.github.mikephil.charting.utils.ColorTemplate;

import java.util.ArrayList;
import java.util.List;

public class ProgressAdapter extends RecyclerView.Adapter<ProgressAdapter.ProgressViewHolder> {

    private List<Progress> mList;
    private Context mContext;
    private ProgressListener mListener;

    public ProgressAdapter(Context context, List<Progress> list, ProgressListener listener) {
        mContext = context;
        mList = list;
        mListener = listener;
    }

    @NonNull
    @Override
    public ProgressViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_progress, parent, false);
        ProgressViewHolder mViewHolder = new ProgressViewHolder(mView);
        return mViewHolder;
    }

    @Override
    public void onBindViewHolder(@NonNull ProgressViewHolder holder, int position) {
        final Progress progress = mList.get(position);
        holder.tvSort.setText(progress.getSort());

        int pot = position+1;

        if (progress.getSort().equals("Hari ke-" + pot)) {
            holder.tvSort.setOnClickListener(view -> {
                Intent day = new Intent(mContext, DetailProgressActivity.class);
                day.putExtra(DetailProgressActivity.EXTRA_DAY, progress.getTglWaktu());
                day.putExtra(DetailProgressActivity.EXTRA_ID, progress.getIdMahasiswa());
                day.putExtra(DetailProgressActivity.EXTRA_INTERN, progress.getIdIntern());
                mContext.startActivity(day);
            });
        }else if(progress.getSort().equals("Minggu ke-" + pot)){
            holder.tvSort.setOnClickListener(view -> mListener.onWeekClickProgress());
        }else if(progress.getSort().equals("Bulan ke-" + pot)){
            holder.tvSort.setOnClickListener(view -> mListener.onMonthClickProgress());
        }

        holder.pcProgress.setDrawHoleEnabled(true);
        holder.pcProgress.setHoleRadius(0);
        holder.pcProgress.setTransparentCircleRadius(0);

        holder.pcProgress.setRotationAngle(0);
        holder.pcProgress.setRotationEnabled(true);

        PieDataSet pieDataSet = new PieDataSet(getData(progress.getPersen()),null);
        pieDataSet.setColors(ColorTemplate.COLORFUL_COLORS);
        pieDataSet.setSliceSpace(3);
        pieDataSet.setSelectionShift(5);
        PieData pieData = new PieData(pieDataSet);
        pieData.setValueFormatter(new PercentFormatter(holder.pcProgress));
        holder.pcProgress.setUsePercentValues(true);
        pieData.setValueTextSize(12f);
        pieData.setValueTextColor(Color.WHITE);
        holder.pcProgress.setDrawSliceText(false);
        holder.pcProgress.setData(pieData);
        holder.pcProgress.animateXY(100, 100);
        holder.pcProgress.invalidate();
        holder.pcProgress.getDescription().setEnabled(false);

    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class ProgressViewHolder extends RecyclerView.ViewHolder {

        PieChart pcProgress;
        TextView tvSort;

        public ProgressViewHolder(@NonNull View itemView) {
            super(itemView);

            pcProgress = itemView.findViewById(R.id.piechart);
            tvSort = itemView.findViewById(R.id.tv_sort);
        }
    }

    private ArrayList getData(String persen){
        float full = Float.valueOf(persen);
        float unfull = 100f -Float.valueOf(persen);
        ArrayList<PieEntry> entries = new ArrayList<>();
        entries.add(new PieEntry(full, "Terpenuhi"));
        entries.add(new PieEntry(unfull, "Tidak terpenuhi"));
        return entries;
    }

    public interface ProgressListener {
        void onMonthClickProgress();
        void onWeekClickProgress();
    }
}
