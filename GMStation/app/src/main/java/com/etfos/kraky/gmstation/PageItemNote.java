package com.etfos.kraky.gmstation;

import android.content.Context;
import android.view.View;
import android.widget.FrameLayout;


public class PageItemNote extends ObjectItem {

    public PageItemNote(Context ctx, ObjectListener LClick){
        super(ctx, LClick);
        tag = "itemNote";

    }

    @Override
    public ObjectItem init() {

        init = true;
        setView(INFLATER.inflate(  R.layout.fragment_item, null));
        View BodyView = INFLATER.inflate(R.layout.layout_item_body_note, null);
        View MenuView = INFLATER.inflate(R.layout.layout_item_menu, null);
        setBody((FrameLayout) getView().findViewById(R.id.item_body));
        setMenu((FrameLayout) getView().findViewById(R.id.item_menu));
        getBody().addView(BodyView);
        getMenu().addView(MenuView);
        InitMenu();


        /*getBody().setOnClickListener(new FrameLayout.OnClickListener() {
            @Override
            public void onClick(View v) {

                //Log.i("KRAKY: Click", "body");

            }
        });*/

        return this;
    }

    public PageItemNote setAll(String Text){
        setName(Text);
        return this;
    }


}
