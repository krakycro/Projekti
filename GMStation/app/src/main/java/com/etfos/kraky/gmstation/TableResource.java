package com.etfos.kraky.gmstation;


import android.content.ContentValues;
import android.database.Cursor;

public class TableResource extends ObjectDB {

    static final String PREFIX ="resource";

    static final String NAME = PREFIX+"_name";
    static final String BODY = PREFIX+"_body";
    static final String ICON = PREFIX+"_icon";

    private String name;
    private String body;
    private String icon;

    public TableResource(){
        super();

        TABLE = "table_"+PREFIX;
        ITEM_ID = PREFIX+"_id";
        CREATE_TABLE = "CREATE TABLE "+TABLE+"("
                +ITEM_ID+" INTEGER PRIMARY KEY"
                +", "+NAME+" VARCHAR(255)"
                +", "+BODY+" VARCHAR(512)"
                +", "+ICON+" VARCHAR(255)"
                +");";

    }

    public TableResource Init(Cursor C) {
        setId(C.getLong(0));
        this.name = C.getString(1);
        this.body = C.getString(2);
        this.icon = C.getString(3);
        return this;
    }

    public TableResource Init(long id, String name, String body, String icon) {
        setId(id);
        this.name = name;
        this.body = body;
        this.icon = icon;
        return this;
    }

    @Override
    public ContentValues update() {
        ContentValues tcv = new ContentValues();
        if(name != null) tcv.put(NAME,name);
        if(body != null) tcv.put(BODY,body);
        if(icon != null) tcv.put(ICON,icon);
        return tcv;
    }

    @Override
    public ContentValues add() {
        ContentValues tcv = new ContentValues();
        if(name != null) tcv.put(NAME,name);
        if(body != null) tcv.put(BODY,body);
        if(icon != null) tcv.put(ICON,icon);
        return tcv;
    }

    public String getName() {
        return name;
    }

    public String getBody() {
        return body;
    }

    public String getIcon() {
        return icon;
    }

    public String getITEM_ID(){
        return ITEM_ID;
    }

    public void setName(String name) {
        this.name = name;
    }

    public void setBody(String body) {
        this.body = body;
    }

    public void setIcon(String icon) {
        this.icon = icon;
    }
}
