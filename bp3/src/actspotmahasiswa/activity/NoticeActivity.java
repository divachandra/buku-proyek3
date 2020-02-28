package com.divakrishnam.actspotmahasiswa.activity;
import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import com.divakrishnam.actspotmahasiswa.R;
public class NoticeActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notice);

        getSupportActionBar().setTitle("Notice");
    }
}
