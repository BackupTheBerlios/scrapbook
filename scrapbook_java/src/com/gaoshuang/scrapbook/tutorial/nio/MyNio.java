package com.gaoshuang.scrapbook.tutorial.nio;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.PrintStream;
import java.nio.ByteBuffer;
import java.nio.channels.FileChannel;

import com.sun.xml.internal.ws.message.ByteArrayAttachment;

public class MyNio
{
    // static String message = "This is NIO \n line 2";
    // static byte messageBytes[] = message.toCharArray();
    static private final byte messageBytes[] = { 83, 111, 109, 101, 32, 98, 121, 116, 101, 115, 46 };

    static public void main(String args[]) throws IOException
    {
        ByteBuffer buffer = ByteBuffer.allocate(4);

        FileOutputStream foutstream = new FileOutputStream("niotest1.txt");
        FileChannel foutc = foutstream.getChannel();

        while (true)
        {
            buffer.clear();
            for (int i = 0; i < messageBytes.length; ++i)
            {
                buffer.put(messageBytes[i]);
                if (i > 3)
                {
                    buffer.flip();
                    foutc.write(buffer);
                }
            }
        }
        foutstream.close();

        FileInputStream fin;
        fin = new FileInputStream("niotest1.txt");
        FileChannel finc = fin.getChannel();

        while (true)
        {
            buffer.clear();
            int r = finc.read(buffer);

            if (r == -1)
            {
                break;
            }

            buffer.flip();
            // fsysoutc.write( buffer );

            while (buffer.hasRemaining())
            {
                byte f = buffer.get();
                System.out.println(f);
            }

        }
    }
}
