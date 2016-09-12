package com.etfos.kraky.gmstation;


import android.content.ContentValues;
import android.database.Cursor;

public abstract class ObjectDB {

    final static int TABLE_MENU = 0;
    final static int TABLE_ITEM = 1;
    final static int TABLE_RESS = 2;
    final static int NULL = -1000;

    private long id;

    public String ITEM_ID;
    public String CREATE_TABLE;
    public String TABLE;

    public ObjectDB(){
    }

    public abstract ObjectDB Init(Cursor C);

    public abstract ContentValues update() ;

    public long getId() {
       return id;
    }

    public void setId(long id) {
        this.id = id;
       // return this;
    }


    public abstract ContentValues add();

}
