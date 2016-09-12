package com.etfos.kraky.gmstation;

import android.content.Context;
import android.content.DialogInterface;
import android.content.res.AssetManager;
import android.content.res.Configuration;
import android.os.Bundle;
import android.support.design.widget.TabLayout;
import android.support.v4.view.ViewPager;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.text.InputType;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.ListView;

import java.util.ArrayList;

public class ActivityMain extends AppCompatActivity {

    public final static int BOARD = 0;
    public final static int PLAYERS = 1;
    public final static int MONSTERS = 2;
    public final static int CONNECT = 3;

    private static ActivityMain aInst = null;
    private static boolean refreshing = false;
    private DrawerLayout DLayout;
    private ArrayList<ObjectMenuFragment> LIST;
    private AdapterMenu AMenu;
    private ListView MList;
    private ActionBarDrawerToggle DToggle;

    public AssetManager AM;
    public AdapterDB DBase;

    private TabLayout TLayout;
    public AdapterPage PAdapter;
    private ViewPager VPager;

    private boolean search = false;
    private int menuStyle = 0;
    private long IDnext = 10;
    private  CharSequence MainTitle;

    private static ObjectMenuFragment Selected;
    public LayoutInflater INFLATER;

    //private  Handler H = new Handler();


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        getROOT(this);

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
        getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_PAN);
        InitDrawer();
        Init();

    }


    public static synchronized ActivityMain getROOT(ActivityMain A){
        if(null == aInst)
        {
            aInst = A;
        }
        return  aInst;
    }

    private void Init(){
        AM = getBaseContext().getAssets();
        DBase = AdapterDB.InitDB(this);
        Log.i("INIT","start");
        LIST = new ArrayList<ObjectMenuFragment>();
        LIST.add(new FragmentMenuMain().setName("Board").init( BOARD, this, android.R.drawable.ic_menu_myplaces));
        LIST.add(new FragmentMenuFlex().setName("Players").init( PLAYERS,  android.R.drawable.ic_menu_my_calendar));
        LIST.add(new FragmentMenuFlex().setName("Monsters").init( MONSTERS, android.R.drawable.ic_menu_mylocation));
        LIST.add(new FragmentMenuNet().setName("Connect").init( CONNECT, android.R.drawable.ic_menu_compass));
        Log.i("INIT","finish");
        VPager = (ViewPager) findViewById(R.id.pager);
        TLayout = (TabLayout) findViewById(R.id.tab);

        INFLATER = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View Search = INFLATER.inflate(R.layout.layout_searchbox, null);
        FrameLayout FL = (FrameLayout) findViewById(R.id.main_searchbox);
        FL.addView(Search);

        InitCategory();
        InitMenu();
        InitBoard(0);
    }

    private void InitCategory(){

        Selected = LIST.get(0);
        MainTitle = Selected.getName();
        setTitle(MainTitle);
    }

    private void InitMenu(){
        AMenu = new AdapterMenu(ActivityMain.this, LIST);
        MList = (ListView) findViewById(R.id.main_menu);
        MList.setAdapter(AMenu);
        MList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                GoTo(position,0);
            }
        });

    }

    public void GoTo(int position, int item){
        MList.setSelection(position);
        AMenu.notifyDataSetChanged();
        Log.i("goto MENU",position+"");
        Selected = LIST.get(position);
        MainTitle = Selected.getName();
        if(LIST.get(position).getClass() == FragmentMenuMain.class)
            menuStyle = 0;
        else if(LIST.get(position).getClass() == FragmentMenuNet.class)
            menuStyle = 2;
        else menuStyle = 1;
        findViewById(R.id.main_fragment).animate().translationY(0);
        search = false;
        DLayout.closeDrawer(Gravity.LEFT);

        InitBoard(item);
        getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_PAN);

        AMenu.notifyDataSetChanged();

    }

    public void GoTo(){
        if(!refreshing){
            refreshing = true;
            GoTo((int)Selected.getID(), VPager.getCurrentItem());
        }
    }

    private void InitBoard(int item){

        PAdapter = new AdapterPage(getSupportFragmentManager(), getBaseContext() ,Selected.getFLIST());
        VPager.setAdapter(PAdapter);
        TLayout.setupWithViewPager(VPager);
        VPager.setCurrentItem(item);
        refreshing = false;
    }

    private void InitDrawer(){
        DLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        DToggle = new ActionBarDrawerToggle(this, DLayout,
                R.string.navigation_drawer_open, R.string.navigation_drawer_close) {


            public void onDrawerClosed(View view) {
                super.onDrawerClosed(view);
                setTitle(MainTitle);
                invalidateOptionsMenu();
            }


            public void onDrawerOpened(View drawerView) {
                super.onDrawerOpened(drawerView);
                setTitle("Menu");
                invalidateOptionsMenu();
            }
        };

        DLayout.addDrawerListener(DToggle);
    }


    @Override
    protected void onPostCreate(Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);
        DToggle.syncState();
    }

    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
        DToggle.onConfigurationChanged(newConfig);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu,menu);

        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();
        if (DToggle.onOptionsItemSelected(item)) {
            return true;
        }
        final EditText input = new EditText(this);
        switch (id){
            case R.id.menu_search:
                LinearLayout FL = (LinearLayout) findViewById(R.id.main_fragment);
                if((search = !search))
                    if(menuStyle == 0)
                        FL.animate().translationY(findViewById(R.id.search_text).getHeight()*1.4f);
                    else
                        FL.animate().translationY(findViewById(R.id.main_searchbox).getHeight());
                else
                    FL.animate().translationY(0);
                break;
            case R.id.menu_sort:
                if(TLayout.getSelectedTabPosition() == FragmentMenuMain.INIT_INDEX)
                    LIST.get(BOARD).getFLIST().get(FragmentMenuMain.INIT_INDEX).getAdapter().sorter(0);
                if(TLayout.getSelectedTabPosition() == FragmentMenuMain.TIMER_INDEX)
                    LIST.get(BOARD).getFLIST().get(FragmentMenuMain.TIMER_INDEX).getAdapter().sorter(1);
                GoTo();
                break;
            case R.id.menu_cyrcle:
                int max = -1;
                TableItem TI0 = new TableItem(), TI;
                TI = (TableItem) DBase.StartCursorLoadDB(ObjectDB.TABLE_ITEM,TableItem.POSS+" DESC",null, TableItem.MENU+"="+FragmentMenuMain.INIT);
                if(TI == null) TI0 = null;
                else max = (int) TI.getPoss();
                while(TI != null){
                    TI0.clone(TI);
                    //Log.i("pstDB cycle init id-ps1",TI.getId()+"-"+TI.getPoss());
                    TI.setPoss(TI.getPoss()-1);

                    DBase.updateDB(ObjectDB.TABLE_ITEM, new TableItem().Init(TI.getId(),TI.getMenu(),TI.getRess(),TI.getType(),TI.getPoss()));
                    //Log.i("pstDB cycle init id-ps2",TI.getId()+"-"+TI.getPoss());
                    TI = (TableItem) DBase.CursorGetRowDB(ObjectDB.TABLE_ITEM);
                }
                if(TI0 != null){
                    DBase.updateDB(ObjectDB.TABLE_ITEM, new TableItem().Init(TI0.getId(),TI0.getMenu(),TI0.getRess(),TI0.getType(),max));
                }
                DBase.CursorCloseDB(ObjectDB.TABLE_ITEM);

                // --------------------------------

                TI = (TableItem) DBase.StartCursorLoadDB(ObjectDB.TABLE_ITEM,null,null, TableItem.MENU+"="+FragmentMenuMain.TIMER);
                while(TI != null){

                    TableResource TR = new TableResource();
                    TR = (TableResource) DBase.getDB(ObjectDB.TABLE_RESS,new AdapterDB.ArrayCursor(),null, null, TR.ITEM_ID+"="+TI.getRess() );
                    int nmb = Integer.parseInt(TR.getBody())-1;
                    if(nmb < 0) nmb = 0;
                    TR.setBody(nmb+"");
                    DBase.updateDB(ObjectDB.TABLE_RESS, new TableResource().Init(TR.getId(),TR.getName(),TR.getBody(),TR.getIcon()));
                    Log.i("pstDB cycl timer id-id",TR.getId()+"-"+TI.getRess()+","+TR.getBody());
                    TI = (TableItem) DBase.CursorGetRowDB(ObjectDB.TABLE_ITEM);
                }
                DBase.CursorCloseDB(ObjectDB.TABLE_ITEM);

                GoTo();
                break;
            case R.id.menu_init:
                input.setInputType(InputType.TYPE_CLASS_NUMBER|InputType.TYPE_NUMBER_FLAG_DECIMAL|InputType.TYPE_NUMBER_FLAG_SIGNED);
                input.setPadding(20,5,20,5);
                input.setHint("0");
                input.setGravity(Gravity.CENTER);
                new AlertDialog.Builder(this)
                        .setTitle("Put to initiative?")
                        .setView(input)
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                //
                                // ADD TO INIT
                                //
                                long OI = -1, TR = -1;
                                //TableResource TR = new TableResource();
                                OI = DBase.addDB(ObjectDB.TABLE_RESS, new TableResource().Init(0, Selected.getFLIST().get(TLayout.getSelectedTabPosition()).getName(),input.getEditableText().toString(),null));
                                TR = DBase.addDB(ObjectDB.TABLE_ITEM, new TableItem().Init(0, FragmentMenuMain.INIT,OI,ObjectItem.VAR, LIST.get(BOARD).getFLIST().get(FragmentMenuMain.INIT_INDEX).getLIST().size()));
                                DBase.updateDB(ObjectDB.TABLE_ITEM,new TableItem().Init(TR, ObjectDB.NULL,ObjectDB.NULL,ObjectDB.NULL,TR));
                                Log.i("pstDB add inita id-ress",TR+"-"+OI);
                            }
                        })
                        .setNegativeButton("No", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                            }
                        }).create().show();
                break;
            case R.id.menu_group_rename:
                input.setText(Selected.getFLIST().get(TLayout.getSelectedTabPosition()).getName());
                new AlertDialog.Builder(this)
                        .setTitle("Renaming "+Selected.getFLIST().get(TLayout.getSelectedTabPosition()).getName()+":")
                        .setView(input)
                        .setPositiveButton("Rename", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                //
                                // RENAME TAB
                                //
                                ObjectListFragment FLM =  Selected.getFLIST().get(TLayout.getSelectedTabPosition());
                                FLM.reName(input.getEditableText().toString());
                                DBase.updateDB(ObjectDB.TABLE_MENU,new TableMenu().Init(FLM.getID(),FLM.getName(),ObjectDB.NULL));
                                PAdapter.notifyDataSetChanged();
                                Log.i("pstDB upd id",FLM.getID()+"");
                            }
                        })
                        .setNegativeButton("Back", null)
                        .create().show();
                break;
            case R.id.menu_group_add:
                VPager.setCurrentItem(Selected.getFLIST().size()-1);
                new AlertDialog.Builder(this)
                        .setTitle("Adding Tab:")
                        .setView(input)
                        .setPositiveButton("Add", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                //
                                // ADD TAB
                                //
                                ObjectListFragment FLM =   new FragmentListMess().init( input.getEditableText().toString(),Selected.getID(),Selected.CL);
                                FLM.setID(DBase.addDB(ObjectDB.TABLE_MENU,new TableMenu().Init(0,FLM.getName(),FLM.getParent())));
                                Selected.getFLIST().add(FLM);
                                PAdapter.notifyDataSetChanged();
                                VPager.setCurrentItem(TLayout.getTabCount());
                                Log.i("pstDB add tab id-par",FLM.getID()+"-"+FLM.getParent());
                            }
                        })
                        .setNegativeButton("Back", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                            }
                        }).create().show();
                break;
            case R.id.menu_group_del:
                if(Selected.getFLIST().size() == 0) break;

                new AlertDialog.Builder(this)
                        .setTitle("Remove  "+Selected.getFLIST().get(VPager.getCurrentItem()).getName()+"?")
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                //
                                // REMOVE TAB
                                //
                                ObjectListFragment FLM =  Selected.getFLIST().get(VPager.getCurrentItem());
                                DBase.deleteDB(ObjectDB.TABLE_MENU,new TableMenu().Init(FLM.getID(),null,0));
                                Selected.getFLIST().remove(FLM);
                                if(Selected.getFLIST().size() == 0){
                                    FLM =  new FragmentListMess().init( "New",Selected.getID(),Selected.CL);
                                    FLM.setID(DBase.addDB(ObjectDB.TABLE_MENU,new TableMenu().Init(0, FLM.getName(),FLM.getParent())));
                                    Selected.getFLIST().add(FLM);
                                    Log.i("pstDB del tab id",FLM.getID()+"");
                                }
                                PAdapter.notifyDataSetChanged();

                            }
                        })
                        .setNegativeButton("No", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                            }
                        }).create().show();
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public boolean onPrepareOptionsMenu(Menu menu) {
        boolean drawerOpen = DLayout.isDrawerOpen(Gravity.LEFT);
        menu.findItem(R.id.menu_search).setVisible(false);
        menu.findItem(R.id.menu_add).setVisible(!drawerOpen);
        menu.findItem(R.id.menu_cyrcle).setVisible(!drawerOpen);
        menu.findItem(R.id.menu_init).setVisible(!drawerOpen);
        menu.findItem(R.id.menu_ping).setVisible(!drawerOpen);
        menu.findItem(R.id.menu_sort).setVisible(!drawerOpen);
        switch (menuStyle){
            case 0:
                menu.findItem(R.id.menu_add).setVisible(false);
                menu.findItem(R.id.menu_init).setVisible(false);
                menu.findItem(R.id.menu_ping).setVisible(false);
                break;
            case 1:
                menu.findItem(R.id.menu_cyrcle).setVisible(false);
                menu.findItem(R.id.menu_ping).setVisible(false);
                menu.findItem(R.id.menu_sort).setVisible(false);
                break;
            case 2:
               /* menu.findItem(R.id.menu_search).setVisible(false);*/
                menu.findItem(R.id.menu_init).setVisible(false);
                menu.findItem(R.id.menu_add).setVisible(false);
                menu.findItem(R.id.menu_cyrcle).setVisible(false);
                menu.findItem(R.id.menu_sort).setVisible(false);
                break;
        }
        return super.onPrepareOptionsMenu(menu);
    }



    public long insertIDnext() {
        return (IDnext++);
    }

    public AdapterDB getDBase() {
        return DBase;
    }
}

