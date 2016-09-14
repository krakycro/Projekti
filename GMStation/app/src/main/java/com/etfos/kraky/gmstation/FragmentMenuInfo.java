package com.etfos.kraky.gmstation;


import java.util.ArrayList;


public class FragmentMenuInfo extends ObjectMenuFragment {

    public ObjectMenuFragment init( long ID, Object... stuff) {
        setID(ID);
        setDBase(AdapterDB.InitDB(getContext()));
        for ( Object x: stuff) {
            if(x.getClass() == Integer.class)
                IMG = (int) x;
        }

        setFLIST(new ArrayList<ObjectListFragment>());
        return this;
    }

}
