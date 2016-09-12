package com.etfos.kraky.gmstation;

public class FragmentListNet extends ObjectListFragment {

    @Override
    public void onStart() {
        super.onStart();

        //
        // INIT LIST LOCK
        //
/*
        new Thread(new Runnable() {
            @Override
            public void run() {

                AdapterDB.ArrayCursor AC = new AdapterDB.ArrayCursor();
                TableItem TI = (TableItem) getDBase().StartArrayCursorLoadDB(ObjectDB.TABLE_ITEM, AC,  TableItem.POSS+" ASC", null, TableItem.MENU+"="+getID());
                Log.i("DB itemLock init-id",getName()+"-"+getID());

                while (TI != null) {
                    Log.i("DB adding item id-paren",TI.getId()+"-"+TI.getMenu());
                    addItem((int)TI.getType(),TI);
                    TI = (TableItem) getDBase().ArrayCursorGetRowDB(ObjectDB.TABLE_ITEM,AC);
                }
                getDBase().ArrayCursorCloseDB(AC);


            }}).start();
*/
    }


}
