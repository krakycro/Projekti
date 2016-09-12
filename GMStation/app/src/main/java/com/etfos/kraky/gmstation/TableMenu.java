package com.etfos.kraky.gmstation;


import android.content.ContentValues;
import android.database.Cursor;

public class TableMenu extends ObjectDB {

    static final String PREFIX ="menu";

    static final String NAME = PREFIX+"_name";
    static final String MENU = PREFIX+"_menu";

    private String name;
    private long menu;

    public TableMenu(){
        super();

        TABLE = "table_"+PREFIX;
        ITEM_ID = PREFIX+"_id";
        CREATE_TABLE = "CREATE TABLE "+TABLE+"("
                +ITEM_ID+" INTEGER PRIMARY KEY"
                +", "+NAME+" VARCHAR(255)"
                +", "+MENU+" INTEGER"
                +");";

    }


    public TableMenu Init(Cursor C) {
        setId(C.getLong(0));
        this.name = C.getString(1);
        this.menu = C.getLong(2);
        return this;
    }

    public TableMenu Init(long id, String name, long menu) {
        setId(id);
        this.name = name;
        this.menu = menu;
        return this;
    }

    @Override
    public ContentValues update() {
        ContentValues tcv = new ContentValues();
        if(name != null)tcv.put(NAME,name);
        if(menu > ObjectDB.NULL)tcv.put(MENU,menu);
        return tcv;
    }

    @Override
    public ContentValues add() {
        ContentValues tcv = new ContentValues();
        if(name != null)tcv.put(NAME,name);
        if(menu > ObjectDB.NULL)tcv.put(MENU,menu);
        return tcv;
    }

    public long getMenu() {
        return menu;
    }

    public String getName() {
        return name;
    }
}
