/**
 *
 */
package com.gaoshuang.scrapbook.util;

import java.io.BufferedInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;

import org.apache.commons.io.FileUtils;

/**
 * Utility methods for dealng with File Objects.
 *
 * @author Sean Gao
 * @since 22-Aug-2005
 */
public class FileUtils
{
    private FileUtils()
    {
    }

    /**
     * Returns the content of a file, as a byte array.
     *
     * @param file
     *            The file to get the content of.
     */
    public static byte[] getContent(final File file) throws IOException
    {
        InputStream in = new FileInputStream(file);
        in = new BufferedInputStream(in);
        final int size = (int) file.length();
        final byte[] content = new byte[size];

        try
        {
            int read = 0;
            for (int pos = 0; pos < size && read >= 0; pos += read)
            {
                read = in.read(content, pos, size - pos);
            }
        } finally
        {
            in.close();
        }

        return content;
    }

    public static byte[] getContent(File file) throws IOException
    {
        InputStream in = new FileInputStream(file);
        try {
            return IOUtils.toByteArray(in);
        } finally {
            IOUtils.closeQuietly(in);
        }

    }


}
