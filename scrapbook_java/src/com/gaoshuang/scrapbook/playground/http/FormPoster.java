package com.gaoshuang.scrapbook.playground.http;
   /**
   *   Java Network Programming, Third Edition
   *   By Elliotte Rusty Harold
   *   Third Edition October 2004
   *   ISBN: 0-596-00721-3
   *   MODIFIED BY SEAN GAO
   */
//http://www.cafeaulait.org/books/jnp3/examples/15/
import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;

public class FormPoster
{
    private String url;
    //added by sean quick testing
    private String request;
    // from Chapter 7, Example 7-9
    private QueryString query = new QueryString();       

    public FormPoster(String url, String request)
    {
        this.url = url;
        this.request = request;
    }

    public void add(String name, String value) {
        query.add(name, value);
      }
    
    public void doPost()
    {
        URL netUrl;
        try
        {
            netUrl = new URL(url);

        }
        catch (MalformedURLException ex)
        {
            System.err.println("Usage: java FormPoster url");
            return;
        }
        
        if (!netUrl.getProtocol().toLowerCase().startsWith("http"))
        {
            throw new IllegalArgumentException("Posting only works for http URLs");
        }
        try
        {
            //use HttpURLConnection so we can use setFixedLengthStreamingMode
            HttpURLConnection connection = (HttpURLConnection) netUrl.openConnection();
            //this is the same as setDoOutPut true
            connection.setRequestMethod("POST");
            //this is not reuired, java will fill it in automaticlly
            //connection.setRequestProperty("Content-Length", "" + query.toString().getBytes().length);
            connection.setUseCaches(false);
            //this is true by deafult, means i want to READ the response
            //connection.setDoInput(true);
            
            connection.setDoOutput(true);
            
    
            /*
             * use URL if we don't do anything fancy
            URLConnection connection = (URLConnection) netUrl.openConnection();
            //set OutPut to true will do a Post
            connection.setDoOutput(true);
            OutputStreamWriter out= new OutputStreamWriter(connection.getOutputStream(), "ASCII");
       
            //out.write(request);
            out.write(query.toString());
            //this maybe for http:1.0
            //out.write("\r\n");

            */
          //this way we don't need a writer
            byte[] data = query.toString().getBytes("UTF-8");
            //cleaver streaming tip
            connection.setFixedLengthStreamingMode(data.length);
            OutputStream out = connection.getOutputStream();
            
            out.write(data);            
            
            out.flush();
            out.close();
    
            BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
    
            String response = reader.readLine();
            while (null != response)
            {
                System.out.println(response);
                response = reader.readLine();
            }
        }
        catch (IOException ex)
        {
            System.err.println(ex);
        }
    }
    
    public static void main(String args[])
    {
        //String request = "&merchant=secpay&amount=10&trans_id=201&callback=123";
        //String url = "https://www.secpay.com/java-bin/ValCard";
    	String url="https://internal.paypoint.net/lc/?";
    	String request="h=5&e=13&l=9999";
        
    	FormPoster poster = new FormPoster(url, request);
        poster.add("merchant","secpay");        
        poster.add("amount","20");
        poster.add("trans_id","20");
        poster.add("callback","123");
        

        poster.doPost();


    }

}
