package com.innoq.httpd;

import java.io.IOException;
import java.nio.channels.SelectionKey;
import java.nio.channels.Selector;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Set;

/**
 * Calls the work-methods of registered {@link Connection}s, if the
 * corresponding channels are ready for the specified operations.
 * @author hendrik.schreiber@innoq.com
 */
class ConnectionSelector extends Thread
{

    private static int _no; // instance counter

    private Selector selector;

    private List queue;

    /**
     * Instantiates and starts this ConnectionSelector. The {@link Selector} is
     * instantiated, too.
     */
    public ConnectionSelector() throws IOException
    {
        super("ConnectionSelector " + (_no++));
        selector = Selector.open();
        queue = new ArrayList();
        start();
    }

    /**
     * Queues a connection and calls {@link Selector#wakeup()}, so that a
     * {@link SelectionKey} can be created and the connection can be registered.
     * @see #registerQueuedConnections()
     */
    public void queue(Connection connection)
    {
        synchronized(queue)
        {
            queue.add(connection);
        }
        // make sure that select() wakes up and the queued
        // connections is taken care of.
        selector.wakeup();
    }

    /**
     * Registers all queued connections with the Selector.
     * @see Connection#register(Selector)
     */
    private void registerQueuedConnections() throws IOException
    {
        // the synchronized block is a bottleneck, therefore
        // it should be avoided if possible
        if(!queue.isEmpty())
        {
            synchronized(queue)
            {
                while(!queue.isEmpty())
                {
                    Connection connection = (Connection)queue.remove(queue
                            .size() - 1);
                    connection.register(selector);
                }
            }
        }
    }

    /**
     * Calls {@link Selector#select()} in an inifnite loop. When the call to
     * select() returns, all queued connections are registered with the
     * Selector. Then {@link Connection#readRequest()} or {@link
     * Connection#writeResponse()} respectively are called for connections that
     * are ready for read or write operations.
     */
    public void run()
    {
        while(true)
        {
            try
            {
                int i = selector.select();
                registerQueuedConnections();
                if(i > 0)
                {
                    Set set = selector.selectedKeys();
                    Iterator connectionIterator = set.iterator();
                    while(connectionIterator.hasNext())
                    {
                        SelectionKey key = (SelectionKey)connectionIterator
                                .next();
                        Connection connection = (Connection)key.attachment();
                        try
                        {
                            if(key.interestOps() == SelectionKey.OP_READ)
                            {
                                connection.readRequest();
                            }
                            else
                            {
                                connection.writeResponse();
                            }
                        }
                        catch(IOException ioe)
                        {
                            connection.close();
                        }
                        catch(Throwable t)
                        {
                            connection.close();
                            t.printStackTrace();
                        }
                    }
                }
            }
            catch(Throwable t)
            {
                t.printStackTrace();
            }
        }
    }
}
