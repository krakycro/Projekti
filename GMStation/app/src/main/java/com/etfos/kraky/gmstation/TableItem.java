package com.etfos.kraky.gmstation;


import android.content.ContentValues;
import android.database.Cursor;

public class TableItem extends ObjectDB {

    static final String PREFIX ="item";

    static final String MENU = PREFIX+"_menu";
    static final String RESOURCE = PREFIX+"_resource";
    static final String TYPE = PREFIX+"_type";
    static final String POSS = PREFIX+"_poss";

    private long menu;
    private long ress;
    private long type;
    private long poss;

    public TableItem(){
        super();

        TABLE = "table_"+PREFIX;
        ITEM_ID = PREFIX+"_id";
        CREATE_TABLE = "CREATE TABLE "+TABLE+"("
                +ITEM_ID+" INTEGER PRIMARY KEY"
                +", "+MENU+" INTEGER"
                +", "+RESOURCE+" INTEGER"
                +", "+TYPE+" INTEGER"
                +", "+POSS+" INTEGER"
                +");";

    }


    public TableItem Init(Cursor C) {
        setId(C.getLong(0));
        this.menu = C.getLong(1);
        this.ress = C.getLong(2);
        this.type = C.getLong(3);
        this.poss = C.getLong(4);
        return this;
    }

    public TableItem Init(long id, long menu, long ress, long type, long poss) {
        setId(id);
        this.menu = menu;
        this.ress = ress;
        this.type = type;
        this.poss = poss;
        return this;
    }

    public void clone(TableItem TI){
        setId(TI.getId());
        this.menu = TI.getMenu();
        this.ress = TI.getRess();
        this.type = TI.getType();
        this.poss = TI.getPoss();
    }

    @Override
    public ContentValues update() {
        ContentValues tcv = new ContentValues();
        if(menu > ObjectDB.NULL)tcv.put(MENU,menu);
        if(ress > ObjectDB.NULL)tcv.put(RESOURCE,ress);
        if(type > ObjectDB.NULL)tcv.put(TYPE,type);
        if(poss > ObjectDB.NULL)tcv.put(POSS,poss);
        return tcv;
    }


    @Override
    public ContentValues add() {
        ContentValues tcv = new ContentValues();
        if(menu > ObjectDB.NULL)tcv.put(MENU,menu);
        if(ress > ObjectDB.NULL)tcv.put(RESOURCE,ress);
        if(type > ObjectDB.NULL)tcv.put(TYPE,type);
        if(poss > ObjectDB.NULL)tcv.put(POSS,poss);
        return tcv;
    }

    public long getType() {
        return type;
    }

    public long getRess() {
        return ress;
    }

    public long getMenu() {
        return menu;
    }

    public void setMenu(long menu) {
        this.menu = menu;
    }

    public void setRess(long ress) {
        this.ress = ress;
    }

    public void setType(long type) {
        this.type = type;
    }


     public long getPoss() {
        return poss;
    }

    public void setPoss(long poss) {
        this.poss = poss;
    }
}
