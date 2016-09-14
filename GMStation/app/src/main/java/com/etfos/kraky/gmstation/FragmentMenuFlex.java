package com.etfos.kraky.gmstation;


import android.content.Context;
import android.content.DialogInterface;
import android.support.v7.app.AlertDialog;

import java.util.ArrayList;


public class FragmentMenuFlex extends ObjectMenuFragment {

    public class ItemAdd extends ObjectListener{

        public ItemAdd(){
        }

        public  ItemAdd(Context ctx, TableItem TI, int board, int tab){
            super(TI);
            this.ctx = ctx;
            this.board = board;
            this.tab = tab;
        }

        public ItemAdd coppy(){
            return new ItemAdd(ctx, new TableItem().Init(TI.getId(), TI.getMenu(), TI.getRess(),TI.getType(),TI.getPoss()), board, tab);
        }

        @Override
        public void init() {
            new AlertDialog.Builder(ctx)
                    .setTitle("Make Shortcut:")
                    .setCancelable(true)
                    .setItems(R.array.list_board, new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            long pick=-1;
                            switch (which){
                                case 0: pick = FragmentMenuMain.BOARD;
                                    getDBase().addDB(ObjectDB.TABLE_ITEM,new TableItem().Init(0,pick,TI.getRess(),TI.getType(),TI.getPoss()));

                                    break;
                                case 1: pick = FragmentMenuMain.TIMER;

                                    TableResource TR = new TableResource();
                                    TR = (TableResource) getDBase().getDB(ObjectDB.TABLE_RESS,new AdapterDB.ArrayCursor(),null,null, TR.getITEM_ID()+"="+TI.getRess());
                                    TR.setId(getDBase().addDB(ObjectDB.TABLE_RESS,new TableResource().Init(0, TR.getName(),"0",TR.getIcon())));
                                    getDBase().addDB(ObjectDB.TABLE_ITEM,new TableItem().Init(0,pick,TR.getId(),ObjectItem.VAR,TI.getPoss()));

                                    break;
                            }

                            //Log.i("Shorcut add",TI.getId()+","+pick+","+TI.getRess()+","+TI.getType()+","+TI.getPoss());
                            //Toast.makeText(getActivity())

                        }
                    })
                    .setNegativeButton("Cancel", null)
                    .create().show();
        }
    };


    public ObjectMenuFragment init( final long ID, Object... stuff) {
        setID(ID);
        setDBase(AdapterDB.InitDB(getContext()));

        CL = new ItemAdd();
        CL.setBoard((int)getID());

        long item = -1;
        for ( Object x: stuff) {
            if(x.getClass() == Integer.class)
                IMG = (int) x;
        }
        //
        // INIT TABS FLEX
        //

        setFLIST(new ArrayList<ObjectListFragment>());
        //new Thread(new Runnable() {
        //    @Override
        //    public void run() {
        //Log.i("DB load menu", ID+"");
                TableMenu TM = (TableMenu) getDBase().StartCursorLoadDB(ObjectDB.TABLE_MENU,null,null,TableMenu.MENU+"="+ID);
                    while (TM != null) {
                        CL.setTab(getFLIST().size());
                        ObjectListFragment FLM = new FragmentListMess().init( TM.getName(), TM.getMenu(), CL);
                        FLM.setID(TM.getId());
                        //Log.i("DB load tab id-rot:CL",TM.getId()+"-"+ID+":"+FLM.getCL().board+"-"+FLM.getCL().tab+"-"+FLM.getCL().TI.getMenu());
                        getFLIST().add(FLM);
                        TM = (TableMenu) getDBase().CursorGetRowDB(ObjectDB.TABLE_MENU);
                    }
                getDBase().CursorCloseDB(ObjectDB.TABLE_MENU);
                if(getFLIST().size() == 0){
                    CL.setTab(0);
                    ObjectListFragment FLM = new FragmentListMess().init("New",ID,CL);
                    FLM.setID(getDBase().addDB(ObjectDB.TABLE_MENU,new TableMenu().Init(0, FLM.getName(), FLM.getParent())));
                   // Log.i("pstDB empty,ad id-rt:CL",FLM.getID()+"-"+ID+":"+FLM.getCL().board+"-"+FLM.getCL().tab+"-"+FLM.getCL().TI.getMenu());
                    getFLIST().add(FLM);
                }
                /*H.post(new Runnable() {
                    @Override
                    public void run() {
                        getPAdapter().notifyDataSetChanged();
                    }
                });*/
        //    }
        //}).start();

        return this;
    }


}
