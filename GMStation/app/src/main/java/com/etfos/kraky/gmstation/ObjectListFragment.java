package com.etfos.kraky.gmstation;

import android.content.DialogInterface;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.app.AlertDialog;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;

import java.util.ArrayList;

public class ObjectListFragment extends Fragment {

    final static String NAME = "Item";

    private String name="Item";
    private long ID = -2;
    private long parent = -3;
    //private long position = -1;
    private Handler H = new Handler();
    private ListView List;
    private ArrayList<ObjectItem> LIST;
    private ArrayList<ObjectItem> SEARCH;
    private AdapterItems Adapter;
    private ObjectListener CL;
    private AdapterDB DBase;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_page,null);
        return view;
    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setRetainInstance(true);
    }

    @Override
    public void onStart() {
        super.onStart();

        LIST = new ArrayList<>();
        SEARCH = new ArrayList<>();
        setAdapter(new AdapterItems(getContext(),LIST,SEARCH));

        setList((ListView) getView().findViewById(R.id.list));
        getList().setAdapter(getAdapter());
    }

    public ObjectListFragment init(String name, long parent, ObjectListener CL) {
        this.DBase = AdapterDB.InitDB(getContext());
        this.name = name;
        this.parent = parent;
        this.CL = CL.coppy();
        return this;
    }


    public void initNewFlex(){

       //if(LIST.size() > 0)
       //     counter = LIST.get(LIST.size()-1).getID();
        //Log.i("restore","newFlex "+DBase+"-"+CL);
        final PageItemNew IN = (PageItemNew) new PageItemNew(getContext(), CL).init();
        IN.getView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                new AlertDialog.Builder(getActivity())
                        .setTitle("Adding item:")
                        .setItems(R.array.list_items, new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                addItem(which,null);
                            }
                        })
                        .setNegativeButton("Back", null)
                        .create().show();

            }
        });
        LIST.add(IN);
        Adapter.notifySearchDataSetChanged(ActivityMain.getROOT(null).SEARCH);
    }

    public void initNewConst(){

        //if(LIST.size() > 0)
        //     counter = LIST.get(LIST.size()-1).getID();
        //Log.i("restore","newFlex "+DBase+"-"+CL);
        final PageItemNew IN = (PageItemNew) new PageItemNew(getContext(), CL ).init();
        IN.getView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                addItem(ObjectItem.VAR,null);
            }
        });
        LIST.add(IN);
        Adapter.notifySearchDataSetChanged(ActivityMain.getROOT(null).SEARCH);
    }


    public void addItem(int which, TableItem TI){
        int num=1;
        ObjectItem OI = null;
        switch(which){
            case 0:
                OI = new PageItemNote(getContext(),CL).setAll(NAME);
                break;
            case 1:
                OI = new PageItemText(getContext(),CL).setAll(NAME);
                break;
            case 2:
                OI = new PageItemVar(getContext(),CL).setAll(NAME);
                break;
        }
        OI.setType(which);
        OI.setBundle("");
        OI.setPosition(LIST.size());
        //
        // ADD LIST
        //
        if(TI == null){
            TableResource TR = new TableResource();
            OI.setID(DBase.addDB(ObjectDB.TABLE_RESS, TR.Init(0, OI.getName(),OI.getBundle(),OI.getPicture())));
            TR.setId(DBase.addDB(ObjectDB.TABLE_ITEM, new TableItem().Init(0, getID(),OI.getID(),OI.getType(), OI.getPosition())));
            OI.setParent(TR.getId());

            //Log.i("DB add item id-re-pa-nm",OI.getID()+"-"+TR.getId()+"-"+getID()+"-"+LIST.size());
        }
        else{
            num =0;
            TableResource TR = new TableResource();
            TR = (TableResource) getDBase().getDB(ObjectDB.TABLE_RESS, new AdapterDB.ArrayCursor(), null,null,TR.getITEM_ID()+"="+TI.getRess());
            OI.setParent(TI.getId());
            OI.setID(TR.getId());
            OI.setName(TR.getName());
            OI.setBundle(TR.getBody());
            OI.setPicture(TR.getIcon());
            OI.setPosition(TI.getPoss());
            //Log.i("DB load item info",TR.getITEM_ID()+"="+TI.getRess()+"  "+OI.getType()+","+OI.getName()+","+OI.getBundle()+","+OI.getPicture()+","+OI.getPosition());
        }

        OI.init();

        final ObjectItem AOI = OI;
        ImageButton IVE = (ImageButton) OI.getView().findViewById(R.id.item_menu_edit);
        IVE.setOnClickListener(new View.OnClickListener() {
            ObjectItem ID = AOI;
            @Override
            public void onClick(View v) {
                final EditText ET2 = new EditText(getContext());
                ET2.setText(ID.getName());
                new AlertDialog.Builder(getActivity())
                        .setTitle("Edit "+ID.getName()+":")
                        .setView(ET2)
                        .setPositiveButton("Change", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                ID.reName(ET2.getText().toString());
                                Adapter.notifyDataSetChanged();
                            }
                        })
                        .setNegativeButton("Back", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                            }
                        }).create().show();

            }
        });

        ImageButton IVDe = (ImageButton) OI.getView().findViewById(R.id.item_menu_delete);
        IVDe.setOnClickListener(new View.OnClickListener() {
            ObjectItem ID = AOI;
            @Override
            public void onClick(View v) {

                new AlertDialog.Builder(getActivity())
                        .setTitle("Delete "+ID.getName()+"?")
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                //
                                // REMOVE LIST
                                //
                                TableResource TR = new TableResource();
                                DBase.deleteDB(ObjectDB.TABLE_ITEM, new TableItem().Init(ID.getParent(), 0,0,0,0));
                                //Log.i("DB del item parent",ID.getParent()+"");
                                if(DBase.StartCursorLoadDB(ObjectDB.TABLE_ITEM) == null){
                                    DBase.deleteDB(ObjectDB.TABLE_RESS, TR.Init(ID.getID(), null,null,null));
                                    //Log.i("DB del item id",ID.getID()+"");
                                }
                                DBase.CursorCloseDB(ObjectDB.TABLE_ITEM);

                                LIST.remove(ID);
                                RefreshList();//Adapter.notifyDataSetChanged();
                            }
                        })
                        .setNegativeButton("No", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                            }
                        }).create().show();

            }
        });

        ImageButton IVU = (ImageButton) OI.getView().findViewById(R.id.item_menu_up);
        if(IVU != null)
        IVU.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if(LIST.indexOf(AOI)>0){

                    int i = LIST.indexOf(AOI);
                    int j = i-1;

                    long tmp = LIST.get(i).getPosition();
                    getDBase().updateWaitDB(TableItem.TABLE_ITEM, new TableItem().Init(LIST.get(i).getParent(), ObjectDB.NULL, ObjectDB.NULL, ObjectDB.NULL, LIST.get(j).getPosition()));
                    getDBase().updateWaitDB(TableItem.TABLE_ITEM, new TableItem().Init(LIST.get(j).getParent(), ObjectDB.NULL, ObjectDB.NULL, ObjectDB.NULL, tmp));
                    LIST.get(i).setPosition(LIST.get(j).getPosition());
                    LIST.get(j).setPosition(tmp);

                    LIST.set(LIST.indexOf(AOI),LIST.set(LIST.indexOf(AOI)-1,AOI));
                    RefreshList();//Adapter.notifyDataSetChanged();
                }
            }
        });
        final int anum = num;
        ImageButton IVD = (ImageButton) OI.getView().findViewById(R.id.item_menu_down);
        if(IVU != null)
        IVD.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(LIST.indexOf(AOI)<LIST.size()-anum-1){

                    int i = LIST.indexOf(AOI);
                    int j = i+1;

                    long tmp = LIST.get(i).getPosition();
                    getDBase().updateWaitDB(TableItem.TABLE_ITEM, new TableItem().Init(LIST.get(i).getParent(), ObjectDB.NULL, ObjectDB.NULL, ObjectDB.NULL, LIST.get(j).getPosition()));
                    getDBase().updateWaitDB(TableItem.TABLE_ITEM, new TableItem().Init(LIST.get(j).getParent(), ObjectDB.NULL, ObjectDB.NULL, ObjectDB.NULL, tmp));
                    LIST.get(i).setPosition(LIST.get(j).getPosition());
                    LIST.get(j).setPosition(tmp);

                    LIST.set(LIST.indexOf(AOI),LIST.set(LIST.indexOf(AOI)+1,AOI));
                    RefreshList();//Adapter.notifyDataSetChanged();
                }
            }
        });

        //Log.i("DB addItem",getParent()+","+TR.getId()+","+OI.getType());

        H.post(new Runnable() {
            @Override
            public void run() {
                LIST.add(LIST.size()-anum,AOI);
                Adapter.notifySearchDataSetChanged(ActivityMain.getROOT(null).SEARCH);
            }
        });

        //return OI;
    }

    public long getID() {
        return ID;
    }

    public void setID(long ID) {
        this.ID = ID;
        CL.TI.setMenu(ID);
    }

    public ObjectListFragment addID(long ID) {
        this.ID = ID;
        CL.TI.setMenu(ID);
        return this;
    }

    public AdapterDB getDBase() {
        return DBase;
    }

    public void setDBase(AdapterDB DBase) {
        this.DBase = DBase;
    }

    public String getName() {
        return name;
    }

    public void reName(String name) {
        this.name = name;
    }

    public ListView getList() {
        return List;
    }

    public void setList(ListView list) {
        List = list;
    }

    public ArrayList<ObjectItem> getLIST() {
        return LIST;
    }

    public void setLIST(ArrayList<ObjectItem> LIST) {
        this.LIST = LIST;
    }

    public AdapterItems getAdapter() {
        return Adapter;
    }

    public void setAdapter(AdapterItems adapter) {
        Adapter = adapter;
    }

    public void  RefreshList(){
        H.post(new Runnable() {
            @Override
            public void run() {
                List.setAdapter(Adapter);
                ActivityMain.getROOT(null).GoTo();
            }
        });

    }
    public ObjectListener getCL() {
        return CL;
    }

    public long getParent() {
        return parent;
    }

}
