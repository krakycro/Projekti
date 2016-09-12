package com.etfos.kraky.gmstation;

import android.support.v4.app.Fragment;

import java.util.ArrayList;


public class ObjectMenuFragment extends Fragment {

    private String name;
    private ArrayList<ObjectListFragment> FLIST;
    public long ID;
    public int IMG;
    public ObjectListener CL;
    private AdapterDB DBase;

    public String getName() {
        return name;
    }

    public void reName(String name) {
        this.name = name;
    }

    public ObjectMenuFragment setName(String name) {
        this.name = name;
        return this;
    }


    public ObjectMenuFragment init( long ID, Object... stuff){
        return this;
    }

    public ArrayList<ObjectListFragment> getFLIST() {
        return FLIST;
    }

    public void setFLIST(ArrayList<ObjectListFragment> FLIST ) {
        this.FLIST = FLIST;
    }

    public AdapterDB getDBase() {
        return DBase;
    }

    public void setDBase(AdapterDB DBase) {
        this.DBase = DBase;
    }

    public long getID() {
        return ID;
    }

    public void setID(long ID) {
        this.ID = ID;
    }
}
