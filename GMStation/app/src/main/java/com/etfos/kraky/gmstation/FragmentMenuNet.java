package com.etfos.kraky.gmstation;


import android.content.Context;

import java.util.ArrayList;

public class FragmentMenuNet extends ObjectMenuFragment {

    private ArrayList<AdapterBluetooth.BGroup> ALIST;

    public class ItemNet extends ObjectListener{

        public ItemNet(){}

        public  ItemNet(Context ctx, TableItem TI, int board, int tab){
            super(TI);
            this.ctx = ctx;
            this.board = board;
            this.tab = tab;
        }

        public ItemNet coppy(){
            return new ItemNet(ctx, new TableItem().Init(TI.getId(), TI.getMenu(), TI.getRess(),TI.getType(),TI.getPoss()), board, tab);
        }

        @Override
        public void init() {

        }
    };


    public FragmentMenuNet init( long ID, Object... stuff) {
        setID(ID);
        setDBase(AdapterDB.InitDB(getContext()));

        CL = new ItemNet();
        CL.setBoard((int)getID());

        for ( Object x: stuff) {
            if(x.getClass() == Integer.class)
                IMG = (int) x;
        }
        for ( Object x: stuff) {
            if(x.getClass() == ArrayList.class)
                ALIST = (ArrayList<AdapterBluetooth.BGroup>) x;
        }

        //
        // INIT TABS NET
        //

        setFLIST(new ArrayList<ObjectListFragment>());
        getFLIST().add(new FragmentListNet().init("BlueTooth",ID, CL).addID(0));

        return this;
    }

    public ArrayList<AdapterBluetooth.BGroup> getALIST() {
        return ALIST;
    }

    public void setALIST(ArrayList<AdapterBluetooth.BGroup> LIST) {
        this.ALIST = LIST;
    }
}
