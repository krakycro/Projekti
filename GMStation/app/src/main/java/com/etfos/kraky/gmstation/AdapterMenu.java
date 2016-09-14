package com.etfos.kraky.gmstation;

import android.content.Context;
import android.support.v4.app.FragmentManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;


public class AdapterMenu extends BaseAdapter {
    private ArrayList<ObjectMenuFragment> LIST;
    private Context ctx;
    private LayoutInflater inflater;
    private FragmentManager FM;

    public AdapterMenu( Context ctx, /*FragmentManager FM,*/ ArrayList<ObjectMenuFragment> LIST){
        //super(FM);
        this.ctx = ctx;
        this.LIST = LIST;
        this.FM = FM;
        this.inflater = LayoutInflater.from(ctx);
    }



    @Override
    public int getCount() {
            return this.LIST.size();
    }

    @Override
    public Object getItem(int position) {
            return this.LIST.get(position);
    }
    /*@Override
    public Fragment getItem(int position) {
        return LIST.get(position);
    }*/

    @Override
    public long getItemId(int position) {
        return position;
    }

    public View getView(int position, View convertView, ViewGroup parent) {

        ObjectMenuFragment curr = this.LIST.get(position);
        convertView =  inflater.inflate(R.layout.layout_menu_list, null );

       // try{
        ImageView IV = (ImageView) convertView.findViewById(R.id.menu_item_pic);
        IV.setImageResource(curr.IMG);
      //  }
        //catch(Exception e){}

        TextView TV = (TextView) convertView.findViewById(R.id.menu_item_text);
        TV.setText(curr.getName());

        return convertView;
    }
}
