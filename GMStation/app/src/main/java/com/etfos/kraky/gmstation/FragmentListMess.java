package com.etfos.kraky.gmstation;

import android.os.Handler;
import android.util.Log;

public class FragmentListMess extends ObjectListFragment {

    private Handler H = new Handler();

    @Override
    public void onStart() {
        super.onStart();

        //
        // INIT LIST MESS
        //
        new Thread(new Runnable() {
            @Override
            public void run() {
                AdapterDB.ArrayCursor AC = new AdapterDB.ArrayCursor();
                TableItem TI = (TableItem) getDBase().StartArrayCursorLoadDB(ObjectDB.TABLE_ITEM, AC, TableItem.POSS+" ASC" ,null,TableItem.MENU+"="+getID());
                Log.i("DB itemMess init-id",getName()+"-"+getID());

                while (TI != null) {
                            Log.i("DB adding item id-paren",TI.getId()+"-"+TI.getMenu());
                            addItem((int)TI.getType(),TI);

                    TI = (TableItem) getDBase().ArrayCursorGetRowDB(ObjectDB.TABLE_ITEM, AC);
                }
                getDBase().ArrayCursorCloseDB(AC);

                H.post(new Runnable() {
                    @Override
                    public void run() {
                        if(getID() == FragmentMenuMain.TIMER) {
                            getAdapter().sorter(1);
                            initNewConst();
                        }
                        else
                            initNewFlex();

                        }
                    });

           }}).start();



    }



}
