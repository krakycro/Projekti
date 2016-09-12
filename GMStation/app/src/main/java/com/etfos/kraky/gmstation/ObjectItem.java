package com.etfos.kraky.gmstation;


import android.content.Context;
import android.content.res.AssetManager;
import android.graphics.drawable.Drawable;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.AlertDialog;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.GridLayout;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.io.IOException;
import java.io.InputStream;

public abstract class ObjectItem {

    public final static int NOTE = 0;
    public final static int TEXT = 1;
    public final static int VAR = 2;

    private View view;
    private Context ctx;
    public boolean init = false;
    public String tag;
    private FrameLayout Body;
    private FrameLayout Menu;
    private long ID = -1;
    private long position = -1;
    private String name = "ITEM";
    private String bundle;
    private String picture;
    private long parent;
    private TextView Text;
    private long type = 0;
    public  LayoutInflater INFLATER;
    private AdapterDB DBase;

    private ObjectListener LClick;

    public ObjectItem(Context ctx, ObjectListener LClick){
        this.DBase = AdapterDB.InitDB(ctx);
        this.ctx = ctx;
        this.LClick = LClick.coppy();

        INFLATER = ActivityMain.getROOT(null).INFLATER; //(LayoutInflater) getCtx().getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    public void InitMenu(){

        load();

        View.OnTouchListener TListener = new FrameLayout.OnTouchListener() {
            private int dist = 5;
            private float x1,x2;

            @Override
            public boolean onTouch(View v, MotionEvent event) {

                int action = event.getAction();
                if(action == MotionEvent.ACTION_DOWN)
                    x1 = event.getX();
                if(action == MotionEvent.ACTION_UP){
                    x2 = event.getX();

                    if ( x1 - x2 > dist){
                        DrawerLayout DL = (DrawerLayout) getView().findViewById(R.id.item_drawer_layout);
                        new Thread(new Runnable() {
                            //FrameLayout FL = (FrameLayout) getView().findViewById(R.id.item_menu_casing);
                            @Override
                            public void run() {
                                //FL.animate().translationX(-FL.getWidth());
                                Log.i("KRAKY: swipe","item");
                            }
                        }).run();
                        DL.openDrawer(Gravity.RIGHT);

                        v.cancelLongPress();
                        return true;
                    }
                }
                return false;
            }
        };

        final ImageButton IB = (ImageButton) getBody().findViewById(R.id.item_uni_img);
        if(getPicture() != null){
            IB.setImageDrawable(getAssetDraw(getPicture()));
        }
        IB.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                final View view2 = INFLATER.inflate(R.layout.alert_item_image, null);
                final GridLayout GV = (GridLayout) view2.findViewById(R.id.alert_grid);

                AlertDialog.Builder AB =  new AlertDialog.Builder(getCtx())
                        .setTitle("Change icon:")
                        .setView(view2)
                        .setNegativeButton("Back", null);

                final AlertDialog A = AB.create();

                AssetManager AM = getCtx().getAssets();
                String[] S = null;
                try {
                    S = AM.list("icons");
                    for ( final String x : S){
                        LinearLayout LL = (LinearLayout) INFLATER.inflate(R.layout.alert_button_img2, null);
                        ImageButton TB = (ImageButton) LL.findViewById(R.id.item_uni_img);
                        TB.setImageDrawable(getAssetDraw(x));
                        TB.setOnClickListener(new View.OnClickListener() {
                            String X = x;
                            @Override
                            public void onClick(View v) {
                                //
                                // DB CHANGE PIC
                                //

                                setPicture(X);
                                IB.setImageDrawable(getAssetDraw(X));
                                getDBase().updateDB(ObjectDB.TABLE_RESS,new TableResource().Init(getID(),null,null,getPicture()));

                                A.dismiss();
                            }
                        });

                        GV.addView(LL);
                        A.show();
                    }
                } catch (IOException e) {
                    e.printStackTrace();
                }

            }
        });

        Body.setOnTouchListener(TListener);

        Text = (TextView) getBody().findViewById(R.id.item_uni_text);
        Text.setText(this.name);
    }


    public Drawable getAssetDraw(String strName)
    {
        AssetManager AM = ActivityMain.getROOT(null).AM;
        InputStream istr = null;
        try {
            istr = AM.open("icons/"+strName);
        } catch (IOException e) {
            e.printStackTrace();
        }
        Drawable d = Drawable.createFromStream(istr, null);
        return d;
    }

    public void load(){
        LClick.TI.setType(getType());
        LClick.TI.setRess(getID());
        LClick.TI.setPoss(getPosition());
        LClick.TI.setId(getParent());
        LClick.setCtx(getCtx());

        Log.i("CL bo-ta-TI",LClick.board+"-tab:"+LClick.tab+"-id:"+LClick.TI.getId()+"-men:"+LClick.TI.getMenu()+"-ress:"+LClick.TI.getRess()+"-pos:"+LClick.TI.getPoss());
        getBody().setOnLongClickListener(new View.OnLongClickListener() {
            ObjectListener TT = LClick;
            @Override
            public boolean onLongClick(View v) {

                if(v.isPressed()){
                    Log.i("LC id-ress-tp",TT.TI.getId()+"-"+TT.TI.getRess()+"-"+TT.TI.getType());
                    TT.init();
                }
                return true;
            }
        });
    }

    public long getPosition() {
        return position;
    }

    public void setPosition(long position) {
        this.position = position;
    }

    public ObjectListener getLClick() {
        return LClick;
    }

    public long getParent() {
        return parent;
    }

    public void setParent(long parent) {
        this.parent = parent;
    }

    public long getType() {
        return type;
    }

    public void setType(long type) {
        this.type = type;
    }

    public AdapterDB getDBase() {
        return DBase;
    }

    public abstract ObjectItem init();

    public View getView(){
        return view;
    }

    public void setView(View view){
        this.view = view;
    }

    public Context getCtx() {
        return ctx;
    }

    public FrameLayout getBody() {
        return Body;
    }

    public void setBody(FrameLayout body) {
        Body = body;
    }

    public long getID() {
        return ID;
    }

    public void setID(long ID) {
        this.ID = ID;
    }

    public String getBundle() {
        return bundle;
    }

    public void setBundle(String bundle) {
        this.bundle = bundle;
    }

    public FrameLayout getMenu() {
        return Menu;
    }

    public void setMenu(FrameLayout menu) {
        Menu = menu;
    }

    public String getPicture() {
        return picture;
    }

    public void setPicture(String picture) {
        this.picture = picture;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public void reName(String name) {

        //
        // CHANGE NAME
        //
        this.Text.setText(name);
        this.name = name;
        getDBase().updateDB(ObjectDB.TABLE_RESS,new TableResource().Init(getID(), getName(),null,null));
    }
}
