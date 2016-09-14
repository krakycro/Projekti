package com.etfos.kraky.gmstation;


import android.content.Context;
import android.content.DialogInterface;
import android.support.v7.app.AlertDialog;
import android.util.Log;

import java.util.ArrayList;


public class FragmentMenuMain extends ObjectMenuFragment {

    public final static int  BOARD = -4;
    public final static  int INIT = -3;
    public final static int  TIMER = -2;
    public final static int  LAN = -1;

    public final static int  BOARD_INDEX = 0;
    public final static  int INIT_INDEX = 1;
    public final static int  TIMER_INDEX = 2;
    public final static int  LAN_INDEX = 3;

    public class ItemRem extends ObjectListener{

        public ItemRem(){}

        public  ItemRem(Context ctx, TableItem TI, int board, int tab){
            super(TI);
            this.ctx = ctx;
            this.board = board;
            this.tab = tab;
        }

        public ItemRem coppy(){
            return new ItemRem(ctx, new TableItem().Init(TI.getId(), TI.getMenu(), TI.getRess(),TI.getType(),TI.getPoss()), board, tab);
        }

        @Override
        public void init() {
            new AlertDialog.Builder(ctx)
                    .setTitle("Shortcut options:")
                    .setCancelable(true)
                    .setItems(R.array.list_shortcut, new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            switch(which){
                                /*case 0:
                                    root.GoTo(board, tab);
                                    Log.i("Shorcut goto",board+", "+tab);
                                    break;*/
                                case 0://case 1:
                                    getDBase().deleteDB(ObjectDB.TABLE_ITEM,new TableItem().Init(TI.getId(),0,0,0,0));
                                    root.PAdapter.notifyDataSetChanged();
                                    Log.i("Shorcut dell",TI.getId()+"");
                                    break;
                            }
                        }
                    })
                    .setNegativeButton("Cancel", null)
                    .create().show();
        }
    };
    private ActivityMain root;
    public ObjectMenuFragment init(long ID, Object... stuff) {
        setID(ID);
        setDBase(AdapterDB.InitDB(getContext()));

        CL = new ItemRem();
        CL.setBoard((int)getID());

        for ( Object x: stuff) {
            if(x.getClass() == Integer.class)
                IMG = (int) x;
        }

        for ( Object x: stuff) {
            if(x.getClass() == ActivityMain.class)
                root = (ActivityMain) x;
        }
        setFLIST(new ArrayList<ObjectListFragment>());
        CL.setTab(FragmentMenuMain.BOARD_INDEX);
        getFLIST().add(new FragmentListMess().init( "Pinboard",ID,CL).addID(BOARD));
        CL.setTab(FragmentMenuMain.INIT_INDEX);
        getFLIST().add(new FragmentListInit().init( "Initiative",ID,CL).addID(INIT));
        CL.setTab(FragmentMenuMain.TIMER_INDEX);
        getFLIST().add(new FragmentListMess().init( "Timers",ID,CL).addID(TIMER));
        CL.setTab(FragmentMenuMain.LAN_INDEX);
        getFLIST().add(new FragmentListNet().init( "Linked",ID,CL).addID(LAN));
        return this;
    }

}
