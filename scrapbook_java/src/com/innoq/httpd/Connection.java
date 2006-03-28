package com.innoq.httpd;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.nio.ByteBuffer;
import java.nio.channels.FileChannel;
import java.nio.channels.SelectionKey;
import java.nio.channels.Selector;
import java.nio.channels.SocketChannel;
import java.util.StringTokenizer;
import java.util.NoSuchElementException;

/**
 * Represents the connection, during which the request is read and a response is
 * written.
 * @author hendrik.schreiber@innoq.com
 * @see ConnectionSelector
 * @see Acceptor
 */
class Connection
{

    private SocketChannel socketChannel;

    private ByteBuffer requestLineBuffer;

    private ByteBuffer responseLineBuffer;

    private int endOfLineIndex;

    private SelectionKey key;

    private FileChannel fileChannel;

    private long filePos;

    private long fileLength;

    private int httpStatus;

    private String httpMessage;

    private String uri;

    private String protocol;

    /**
     * Initializes this connection with a SocketChannel. Here also the channel
     * is set to non-blocking mode.
     */
    public Connection(SocketChannel socketChannel) throws IOException
    {
        this.socketChannel = socketChannel;
        // disable Nagle's algorithm for better performance
        socketChannel.socket().setTcpNoDelay(true);
        // the channel shall _not_ block
        socketChannel.configureBlocking(false);
        requestLineBuffer = ByteBuffer.allocate(512);
        // default http status code: OK
        httpStatus = 200;
        // default http status message
        httpMessage = "OK";
        // default protocol version
        protocol = "HTTP/0.9";
    }

    /**
     * Register this connection with the provided Selector. Initially we are
     * only interested in read operations ({@link SelectionKey.OP_READ}). This
     * method is called by {@link ConnectionSelector}.
     */
    public void register(Selector selector) throws IOException
    {
        key = socketChannel.register(selector, SelectionKey.OP_READ);
        // deposit this connection in its selection key
        key.attach(this);
    }

    /**
     * Reads the request. If somethings goes wrong, an error code is set. If the
     * whole request read, {@link #prepareForResponse()} is called.
     */
    public void readRequest() throws IOException
    {
        try
        {
            if(!requestLineBuffer.hasRemaining())
            {
                setError(414, "Request URI too long.");
                prepareForResponse();
                return;
            }
            socketChannel.read(requestLineBuffer);
            if(!isRequestLineRead())
            {
                return;
            }
            requestLineBuffer.flip();
            byte[] b = new byte[endOfLineIndex];
            requestLineBuffer.get(b);
            String requestline = new String(b, 0);
            StringTokenizer st = new StringTokenizer(requestline, " \r\n");
            String method = st.nextToken();
            uri = st.nextToken();
            File file = new File(uri.substring(1));
            if(st.hasMoreTokens())
            {
                protocol = st.nextToken();
            }
            if(!method.equals("GET"))
            {
                setError(405, "Method " + method + " is not supported.");
            }
            else if(!file.exists() || file.isDirectory())
            {
                setError(404, "Resource " + uri + " was not found.");
            }
            else if(!file.canRead())
            {
                setError(403, "Forbidden: " + uri);
            }
            else
            {
                fileLength = file.length();
                fileChannel = new FileInputStream(file).getChannel();
            }
            prepareForResponse();
        }
        catch(NoSuchElementException nsee)
        {
            // we didn't read enough tokens
            setError(400, "Bad request.");
        }
        catch(Exception e)
        {
            // something else went wrong
            setError(500, "Internal Server Error.");
            prepareForResponse();
            e.printStackTrace();
        }
    }

    /**
     * Creates a buffer that contains the response line, headers and in case of
     * an error an HTML message.
     */
    private void prepareForResponse() throws IOException
    {
        StringBuffer responseLine = new StringBuffer(128);
        // write response line if Http >= 1.0
        if(!protocol.equals("HTTP/0.9"))
        {
            responseLine.append("HTTP/1.0 " + httpStatus + " " + httpMessage
                    + "\r\n");
            // In case of an error, we don't need headers
            if(httpStatus != 200)
            {
                responseLine.append("\r\n");
            }
            else
            {
                // Header for the file
                responseLine.append("Content-Type: "
                        + NIOHttpd.guessContentType(uri) + "\r\n\r\n");
            }
        }
        if(httpStatus != 200)
        {
            // Error message for the user
            responseLine.append("<HTML><BODY><H1>" + httpMessage
                    + "</H1></BODY></HTML>");
        }
        responseLineBuffer = ByteBuffer.wrap(responseLine.toString().getBytes(
                "ASCII"));
        key.interestOps(SelectionKey.OP_WRITE);
        key.selector().wakeup();
    }

    /**
     * Inidcates, whether the request line was read.
     */
    private boolean isRequestLineRead()
    {
        for(; endOfLineIndex < requestLineBuffer.limit(); endOfLineIndex++)
        {
            if(requestLineBuffer.get(endOfLineIndex) == '\r') return true;
        }
        return false;
    }

    /**
     * Writes the responseLineBuffer and - if necessary - the requested file to
     * the client. After all data has been written, the selection key is
     * cancelled and the connection is closed.
     */
    public void writeResponse() throws IOException
    {
        // write the response buffer
        if(responseLineBuffer.hasRemaining())
        {
            socketChannel.write(responseLineBuffer);
        }
        // if the complete response buffer has been written,
        // we are either done (in case of an error) or
        // we need to send the file.
        if(!responseLineBuffer.hasRemaining())
        {
            if(httpStatus != 200)
            {
                close();
            }
            else
            {
                filePos += fileChannel.transferTo(filePos, (int)Math.min(
                        64 * 1024, fileLength - filePos), socketChannel);
                if(filePos == fileLength)
                {
                    close();
                }
            }
        }
    }

    /**
     * Sets an error.
     */
    private void setError(int httpStatus, String httpMessage)
    {
        this.httpStatus = httpStatus;
        this.httpMessage = httpMessage;
    }

    /**
     * Cancels the selection key and closes all open channels.
     */
    public void close()
    {
        try
        {
            if(key != null) key.cancel();
        }
        catch(Exception e)
        {
            /* ignore */
        }
        try
        {
            if(socketChannel != null) socketChannel.close();
        }
        catch(Exception e)
        {
            /* ignore */
        }
        try
        {
            if(fileChannel != null) fileChannel.close();
        }
        catch(Exception e)
        {
            /* ignore */
        }
    }
}
