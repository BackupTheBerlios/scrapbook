/* $RCSfile: NewVersionChecker.java,v $
* Created on 2007 九月 25 by sean.gao
* $Source: /home/xubuntu/berlios_backup/github/tmp-cvs/scrapbook/Repository/scrapbook_java/src/scrapbook/util/NewVersionChecker.java,v $
* $Id: NewVersionChecker.java,v 1.1 2009/05/27 14:28:42 gaoshuang Exp $
* Copyright (c) 2007 SECPay Ltd.  All rights reserved.
* http://www.rgagnon.com/javadetails/java-0544.html
* Possible major/minor value : 

major  minor Java platform version 
45       3           1.0
45       3           1.1
46       0           1.2
47       0           1.3
48       0           1.4
49       0           1.5
50       0           1.6


*/ 
package scrapbook.util;

import java.io.*;

public class NewVersionChecker {
    public static void main(String[] args) throws IOException {
        //for (int i = 0; i < args.length; i++)
            //checkClassVersion(args[i]);
            checkClassVersion("C:\\Item.class");
    }

    private static void checkClassVersion(String filename)
        throws IOException
    {
        DataInputStream in = new DataInputStream
         (new FileInputStream(filename));

        int magic = in.readInt();
        if(magic != 0xcafebabe) {
          System.out.println(filename + " is not a valid class!");;
        }
        int minor = in.readUnsignedShort();
        int major = in.readUnsignedShort();
        System.out.println(filename + ": " + major + " . " + minor);
        in.close();
    }
}
