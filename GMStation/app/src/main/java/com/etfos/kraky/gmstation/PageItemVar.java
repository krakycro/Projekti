package com.etfos.kraky.gmstation;

import android.content.Context;
import android.view.View;
import android.widget.EditText;
import android.widget.FrameLayout;


public class PageItemVar extends ObjectItem {

    public PageItemVar(Context ctx, ObjectListener LClick) {
        super(ctx, LClick);
        tag = "itemVar";
    }

    @Override
    public ObjectItem init() {
        init = true;
        setView(INFLATER.inflate( R.layout.fragment_item, null));
        View BodyView = INFLATER.inflate(R.layout.layout_item_body_var, null);
        View MenuView = INFLATER.inflate(R.layout.layout_item_menu, null);
        setBody((FrameLayout) getView().findViewById(R.id.item_body));
        setMenu((FrameLayout) getView().findViewById(R.id.item_menu));
        getBody().addView(BodyView);
        getMenu().addView(MenuView);
        InitMenu();

       /* getBody().setOnClickListener(new FrameLayout.OnClickListener() {
            @Override
            public void onClick(View v) {

               // Log.i("KRAKY: Click", "body");

            }
        });*/

        final EditText IV = (EditText) getBody().findViewById(R.id.item_uni_edit);

        if(getBundle() != null)
            IV.setText(getBundle());

        IV.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {

                if(!hasFocus){
                    //
                    // CHANGE BUNDLE
                    //
                    setBundle(IV.getText().toString());
                    getDBase().updateDB(ObjectDB.TABLE_RESS,new TableResource().Init(getID(),null,getBundle(),null));

                    ActivityMain.getROOT(null).GoTo();

                    //Log.i("DBitem upd id",getID()+"");
                }
            }
        });

        return this;
    }

    public PageItemVar setAll(String Text){
        setName(Text);
        return this;
    }

}
