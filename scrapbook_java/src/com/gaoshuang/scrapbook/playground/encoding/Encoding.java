package com.gaoshuang.scrapbook.playground.encoding;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;

public class Encoding {
    public static void main(String[] args) {
        

        try {
            outputCharset(new File("latin1.html"), "latin1", 0xFF);
            outputCharset(new File("utf8.html"),   "utf8",   0xFFFF);
        } 
        catch (IOException e) {
            e.printStackTrace();
        }

    }
    
    public static void outputCharset(File file, String charset, int size) throws IOException {
        
        OutputStreamWriter out = null;        
        try {
            out = new OutputStreamWriter(new FileOutputStream(file), charset);
            
            out.write("<html><body>");
            for (int i=0; i<size; i++) {
                out.write(i + " ");
                out.write(i);
                out.write("<br>");
            }
            out.write("</body></html>");
            
        } 
        finally {
            try { out.close(); } catch (Exception e) {}        
        }        
    }
}
