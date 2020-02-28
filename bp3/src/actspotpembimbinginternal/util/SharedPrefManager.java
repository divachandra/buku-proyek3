package com.divakrishnam.actspotpembimbinginternal.util;

import android.content.Context;
import android.content.SharedPreferences;

import com.divakrishnam.actspotpembimbinginternal.model.Login;

public class SharedPrefManager {

    private SharedPreferences pref;
    private SharedPreferences.Editor editor;
    private static SharedPrefManager mInstance;
    private static Context mContext;

    private static final String SHARED_PREF_NAME = "actspotpembimbinginternal";

    private static final String KEY_USERNAME = "keyusername";
    private static final String KEY_PASSWORD = "keypassword";
    private static final String KEY_IDDOSEN = "keyidosen";
    private static final String KEY_NAMADOSEN = "keynamadosen";
    private static final String KEY_FOTODOSEN = "keyfotodosen";
    private static final String KEY_IDINTERN = "keyidintern";
    private static final String KEY_NAMAPRODI = "keynamaprodi";
    private static final String KEY_KONTAKDOSEN = "keykontakdosen";

    private static final String KEY_SORT = "keysort";

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

    public void dosenLogin(Login login){
        editor.putString(KEY_USERNAME, login.getUsername());
        editor.putString(KEY_PASSWORD, login.getPassword());
        editor.putString(KEY_IDDOSEN, login.getIdDosen());
        editor.putString(KEY_NAMADOSEN, login.getNamaDosen());
        editor.putString(KEY_FOTODOSEN, login.getFotoDosen());
        editor.putString(KEY_NAMAPRODI, login.getNamaProdi());
        editor.putString(KEY_KONTAKDOSEN, login.getKontakDosen());
        editor.apply();
    }

    public boolean isLoggedIn(){
        return pref.getString(KEY_IDDOSEN, null) != null;
    }

    public Login getDosen(){
        return new Login(
                pref.getString(KEY_USERNAME, null),
                pref.getString(KEY_PASSWORD, null),
                pref.getString(KEY_IDDOSEN, null),
                pref.getString(KEY_NAMADOSEN, null),
                pref.getString(KEY_FOTODOSEN, null),
                //pref.getString(KEY_IDINTERN, null),
                pref.getString(KEY_NAMAPRODI, null),
                pref.getString(KEY_KONTAKDOSEN, null)
        );
    }

    public void setSort(String sort){
        editor.putString(KEY_SORT, sort);
        editor.apply();
    }

    public String getSort(){
        return pref.getString(KEY_SORT, null);
    }

    public void logout(){
        editor.clear();
        editor.apply();
    }
}
