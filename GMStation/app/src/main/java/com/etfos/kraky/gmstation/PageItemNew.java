package com.etfos.kraky.gmstation;

import android.content.Context;


public class PageItemNew extends ObjectItem {


    public PageItemNew( Context ctx, ObjectListener LClick){
        super(ctx, LClick);
        tag = "itemNew";
        init = true;

    }

    @Override
    public ObjectItem init() {
        setView(INFLATER.inflate(  R.layout.layout_item_body_new, null));
        return this;
    }

}
