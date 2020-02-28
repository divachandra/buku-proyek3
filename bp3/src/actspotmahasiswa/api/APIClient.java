package com.divakrishnam.actspotmahasiswa.api;
import com.divakrishnam.actspotmahasiswa.util.Urls;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;
public class APIClient {
    private static Retrofit retrofit = null;
    public static Retrofit getClient() {
        if (retrofit==null) {
            retrofit = new Retrofit.Builder()
                    .baseUrl(Urls.API_URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build();
        }
        return retrofit;
    }
}
