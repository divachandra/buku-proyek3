package com.divakrishnam.actspotpembimbingeksternal.adapter;

import android.content.Context;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;
import androidx.fragment.app.FragmentStatePagerAdapter;

import com.divakrishnam.actspotpembimbingeksternal.fragment.AbsenceConfirmFragment;
import com.divakrishnam.actspotpembimbingeksternal.fragment.MahasiswaConfirmFragment;

public class PageAdapter extends FragmentPagerAdapter {

    public PageAdapter(FragmentManager fm) {
        super(fm);
    }

    @Override
    public Fragment getItem(int i) {
        switch (i){
            case 0:
                return new AbsenceConfirmFragment();
            case 1:
                return new MahasiswaConfirmFragment();
        }
        return null;
    }

    @Override
    public int getCount() {
        return 2;
    }

    @Nullable
    @Override
    public CharSequence getPageTitle(int position) {
        switch (position){
            case 0:
                return "Absensi";
            case 1:
                return "Mahasiswa";
        }
        return super.getPageTitle(position);
    }
}
