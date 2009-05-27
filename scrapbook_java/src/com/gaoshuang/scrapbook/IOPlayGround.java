/*
 * IOPlayGround.java
 *
 * Created on 15 July 2005, 11:46
 *
 * To change this template, choose Tools | Options and locate the template under
 * the Source Creation and Management node. Right-click the template and choose
 * Open. You can then make changes to the template in the Source Editor.
 */

package com.gaoshuang.scrapbook;

import java.io.File;
import java.io.FileOutputStream;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.Writer;


/**
 *
 * @author seangao
 */
public class IOPlayGround {
    
    /** Creates a new instance of IOPlayGround */
    public IOPlayGround() {
    }
       public static void main(String[] args) throws Exception{
        
         //File
           File myFile = new File("////javatemp");
           System.out.println(myFile + (myFile.exists()?" does":" does not") + " exist");
           System.out.println(myFile + (myFile.isDirectory()?" is":" is not") + " a directory.");
           System.out.println(myFile + (myFile.isFile()?" is":" is not") + " a file.");
           System.out.println(myFile  + (myFile.canRead()?" can":" can not") + " be read.");
           System.out.println(myFile  + (myFile.canWrite()?" can":" can not") + " be written.");
         
           
         Writer writer = new OutputStreamWriter(System.out, "UTF-8");
         writer.write("[%s]屁啦~11111");
         writer.close();
         
         OutputStream out = new FileOutputStream("seanwrite.txt"); 
         Writer writer1 = new OutputStreamWriter(out, "UTF-8"); 
         writer1.write("[%s]屁啦~1232123");
         writer1.close();
         
         
        
        

    }
}
