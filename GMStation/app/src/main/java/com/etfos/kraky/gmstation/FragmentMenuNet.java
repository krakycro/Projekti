package com.etfos.kraky.gmstation;


import android.content.Context;
import android.os.Handler;

import java.util.ArrayList;


public class FragmentMenuNet extends ObjectMenuFragment {

    Handler H = new Handler();

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

    public ObjectMenuFragment init( long ID, Object... stuff) {
        setID(ID);
        setDBase(AdapterDB.InitDB(getContext()));

        CL = new ItemNet();
        CL.setBoard((int)getID());

        long item = -1;
        for ( Object x: stuff) {
            if(x.getClass() == Integer.class)
                IMG = (int) x;
        }

        //
        // INIT TABS NET
        //

        setFLIST(new ArrayList<ObjectListFragment>());
        getFLIST().add(new FragmentListInit().init("Bluethooth", ID, CL).addID(0));
        return this;
    }

}
