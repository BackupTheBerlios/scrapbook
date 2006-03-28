package com.innoq.httpd;

import java.nio.channels.SocketChannel;
import java.nio.channels.ServerSocketChannel;

/**
 * Acceptors call the accept() method of a {@link ServerSocketChannel},
 * instantiate a {@link Connection} object with the accepted connection, and
 * register this connection with the {@link ConnectionSelector}.
 * @author hendrik.schreiber@innoq.com
 */
class Acceptor extends Thread
{

    private static int _no; // Instance counter

    private ServerSocketChannel serverSocketChannel;

    private ConnectionSelector connectionSelector;

    /**
     * Starts this Acceptor thread.
     */
    public Acceptor(ServerSocketChannel serverSocketChannel,
            ConnectionSelector connectionSelector)
    {
        super("Acceptor " + (_no++));
        this.serverSocketChannel = serverSocketChannel;
        this.connectionSelector = connectionSelector;
        start();
    }

    /**
     * Accepts connections and regsiters them with
     * {@link ConnectionSelector#queue(Connection)}.
     */
    public void run()
    {
        while(true)
        {
            SocketChannel socketChannel = null;
            try
            {
                socketChannel = serverSocketChannel.accept();
                connectionSelector.queue(new Connection(socketChannel));
            }
            catch(Exception e)
            {
                e.printStackTrace();
                // clean-up, if necessary
                if(socketChannel != null)
                {
                    try
                    {
                        socketChannel.close();
                    }
                    catch(Exception ee)
                    {
                        /* ignore */
                    }
                }
            }
        }
    }
}
