package com.etfos.kraky.gmstation;

import android.content.Context;
import android.content.DialogInterface;
import android.support.v7.app.AlertDialog;
import android.view.View;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.ImageButton;


public class PageItemText extends ObjectItem {



    public PageItemText(Context ctx, ObjectListener LClick){
        super(ctx, LClick);
        tag = "itemText";

    }

    @Override
    public ObjectItem init() {

        init = true;
        setView( INFLATER.inflate( R.layout.fragment_item, null));
        View BodyView = INFLATER.inflate(R.layout.layout_item_body_text, null);
        View MenuView = INFLATER.inflate(R.layout.layout_item_menu, null);
        setBody((FrameLayout) getView().findViewById(R.id.item_body));
        setMenu((FrameLayout) getView().findViewById(R.id.item_menu));
        getBody().addView(BodyView);
        getMenu().addView(MenuView);
        InitMenu();


        ImageButton IV = (ImageButton) getBody().findViewById(R.id.item_uni_edit);
        IV.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                final View view2 = INFLATER.inflate(R.layout.alert_item_textbox, null);
                final EditText ET = (EditText) view2.findViewById(R.id.alert_text);
                ET.setText(getBundle());

                new AlertDialog.Builder(getCtx())
                        .setTitle("Edit "+getName()+":")
                        .setView(view2)
                        .setPositiveButton("Change", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {

                                //
                                // CHANGE BUNDLE
                                //
                                setBundle(ET.getText().toString());
                                getDBase().updateDB(ObjectDB.TABLE_RESS,new TableResource().Init(getID(),null,getBundle(),null));
                               // Log.i("DBitem upd id",getID()+","+getName()+","+getBundle()+","+getPicture());
                            }
                        })
                        .setNegativeButton("Back", null)
                        .create().show();
                view2.requestFocus();
                ET.requestFocus();
            }
        });

        return this;
    }


    public PageItemText setAll(String Text){
        setName(Text);
        return this;
    }


}
