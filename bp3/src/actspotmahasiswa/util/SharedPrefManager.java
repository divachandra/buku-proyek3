package com.divakrishnam.actspotmahasiswa.util;
import android.content.Context;
import com.divakrishnam.actspotmahasiswa.model.Login;
public class SharedPrefManager {
    private android.content.SharedPreferences pref;
    private android.content.SharedPreferences.Editor editor;
    private static SharedPrefManager mInstance;
    private static Context mContext;
    private static final String SHARED_PREF_NAME = "actspotmahasiswa";
    private static final String KEY_IDMAHASISWA = "keyidmahasiswa";
    private static final String KEY_USERNAME = "keyusername";
    private static final String KEY_PASSWORD = "keypassword";
    private static final String KEY_NAMAMAHASISWA = "keynamamahasiswa";
    private static final String KEY_KELASMAHASISWA = "keykelasmahasiswa";
    private static final String KEY_ANGKATANMAHASISWA = "keyangkatanmahasiswa";
    private static final String KEY_FOTOMAHASISWA = "keyfotomahasiswa";
    private static final String KEY_NAMAPRODI = "keynamaprodi";
    private static final String KEY_IDINTERN = "keyidintern";
    private static final String KEY_IDDOSEN = "keyiddosen";
    private static final String KEY_IDPEMBIMBING = "keyidpembimbing";
    private static final String KEY_NAMADOSEN = "keynamadosen";
    private static final String KEY_NAMAPERUSAHAAN = "keynamaperusahaan";
    private static final String KEY_NAMAPEMBIMBING = "keynamapembimbing";
    private static final String KEY_KONTAKMAHASISWA = "keykontakmahasiswa";
    private static final String KEY_SORT = "keysort";
    private SharedPrefManager(Context context) {
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
    public void mahasiswaLogin(Login login) {
        editor.putString(KEY_IDMAHASISWA, login.getIdMahasiswa());
        editor.putString(KEY_USERNAME, login.getUsername());
        editor.putString(KEY_PASSWORD, login.getPassword());
        editor.putString(KEY_NAMAMAHASISWA, login.getNamaMahasiswa());
        editor.putString(KEY_KELASMAHASISWA, login.getKelasMahasiswa());
        editor.putString(KEY_ANGKATANMAHASISWA, login.getAngkatanMahasiswa());
        editor.putString(KEY_FOTOMAHASISWA, login.getFotoMahasiswa());
        editor.putString(KEY_NAMAPRODI, login.getNamaProdi());
        editor.putString(KEY_IDINTERN, login.getIdIntern());
        editor.putString(KEY_IDDOSEN, login.getIdDosen());
        editor.putString(KEY_IDPEMBIMBING, login.getIdPembimbing());
        editor.putString(KEY_NAMADOSEN, login.getNamaDosen());
        editor.putString(KEY_NAMAPEMBIMBING, login.getNamaPembimbing());
        editor.putString(KEY_NAMAPERUSAHAAN, login.getNamaPerusahaan());
        editor.putString(KEY_KONTAKMAHASISWA, login.getKontakMahasiswa());
        editor.apply();
    }
    public void setSort(String sort){
        editor.putString(KEY_SORT, sort);
        editor.apply();
    }
    public String getSort(){
        return pref.getString(KEY_SORT, null);
    }
    public Login getMahasiswaLogin() {
        return new Login(
            pref.getString(KEY_IDMAHASISWA, null),
            pref.getString(KEY_USERNAME, null),
            pref.getString(KEY_PASSWORD, null),
            pref.getString(KEY_NAMAMAHASISWA, null),
            pref.getString(KEY_KELASMAHASISWA, null),
            pref.getString(KEY_ANGKATANMAHASISWA, null),
            pref.getString(KEY_FOTOMAHASISWA, null),
            pref.getString(KEY_NAMAPRODI, null),
            pref.getString(KEY_IDINTERN, null),
            pref.getString(KEY_IDDOSEN, null),
            pref.getString(KEY_NAMADOSEN, null),
            pref.getString(KEY_NAMAPEMBIMBING, null),
            pref.getString(KEY_IDPEMBIMBING, null),
            pref.getString(KEY_NAMAPERUSAHAAN, null),
            pref.getString(KEY_KONTAKMAHASISWA, null)
        );
    }
    public void registrasiPerusahaan(Login login) {
        editor.putString(KEY_IDINTERN, login.getIdIntern());
        editor.putString(KEY_IDMAHASISWA, login.getIdMahasiswa());
        editor.putString(KEY_IDDOSEN, login.getIdDosen());
        editor.apply();
    }
    public boolean isLoggedIn() {
        return pref.getString(KEY_IDMAHASISWA, null) != null && pref.getString(KEY_NAMAPERUSAHAAN, null) != null;
    }
    public Login getRegistrasiPerusahaan() {
        return new Login(
            pref.getString(KEY_IDINTERN, null),
            pref.getString(KEY_IDMAHASISWA, null),
            pref.getString(KEY_IDDOSEN, null)
        );
    }
    public void logout() {
        editor.clear();
        editor.apply();
    }
}
