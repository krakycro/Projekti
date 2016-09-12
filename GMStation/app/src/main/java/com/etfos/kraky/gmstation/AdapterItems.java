package com.etfos.kraky.gmstation;

import android.content.Context;
import android.os.Handler;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;


public class AdapterItems extends BaseAdapter implements AdapterView.OnItemSelectedListener {


    private Context ctx;

    private ArrayList<ObjectItem> LIST;
    private final Handler H = new Handler();


    public AdapterItems(Context ctx, ArrayList<ObjectItem> LIST) {
        this.ctx = ctx;
        this.LIST = LIST;
    }

    public void sorter(int flag){
        AdapterDB Dbase = AdapterDB.InitDB(ctx);

        if(LIST.size()> 1)
        for(int i = 0 ; i < LIST.size()-flag-1; i++){
            for(int j = i+1 ; j < LIST.size()-flag; j++){
                float a = Float.parseFloat(LIST.get(i).getBundle());
                float b = Float.parseFloat(LIST.get(j).getBundle());
                if(a < b){
                    long tmp = LIST.get(i).getPosition();
                    Dbase.updateWaitDB(TableItem.TABLE_ITEM, new TableItem().Init(LIST.get(i).getParent(), ObjectDB.NULL, ObjectDB.NULL, ObjectDB.NULL, LIST.get(j).getPosition()));
                    Dbase.updateWaitDB(TableItem.TABLE_ITEM, new TableItem().Init(LIST.get(j).getParent(), ObjectDB.NULL, ObjectDB.NULL, ObjectDB.NULL, tmp));
                    LIST.get(i).setPosition(LIST.get(j).getPosition());
                    LIST.get(j).setPosition(tmp);
                }
            }
        }

        Collections.sort(LIST,new Comparator<ObjectItem>() {

            @Override
            public int compare(ObjectItem lhs, ObjectItem rhs) {
                if(lhs.getBundle() != null && rhs.getBundle() != null){
                    float a = Float.parseFloat(lhs.getBundle());
                    float b = Float.parseFloat(rhs.getBundle());
                    if(a > b){
                        return -1;
                    }
                    else if(a < b) {
                        return 1;
                    }
                }
                return 0;
            }
        });

        this.notifyDataSetChanged();
    }

    @Override
    public void notifyDataSetChanged() {
        super.notifyDataSetChanged();
    }

    @Override
    public int getCount() {
        return this.LIST.size();
    }

    @Override
    public Object getItem(int position) {
        return this.LIST.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        ObjectItem currList = this.LIST.get(position);

        return currList.getView();
    }


    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id)
    {
        if (position == 1)
        {
            parent.setDescendantFocusability(ViewGroup.FOCUS_AFTER_DESCENDANTS);
            LIST.get(position).getBody().requestFocus();
        }
        else
        {
            if (!parent.isFocused())
            {
                parent.setDescendantFocusability(ViewGroup.FOCUS_BEFORE_DESCENDANTS);
                parent.requestFocus();
            }
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> parent)
    {
        parent.setDescendantFocusability(ViewGroup.FOCUS_BEFORE_DESCENDANTS);
    }
}

