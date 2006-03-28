package com.gaoshuang.scrapbook.playground;

import java.io.IOException;
import java.io.InputStream;
import java.util.Properties;

public class Config
{

    /**
     * @param args
     * @throws IOException
     */
    public static void main(String[] args) throws IOException
    {
            Config config = new Config();
            InputStream input = config.getClass().getClassLoader().getResourceAsStream(
                    "com/gaoshuang/scrapbook/playground/conf/scrapbook.properties");
            Properties properties = new Properties();
            properties.load(input);
            String foo = properties.getProperty("foo");
            System.out.println( "foo=" + foo);
    }

}
