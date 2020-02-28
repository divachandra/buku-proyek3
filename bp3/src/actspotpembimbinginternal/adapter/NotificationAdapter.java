package com.divakrishnam.actspotpembimbinginternal.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.divakrishnam.actspotpembimbinginternal.R;
import com.divakrishnam.actspotpembimbinginternal.model.Notification;

import java.util.List;

public class NotificationAdapter extends RecyclerView.Adapter<NotificationAdapter.NotificationViewHolder> {
    private List<Notification> mList;
    private Context mContext;

    public NotificationAdapter(Context context, List<Notification> list){
        mContext = context;
        mList = list;
    }

    @NonNull
    @Override
    public NotificationViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_notification, parent, false);
        NotificationViewHolder mViewHolder = new NotificationViewHolder(mView);
        return mViewHolder;
    }

    @Override
    public void onBindViewHolder(@NonNull NotificationViewHolder holder, int position) {
        final Notification notification = mList.get(position);

        holder.tvTime.setText(notification.getTglWaktu());
        holder.tvMessage.setText(notification.getPesan());
    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class NotificationViewHolder extends RecyclerView.ViewHolder {
        TextView tvTime, tvMessage;

        public NotificationViewHolder(@NonNull View itemView) {
            super(itemView);

            tvTime = itemView.findViewById(R.id.tv_time);
            tvMessage = itemView.findViewById(R.id.tv_message);
        }
    }
}
