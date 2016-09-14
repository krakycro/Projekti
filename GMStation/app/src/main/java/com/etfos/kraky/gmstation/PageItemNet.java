package com.etfos.kraky.gmstation;

import android.content.Context;
import android.view.View;
import android.widget.FrameLayout;


public class PageItemNet extends ObjectItem {


    public PageItemNet(Context ctx, ObjectListener LClick){
        super(ctx, LClick);
        tag = "itemNew";
        init = true;

    }

    @Override
    public ObjectItem init() {
        setView(INFLATER.inflate( R.layout.fragment_item, null));
        View BodyView = INFLATER.inflate(R.layout.layout_item_body_net, null);
        setBody((FrameLayout) getView().findViewById(R.id.item_body));
        getBody().addView(BodyView);

        getBody().setOnClickListener(new FrameLayout.OnClickListener() {
            @Override
            public void onClick(View v) {

                // Log.i("KRAKY: Click", "body");

            }
        });

        return this;
    }

}
