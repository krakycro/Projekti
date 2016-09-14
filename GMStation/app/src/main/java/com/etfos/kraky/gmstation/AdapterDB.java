package com.etfos.kraky.gmstation;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.os.Handler;

import java.util.ArrayList;


public class AdapterDB extends SQLiteOpenHelper {

    public static class ArrayCursor{
        private Cursor C;
        public void setC(Cursor c) {
            C = c;
        }

        public Cursor getC() {
            return C;
        }
    };


    private static AdapterDB mInst = null;
    private static Context ctx = null;
    private ArrayList<ArrayCursor> C;
    private ArrayList<ObjectDB> DB;
    private  Handler H = new Handler();

    private static final int DATABASE_VERSION = 31;
    static final String DATABASE_NAME = "GM_Station_DB";



    private AdapterDB(Context ctx){
        super(ctx, DATABASE_NAME, null, DATABASE_VERSION);
        this.DB = new ArrayList<>();
        DB.add(new TableMenu());
        DB.add(new TableItem());
        DB.add(new TableResource());
        C = new ArrayList<>();
        for(int i = 0; i < DB.size();i++){
            C.add(new ArrayCursor());
        }

    }

    public static synchronized AdapterDB InitDB(Context tctx){
        if(null == mInst)
        {
            tctx = tctx.getApplicationContext();
            mInst = new AdapterDB(tctx);
            ctx = tctx;
        }
        return  mInst;
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        for( ObjectDB AA : DB)
            db.execSQL(AA.CREATE_TABLE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        for( ObjectDB AA : DB){
            String DROP_TABLE = "DROP TABLE IF EXISTS "+AA.TABLE;
            db.execSQL(DROP_TABLE);
        }
        onCreate(db);
    }

    @Override
    public void onDowngrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        for( ObjectDB AA : DB){
            String DROP_TABLE = "DROP TABLE IF EXISTS "+AA.TABLE;
            db.execSQL(DROP_TABLE);
        }
        onCreate(db);
    }

    public ArrayList<ObjectDB> LoadDB (int index, String... flags) {
        String ORDER_BY = (flags.length>0)? flags[0]:null;
        String GROUP_BY = (flags.length>1)? flags[1]:null;
        String WHERE = (flags.length>2)? flags[2]:null;
        ArrayList<ObjectDB> tDL = new ArrayList<ObjectDB>();
        SQLiteDatabase tdb = getReadableDatabase();
        C.get(index).setC(tdb.query(DB.get(index).TABLE, null, WHERE, null, GROUP_BY, null, ORDER_BY));
        if (C.get(index).getC().moveToFirst()) {
            do {
                ObjectDB tmp = DB.get(index);
                try {
                    tmp.Init(C.get(index).getC());
                } catch (Exception e) {
                    e.printStackTrace();
                }
                tDL.add(tmp);
            } while (C.get(index).getC().moveToNext());
        }
        C.get(index).getC().close();
        return tDL;
    }

    public ObjectDB StartArrayCursorLoadDB(int index, ArrayCursor C, String... flags){
        String ORDER_BY = (flags.length>0)? flags[0]:null;
        String GROUP_BY = (flags.length>1)? flags[1]:null;
        String WHERE = (flags.length>2)? flags[2]:null;
        if(C.getC() == null || C.getC().isClosed()){
            SQLiteDatabase tdb = getReadableDatabase();
            C.setC(tdb.query(DB.get(index).TABLE, null, WHERE, null, GROUP_BY, null, ORDER_BY));
            if (C.getC().moveToFirst()) {
                ObjectDB tmp = DB.get(index);
                try {
                    tmp.Init(C.getC());
                } catch (Exception e) {
                    e.printStackTrace();
                }
                return tmp;
            }
        }
        return null;
    }

    public ObjectDB ArrayCursorGetRowDB(int index, ArrayCursor C) {
        if (C.getC().moveToNext()) {
            ObjectDB tmp = DB.get(index);
            try {
                tmp.Init(C.getC());
            } catch (Exception e) {
                e.printStackTrace();
            }
            return tmp;
        }
        else C.getC().close();
        return null;
    }

    public void ArrayCursorCloseDB(ArrayCursor C){ C.getC().close(); }

    public ObjectDB StartCursorLoadDB(int index, String... flags){
        String ORDER_BY = (flags.length>0)? flags[0]:null;
        String GROUP_BY = (flags.length>1)? flags[1]:null;
        String WHERE = (flags.length>2)? flags[2]:null;
        if(C.get(index).getC() == null || C.get(index).getC().isClosed()){
            SQLiteDatabase tdb = getReadableDatabase();
            C.get(index).setC(tdb.query(DB.get(index).TABLE, null, WHERE, null, GROUP_BY, null, ORDER_BY));
            if (C.get(index).getC().moveToFirst()) {
                ObjectDB tmp = DB.get(index);
                try {
                    tmp.Init(C.get(index).getC());
                } catch (Exception e) {
                    e.printStackTrace();
                }
                return tmp;
            }
        }
        return null;
    }

    public ObjectDB CursorGetRowDB(int index) {
        if (C.get(index).getC().moveToNext()) {
            ObjectDB tmp = DB.get(index);
            try {
                tmp.Init(C.get(index).getC());
            } catch (Exception e) {
                e.printStackTrace();
            }
            return tmp;
        }
        else C.get(index).getC().close();
        return null;
    }

    public void CursorCloseDB(int index){ C.get(index).getC().close(); }

    public ObjectDB getDB(final int index,  ArrayCursor CC,  String... flags){
        String ORDER_BY = (flags.length>0)? flags[0]:null;
        String GROUP_BY = (flags.length>1)? flags[1]:null;
        String WHERE = (flags.length>2)? flags[2]:null;
        SQLiteDatabase tdb = getReadableDatabase();
        CC.setC(tdb.query(DB.get(index).TABLE, null, WHERE, null, GROUP_BY, null, ORDER_BY));
            if (CC.getC().moveToFirst()) {
                ObjectDB tmp = DB.get(index);
                try {
                    tmp.Init(CC.getC());
                } catch (Exception e) {
                    e.printStackTrace();
                }
                return tmp;
            }
        return null;
    }

    public long addDB(final int index, final ObjectDB MT){
        if( mInst == null ) return -1;
        final SQLiteDatabase tdb = getWritableDatabase();
        final ContentValues tcv = new ContentValues();
        tcv.putAll( MT.add());
        long ii = tdb.insert(DB.get(index).TABLE, DB.get(index).ITEM_ID, tcv);
        //Log.i("DB add id", ii+"");
        return ii;
    }

    public boolean deleteDB(final int index, final ObjectDB DL){
        if(  mInst == null ) return false;
        double id = DL.getId();
        final String[] targ = new String[]{String.valueOf(id)};
        final SQLiteDatabase tdb = getWritableDatabase();
        new Thread(new Runnable() {
            @Override
            public void run() {
                //Log.i("DB del id-numb",DL.getId()+"-"+tdb.delete(DB.get(index).TABLE, DB.get(index).ITEM_ID + "=?", targ)+"");
            }
        }).start();
        return true;
    }
    public boolean deleteAllDB(final int index){
        if(  mInst == null ) return false;
        final SQLiteDatabase tdb = getWritableDatabase();
        new Thread(new Runnable() {
            @Override
            public void run() {
                tdb.delete(DB.get(index).TABLE, "1", null);
            }
        }).start();
        return true;
    }

    public boolean updateDB(final int index, final ObjectDB DL){
        if(  mInst == null ) return false;
        double id = DL.getId();
        final String[] targ = new String[]{String.valueOf(id)};
        final ContentValues tcv = new ContentValues();
        final SQLiteDatabase tdb = getWritableDatabase();

        new Thread(new Runnable() {
            @Override
            public void run() {
                tcv.putAll(DL.update());
                tdb.update(DB.get(index).TABLE, tcv, DB.get(index).ITEM_ID + "=?", targ);
                //Log.i("DB upd id-numb",DL.getId()+"");
            }
        }).start();
        return true;
    }

    public boolean updateWaitDB(final int index, final ObjectDB DL){
        if(  mInst == null ) return false;
        double id = DL.getId();
        final String[] targ = new String[]{String.valueOf(id)};
        final ContentValues tcv = new ContentValues();
        final SQLiteDatabase tdb = getWritableDatabase();

                tcv.putAll(DL.update());
                tdb.update(DB.get(index).TABLE, tcv, DB.get(index).ITEM_ID + "=?", targ);
               // Log.i("DB upd id-numb",DL.getId()+"-"+((TableItem)DL).getPoss());

        return true;
    }


    public ArrayList<ObjectDB> getDB() {
        return DB;
    }

    public static AdapterDB getmInst() {
        return mInst;
    }

}
