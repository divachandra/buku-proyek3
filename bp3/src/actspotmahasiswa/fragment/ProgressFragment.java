package com.divakrishnam.actspotmahasiswa.fragment;
import android.app.ActionBar;
import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;
import com.divakrishnam.actspotmahasiswa.R;
import com.divakrishnam.actspotmahasiswa.activity.MainActivity;
import com.divakrishnam.actspotmahasiswa.adapter.ProgressAdapter;
import com.divakrishnam.actspotmahasiswa.api.APIClient;
import com.divakrishnam.actspotmahasiswa.api.APIService;
import com.divakrishnam.actspotmahasiswa.model.Progress;
import com.divakrishnam.actspotmahasiswa.model.ResponseProgress;
import com.divakrishnam.actspotmahasiswa.util.SharedPrefManager;
import java.util.List;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
public class ProgressFragment extends Fragment implements ProgressAdapter.ProgressListener {
    private RecyclerView rvProgress;
    private APIService mApiInterface;
    private SharedPrefManager pref;
    private ProgressBar pbProgress;
    private TextView tvError;
    public ProgressFragment() {
    }
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        setHasOptionsMenu(true);
        ((MainActivity) getActivity()).setActionBarTitle("My Progress");
        return inflater.inflate(R.layout.fragment_progress, container, false);
    }
    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        pbProgress = view.findViewById(R.id.pb_progress);
        rvProgress = view.findViewById(R.id.rv_progress);
        tvError = view.findViewById(R.id.tv_error);
        pref = SharedPrefManager.getInstance(getContext());
        mApiInterface = APIClient.getClient().create(APIService.class);
    }
    @Override
    public void onResume() {
        super.onResume();
        if(pref.getSort() == null){
            showProgress("bulan");
            pref.setSort("bulan");
        }{
            showProgress(pref.getSort());
        }
    }
    private void showProgress(String sort) {
        showLoading(true);
        String idIntern = pref.getRegistrasiPerusahaan().getIdIntern();
        String idMahasiswa = pref.getRegistrasiPerusahaan().getIdMahasiswa();
        rvProgress.setLayoutManager(new GridLayoutManager(getContext(), 2));
        Call<ResponseProgress> call = mApiInterface.progressMahasiswa(idIntern, idMahasiswa, sort);
        call.enqueue(new Callback<ResponseProgress>() {
            @Override
            public void onResponse(Call<ResponseProgress> call, Response<ResponseProgress> response) {
                showLoading(false);
                if(response.body().getStatus().equals("201") || response.body().getStatus().equals("202") || response.body().getStatus().equals("203")){
                    showProgress(response.body().getData());
                }else{
                    showMessage(true, response.body().getMessage());
                }
            }
            @Override
            public void onFailure(Call<ResponseProgress> call, Throwable t) {
                showLoading(false);
                showMessage(true, t.getMessage());
            }
        });
    }
    private void showProgress(List<Progress> data){
        ProgressAdapter progressAdapter = new ProgressAdapter(getContext(), data, this);
        rvProgress.setAdapter(progressAdapter);
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
    @Override
    public void onCreateOptionsMenu(@NonNull Menu menu, @NonNull MenuInflater inflater) {
        inflater.inflate(R.menu.menu_progress, menu);
        super.onCreateOptionsMenu(menu, inflater);
    }
    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem menuItem) {
        if (menuItem.getItemId() == R.id.menu_sort_progress) {
            sortProgress();
        }
        return true;
    }
    private void sortProgress() {
        AlertDialog.Builder builder = new AlertDialog.Builder(getContext());
        String[] sorts = {"Date", "Week", "Month"};
        builder.setItems(sorts, (dialog, which) -> {
            switch (which) {
                case 0:
                    showProgress("hari");
                    pref.setSort("hari");
                    break;
                case 1:
                    showProgress("minggu");
                    pref.setSort("minggu");
                    break;
                case 2:
                    showProgress("bulan");
                    pref.setSort("bulan");
                    break;
            }
        });
        AlertDialog dialog = builder.create();
        dialog.show();
    }
    @Override
    public void onMonthClickProgress() {
        showProgress("minggu");
        pref.setSort("minggu");
    }
    @Override
    public void onWeekClickProgress() {
        showProgress("hari");
        pref.setSort("hari");
    }
}
