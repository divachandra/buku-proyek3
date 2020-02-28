package com.divakrishnam.actspotpembimbingeksternal.fragment;


import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.viewpager.widget.ViewPager;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.divakrishnam.actspotpembimbingeksternal.R;
import com.divakrishnam.actspotpembimbingeksternal.activity.MainActivity;
import com.divakrishnam.actspotpembimbingeksternal.adapter.PageAdapter;
import com.google.android.material.tabs.TabLayout;

public class ConfirmationFragment extends Fragment{

    private TabLayout tabLayout;

    private ViewPager viewPager;

    public ConfirmationFragment() {
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        ((MainActivity) getActivity()).setActionBarTitle("Confirmation");
        return inflater.inflate(R.layout.fragment_confirmation, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        ((AppCompatActivity) getActivity()).getSupportActionBar().setElevation(0);
        viewPager = view.findViewById(R.id.pager);
        PageAdapter pageAdapter = new PageAdapter(getChildFragmentManager());
        viewPager.setAdapter(pageAdapter);

        tabLayout = view.findViewById(R.id.tabLayout);
        tabLayout.setupWithViewPager(viewPager);
    }
}
