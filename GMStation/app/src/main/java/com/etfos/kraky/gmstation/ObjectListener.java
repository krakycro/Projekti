package com.etfos.kraky.gmstation;


import android.content.Context;

public abstract class ObjectListener {

    public int board, tab;
    public Context ctx;
    public TableItem TI;

    public ObjectListener(){
        this.TI = new TableItem();
    }

    public ObjectListener(TableItem TI){
        this.TI = TI;
    }

    public void setTI(TableItem TI){ this.TI = TI;}

    public abstract ObjectListener coppy();

    public abstract void init();

    public void setBoard(int board) {
        this.board = board;
    }

    public void setTab(int tab) {
        this.tab = tab;
    }

    public void setCtx(Context ctx) {
        this.ctx = ctx;
    }
}
