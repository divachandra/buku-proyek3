package com.divakrishnam.actspotpembimbingeksternal.util;

import android.content.Context;
import android.content.SharedPreferences;

import com.divakrishnam.actspotpembimbingeksternal.model.Login;

public class SharedPrefManager {

    private SharedPreferences pref;
    private SharedPreferences.Editor editor;
    private static SharedPrefManager mInstance;
    private static Context mContext;

    private static final String SHARED_PREF_NAME = "actspotpembimbingeksternal";

    private static final String KEY_USERNAME = "keyusername";
    private static final String KEY_PASSWORD = "keypassword";
    private static final String KEY_IDPEMBIMBING = "keyidpembimbing";
    private static final String KEY_NAMA = "keynama";
    private static final String KEY_PERUSAHAAN = "keyperusahaan";
    private static final String KEY_FOTO = "keyfoto";
    private static final String KEY_KONTAK = "keykontak";

    private SharedPrefManager(Context context){
        mContext = context;
        pref = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        editor = pref.edit();
    }

    public static synchronized SharedPrefManager getInstance(Context context) {
        if (mInstance == null) {
            mInstance = new SharedPrefManager(context);
        }
        return mInstance;
    }

    public void pembimbingLogin(Login login){
        editor.putString(KEY_USERNAME, login.getUsername());
        editor.putString(KEY_PASSWORD, login.getPassword());
        editor.putString(KEY_IDPEMBIMBING, login.getIdPembimbing());
        editor.putString(KEY_NAMA, login.getNamaPembimbing());
        editor.putString(KEY_PERUSAHAAN, login.getNamaPerusahaan());
        editor.putString(KEY_FOTO, login.getFotoPembimbing());
        editor.putString(KEY_KONTAK, login.getKontakPembimbing());
        editor.apply();
    }

    public boolean isLoggedIn(){
        return pref.getString(KEY_IDPEMBIMBING, null) != null;
    }

    public Login getPembimbing(){
        return new Login(
                pref.getString(KEY_USERNAME, null),
                pref.getString(KEY_PASSWORD, null),
                pref.getString(KEY_IDPEMBIMBING, null),
                pref.getString(KEY_NAMA, null),
                pref.getString(KEY_PERUSAHAAN, null),
                pref.getString(KEY_FOTO, null),
                pref.getString(KEY_KONTAK, null)
        );
    }



    public void logout(){
        editor.clear();
        editor.apply();
    }
}
