package com.innoq.httpd;

import java.io.IOException;
import java.net.InetSocketAddress;
import java.nio.channels.ServerSocketChannel;

/**
 * Http daemon that uses the new I/O API. Connections are accepted by
 * {@link Acceptor} threads. They are then registered as {@link Connection}s
 * with a {@link java.nio.channels.Selector}. {@link ConnectionSelector} threads
 * call the connection's work-methods until the connections de-register
 * themselves.
 * @author hendrik.schreiber@innoq.com
 * @see Acceptor
 * @see ConnectionSelector
 * @see Connection
 */
public class NIOHttpd
{

    /**
     * Returns the content-type of a given resource.
     */
    public static String guessContentType(String uri)
    {
        // Hack. This should be done with a
        // configuration file.
        uri = uri.toLowerCase();
        if(uri.endsWith(".html") || uri.endsWith(".htm"))
        {
            return "text/html";
        }
        else if(uri.endsWith(".txt"))
        {
            return "text/plain";
        }
        else if(uri.endsWith(".jpg") || uri.endsWith(".jpeg"))
        {
            return "image/jpeg";
        }
        else if(uri.endsWith(".gif"))
        {
            return "image/gif";
        }
        else
        {
            return "unknown";
        }
    }

    /**
     * Starts the Http daemon with 2n threads. The first argument is n.
     */
    public static void main(String[] args) throws IOException
    {
        ServerSocketChannel serverSocketChannel = ServerSocketChannel.open();
        serverSocketChannel.socket().bind(new InetSocketAddress(8080));
        for(int i = 0; i < Integer.parseInt(args[0]); i++)
        {
            ConnectionSelector connectionSelector = new ConnectionSelector();
            Acceptor acceptor = new Acceptor(serverSocketChannel,
                    connectionSelector);
        }
    }
}
