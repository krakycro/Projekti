package com.etfos.kraky.gmstation;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;
import android.support.v4.view.PagerAdapter;

import java.util.ArrayList;


public class AdapterPage extends FragmentStatePagerAdapter {

    private ArrayList<ObjectListFragment> TTitles;


    public AdapterPage(FragmentManager FM, ArrayList<ObjectListFragment> TTitles){
        super(FM);
        this.TTitles = TTitles;
    }


    public void Remove(){

    }

    @Override
    public Fragment getItem(int position) {

        return TTitles.get(position);
    }

    @Override
    public int getCount() {
        return TTitles.size();
    }

    @Override
    public CharSequence getPageTitle(int position) {
        return TTitles.get(position).getName();
    }


    @Override
    public int getItemPosition(Object object) {
        return PagerAdapter.POSITION_NONE;
    }




}
