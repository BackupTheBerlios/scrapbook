/*
http://martin.nobilitas.com/java/cookies.html
*/
package com.gaoshuang.scrapbook.playground;

import java.net.*;
import java.io.*;
import java.util.*;
import java.text.*;
//Program to get all the cookies(name/pair values) from the URL passed as parameter
public class GetCookieFromURL{
    public static void main(String args[])   {
        try{
            //create url by pass your url as string
            URL url = new
                    URL("http://www.secpay.com");
            // opening the connection to the url
            URLConnection conn = url.openConnection();
            //setting up the browser's user agent as property to conn
            conn.setRequestProperty("User-Agent", "Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041020 Firefox/0.10.1");
            conn.connect();
            //To read the body you're getting back
            InputStream bodyInputStream = conn.getInputStream();
            System.out.println( bodyInputStream );
            //traverse around the cookie till the headerfield is null
            int i=0;
            while(true){
                if(conn.getHeaderField(i) !=null){
                    System.out.println(  i );
                    System.out.println(  conn.getHeaderFieldKey(i));
                    System.out.println(  conn.getHeaderField(i));
                    i++;
                }else {
                    break;
                }
            }//end of while
        }//end of try
        catch(Exception e) {
            System.out.println(e);
        }
    } // end of main
}//end of class

