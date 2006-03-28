package com.innoq.httpd;

import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.NoSuchElementException;
import java.util.StringTokenizer;

/**
 * Simple multithreaded Http daemon that exclusively uses the 'old ' I/O API.
 * @author hendrik.schreiber@innoq.com
 */
public class Httpd extends Thread
{

    private static int _no; // instance counter

    private ServerSocket serverSocket;

    private byte[] buf = new byte[1024 * 8];

    private String protocol;

    private InputStream in;

    private OutputStream out;

    private String uri;

    /**
     * Starts a Httpd thread.
     */
    public Httpd(ServerSocket serverSocket) throws IOException
    {
        super("Httpd " + (_no++));
        this.serverSocket = serverSocket;
        // default protocol-version
        protocol = "HTTP/0.9";
        start();
    }

    /**
     * Waits for incoming connections and then calls handleRequest.
     */
    public void run()
    {
        Socket socket = null;
        while(true)
        {
            try
            {
                socket = serverSocket.accept();
                // disable Nagle's algorithm
                // for better performance
                socket.setTcpNoDelay(true);
                in = socket.getInputStream();
                out = socket.getOutputStream();
                handleRequest();
            }
            catch(Exception e)
            {
                // something went wrong...
                e.printStackTrace();
            }
            finally
            {
                // clean-up
                if(socket != null)
                {
                    try
                    {
                        // this also closes
                        // the in- and outputstream.
                        socket.close();
                    }
                    catch(IOException ioe)
                    {
                        /* ignore */
                    }
                }
                socket = null;
            }
        }
    }

    /**
     * Reads the request and sends either the file or an error message back to
     * the client.
     */
    private void handleRequest() throws IOException
    {
        try
        {
            // read only 512 bytes - the line should
            // not be longer anyway
            int length = in.read(buf, 0, 512);
            if(length == 512)
            {
                sendError(414, "Request URI too long.");
                return;
            }
            // we assume ASCII as character set,
            // therefore we can use the deprecated but
            // faster String constructor.
            String requestline = new String(buf, 0, 0, length);
            StringTokenizer st = new StringTokenizer(requestline, " \r\n");
            String method = st.nextToken();
            uri = st.nextToken();
            if(st.hasMoreTokens())
            {
                protocol = st.nextToken();
            }
            File file = new File(uri.substring(1));
            if(!method.equals("GET"))
            {
                sendError(405, "Method " + method + " is not supported.");
            }
            else if(!file.exists() || file.isDirectory())
            {
                sendError(404, "Resource " + uri + " was not found.");
            }
            else if(!file.canRead())
            {
                sendError(403, "Forbidden: " + uri);
            }
            else
            {
                sendFile(file);
            }
        }
        catch(NoSuchElementException nsee)
        {
            // we didn't read enough tokens
            sendError(400, "Bad request.");
        }
        catch(Exception e)
        {
            try
            {
                sendError(500, "Internal Server Error.");
            }
            catch(IOException ioe)
            {
                /* ignore */
            }
        }
    }

    /**
     * Sends an error message to the client.
     */
    private void sendError(int httpStatus, String httpMessage)
            throws IOException
    {
        StringBuffer errorMessage = new StringBuffer(128);
        if(!protocol.equals("HTTP/0.9"))
        {
            errorMessage.append("HTTP/1.0 " + httpStatus + " " + httpMessage
                    + "\r\n\r\n");
        }
        errorMessage.append("<HTML><BODY><H1>" + httpMessage
                + "</H1></BODY></HTML>");
        out.write(errorMessage.toString().getBytes("ASCII"));
        out.flush();
    }

    /**
     * Sends the requested file to the client.
     */
    private void sendFile(File file) throws IOException
    {
        InputStream filein = null;
        try
        {
            filein = new FileInputStream(file);
            if(!protocol.equals("HTTP/0.9"))
            {
                // write status code and header
                out.write(("HTTP/1.0 200 OK\r\nContent-Type: "
                        + Httpd.guessContentType(uri) + "\r\n\r\n")
                        .getBytes("ASCII"));
            }
            int length = 0;
            while((length = filein.read(buf)) != -1)
            {
                out.write(buf, 0, length);
            }
            out.flush();
        }
        finally
        {
            if(filein != null) try
            {
                filein.close();
            }
            catch(IOException ioe)
            {
                /* ignore */
            }
        }
    }

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
     * Starts the Http daemon with n threads. The first argument is n.
     */
    public static void main(String[] args) throws IOException
    {
        ServerSocket serverSocket = new ServerSocket(8080);
        for(int i = 0; i < Integer.parseInt(args[0]); i++)
        {
            new Httpd(serverSocket);
        }
    }
}
