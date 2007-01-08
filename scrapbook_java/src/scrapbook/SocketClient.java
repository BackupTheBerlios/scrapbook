/**
 * 
 */
package scrapbook;

import java.io.IOException;
import java.net.InetAddress;
import java.net.InetSocketAddress;
import java.net.Socket;
import java.net.SocketAddress;
import java.net.SocketTimeoutException;
import java.net.UnknownHostException;
import java.nio.channels.ServerSocketChannel;


/**
 * @author Sean Gao
 * @since 17:21:46 08-Jul-2005
 */
public class SocketClient
{

    public static void main(String[] args) throws IOException
    {
        // Create a socket without a timeout
        try
        {
            InetAddress addr = InetAddress.getByName("127.0.0.1");
            int port = 8080;

            // This constructor will block until the connection succeeds
            Socket socket = new Socket(addr, port);
        }
        catch(UnknownHostException e)
        {
        }
        catch(IOException e)
        {
        }

        // Create a socket with a timeout
        try
        {
            InetAddress addr = InetAddress.getByName("java.sun.com");
            int port = 80;
            SocketAddress sockaddr = new InetSocketAddress(addr, port);

            // Create an unbound socket
            Socket sock = new Socket();

            // This method will block no more than timeoutMs.
            // If the timeout occurs, SocketTimeoutException is thrown.
            int timeoutMs = 2000; // 2 seconds
            sock.connect(sockaddr, timeoutMs);
        }
        catch(UnknownHostException e)
        {
        }
        catch(SocketTimeoutException e)
        {
        }
        catch(IOException e)
        {
        }

    }

}
