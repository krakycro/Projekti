package com.etfos.kraky.gmstation;

import android.app.Activity;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.os.Handler;
import android.util.Log;
import android.widget.Toast;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.UUID;


public class AdapterBluetooth {

    private static final String TAG = "GMBluetooth";
    private final Context ctx;
    private final Activity act;

    final int RECIEVE_MESSAGE = 1;
    private BluetoothAdapter BAdapter = null;
    private BluetoothSocket BSocket = null;
    private StringBuilder sb = new StringBuilder();
    private Handler h;
    private boolean GO = true;
    private ConnectedThread CThread;

    private static final UUID MY_UUID = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");


    public static class BGroup{
        public String name;
        public String address;

       public  BGroup(String name, String address){
            this.name = name;
           this.address = address;
        }
    }
    private ArrayList<BGroup> LIST;




    public AdapterBluetooth(Context ctx){
        this.act = ActivityMain.getROOT(null);
        this.ctx = ctx;
        this.LIST = new ArrayList<>();
        h = new Handler() {
            public void handleMessage(android.os.Message msg) {
                switch (msg.what) {
                    case RECIEVE_MESSAGE:
                        byte[] readBuf = (byte[]) msg.obj;
                        String strIncom = new String(readBuf, 0, msg.arg1);
                        sb.append(strIncom);
                        int endOfLineIndex = sb.indexOf("\r\n");
                        if (endOfLineIndex > 0) {
                            String sbprint = sb.substring(0, endOfLineIndex);

                            //
                            // Reciever!
                            //

                            sb.delete(0, sb.length());
                        }

                        break;
                }
            }
        };
    }

    private BluetoothSocket createBluetoothSocket(BluetoothDevice device) throws IOException {
        if(Build.VERSION.SDK_INT >= 10){
            try {
                final Method m = device.getClass().getMethod("createInsecureRfcommSocketToServiceRecord", new Class[] { UUID.class });
                return (BluetoothSocket) m.invoke(device, MY_UUID);
            } catch (Exception e) {
                Log.e(TAG, "Could not create Insecure RFComm Connection", e);
            }
        }
        return  device.createRfcommSocketToServiceRecord(MY_UUID);
    }

    public void resume(int index) {
        if(!GO) return;
        Log.d(TAG, "...onResume - try connect...");

        BluetoothDevice device = BAdapter.getRemoteDevice(LIST.get(index).address);

        try {
            BSocket = createBluetoothSocket(device);
        } catch (IOException e) {
            errorExit("Fatal Error", "In onResume() and socket create failed: " + e.getMessage() + ".");
        }

        BAdapter.cancelDiscovery();

        Log.d(TAG, "...Connecting...");
        try {
            BSocket.connect();
            Log.d(TAG, "....Connection ok...");
        } catch (IOException e) {
            try {
                BSocket.close();
            } catch (IOException e2) {
                errorExit("Fatal Error", "In onResume() and unable to close socket during connection failure" + e2.getMessage() + ".");
            }
        }

        Log.d(TAG, "...Create Socket...");
        CThread = new ConnectedThread(BSocket);
        CThread.start();
    }

    public void pause() {
        Log.d(TAG, "...In onPause()...");

        try     {
            BSocket.close();
        } catch (IOException e2) {
            errorExit("Fatal Error", "In onPause() and failed to close socket." + e2.getMessage() + ".");
        }
    }

    public void checkBTState() {
        BAdapter = BluetoothAdapter.getDefaultAdapter();
        if(BAdapter==null) {
            GO = false;
            errorExit("Fatal Error", "Bluetooth not support");
        } else {
            if (BAdapter.isEnabled()) {
                Log.d(TAG, "...Bluetooth ON...");
            } else {
                Intent enableBtIntent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
                act.startActivityForResult(enableBtIntent,1);
            }
        }
    }

    private void errorExit(String title, String message){
        Toast.makeText(ctx, title + " - " + message, Toast.LENGTH_LONG).show();
        GO = false;
    }

    private class ConnectedThread extends Thread {
        private final InputStream mmInStream;
        private final OutputStream mmOutStream;

        public ConnectedThread(BluetoothSocket socket) {
            InputStream tmpIn = null;
            OutputStream tmpOut = null;

            try {
                tmpIn = socket.getInputStream();
                tmpOut = socket.getOutputStream();
            } catch (IOException e) { }

            mmInStream = tmpIn;
            mmOutStream = tmpOut;
        }

        public void run() {
            byte[] buffer = new byte[256];
            int bytes;

            while (true) {
                try {
                    bytes = mmInStream.read(buffer);
                    h.obtainMessage(RECIEVE_MESSAGE, bytes, -1, buffer).sendToTarget();
                } catch (IOException e) {
                    break;
                }
            }
        }

        public void write(String message) {
            Log.d(TAG, "...Data to send: " + message + "...");
            byte[] msgBuffer = message.getBytes();
            try {
                mmOutStream.write(msgBuffer);
            } catch (IOException e) {
                Log.d(TAG, "...Error data send: " + e.getMessage() + "...");
            }
        }
    }

    public ArrayList<BGroup> getLIST() {
        return this.LIST;
    }

    public void setLIST(ArrayList<BGroup> address) {
        this.LIST = address;
    }
}

